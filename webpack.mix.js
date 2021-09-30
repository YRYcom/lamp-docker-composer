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
    .copy('vendor/almasaeed2010/adminlte/plugins','public/adminlte/plugins')
    .copy('vendor/almasaeed2010/adminlte/dist','public/adminlte/')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);
