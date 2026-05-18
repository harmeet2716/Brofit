import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'fit-green': '#15803D',      /* Clean flat deep forest green - NO PARROT OR LIME GLOW */
                'fit-green-light': '#ffffff', /* Pure white */
                'fit-green-dark': '#166534',  /* Extra deep solid dark green */
            },
            borderRadius: {
                none: '0px',
                sm: '0px',
                DEFAULT: '0px',
                md: '0px',
                lg: '0px',
                xl: '0px',
                '2xl': '0px',
                '3xl': '0px',
                full: '0px',
            },
            boxShadow: {
                sm: 'none',
                DEFAULT: 'none',
                md: 'none',
                lg: 'none',
                xl: 'none',
                '2xl': 'none',
                inner: 'none',
                none: 'none',
            },
            transitionProperty: {
                none: 'none',
                all: 'none',
                DEFAULT: 'none',
                colors: 'none',
                opacity: 'none',
                shadow: 'none',
                transform: 'none',
            },
            transitionDuration: {
                DEFAULT: '0ms',
            },
            animation: {
                none: 'none',
                spin: 'none',
                ping: 'none',
                pulse: 'none',
                bounce: 'none',
            }
        },
    },

    plugins: [forms],
};
