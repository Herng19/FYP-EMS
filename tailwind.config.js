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
                '900': '#1E3483',
                '700': '#1A39A6', 
                '500': '#132FBA', 
                '300': '#99ADF5', 
                '200': '#D3DBF8', 
                '100': '#E8EDFF', 
            }, 
            'darkblue': '#38477C', 
            'gray': {
                '900': '#2D2D2A',
            }, 
            'milk': '#FFF6D2', 
            'ivory': '#FFFEFA', 
            ...colors, 
        },
        borderRadius: {
            'none': '0',
            'sm': '4px',
            DEFAULT: '0.25rem',
            DEFAULT: '8px',
            'md': '12px',
            'lg': '20px',
            'full': '9999px',
            'large': '20px',
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
