const path = require('path')
const PrerenderSPAPlugin = require('prerender-spa-plugin')
const webpack = require('webpack');

module.exports = {
  configureWebpack: {
    plugins: [
      new PrerenderSPAPlugin({
        // Required - The path to the webpack-outputted app to prerender.
        staticDir: path.join(__dirname, 'dist'),
        // Required - Routes to render.
        routes: ['/']
      }),
      new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/, /de|fr|hu/)
    ],
  },
  chainWebpack: (config) => {
    config.plugins.delete('prefetch')
    config.plugin('preload').tap((options) => {
      options[0].include = 'css'
      return options
    })
  }
}