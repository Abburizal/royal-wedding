import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                serif: ['Playfair Display', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                gold: {
                    50:  '#FDFAF3',
                    100: '#FAF3E0',
                    200: '#F0DFA8',
                    300: '#E2C97E',
                    400: '#D4B361',
                    500: '#C6A75E',  // champagne gold utama
                    600: '#B08D44',
                    700: '#8A6D30',
                    800: '#614D1E',
                    900: '#3D300F',
                },
                ivory: {
                    50:  '#FFFFFF',
                    100: '#FAFAF7',  // background utama
                    200: '#F5F4EF',
                    300: '#EDEAE0',
                    400: '#DDD8CB',
                },
            },
            boxShadow: {
                'luxury': '0 4px 24px -4px rgba(198, 167, 94, 0.15)',
                'luxury-lg': '0 8px 40px -8px rgba(198, 167, 94, 0.25)',
                'card': '0 2px 16px rgba(0,0,0,0.06)',
            },
        },
    },

    plugins: [forms],
};
