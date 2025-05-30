import React from "react";

export default function Pages({ currentPage, onPageChange, totalCount, pageSize }) {
  const totalPages = Math.ceil(totalCount / pageSize);

  const handlePageClick = (page) => (e) => {
    e.preventDefault();
    if (page !== currentPage && page >= 1 && page <= totalPages) {
      onPageChange(page);
    }
  };

 const getPages = () => {
    const maxButtons = 8;
    const pages = [];

    if (totalPages <= maxButtons) {
      for (let i = 1; i <= totalPages; i++) {
        pages.push(i);
      }
    } else {
      const left = 1;
      const right = totalPages;
      const siblingsCount = 1;

      let startPage = Math.max(currentPage - siblingsCount, 2);
      let endPage = Math.min(currentPage + siblingsCount, totalPages - 1);

      if (currentPage <= 3) {
        startPage = 2;
        endPage = 5;
      } else if (currentPage >= totalPages - 2) {
        startPage = totalPages - 4;
        endPage = totalPages - 1;
      }

      pages.push(left);

      if (startPage > 2) {
        pages.push("left-ellipsis");
      }

      for (let i = startPage; i <= endPage; i++) {
        pages.push(i);
      }

      if (endPage < totalPages - 1) {
        pages.push("right-ellipsis");
      }

      pages.push(right);
    }

    return pages;
  };

  const pages = getPages();

  return (
    <nav className="mt-4 flex justify-center" aria-label="Pagination Navigation">
      <ul className="flex items-center -space-x-px h-10 text-base">
        <li>
          <a
            href="#"
            onClick={handlePageClick(currentPage - 1)}
            className={`flex items-center justify-center px-4 h-10 ms-0 leading-tight border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 ${
              currentPage === 1 ? "text-gray-300 cursor-not-allowed bg-white" : "text-gray-500 bg-white"
            }`}
            aria-disabled={currentPage === 1}
            aria-label="Previous Page"
          >
            <svg
              className="w-3 h-3 rtl:rotate-180"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 6 10"
            >
              <path
                stroke="currentColor"
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth="2"
                d="M5 1 1 5l4 4"
              />
            </svg>
          </a>
        </li>

        {pages.map((page, index) => {
          if (page === "left-ellipsis" || page === "right-ellipsis") {
            return (
              <li key={page + index} className="flex items-center justify-center px-4 h-10 text-gray-500">
                &#8230;
              </li>
            );
          }

          return (
            <li key={page}>
              <a
                href="#"
                onClick={handlePageClick(page)}
                aria-current={page === currentPage ? "page" : undefined}
                className={`flex items-center justify-center px-4 h-10 leading-tight border border-gray-300 hover:bg-gray-100 hover:text-gray-700 ${
                  page === currentPage
                    ? "z-10 text-blue-600 border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700"
                    : "text-gray-500 bg-white"
                }`}
              >
                {page}
              </a>
            </li>
          );
        })}

        <li>
          <a
            href="#"
            onClick={handlePageClick(currentPage + 1)}
            className={`flex items-center justify-center px-4 h-10 leading-tight border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 ${
              currentPage === totalPages ? "text-gray-300 cursor-not-allowed bg-white" : "text-gray-500 bg-white"
            }`}
            aria-disabled={currentPage === totalPages}
            aria-label="Next Page"
          >
            <svg
              className="w-3 h-3 rtl:rotate-180"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 6 10"
            >
              <path
                stroke="currentColor"
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth="2"
                d="m1 9 4-4-4-4"
              />
            </svg>
          </a>
        </li>
      </ul>
    </nav>
  );
}
