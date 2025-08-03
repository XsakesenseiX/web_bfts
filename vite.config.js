import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/member.css',
                'resources/css/member-safe-styling.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});
