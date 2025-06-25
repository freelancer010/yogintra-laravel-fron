import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'public/assets/front/css/style-main.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});
