const mix = require('laravel-mix');

//noinspection JSUnresolvedFunction
mix.js('resources/assets/application.js', 'public/assets')
   .sass('resources/assets/application.scss', 'public/assets');
