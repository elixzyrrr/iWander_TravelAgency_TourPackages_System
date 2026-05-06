import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/admin.css',
                'resources/css/airlines-selection.css',
                'resources/css/auth.css',
                'resources/css/booking.css',
                'resources/css/booking_second.css',
                'resources/css/booking_third.css',
                'resources/css/flight-details.css',
                'resources/css/hotel-details.css',
                'resources/css/landing_page.css',
                'resources/css/loading.css',
                'resources/css/login.css',
                'resources/css/rooms-selection.css',
                'resources/css/signup.css',
                'resources/css/tour-dates-selection.css',
                'resources/css/tour-details.css',
                'resources/css/user_dashboard.css',
                'resources/js/app.js',
                'resources/js/airlines-selection.js',
                'resources/js/booking.js',
                'resources/js/booking_second.js',
                'resources/js/booking_third.js',
                'resources/js/flight-details.js',
                'resources/js/hotel-details.js',
                'resources/js/hotels-selection.js',
                'resources/js/loading.js',
                'resources/js/login.js',
                'resources/js/signup.js',
                'resources/js/tour-details.js',
                'resources/js/tour-selection.js',
                'resources/js/user_dashboard.js',
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
