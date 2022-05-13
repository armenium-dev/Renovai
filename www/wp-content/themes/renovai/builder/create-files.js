const fs = require('fs');

const dataIndexJs = 'import html from \'./components/pages/index.pug\';\n' +
	'// Import styles\n' +
	'import style from \'./sass/index.sass\';\n' +
	'// Import scripts\n' +
	'import $ from \'jquery\';\n' +
	'import popper from \'popper.js\';\n' +
	'import bootstrap from \'bootstrap\';\n' +
	'import slick from \'slick-carousel\';\n' +
	'import L from \'leaflet\';\n' +
	'\n' +
	'import \'./js/common.js\';';

const dataIndexSass = '@import \'variables\'\n' +
	'\n' +
	'@import \'~bootstrap/scss/bootstrap\'\n' +
	'@import \'~slick-carousel/slick/slick.css\'\n' +
	'@import \'~slick-carousel/slick/slick-theme.css\'\n' +
	'@import \'~font-awesome/css/font-awesome.min.css\'\n' +
	'@import \'~leaflet/dist/leaflet.css\'\n' +
	'\n' +
	'@import \'header\'\n' +
	'@import \'footer\'\n' +
	'@import \'breadcrumb\'\n' +
	'\n' +
	'@import \'ui\'\n' +
	'@import \'icons\'';

const dataIndexJson = '{}';

const dataLoyuotPug = 'block variables\n' +
	'- let path = self.htmlWebpackPlugin.options\n' +
	'\n' +
	'doctype html\n' +
	'html(lang="en")\n' +
	'\tinclude ../organisms/head\n' +
	'\thead\n' +
	'\t\t+head(path.file)\n' +
	'\t\tblock head\n' +
	'\tbody.d-flex.flex-column\n' +
	'\t\tinclude ../organisms/header\n' +
	'\t\tblock main\n' +
	'\t\tinclude ../organisms/footer\n' +
	'\t\tblock scripts\n';

const dataIndexPug = 'extends ../templates/layout\n' +
	'\n' +
	'block main\n' +
	'\tmain';

const dataHeadPug = 'mixin head(data)\n' +
	'\tmeta(charset="UTF-8")\n' +
	'\tmeta(name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes")\n' +
	'\tmeta(name="description" content=data && data.head && data.head.description || \'\')\n' +
	'\tlink(href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet")\n' +
	'\ttitle= (data && data.head && data.head.title || \'\') + \'\'\n' +
	'\tlink(rel="icon" type="image/x-icon" href="/favicon.ico")\n';

const configPages = 'module.exports.pages =  {\n' +
	'\tindex: \'./src/index.js\'\n' +
	'};\n';

const commonJS = '(function (factory, jQuery, Zepto) {\n' +
	'\tif (typeof define === \'function\' && define.amd) {\n' +
	'\t\tdefine([\'jquery\'], factory);\n' +
	'\t} else if (typeof exports === \'object\' && typeof Meteor === \'undefined\') {\n' +
	'\t\tmodule.exports = factory(require(\'jquery\'));\n' +
	'\t} else {\n' +
	'\t\tfactory(jQuery || Zepto);\n' +
	'\t}\n' +
	'}(function($){\n' +
	'\t\'use strict\';\n' +
	'\n' +
	'\t$.fn.exists = function () {\n' +
	'\t\treturn this.length !== 0;\n' +
	'\t};\n' +
	'\n' +
	'}, window.jQuery, window.Zepto));';

const gitIgnore = '.idea/\n' +
	'dist/\n' +
	'node_modules/';

const files = [
	{
		name: './src/index.js',
		data: dataIndexJs
	},
	{
		name: './src/sass/index.sass',
		data: dataIndexSass
	},
	{
		name: './src/sass/ui.sass'
	},
	{
		name: './src/sass/icons.sass'
	},
	{
		name: './src/sass/header.sass'
	},
	{
		name: './src/sass/footer.sass'
	},
	{
		name: './src/sass/breadcrumb.sass'
	},
	{
		name: './src/data/index.json',
		data: dataIndexJson
	},
	{
		name: './src/components/templates/layout.pug',
		data: dataLoyuotPug
	},
	{
		name: './src/components/pages/index.pug',
		data: dataIndexPug
	},
	{
		name: './src/components/organisms/footer.pug'
	},
	{
		name: './src/components/organisms/head.pug',
		data: dataHeadPug
	},
	{
		name: './src/components/organisms/header.pug'
	},
	{
		name: './config/config.pages.js',
		data: configPages
	},
	{
		name: './src/js/common.js',
		data: commonJS
	},
	{
		name: './.gitignore',
		data: gitIgnore
	},
	{
		name: './src/sass/variables.scss'
	}
];

for (const file of files) {
	fs.writeFileSync(file.name, file.data || '', 'utf8', (error) => {
		console.log(error);
	});
}

fs.copyFile('./node_modules/bootstrap/scss/_variables.scss', './src/sass/variables.scss', (err) => {
	if (err) throw err;
	console.log('_variables.scss was copied to variables.scss');
});

