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
const assets = './../assets'
const imagePath = assets + '/image'
const jsPath = assets + '/js'
const cssPath = assets + '/css'

mix.options({
    processCssUrls: false
});
mix.js('js/script.js', jsPath)
    .sass('scss/style.scss', '/css')
    .options({
        autoprefixer: {
            options: {
                browsers: [
                    'last 6 versions',
                ]
            }
        }
    }).sourceMaps()

mix.setPublicPath(assets + '/')
    .copyDirectory('image', `${imagePath}`)
    .copyDirectory('node_modules/@glidejs/glide/dist/glide.min.js', `${jsPath}`)
    .copyDirectory('node_modules/@glidejs/glide/dist/css/glide.core.min.css', `${cssPath}`)
    .copyDirectory('node_modules/@glidejs/glide/dist/css/glide.theme.min.css', `${cssPath}`)
