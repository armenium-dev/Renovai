<?php
namespace Digidez;

class Custom_Post_Types {

	public static $post_types_taxonomies = [];

    public static function initialise(){
        $self = new self();

        // define all action hooks here and document if not self explanatory
        add_action('init', [$self, 'postTypeFunction'], 0);
    }

    private function createLabels($name, $plural_name = ''){
    	if(empty($plural_name)){
		    $plural_name = $name;
		
		    if(substr($name, -1, 1) == 's'){
			    $plural_name .= 'es';
		    }else{
			    $plural_name .= 's';
		    }
	    }
    	
	    $labels = [
		    'name'                  => _x($plural_name, 'Post Type General Name', THEME_TD),
		    'singular_name'         => _x($name, 'Post Type Singular Name', THEME_TD),
		    'menu_name'             => __($plural_name, THEME_TD),
		    'name_admin_bar'        => __($plural_name, THEME_TD),
		    'archives'              => __($plural_name, THEME_TD),
		    'attributes'            => __('Item Attributes', THEME_TD),
		    'parent_item_colon'     => __('Parent Item:', THEME_TD),
		    'all_items'             => __('All '.$plural_name, THEME_TD),
		    'add_new_item'          => __('Add new '.$name, THEME_TD),
		    'add_new'               => __('Add new '.$name, THEME_TD),
		    'new_item'              => __('New '.$name, THEME_TD),
		    'edit_item'             => __('Edit '.$name, THEME_TD),
		    'update_item'           => __('Update '.$name, THEME_TD),
		    'view_item'             => __('View '.$name, THEME_TD),
		    'view_items'            => __('View items', THEME_TD),
		    'search_items'          => __('Search Item', THEME_TD),
		    'not_found'             => __('Not found', THEME_TD),
		    'not_found_in_trash'    => __('Not found in Trash', THEME_TD),
		    'featured_image'        => __($name.' image', THEME_TD),
		    'set_featured_image'    => __('Set image', THEME_TD),
		    'remove_featured_image' => __('Remove image', THEME_TD),
		    'use_featured_image'    => __('Use as '.$name.' image', THEME_TD),
		    'insert_into_item'      => __('insert into item', THEME_TD),
		    'uploaded_to_this_item' => __('Uploaded to this item', THEME_TD),
		    'items_list'            => __('Items list', THEME_TD),
		    'items_list_navigation' => __('Items list navigation', THEME_TD),
		    'filter_items_list'     => __('Filter items list', THEME_TD),
	    ];

	    return $labels;
    }

	public function postTypeFunction(){
		self::create_testimonials_cpt();
		self::create_clients_cpt();
		self::create_news_cpt();
		self::create_content_slider_cpt();
		self::create_jobs_cpt();
		self::create_case_studies_cpt();
		self::create_vaid_solution_cpt();
	}
	
	public function create_testimonials_cpt(){
		$cpt = 'testimonial';
		$labels = $this->createLabels('Testimonial');
		$args = [
			'label'               => __('Testimonial', THEME_TD),
			'description'         => __('Testimonials', THEME_TD),
			'labels'              => $labels,
			'supports'            => ['title', 'page-attributes'],
			'hierarchical'        => false,
			'public'              => false,
			'publicly_queryable'  => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 20,
			'menu_icon'           => 'dashicons-admin-post',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => true,
			'capability_type'     => 'post',
		];
		
		register_post_type($cpt, $args);
		//self::$post_types_taxonomies[] = $cpt;
	}
	
	public function create_clients_cpt(){
		$cpt = 'client';
		$name = 'Client';
		$labels = $this->createLabels($name);
		$args = [
			'label'               => __($name, THEME_TD),
			'description'         => __($name.'s', THEME_TD),
			'labels'              => $labels,
			'supports'            => ['title', 'page-attributes'],
			'hierarchical'        => false,
			'public'              => false,
			'publicly_queryable'  => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 20,
			'menu_icon'           => 'dashicons-admin-post',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => true,
			'capability_type'     => 'post',
		];
		
		register_post_type($cpt, $args);
	}
	
	public function create_news_cpt(){
		$cpt = 'news';
		$name = 'News';
		$labels = $this->createLabels($name, $name);
		$args = [
			'label'               => __($name, THEME_TD),
			'description'         => __($name, THEME_TD),
			'labels'              => $labels,
			'supports'            => ['title', 'page-attributes'],
			'hierarchical'        => false,
			'public'              => false,
			'publicly_queryable'  => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 20,
			'menu_icon'           => 'dashicons-admin-post',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => true,
			'capability_type'     => 'post',
		];
		
		register_post_type($cpt, $args);
	}
	
	public function create_maplocations_cpt(){
		$cpt = 'map_location';
		$labels = $this->createLabels('Map Location');
		$args = [
			'label'               => __('Map Location', THEME_TD),
			'description'         => __('Map Locations and performances', THEME_TD),
			'labels'              => $labels,
			'supports'            => ['title', 'editor'],
			'hierarchical'        => false,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 20,
			'menu_icon'           => 'dashicons-admin-post',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
		];

		register_post_type($cpt, $args);
		//self::$post_types_taxonomies[] = $cpt;
	}

	public function create_partners_cpt(){
		$cpt = 'partner';
		$labels = $this->createLabels('Partner');
		$args = [
			'label'               => __('Partner', THEME_TD),
			'description'         => __('Partners and performances', THEME_TD),
			'labels'              => $labels,
			'supports'            => ['title', 'thumbnail', 'page-attributes'],
			'hierarchical'        => false,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 25,
			'menu_icon'           => 'dashicons-groups',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'capability_type'     => 'page',
		];

		register_post_type($cpt, $args);
		//self::$post_types_taxonomies[] = $cpt;
	}

