const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
// module.exports = {
//     // ...
//     resolve: {
//       alias: {
//         //jquery: 'jquery/src/jquery',
//         'vue$': 'vue/dist/vue.esm.js',
//       }
//     }
//     // ...
//   }
// mix.webpackConfig({
//     resolve: {
//         alias: {
//         //jquery: 'jquery/src/jquery',
//             'vue$': 'vue/dist/vue',
//         }
//     }
// });
mix//.js('resources/js/datatable.js', 'public/js');
    .js('resources/js/order_table.js', 'public/js');
    //.js('resources/js/app.js', 'public/js');
    //.sass('resources/sass/app.scss', 'public/css');
