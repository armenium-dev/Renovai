var el = wp.element.createElement,
	registerBlockType = wp.blocks.registerBlockType,
	RichText = wp.editor.RichText;

registerBlockType('my-gutenberg/blue-title-block', {
	title: 'Hading Blue',

	description: 'Insert H4 tag width custom css-class',

	icon: {
		background: '#61c0fa',
		foreground: '#fff',
		src: 'heading',
	},

	attributes: {
		content: {
			type: 'string',
			source: 'html',
			selector: 'h4',
		}
	},

	category: 'common',

	edit: function(props){
		var content = props.attributes.content;

		function onChangeContent(newContent){
			props.setAttributes({content: newContent});
		}

		return el(RichText, {
			tagName: 'h4',
			className: 'text-secondary',
			onChange: onChangeContent,
			value: content,
		});
	},

	save: function(props){
		var content = props.attributes.content;

		return el(RichText.Content, {
			tagName: 'h4',
			className: 'text-secondary',
			value: content
		});
	},
});
