<?php


namespace Digidez;


class Editor {
	
	public static function initialise(){
		$self = new self();
		
		add_action('init', [$self, 'custom_blocks_for_gutenberg']);
		
	}
	
	
	public function custom_blocks_for_gutenberg(){
		wp_register_script(THEME_SHORT.'-script-editor', INC_URI.'/editor/blocks/script_editor.js', ['wp-blocks', 'wp-element', 'wp-components']);
		wp_register_style(THEME_SHORT.'-style-editor', INC_URI.'/editor/blocks/style_editor.css', ['wp-edit-blocks']);
		#wp_register_style(THEME_SHORT.'-front-style', INC_URI.'/editor/blocks/style.css', ['wp-blocks']);
		
		register_block_type('my-gutenberg/my-first-block', [
			'editor_script' => THEME_SHORT.'-script-editor',
			'editor_style'  => THEME_SHORT.'-style-editor',
			#'style'         => THEME_SHORT.'-front-style'
		]);
	}
	
	
}