	public function create_portfolio_cpt(){
		$cpt = 'portfolio';
		$labels = $this->createLabels('Portfolio');
		$args = [
			'label'               => __('Portfolio', THEME_TD),
			'description'         => __('Portfolios', THEME_TD),
			'labels'              => $labels,
			'supports'            => ['title', 'thumbnail', 'page-attributes'],
			'hierarchical'        => false,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 25,
			'menu_icon'           => 'dashicons-groups',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'capability_type'     => 'page',
		];

		register_post_type($cpt, $args);
		//self::$post_types_taxonomies[] = $cpt;
	}

	public function create_jobs_cpt(){
		$cpt = 'job';
		$name = 'Job';
		$labels = $this->createLabels($name);
		$args = [
			'label'               => __($name, THEME_TD),
			'description'         => __($name.'s', THEME_TD),
			'labels'              => $labels,
			'supports'            => ['title', 'page-attributes'],
			'hierarchical'        => false,
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_rest'        => false,
			'rest_base'           => '',
			'show_in_menu'        => true,
			'exclude_from_search' => false,
			'menu_position'       => 20,
			'menu_icon'           => 'dashicons-admin-post',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => $cpt,
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
			'query_var'           => true,
			'taxonomies'          => [$cpt.'-cat'],
			//'rewrite'             => ['slug' => $cpt.'s/%'.$cpt.'-cat%', 'with_front' => false, 'pages' => false, 'feeds' => false, 'feed' => false],
			'rewrite'             => ['slug' => $cpt, 'with_front' => false, 'pages' => false, 'feeds' => false, 'feed' => false],
		];

		register_post_type($cpt, $args);
		self::$post_types_taxonomies[$cpt.'-cat'] = ['cpt' => $cpt, 'label' => ['name' => 'Categories', 'singular_name' => 'Category'], 'args' => ['public' => false]];
	}

	public function create_content_slider_cpt(){
		$cpt = 'content_slider';
		$labels = $this->createLabels('Content Slider');
		$args = [
			'label'               => __('Content Slider', THEME_TD),
			'description'         => __('Content Sliders', THEME_TD),
			'labels'              => $labels,
			'supports'            => ['title', 'page-attributes'],
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 20,
			'menu_icon'           => 'dashicons-admin-post',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'capability_type'     => 'post',
		];

		register_post_type($cpt, $args);
		//self::$post_types_taxonomies[] = $cpt;
	}
	
	public function create_case_studies_cpt(){
		$cpt = 'case-studies';
		$name = 'Case Studies';
		$plural_name = 'Case Studies';
		$labels = $this->createLabels($name, $plural_name);
		$args = [
			'label'               => __($name, THEME_TD),
			'description'         => __($plural_name, THEME_TD),
			'labels'              => $labels,
			'supports'            => ['title', 'page-attributes'],
			'hierarchical'        => false,
			'public'              => true,
			'publicly_queryable'  => false,
			'show_ui'             => true,
			'show_in_rest'        => false,
			'rest_base'           => '',
			'show_in_menu'        => true,
			'exclude_from_search' => false,
			'menu_position'       => 20,
			'menu_icon'           => 'dashicons-admin-post',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => $cpt,
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
			'query_var'           => true,
			'taxonomies'          => [$cpt.'-cat'],
			//'rewrite'             => ['slug' => $cpt.'s/%'.$cpt.'-cat%', 'with_front' => false, 'pages' => false, 'feeds' => false, 'feed' => false],
			'rewrite'             => ['slug' => $cpt, 'with_front' => false, 'pages' => false, 'feeds' => false, 'feed' => false],
		];
		
		register_post_type($cpt, $args);
		//self::$post_types_taxonomies[$cpt.'-cat'] = ['cpt' => $cpt, 'label' => ['name' => 'Categories', 'singular_name' => 'Category'], 'args' => ['public' => false]];
	}
	
	public function create_vaid_solution_cpt(){
		$cpt = 'vaid_solution';
		$name = 'VAID Solution';
		$labels = $this->createLabels($name);
		$args = [
			'label'               => __($name, THEME_TD),
			'description'         => __($name.'s', THEME_TD),
			'labels'              => $labels,
			'supports'            => ['title', 'page-attributes'],
			'hierarchical'        => false,
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_rest'        => false,
			'rest_base'           => '',
			'show_in_menu'        => true,
			'exclude_from_search' => false,
			'menu_position'       => 20,
			'menu_icon'           => 'dashicons-admin-post',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => $cpt,
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
			'query_var'           => true,
			'taxonomies'          => [$cpt.'-cat'],
			//'rewrite'             => ['slug' => $cpt.'s/%'.$cpt.'-cat%', 'with_front' => false, 'pages' => false, 'feeds' => false, 'feed' => false],
			'rewrite'             => ['slug' => 'visual-ai-design-solutions', 'with_front' => false, 'pages' => false, 'feeds' => false, 'feed' => false],
		];
		
		register_post_type($cpt, $args);
		#self::$post_types_taxonomies[$cpt.'-cat'] = ['cpt' => $cpt, 'label' => ['name' => 'Categories', 'singular_name' => 'Category'], 'args' => ['public' => false]];
	}
	
}
