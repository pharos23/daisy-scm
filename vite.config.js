import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/pages/login.js',
                'resources/js/pages/contacts.js',
                'resources/js/pages/users.js',
                'resources/js/pages/roles.js',
                'resources/js/pages/permissions.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
