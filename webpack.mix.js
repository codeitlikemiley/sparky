let mix = require('laravel-mix');
var path = require('path');
mix.webpackConfig({
    resolve: {
        modules: [
            path.resolve(__dirname, 'vendor/laravel/spark/resources/assets/js'),
            'node_modules',
        ],
        alias: {
            'vue$': 'vue/dist/vue.js'
        }
    }
});
// Copy Laravel Spark Sweet Alert
mix.copy('node_modules/sweetalert/dist/sweetalert.min.js', 'public/js/sweetalert.min.js')
    .copy('node_modules/sweetalert/dist/sweetalert.css', 'public/css/sweetalert.css')
mix.styles([
    // Add Here all CSS to Concatenate

    // We import Metro Ui
    'resources/assets/metro/css/metro.css',
    'resources/assets/metro/css/metro-icons.css',
    'resources/assets/metro/css/metro-responsive.css',
    'resources/assets/metro/css/metro-schemes.css',
    'resources/assets/metro/css/metro-colors.css',
    'resources/assets/metro/css/metroskin-animation.css',
    'resources/assets/metro/css/font-awesome.css',
    'resources/assets/metro/plugins/bootstrap/css/bootstrap.metro.css',
    'resources/assets/metro/css/help.css',
    'resources/assets/metro/css/parsley.css',
    'resources/assets/metro/css/docs.css',
    'resources/assets/metro/css/docs-rtl.css',
    // This is Required By Spark 
    // app.css will be our override
    // 'resources/assets/build/css/app.css',
], 'public/css/metroui.css')

// This Has Jquery Included
mix.js('resources/assets/js/app.js', 'public/js/app.js')

mix.combine([
    // required Jquery to Run this
    'resources/assets/metro/js/metro.js',
    'resources/assets/metro/plugins/jquery-ui.min.js',
    // added data tables // read more about this shit
    'resources/assets/metro/js/jquery.dataTables.min.js',
    'resources/assets/metro/js/web.js',
    'resources/assets/metro/js/docs.js',
], 'public/js/metroui.js')

if (mix.config.inProduction) {
    mix.version()
}
mix.browserSync({
    proxy: 'evolutly-info.dev'
});