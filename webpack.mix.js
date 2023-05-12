const mix = require("laravel-mix");

mix.options({
    terser: {
        extractComments: false, //remove comments
    },
})

mix.postCss('resources/css/filament-phone.css', 'dist/css', [
    require('tailwindcss')
])
