const mix = require('laravel-mix');

require('laravel-mix-purgecss');

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ]);

mix.copyDirectory('resources/images', 'public/images');

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

// Datatables
mix.combine([
    'resources/plugins/datatables/datatables.js',
    'resources/plugins/datatables/tr.js',
    'resources/plugins/datatables/make.js',
],'public/plugins/datatables/plugin.min.js');

mix.combine([
    'resources/plugins/datatables/datatables.css',
],'public/plugins/datatables/plugin.min.css').purgeCss();

mix.copyDirectory('resources/plugins/datatables/images', 'public/plugins/datatables/images');

// Sweetalert 2
mix.combine([
    'resources/plugins/sweetalert2/sweetalert2.js',
    'resources/plugins/sweetalert2/make.js',
],'public/plugins/sweetalert2/plugin.min.js');

// Toastr
mix.combine([
    'resources/plugins/toastr/toastr.js',
],'public/plugins/toastr/plugin.min.js');

mix.combine([
    'resources/plugins/toastr/toastr.css',
],'public/plugins/toastr/plugin.min.css').purgeCss();

// Dropzone
mix.combine([
    'resources/plugins/dropzone/dropzone.js',
],'public/plugins/dropzone/plugin.min.js');

mix.combine([
    'resources/plugins/dropzone/dropzone.css',
],'public/plugins/dropzone/plugin.min.css').purgeCss();

// Jquery
mix.combine([
    'resources/plugins/kCode/k-code.js',
],'public/plugins/kCode/plugin.min.js');

if (mix.inProduction()) {
    mix.version();
}
