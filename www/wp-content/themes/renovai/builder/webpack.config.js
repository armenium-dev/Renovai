const path = require('path');
const webpack = require('webpack');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const HtmlWebPackPlugin = require('html-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');

const configureCopy = () => {
	return [
		{from: "src/video/", to: "video/"},
		{from: "src/images/", to: "images/"},
		{from: 'src/fonts/', to: 'fonts/'}
	]
};

module.exports = {
	mode: 'development',

	entry: {
		index: './src/index.js'
	},

	output: {
		filename: 'js/index.js',
		path: path.resolve(__dirname, '../assets/')
	},

	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /node_modules/,
				use: {
					loader: 'babel-loader'
				}
			},
			{
				test: /\.(svg|png|jpg|gif|jpeg)$/,
				use: {
					loader: 'file-loader',
					options: {
						name: '[name].[ext]',
						outputPath: 'images/',
						publicPath: '../'
					}
				}
			},
			{
				test: /\.(mp4)$/,
				use: {
					loader: 'file-loader',
					options: {
						name: 'video/[name].[ext]',
						outputPath: 'video/',
						publicPath: '../'
					}
				}
			},
			{
				test: /\.(woff|woff2|eot|ttf|svg)$/,
				use: [
					{
						loader: 'file-loader',
						options: {
							name: 'fonts/[name].[ext]',
							outputPath: 'fonts/',
							publicPath: '../'
						}
					}
				]
			},
			{
				test: /\.pug$/,
				use: {
					loader: 'pug-loader',
					options: {
						pretty: true,
						self: true
					}
				}
			},
			{
				test: /\.(sass|css)$/,
				use: [
					MiniCssExtractPlugin.loader,
					// 'style-loader', // style nodes from js strings
					'css-loader',
					'sass-loader'
				]
			}
		]
	},

	plugins: [
		/*
		new CopyWebpackPlugin({
			patterns: configureCopy()
		}),
		new HtmlWebPackPlugin({
			template: './src/components/pages/index.pug',
			filename: 'index.html',
			file: require('./src/data/white-menu.json'),
			cache: false
		}),
		new HtmlWebPackPlugin({
			template: './src/components/pages/product-page.pug',
			filename: 'product-page.html',
			file: require('./src/data/black-menu.json'),
			cache: false
		}),
		new HtmlWebPackPlugin({
			template: './src/components/pages/careers.pug',
			filename: 'careers.html',
			file: require('./src/data/black-menu.json'),
			cache: false
		}),
		new HtmlWebPackPlugin({
			template: './src/components/pages/job-application.pug',
			filename: 'job-application.html',
			file: require('./src/data/black-menu.json'),
			cache: false
		}),
		new HtmlWebPackPlugin({
			template: './src/components/pages/case-studies.pug',
			filename: 'case-studies.html',
			file: require('./src/data/white-menu.json'),
			cache: false
		}),
		new HtmlWebPackPlugin({
			template: './src/components/pages/case-studies-item.pug',
			filename: 'case-studies-item.html',
			file: require('./src/data/white-menu.json'),
			cache: false
		}),
		new HtmlWebPackPlugin({
			template: './src/components/pages/case-studies-got-it.pug',
			filename: 'case-studies-got-it.html',
			file: require('./src/data/white-menu.json'),
			cache: false
		}),
		new HtmlWebPackPlugin({
			template: './src/components/pages/blog.pug',
			filename: 'blog.html',
			file: require('./src/data/white-menu.json'),
			cache: false
		}),
		new HtmlWebPackPlugin({
			template: './src/components/pages/blog-item.pug',
			filename: 'blog-item.html',
			file: require('./src/data/white-menu.json'),
			cache: false
		}),
		new HtmlWebPackPlugin({
			template: './src/components/pages/news.pug',
			filename: 'news.html',
			file: require('./src/data/white-menu.json'),
			cache: false
		}),
		new HtmlWebPackPlugin({
			template: './src/components/pages/page-not-found.pug',
			filename: 'page-not-found.html',
			file: require('./src/data/white-menu.json'),
			cache: false
		}),
		new HtmlWebPackPlugin({
			template: './src/components/pages/book-a-demo.pug',
			filename: 'book-a-demo.html',
			file: require('./src/data/black-menu.json'),
			cache: false
		}),
		new HtmlWebPackPlugin({
			template: './src/components/pages/thank-you.pug',
			filename: 'thank-you.html',
			file: require('./src/data/black-menu.json'),
			cache: false
		}),
		new HtmlWebPackPlugin({
			template: './src/components/pages/contact-thank-you.pug',
			filename: 'contact-thank-you.html',
			file: require('./src/data/white-menu.json'),
			cache: false
		}),
		new HtmlWebPackPlugin({
			template: './src/components/pages/reports-white-papers.pug',
			filename: 'reports-white-papers.html',
			file: require('./src/data/white-menu.json'),
			cache: false
		}),
		new HtmlWebPackPlugin({
			template: './src/components/pages/about.pug',
			filename: 'about.html',
			file: require('./src/data/black-menu.json'),
			cache: false
		}),
		new HtmlWebPackPlugin({
			template: './src/components/pages/contact-us.pug',
			filename: 'contact-us.html',
			file: require('./src/data/white-menu.json'),
			cache: false
		}),
		new HtmlWebPackPlugin({
			template: './src/components/pages/general-terms-and-conditions.pug',
			filename: 'general-terms-and-conditions.html',
			file: require('./src/data/white-menu.json'),
			cache: false
		}),
		new HtmlWebPackPlugin({
			template: './src/components/pages/studio-lp.pug',
			filename: 'studio-lp.html',
			file: require('./src/data/white-menu.json'),
			cache: false
		}),
		*/
		new MiniCssExtractPlugin({
			filename: 'css/custom.css',
			chunkFilename: '[id].css'
		})
	],

	optimization: {
		minimizer: [new TerserPlugin()],

		splitChunks: {
			cacheGroups: {
				vendors: {
					priority: -10,
					test: /[\\/]node_modules[\\/]/
				}
			},

			chunks: 'async',
			minChunks: 1,
			minSize: 30000,
			name: false
		}
	}
};
