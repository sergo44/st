const path = require('path');
const webpack = require('webpack');
const autoprefixer = require('autoprefixer')

module.exports = {
    entry: {
        style: [
            './assets/less/style.less'
        ],
        common: [
            './assets/js/common.js',
            './assets/js/user_sign.js',
            './assets/js/user_sign_in.js'
        ],
        add_object: [
            './assets/js/set_coordinates.js',
            './assets/js/add_object.js'
        ],
        objects_map: [
            './assets/js/objects_map.js'
        ],
        about_object: [
            './assets/js/about_object.js'
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
