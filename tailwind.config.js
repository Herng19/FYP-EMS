import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
const colors = require('tailwindcss/colors')
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        colors: {
            'primary': {
                '700': '#1A39A6', 
                '500': '#132FBA', 
                '300': '#99ADF5', 
                '200': '#D3DBF8', 
                '100': '#E8EDFF', 
            }, 
            'gray': {
                '900': '#2D2D2A',
            }, 
            'milk': '#FFF6D2', 
            'ivory': '#FFFEFA', 
            ...colors, 
        },
        extend: {
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
                serif: ['Pridi', ...defaultTheme.fontFamily.serif],
            },
        },
    },

    plugins: [forms, typography],
};
