import BrowserSyncPlugin from 'browser-sync-webpack-plugin';
import CssMinimizerPlugin from 'css-minimizer-webpack-plugin';
import MiniCssExtractPlugin from 'mini-css-extract-plugin';
import path from 'path';
import postcssCustomProperties from 'postcss-custom-properties';
import postcssRelativeColorSyntax from '@csstools/postcss-relative-color-syntax';
import TerserPlugin from 'terser-webpack-plugin';
import { WebpackManifestPlugin } from 'webpack-manifest-plugin';

process.loadEnvFile();

export default {
	mode: 'production',
	devtool: false,
	entry: {
		admin: './resources/js/admin.js',
		app: './resources/js/app.js',
	},
	output: {
		filename: 'assets/js/[name].min.js?[contenthash]',
		path: path.resolve(process.cwd(), 'public'),
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
				test: /\.css$/,
				use: [
					MiniCssExtractPlugin.loader,
					{
						loader: 'css-loader',
						options: {
							importLoaders: 1,
							url: false,
						},
					},
					{
						loader: 'postcss-loader',
						options: {
							postcssOptions: {
								plugins: [
									[
										'@csstools/postcss-global-data',
										{
											files: [
												'./resources/css/utilities/breakpoints.css',
												'./resources/css/utilities/colors.css',
											],
										},
									],

									// Relative color syntax is not supported by iOS 12.
									// postcss-relative-color-syntax has a polyfill, but it cannot dynamically resolve var in relative color syntax,
									// so replace vars with static values first using postcss-custom-properties.
									postcssCustomProperties(),
									postcssRelativeColorSyntax(),

									'postcss-preset-env',
								],
							},
						},
					},
				],
			},
		],
	},
	optimization: {
		minimizer: [
			new TerserPlugin({
				extractComments: false,
			}),
			new CssMinimizerPlugin({
				minimizerOptions: {
					// Disable postcss-calc to avoid warnings about calc() inside hsl().
					// https://github.com/postcss/postcss-calc/issues/216
					preset: ['default', { calc: false }],
				},
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
