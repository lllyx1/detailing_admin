import { useState } from 'react';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faSliders, faTimes } from '@fortawesome/free-solid-svg-icons';

export default function BtnComponent({ filters, onChange }) {
  const [isOpen, setIsOpen] = useState(false);

  return (
    <>
      <button
        type="button"
        className="flex items-center gap-2 bg-gray-200 px-6 py-2 rounded-full text-black font-medium font-montserrat shadow hover:bg-gray-300 transition"
        onClick={() => setIsOpen(true)}
      >
        Фильтры
        <FontAwesomeIcon icon={faSliders} className="text-[#636363] text-[21px]" />
      </button>

      {isOpen && (
        <div className="fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center">
          <div className="bg-white rounded-lg w-11/12 max-w-md p-6 relative">
            <button
              type="button"
              aria-label="Закрыть фильтры"
              className="absolute top-4 right-4 text-gray-600 hover:text-gray-900"
              onClick={() => setIsOpen(false)}
            >
              <FontAwesomeIcon icon={faTimes} size="lg" />
            </button>

            <h2 className="text-xl font-semibold mb-4">Фильтры</h2>

            <label className="flex flex-col text-sm text-gray-700 mb-4">
              Возраст от:
              <input
                type="number"
                min="0"
                max="100"
                value={filters.ageFrom}
                onChange={e => onChange("ageFrom", e.target.value)}
                className="mt-1 px-3 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400"
                placeholder="от"
              />
            </label>

            <label className="flex flex-col text-sm text-gray-700 mb-4">
              Возраст до:
              <input
                type="number"
                min="0"
                max="100"
                value={filters.ageTo}
                onChange={e => onChange("ageTo", e.target.value)}
                className="mt-1 px-3 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400"
                placeholder="до"
              />
            </label>

            <button
              type="button"
              className="mt-4 w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition"
              onClick={() => setIsOpen(false)}
            >
              Применить
            </button>
          </div>
        </div>
      )}
    </>
  );
}
