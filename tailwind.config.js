const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            width: {
                '1/8': '12.5%',
                '1/10': '10%',
            },
            height: {
                '1/2-screen': '50vh',
            },
            minHeight: {
                '1/2-screen': '50vh',
            },
            maxHeight: {
                '1/2-screen': '50vh',
                '3/4-screen': '75vh',
            },
            colors: {
                theme: {
                    900: '#3A3878',
                    600: '#D9DFF6',
                    500: '#5FBBFD',
                    400: '#EAEDF5',
                    300: '#F3F5FD',
                }
            },
            fontSize: {
                '2xs': '0.6rem',
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
