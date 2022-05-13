const ENTRY = require('./config/config.pages');
const path = require('path');
const HtmlWebPackPlugin = require('html-webpack-plugin');

// configure Resolve
const configureResolveAlias = () => {
	return {
		alias: {
			'assets': path.resolve(__dirname, './src/images')
		}
	}
};

// configure Babel Loader
const configureBabelLoader = () => {
	return {
		test: /\.js$/,
		exclude: /node_modules/,
		use: {
			loader: 'babel-loader',
		},
	}
};

// configure Pug Loader
const configurePugLoader = () => {
	return {
		test: /\.pug$/,
		loader: 'pug-loader',
		options: {
			pretty: true,
			self: true,
		}
	}
};

module.exports = {
	entry: ENTRY.pages,
	resolve: configureResolveAlias(),
	module: {
		rules: [
			configureBabelLoader(),
			configurePugLoader(),
		],
	},
	plugins: Object.keys(ENTRY.pages).map(entryName => {
		return new HtmlWebPackPlugin({
			filename: `${entryName}.html`,
			template: `./src/components/pages/${entryName}.pug`,
			file: require(`./src/data/${entryName}.json`),
			chunks: [entryName],
			mode: process.env.NODE_ENV === 'production' ? 'production' : 'development'
		});
	})
};
