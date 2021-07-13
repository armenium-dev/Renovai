<?php
namespace Digidez;

class Custom_Taxonomies {
	
	/*
	 * Static function must be called after require within functions.inc.php
	 * This will setup all action hooks
	 */
	public static function initialise(){
		$self = new self();
		
		// define all action hooks here and document if not self explanatory
		add_action('init', array($self, 'createTaxonomies'), 1);
	}
	
	
	public function createLabels($label){
		$ret = [
			'name'              => _x($label['name'], 'taxonomy general name'),
			'singular_name'     => _x($label['singular_name'], 'taxonomy singular name'),
			'search_items'      => __('Search '.$label['name']),
			'all_items'         => __('All '.$label['name']),
			'parent_item'       => __('Parent '.$label['singular_name']),
			'parent_item_colon' => __('Parent '.$label['singular_name'].':'),
			'edit_item'         => __('Edit '.$label['singular_name']),
			'update_item'       => __('Update '.$label['singular_name']),
			'add_new_item'      => __('Add New '.$label['singular_name']),
			'new_item_name'     => __('New '.$label['singular_name'].' Name'),
			'menu_name'         => $label['name'],
		];
		
		return $ret;
	}
	
	public function createRewrite($post_type, $args){
		return [
			'slug' => $post_type.'s',
			'hierarchical' => $args['hierarchical'],
			'with_front' => false,
			'feed' => false
		];
	}
	
	/**
	 * [projectCategories description]
	 * @return [type] [description]
	 */
	public function createTaxonomies(){
		
		$defaults = [
			'labels'                => [],
			'hierarchical'          => true,
			'public'                => true,
			'show_in_nav_menus'     => false, // равен аргументу public
			'show_ui'               => true,
			'show_tagcloud'         => false, // равен аргументу show_ui
			'show_admin_column'     => true,
			'update_count_callback' => '_update_post_term_count',
			//'query_var'             => true,
		];
		
		$post_types_taxonomies = Custom_Post_Types::$post_types_taxonomies;
		if(!empty($post_types_taxonomies)){
			foreach($post_types_taxonomies as $post_type_cat => $post_type){
				$args = wp_parse_args($post_type['args'], $defaults);
				$args['labels'] = $this->createLabels($post_type['label']);
				$args['rewrite'] = $this->createRewrite($post_type['cpt'], $args);
				
				register_taxonomy($post_type_cat, $post_type['cpt'], $args);
			}
		}
		
		//...
		
	}
	
}
