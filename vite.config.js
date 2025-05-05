import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/screen/tv1.css',
                'resources/js/screen/tv1.js',
                'resources/css/screen/tv2.css',
                'resources/js/screen/tv2.js',
                'resources/css/screen/tv3.css',
                'resources/js/screen/tv3.js',
                'resources/css/screen/tv4.css',
                'resources/js/screen/tv4.js',
              
            ],
            refresh: true,
        }),
    ],
});
