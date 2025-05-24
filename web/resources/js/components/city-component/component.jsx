import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faLocationArrow } from '@fortawesome/free-solid-svg-icons';
import CityDropdown from '../city-dropdown/component';
import { useCities } from '../../hooks/useCities'

function generateKey(cityName) {
  return cityName
    .toLowerCase()
    .replace(/[\s-]/g, "")
    .slice(0, 3);
}


export default function Header({ city, onChangeCity }) { 
    const { cities, loading, error } = useCities();
    const citiesMap = {};


    if (Array.isArray(cities)) {
    cities.forEach(({ id, city }) => {
        citiesMap[id] = city;
    });
    }


    return (
        <>
            <div className="flex flex-col bg-[#222222] pt-5 px-6 pb-3">
            <div className="flex items-center gap-2">
                <span className="font-Intro text-[15px] font-bold text-white text-lg uppercase"> { citiesMap[city] || 'Город не указан' } </span>
                <FontAwesomeIcon icon={faLocationArrow} className="text-[#636363] text-[21px]"/>
            </div>
            <CityDropdown cities={citiesMap} selectedCity={city} onChange={onChangeCity} />
            </div>
        </>
    )

}
