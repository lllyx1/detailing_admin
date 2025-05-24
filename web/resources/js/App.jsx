import React, { useState, useEffect } from 'react';
import { useSearchParams } from 'react-router-dom';
import { useCities } from './hooks/useCities';
import Header from './components/city-component/component';
import FilterBtn from './components/filter-btn-component/component';
import Card from './components/specialist-card-component/component';
import './App.css';

function calculateAge(birthDateStr) {
  const birthDate = new Date(birthDateStr);
  const today = new Date();
  let age = today.getFullYear() - birthDate.getFullYear();
  const m = today.getMonth() - birthDate.getMonth();
  if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
    age--;
  }
  return age;
}

function App() {
  const [searchParams, setSearchParams] = useSearchParams();
  const { cities } = useCities();
  const [filters, setFilters] = useState({
    city: '',
    ageFrom: '',
    ageTo: '',
  });
  const [specialists, setSpecialists] = useState([]);
  const [filteredSpecialists, setFilteredSpecialists] = useState([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  useEffect(() => {
    setFilters({
      city: searchParams.get('city') || '',
      ageFrom: searchParams.get('ageFrom') || '',
      ageTo: searchParams.get('ageTo') || '',
    });
  }, [searchParams]);

  const onChangeField = (field, value) => {
    const newParams = new URLSearchParams(searchParams);
    value ? newParams.set(field, value) : newParams.delete(field);
    setSearchParams(newParams);
  };



  useEffect(() => {
    if (cities.length === 0) return;

    const cityInParams = searchParams.get('city');
    if (!cityInParams) {
      const citiesMap = {};

      if (Array.isArray(cities)) {
        cities.forEach(({ id, city }) => {
          citiesMap[id] = city;
        });
      }

      const firstCityId = Object.keys(citiesMap)[0];
      if (firstCityId) {
        onChangeField("city", firstCityId);
        setFilters(prev => ({ ...prev, city: firstCityId }));
      }
    }
  }, [cities, searchParams, setSearchParams]);



  useEffect(() => {
    async function fetchSpecialists() {
      setLoading(true);
      setError(null);

      try {
        const params = new URLSearchParams();
        if (filters.city) params.append('city', filters.city);

        const response = await fetch(
          `https://detailingcitybot.ru/web/api/search?${params.toString()}`
        );

        if (!response.ok) throw new Error(`Ошибка ${response.status}`);

        const data = await response.json();
        setSpecialists(data);
      } catch (e) {
        setError(e.message);
      } finally {
        setLoading(false);
      }
    }

    fetchSpecialists();
  }, [filters.city]);


  useEffect(() => {
    if (!specialists.length) {
      setFilteredSpecialists([]);
      return;
    }

    const ageFromNum = filters.ageFrom ? Number(filters.ageFrom) : null;
    const ageToNum = filters.ageTo ? Number(filters.ageTo) : null;


    const filtered = specialists.filter(specialist => {
      const age = calculateAge(specialist.age);

      if (ageFromNum !== null && age < ageFromNum) return false;
      if (ageToNum !== null && age > ageToNum) return false;

      return true;
    });

    setFilteredSpecialists(filtered);
  }, [specialists, filters.ageFrom, filters.ageTo]);

  return (
    <>
      <Header city={filters.city} onChangeCity={onChangeField} />
      <div className='flex justify-between mt-6 mx-5'>
        <span className='font-montserrat text-[#868686]'>
          Для вас найдено {loading ? '...' : filteredSpecialists.length} <br /> специалистов
        </span>
        <FilterBtn filters={filters} onChange={onChangeField} />
      </div>
      <div className='flex flex-col gap-4 mt-8 mx-5'>
        {error && <div className="text-red-600 mb-4">Ошибка: {error}</div>}
        {loading && <div>Загрузка...</div>}
        {!loading && !error && filteredSpecialists.length === 0 && (
          <div>Специалисты не найдены</div>
        )}
        {!loading && !error && filteredSpecialists.map(specialist => (
          <Card
            key={specialist.id || specialist.phone}
            name={specialist.name}
            title={specialist.title}
            body={specialist.body}
            phone={specialist.phone}
            photos={specialist.resumePhotos?.map(photo => photo.file) || []}
          />
        ))}
      </div>
    </>
  );
}

export default App;
