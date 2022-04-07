const mix = require('laravel-mix');

require('laravel-mix-purgecss');

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ]);

// Jquery
mix.combine([
    'resources/plugins/jquery/jquery-3.6.0.js',
],'public/plugins/jquery/plugin.min.js');

if (mix.inProduction()) {
    mix.version();
}
