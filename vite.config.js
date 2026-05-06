import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/admin.css',
                'resources/css/booking.css',
                'resources/css/landing_page.css',
                'resources/css/user_dashboard.css',
                'resources/css/signup.css',
                'resources/js/app.js',
                'resources/js/booking.js',
                'resources/js/user_dashboard.js',
                'resources/js/signup.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
