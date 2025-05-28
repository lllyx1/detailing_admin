import React from "react";

export default function Footer() {
    return (
        <footer id="footer" className="mt-auto py-3 bg-light" style={{ marginTop: "40px" }}>
            <div className="container">
                <div className="row text-muted">
                    <div className="col-md-6 text-center text-md-start">
                        © Detailing city 2025
                    </div>
                    <div className="col-md-6 text-center text-md-end">
                        создано by <a href="https://lllyx.ru">lllyx</a>
                    </div>
                </div>
            </div>
        </footer>
    );
}
