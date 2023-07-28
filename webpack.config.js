const path = require('path');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const { WebpackManifestPlugin } = require('webpack-manifest-plugin');

require('dotenv').config();

module.exports = {
	mode: 'production',
	devtool: false,
	entry: {
		admin: './resources/js/admin.js',
		app: './resources/js/app.js',
	},
	output: {
		filename: 'assets/js/[name].min.js?[contenthash]',
		path: path.resolve(__dirname, 'public'),
		publicPath: '/',
	},
	plugins: [
		new MiniCssExtractPlugin({
			filename: 'assets/css/[name].min.css?[contenthash]',
		}),
		new WebpackManifestPlugin({
			map: (f) => {
				f.name = f.path.replace(/\?.+$/, '');
				return f;
			},
			fileName: 'mix-manifest.json',
		}),
		new BrowserSyncPlugin({
			proxy: process.env.APP_URL,
			port: 3000,
			files: [
				'public/assets/js/**/*',
				'public/assets/css/**/*',
				'resources/views/**/*',
			],
			snippetOptions: {
				rule: {
					match: /<body[^>]*>/i,
					fn: (snippet, match) => (
						// Allow Browsersync to work with Content-Security-Policy without script-src 'unsafe-inline'.
						`${match}${snippet.replace('id=', 'nonce="browser-sync" id=')}`
					),
				},
			},
		}, {
			reload: false,
		}),
	],
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /node_modules/,
				use: ['babel-loader'],
			},
			{
				test: /\.scss$/,
				use: [
					MiniCssExtractPlugin.loader,
					{
						loader: 'css-loader',
						options: {
							url: false,
						},
					},
					{
						loader: 'postcss-loader',
						options: {
							postcssOptions: {
								plugins: [
									'autoprefixer',
									'cssnano',
								],
							},
						},
					},
					'sass-loader',
				],
			},
		],
	},
	optimization: {
		minimizer: [
			new TerserPlugin({
				extractComments: false,
			}),
		],
		splitChunks: {
			cacheGroups: {
				style: {
					name: 'style',
					type: 'css/mini-extract',
					chunks: (chunk) => (chunk.name === 'app'),
					enforce: true,
				},
				admin: {
					name: 'admin',
					type: 'css/mini-extract',
					chunks: (chunk) => (chunk.name === 'admin'),
					enforce: true,
				},
			},
		},
	},
};
