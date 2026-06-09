let path = require('path');
let mix = require('laravel-mix');
let postcssImport = require('postcss-import');
let tailwindcss = require('tailwindcss');

mix.extend('nova', new require('laravel-nova-devtool'));

mix
  .setPublicPath('dist')
  .js('resources/js/field.js', 'js')
  .vue({ version: 3 })
  .nova('outl1ne/nova-color-fields')
  .postCss('resources/css/field.css', 'dist/css/', [postcssImport(), tailwindcss('tailwind.config.js')]);
