import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';

// Используем динамический импорт для Tailwind
const tailwindcss = await import('@tailwindcss/vite').then(m => m.default);
export default defineConfig({
    plugins: [
        react(),
        tailwindcss(),
    ],
    build: {
        outDir: 'web/public/build',
        manifest: true,
        rollupOptions: {
            input: './web/resources/js/main.jsx'
        }
    },
    server: {
        host: '0.0.0.0',
        port: 3000,
        strictPort: true,
        hmr: {
            protocol: 'ws',
            host: 'localhost'
        }
    }
});