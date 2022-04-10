const mix = require('laravel-mix');

require('laravel-mix-purgecss');

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ]);

// Books
mix.combine([
    'resources/css/bootstrap.css',
    'resources/css/books.css',
],'public/css/books.css').purgeCss();

// Jquery
mix.combine([
    'resources/plugins/jquery/jquery-3.6.0.js',
],'public/plugins/jquery/plugin.min.js');

// Modernizr
mix.combine([
    'resources/plugins/modernizr/modernizr.js',
],'public/plugins/modernizr/plugin.min.js');

// Bookblock
mix.combine([
    'resources/plugins/bookblock/bookblock.js',
    'resources/plugins/bookblock/custom.js',
],'public/plugins/bookblock/plugin.min.js');

mix.combine([
    'resources/plugins/bookblock/bookblock.css',
],'public/plugins/bookblock/plugin.min.css').purgeCss();

// Howler
mix.combine([
    'resources/plugins/howler/howler.js',
],'public/plugins/howler/plugin.min.js');

// Lazy
mix.combine([
    'resources/plugins/lazy/lazy.js',
    'resources/plugins/lazy/jquery.lazy.plugins.js',
],'public/plugins/lazy/plugin.min.js');

if (mix.inProduction()) {
    mix.version();
}
