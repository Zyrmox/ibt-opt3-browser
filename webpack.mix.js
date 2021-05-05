
const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ]);

mix.copy('node_modules/fullcalendar/main.min.js', 'public/js/fullcalendar.js')
    .copy('node_modules/fullcalendar/locales/cs.js', 'public/js/fullcalendar-cs.js')
    .css('node_modules/fullcalendar/main.min.css', 'public/css/fullcalendar.css');

if (mix.inProduction()) {
    mix.version();
}


