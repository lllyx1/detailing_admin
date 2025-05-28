import React, { useState } from "react";

export default function Card({ name, title, body, photos = [], phone }) {
  const [currentIndex, setCurrentIndex] = useState(0);

  const prevPhoto = (e) => {
    e.preventDefault();
    setCurrentIndex((prev) => (prev === 0 ? photos.length - 1 : prev - 1));
  };

  const nextPhoto = (e) => {
    e.preventDefault();
    setCurrentIndex((prev) => (prev === photos.length - 1 ? 0 : prev + 1));
  };

  return (
    <a href={`tel:${phone}`} className="block max-w-[100%] mx-auto no-underline">
      <div className="bg-white rounded-2xl border border-[#E7E7E7] p-6 max-w-sm mx-auto">
        <div className="relative">
          <img
            src={`https://detailingcitybot.ru/${photos[currentIndex]}`}
            alt={name}
            className="w-full h-72 object-cover rounded-xl"
          />

          {/* Левая кнопка */}
          <button
            onClick={prevPhoto}
            aria-label="Предыдущее фото"
            className="absolute top-1/2 left-3 -translate-y-1/2 bg-white rounded-full w-10 h-10 flex items-center justify-center shadow-md hover:bg-gray-100 transition"
            style={{ userSelect: "none" }}
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              className="h-6 w-6 text-gray-700"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              strokeWidth={2}
            >
              <path strokeLinecap="round" strokeLinejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
          </button>

          {/* Правая кнопка */}
          <button
            onClick={nextPhoto}
            aria-label="Следующее фото"
            className="absolute top-1/2 right-3 -translate-y-1/2 bg-white rounded-full w-10 h-10 flex items-center justify-center shadow-md hover:bg-gray-100 transition"
            style={{ userSelect: "none" }}
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              className="h-6 w-6 text-gray-700"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
              strokeWidth={2}
            >
              <path strokeLinecap="round" strokeLinejoin="round" d="M9 5l7 7-7 7" />
            </svg>
          </button>

          {/* Индикаторы */}
          <div className="absolute bottom-3 left-1/2 transform -translate-x-1/2 flex space-x-2">
            {photos.map((_, idx) => (
              <button
                key={idx}
                onClick={(e) => {
                  e.preventDefault();
                  setCurrentIndex(idx);
                }}
                aria-label={`Перейти к фото ${idx + 1}`}
                className={`w-3 h-3 rounded-full transition ${
                  idx === currentIndex ? "bg-blue-600" : "bg-gray-300"
                }`}
              />
            ))}
          </div>
        </div>

        <div className="mt-4 text-left">
          <h2 className="font-montserrat font-bold text-xl mb-1">{name}</h2>
          <div className="font-montserrat text-[#555555] text-base mb-3">{title}</div>
          <p className="text-black text-sm font-montserrat whitespace-pre-line">{body}</p>
        </div>
      </div>
    </a>
  );
}
