import { useState, useEffect } from "react";




export function useCities() {
  const [cities, setCities] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    async function fetchCities() {
      try {
        const response = await fetch(`https://detailingcitybot.ru/web/api/city`);
        if (!response.ok) throw new Error(`Ошибка: ${response.status}`);
        const data = await response.json();
        setCities(data);
      } catch (e) {
        setError(e.message);
      } finally {
        setLoading(false);
      }
    }
    fetchCities();
  }, []);


  return { cities, loading, error };
}
