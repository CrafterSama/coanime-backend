const mix = require('laravel-mix');

const { distAssets } = require('./package.json') // TODO: Usar .min al terminar etapa de pruebas

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

mix.js('resources/js/app.js', 'public/assets/js')
  .sass('resources/sass/app.scss', 'public/assets/css');

// TODO: Mover CSS la carpeta flat a sass.
mix.copy('resources/flat/css/*.css', 'public/assets/css')
mix.copy('resources/flat/js/*.js', 'public/assets/js')

// Usar .extract al corregir el bug que lo impide y dejar de usar los js en distAssets


/*
 |--------------------------------------------------------------------------
 | Static Vendor Packages Management
 |--------------------------------------------------------------------------
 |
 |
 */

/**
 * Resource handler for publishing (copy).
 *
 * @author Nelson Martell <nelson6e65@gmail.com>
 * @copyright 2017 (c) Nelson Martell
 * @license MIT
 */
class Resource {
  /**
   *
   * @param {String} name Resource name (path name).
   */
  constructor (name) {
    this.name = name
  }

  get sourceDir () {
    return 'node_modules/' + this.name + '/'
  }

  get publishDir () {
    return 'public/assets/vendor/' + this.name + '/'
  }

  /**
   * Copy resources from 'node_modules' to the public directory.
   *
   * @param {String} src          Asset file/dir path (relative to sources).
   * @param  {String} [target=''] Target dir/name path (path relative to destination).
   *
   * @todo Allow arrays for 'src' param.
   */
  publish (src, target = '') {
    mix.copy(this.sourceDir + src, this.publishDir + target)
  }
}

Object.keys(distAssets).forEach(function (name) {
  let res = new Resource(name)

  distAssets[name].forEach(function (asset) {
    res.publish(asset.src, asset.target)
  })
})
