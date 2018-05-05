const path = require('path');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const cssnano = require('cssnano');

const buildPath = path.resolve(__dirname, 'dist');
const extractSass = new ExtractTextPlugin({
    publicPath:  buildPath,
    filename: 'styles.css'
});
const env = process.env.NODE_ENV;
const isDev = (env !== 'production');
const plugins = [
    extractSass
];

if (!isDev) {
    plugins.push(new UglifyJsPlugin({
        sourceMap: true,
        uglifyOptions: {
            ecma:8,
            compress: {
                warnings: false
            }
        }
    }));

    plugins.push(new OptimizeCSSAssetsPlugin({
        cssProcessor: cssnano,
        cssProcessorOptions: { discardComments: { removeAll: true } },
        canPrint: false
    }));
}

const config = {
    devtool: 'source-map',
    mode: isDev ? 'development' : 'production',
    entry: {
        app: './js/app/app.js',
        styles: './sass/styles.scss'
    },
    output: {
        path: buildPath,
        filename: '[name].js'
    },
    watchOptions: {
        poll: 1000
    },
    module: {
        rules: [
            {
                test: /\.scss$/,
                use: extractSass.extract({
                    use: [{
                        loader: 'css-loader?sourceMap'
                    }, {
                        loader: 'sass-loader?sourceMap',
                        options: {
                            sourceMap: true,
                        }
                    }],
                    // use style-loader in development
                    fallback: 'style-loader'
                })
            },
            {
                test: /\.css$/,
                use: [{
                    loader: 'style-loader?sourceMap'
                }, {
                    loader: 'css-loader?sourceMap',
                    options: {
                        sourceMap: true,
                    },
                }, {
                    loader: 'resolve-url-loader'
                }]
            },
            {
                test: /\.(gif|png|jpe?g|svg)$/i,
                use: [
                    'file-loader',
                    {
                        loader: 'image-webpack-loader',
                        options: !isDev ? {
                            bypassOnDebug: true,
                            pngquant: {
                                quality: '65-90',
                                speed: 4
                            }
                        } : {},
                    },
                ],
            },
            { test: /\.eot(\?v=\d+\.\d+\.\d+)?$/, loader: 'url-loader?mimetype=application/vnd.ms-fontobject'},
            { test: /\.woff(2)?(\?v=\d+\.\d+\.\d+)?$/, loader: 'url-loader?limit=10000&mimetype=application/font-woff'},
            { test: /\.ttf(\?v=\d+\.\d+\.\d+)?$/, loader: 'url-loader?limit=10000&mimetype=application/octet-stream'},
            { test: /.svg(\?v=\d+\.\d+\.\d+)?$|.svg$/, loader: 'file-loader?name=[path][name].[ext]&context=./src&mimetype=image/svg+xml'},
            { test: /\.(jpg|png|woff|woff2|eot|ttf|svg)$/, loader: 'file-loader?url-loader?limit=100000' }
        ]
    },
    plugins: plugins
};

module.exports = config;