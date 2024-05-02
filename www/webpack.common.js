const path = require('path');
const webpack = require('webpack');
const autoprefixer = require('autoprefixer')

module.exports = {
    entry: {
        common: [
            './assets/js/common.js',
            './assets/js/user_sign.js',
            './assets/js/user_sign_in.js',
            './assets/less/style.less'
        ]
    },
    output: {
        filename: '[name].bundle.js',
        path: path.resolve(__dirname, './public/build/'),
        clean: true
    },
    module: {
        rules: [
            {
                test: /\.less$/i,
                use: [
                    // compiles Less to CSS
                    "style-loader",
                    "css-loader",
                    "less-loader",
                ]
            },
            {
                test: /\.(scss)$/,
                use: [
                    {
                        loader: 'style-loader'
                    },
                    {
                        loader: 'css-loader'
                    },
                    {
                        loader: 'postcss-loader',
                        options: {
                            postcssOptions: {
                                plugins: [
                                    autoprefixer
                                ]
                            }
                        }
                    }
                ]
            }
        ]
    },

    plugins: [
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery'
        })
    ]
}
