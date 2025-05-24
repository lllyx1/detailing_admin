

import React, { useState, useRef, useEffect } from "react";

export default function CityDropdown({ cities, selectedCity, onChange }) {
  const [isOpen, setIsOpen] = useState(false);
  const dropdownRef = useRef(null);

  useEffect(() => {
    function handleClickOutside(event) {
      if (dropdownRef.current && !dropdownRef.current.contains(event.target)) {
        setIsOpen(false);
      }
    }
    document.addEventListener("mousedown", handleClickOutside);
    return () => document.removeEventListener("mousedown", handleClickOutside);
  }, []);

  const handleSelect = (id) => {
    onChange("city", id);
    setIsOpen(false);
  };

  return (
    <div className="relative inline-block" ref={dropdownRef}>
      <button
        type="button"
        onClick={() => setIsOpen(!isOpen)}
        className=""
      >
        <span className="font-Lacquer text-[15px] text-white underline text-lg text-left">
          Изменить город
        </span>
      </button>

      {isOpen && (
        <ul className="absolute z-10 mt-1 w-full bg-[#222222] text-white rounded-md shadow-lg max-h-60 overflow-auto focus:outline-none">
          {Object.entries(cities).map(([id, name]) => (
            <li
              key={id}
              className={`cursor-pointer select-none px-4 py-2 hover:bg-[#303030] ${
                id === selectedCity ? "font-bold" : ""
              }`}
              onClick={() => handleSelect(id)}
            >
              {name}
            </li>
          ))}
        </ul>
      )}
    </div>
  );
}
