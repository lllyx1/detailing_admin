import React, { useEffect, useMemo, useCallback, useState } from 'react';
import { useSearchParams } from 'react-router-dom';
import { useCities } from './hooks/useCities';
import Header from './components/city-component/component';
import FilterBtn from './components/filter-btn-component/component';
import Card from './components/specialist-card-component/component';
import Pagination from "./components/pages-component/component";
import "./App.css";

const API_URL = 'https://detailingcitybot.ru/web/api';
const ITEMS_ON_PAGE = 10

function getFiltersFromParams(params) {
  return {
    city: params.get('city') || '',
    page: params.get('page') || 1,
    minAge: params.get('minAge') || '',
    maxAge: params.get('maxAge') || '',
  };
}



function App() {
  const [searchParams, setSearchParams] = useSearchParams();
  const { cities } = useCities();
  const filters = getFiltersFromParams(searchParams);

  const [specialists, setSpecialists] = useState([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);
  const [totalCount, setTotalCount] = useState();

  const onChangeField = useCallback((field, value) => {
    const newParams = new URLSearchParams(searchParams);
    value ? newParams.set(field, value) : newParams.delete(field);
    setSearchParams(newParams);
  }, [searchParams, setSearchParams]);

  useEffect(() => {
    if (cities.length === 0) return;

    const cityInParams = searchParams.get('city');
    if (!cityInParams) {
      const firstCityId = Array.isArray(cities) && cities.length > 0 ? cities[0].id : null;
      if (firstCityId) {
        onChangeField("city", firstCityId);
      }
    }
  }, [cities, searchParams, onChangeField]);

  useEffect(() => {
    async function fetchSpecialists() {
      const { city, page, minAge, maxAge } = filters;
      if (!city) return;

      setLoading(true);
      setError(null);

      try {
        const params = new URLSearchParams({ city, page, minAge, maxAge, 'per-page': ITEMS_ON_PAGE});
        const response = await fetch(`${API_URL}/search?${params.toString()}`);

        if (!response.ok) throw new Error(`Ошибка ${response.status}`);

        const data = await response.json();
        if (data.error) throw new Error(data.error);
        setTotalCount(Number(data.totalCount) || 0);


        const specialistsArray = Object.entries(data)
          .filter(([key, value]) => key !== 'totalCount' && typeof value === 'object' && value.id)
          .map(([_, value]) => value);
        setSpecialists(specialistsArray);
      } catch (e) {
        setError(e.message);
        setSpecialists([]);
      } finally {
        setLoading(false);
      }
    }

    fetchSpecialists();
  }, [filters.city, filters.page, filters.minAge, filters.maxAge]);

  console.log(specialists);

  return (
    <>
      <Header city={filters.city} onChangeCity={onChangeField} />
      <main className='min-h-screen flex flex-col'>
        <div className='flex justify-between mt-6 mx-5'>
          <span className='font-montserrat text-[#868686]'>
            Для вас найдено {loading ? '...' : totalCount} <br /> специалистов
          </span>
          <FilterBtn filters={filters} onChange={onChangeField} />
        </div>

        <div className='flex-grow flex flex-col gap-4 mt-8 mx-5'>
          {error && <div className="text-red-600 mb-4">Ошибка: {error}</div>}
          {loading && (
            <div className="space-y-4 animate-pulse">
              {[...Array(3)].map((_, i) => (
                <div key={i} className="h-24 bg-gray-200 rounded-xl" />
              ))}
            </div>
          )}
          {!loading && !error && specialists.length === 0 && (
            <div>Специалисты не найдены</div>
          )}
          {!loading && !error && specialists.map(specialist => (
            <Card
              key={specialist.id}
              name={specialist.name}
              title={specialist.title}
              body={specialist.body}
              phone={specialist.phone}
              photos={specialist.resumePhotos?.map(photo => photo.thumbUrl) || []}
            />
          ))}
        </div>

        <Pagination
          currentPage={Number(filters.page)}
          onPageChange={(page) => onChangeField("page", page)}
          totalCount={totalCount || 0}
          pageSize={ITEMS_ON_PAGE}
        />
      </main>
    </>
  );
}

export default App;
