import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
const colors = require('tailwindcss/colors'); 

delete colors['lightBlue'];
delete colors['warmGray'];
delete colors['trueGray'];
delete colors['coolGray'];
delete colors['blueGray'];

export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./node_modules/flowbite/**/*.js"
    ],

    theme: {
        colors: {
            'primary': {
                '900': '#006061',
                '800': '#008081',
                '700': '#009091', 
                '600': '#00A0A1',
                '500': '#1AAAAA', 
                '400': '#33b3b4', 
                '300': '#4dbdbd', 
                '200': '#80d0d0', 
                '100': '#ccecec', 
                '50': '#edf7f7',
            }, 
            'darkblue': '#38477C', 
            'gray': '#324B4B',
            'milk': '#FFF6D2', 
            'ivory': '#FFFEFA', 
            ...colors, 
        },
        fontSize: {
            xs: '0.75rem',
            sm: '0.825rem',
            base: '1rem',
            xl: '1.25rem',
            '2xl': '1.563rem',
            '3xl': '1.953rem',
            '4xl': '2.441rem',
            '5xl': '3.052rem',
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

    plugins: [
        forms, 
        typography,
        require('flowbite/plugin')
    ],
};
