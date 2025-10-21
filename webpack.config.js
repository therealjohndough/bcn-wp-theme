const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');

module.exports = (env, argv) => {
  const isProduction = argv.mode === 'production';
  
  return {
    entry: {
      'main': './assets/js/main.js',
      'member-cards-enhanced': './assets/js/member-cards-enhanced.js',
      'member-archive': './assets/js/member-archive.js',
      'customizer': './assets/js/customizer.js',
      'navigation': './assets/js/navigation.js'
    },
    output: {
      path: path.resolve(__dirname, 'build/assets'),
      filename: 'js/[name].js',
      clean: true
    },
    module: {
      rules: [
        {
          test: /\.js$/,
          exclude: /node_modules/,
          use: {
            loader: 'babel-loader',
            options: {
              presets: ['@babel/preset-env']
            }
          }
        },
        {
          test: /\.scss$/,
          use: [
            MiniCssExtractPlugin.loader,
            'css-loader',
            'postcss-loader',
            'sass-loader'
          ]
        },
        {
          test: /\.css$/,
          use: [
            MiniCssExtractPlugin.loader,
            'css-loader',
            'postcss-loader'
          ]
        },
        {
          test: /\.(png|jpg|jpeg|gif|svg)$/,
          type: 'asset/resource',
          generator: {
            filename: 'images/[name][ext]'
          }
        },
        {
          test: /\.(woff|woff2|eot|ttf|otf)$/,
          type: 'asset/resource',
          generator: {
            filename: 'fonts/[name][ext]'
          }
        }
      ]
    },
    plugins: [
      new CleanWebpackPlugin(),
      new MiniCssExtractPlugin({
        filename: 'css/[name].css'
      }),
      new CopyWebpackPlugin({
        patterns: [
          {
            from: 'assets/images',
            to: 'images',
            noErrorOnMissing: true
          },
          {
            from: 'assets/fonts',
            to: 'fonts',
            noErrorOnMissing: true
          }
        ]
      })
    ],
    optimization: {
      minimize: isProduction,
      minimizer: [
        new TerserPlugin({
          terserOptions: {
            compress: {
              drop_console: isProduction
            }
          }
        }),
        new CssMinimizerPlugin()
      ],
      splitChunks: {
        chunks: 'all',
        cacheGroups: {
          vendor: {
            test: /[\\/]node_modules[\\/]/,
            name: 'vendors',
            chunks: 'all'
          }
        }
      }
    },
    devtool: isProduction ? 'source-map' : 'eval-source-map',
    resolve: {
      extensions: ['.js', '.scss', '.css'],
      alias: {
        '@': path.resolve(__dirname, 'assets'),
        '@js': path.resolve(__dirname, 'assets/js'),
        '@css': path.resolve(__dirname, 'assets/css'),
        '@images': path.resolve(__dirname, 'assets/images')
      }
    },
    externals: {
      jquery: 'jQuery'
    }
  };
};