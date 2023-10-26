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
                '900': '#032d7c',
                '800': '#012b7a',
                '700': '#1A39A6', 
                '600': '#1E3483',
                '500': '#132FBA', 
                '400': '#3a51c7', 
                '300': '#99ADF5', 
                '200': '#D3DBF8', 
                '100': '#E8EDFF', 
                '50': '#F0F3FF',
            }, 
            'darkblue': '#38477C', 
            'gray': '#2D2D2A',
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
