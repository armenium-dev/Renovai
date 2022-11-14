<?php


namespace Digidez;


class Theme {
	
	public static function initialise(){
		$self = new self();
		
		add_action('init', [$self, 'create_theme_options']);
		add_action('after_setup_theme', [$self, 'theme_setup']);
		
	}
	
	public function theme_setup(){
		load_theme_textdomain( THEME_TD, get_template_directory() . '/languages' );
		
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );
		
		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );
		
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(array(
			'primary' => __('Primary Menu', THEME_TD),
			//'footer'  => __('Footer Menu', THEME_TD),
			//'mobile'    => __('Mobile Nav', THEME_TD),
			//'icons' => __('Icon Nav', THEME_TD),
		));
		
		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			//'search-form',
			//'comment-form',
			//'comment-list',
			'gallery',
			'caption',
		) );
		
		/*
		 * Adding Thumbnail basic support
		 */
		add_theme_support( 'post-thumbnails' );
		
		/*
		 * Adding support for Widget edit icons in customizer
		 */
		//add_theme_support( 'customize-selective-refresh-widgets' );
		
		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		/*add_theme_support('post-formats', array(
			//'aside',
			//'image',
			//'video',
			//'quote',
			//'link',
		));*/
		
		// Set up the WordPress core custom background feature.
		//add_theme_support('custom-background', array('default-color' => 'ffffff', 'default-image' => ''));
		
		// Set up the WordPress Theme logo feature.
		//add_theme_support('custom-logo');
		
		// Check and setup theme default settings.
		/*$posts_index_style = get_theme_mod('theme_posts_index_style');
		if('' == $posts_index_style){
			set_theme_mod('theme_posts_index_style', 'default');
		}*/
		
		// Sidebar position.
		/*$sidebar_position = get_theme_mod('theme_sidebar_position');
		if('' == $sidebar_position){
			set_theme_mod('theme_sidebar_position', 'right');
		}*/
		
		// Container width.
		/*$container_type = get_theme_mod('theme_container_type');
		if('' == $container_type){
			set_theme_mod('theme_container_type', 'container');
		}*/
		
		if(!current_user_can('administrator') && !is_admin()){
			show_admin_bar(false);
		}
	}
	
	/** THEME OPTIONS **/
	
	public function create_theme_options(){
		if(function_exists('acf_add_options_page')){
			acf_add_options_page(array(
				'page_title' 	=> 'General',
				'menu_title'	=> 'Theme Options',
				'menu_slug' 	=> 'theme-options',
				'capability'	=> 'edit_posts',
				'parent_slug'   => 'themes.php',
				'position'      => false,
				'icon_url'      => false,
				'redirect'		=> false
			));
			
			/*acf_add_options_sub_page(array(
				'page_title' 	=> 'Page options',
				'menu_title'	=> 'Pages',
				'menu_slug' 	=> 'theme-options-pages',
				'capability'	=> 'edit_posts',
				'parent_slug'	=> 'theme-options',
				'position'      => false,
				'icon_url'      => false,
			));*/
			
			/*acf_add_options_sub_page(array(
				'page_title' 	=> 'Jobs options',
				'menu_title'	=> 'Jobs',
				'menu_slug' 	=> 'theme-options-jobs',
				'capability'	=> 'edit_posts',
				'parent_slug'	=> 'theme-options',
				'position'      => false,
				'icon_url'      => false,
			));*/
			
			acf_add_options_page(array(
				'page_title' 	=> 'Popups Options',
				'menu_title'	=> 'Popups Options',
				'menu_slug' 	=> 'theme-options-popups',
				'capability'	=> 'edit_posts',
				'parent_slug'	=> 'themes.php',
				'position'      => false,
				'icon_url'      => false,
				'redirect'		=> false
			));
			
			/*acf_add_options_page(array(
				'page_title' 	=> 'Cron options',
				'menu_title'	=> 'Cron options',
				'menu_slug' 	=> 'theme-options-cron',
				'capability'	=> 'edit_posts',
				'parent_slug'	=> 'themes.php',
				'position'      => false,
				'icon_url'      => false,
				'redirect'		=> false
			));*/
			
			/*acf_add_options_sub_page(array(
				'page_title' 	=> 'CF7 options',
				'menu_title'	=> 'Contact Form 7',
				'menu_slug' 	=> 'theme-options-cf7',
				'capability'	=> 'edit_posts',
				'parent_slug'	=> 'theme-options',
				'position'      => false,
				'icon_url'      => false,
			));*/
		}
	}
	
	public static function slbd_count_widgets($sidebar_id){
		if(empty($sidebar_id)){
			return '';
		}
		
		// If loading from front page, consult $_wp_sidebars_widgets rather than options
		// to see if wp_convert_widget_settings() has made manipulations in memory.
		global $_wp_sidebars_widgets;
		if(empty($_wp_sidebars_widgets)) :
			$_wp_sidebars_widgets = get_option('sidebars_widgets', array());
		endif;
		
		$sidebars_widgets_count = $_wp_sidebars_widgets;
		
		if(isset($sidebars_widgets_count[$sidebar_id])) :
			$widget_count   = count($sidebars_widgets_count[$sidebar_id]);
			$widget_classes = 'widget-count-'.count($sidebars_widgets_count[$sidebar_id]);
			if($widget_count % 4 == 0 || $widget_count > 6) :
				// Four widgets per row if there are exactly four or more than six
				$widget_classes .= ' col-md-3';
			elseif(6 == $widget_count) :
				// If two widgets are published
				$widget_classes .= ' col-md-2';
			elseif($widget_count >= 3) :
				// Three widgets per row if there's three or more widgets
				$widget_classes .= ' col-md-4';
			elseif(2 == $widget_count) :
				// If two widgets are published
				$widget_classes .= ' col-md-6';
			elseif(1 == $widget_count) :
				// If just on widget is active
				$widget_classes .= ' col-md-12';
			endif;
			
			return $widget_classes;
		endif;
	}
	
	
	/** MENU NAVS **/
	
	public static function get_menu($menu_name = 'main_menu'){
		global $post;
		//self::_debug($post->post_name);
		
		$theme_locations = get_nav_menu_locations();
		$menu = get_term($theme_locations[$menu_name], 'nav_menu');
		$menu_items = wp_get_nav_menu_items($menu->term_id, array('update_post_term_cache' => false));
		//self::_debug($menu_items);
		
		$sorted_menu = array();
		foreach((array)$menu_items as $menu_item){
			$sorted_menu[$menu_item->ID] = array(
				'id'      => $menu_item->ID,
				'name'    => $menu_item->title,
				'url'     => $menu_item->url,
				'target'     => $menu_item->target,
				'classes' => (isset($menu_item->classes) ? implode(' ', $menu_item->classes) : ''),
				'active_class' => (strstr($menu_item->url, $post->post_name) !== false || $post->ID == $menu_item->post_name || $post->post_name == $menu_item->post_name ? 'active' : ''),
			);
		}
		
		//self::_debug($sorted_menu);
		
		return $sorted_menu;
	}
	
	public static function get_menu_sections($menu_name = 'main_menu'){
		$menu       = wp_get_nav_menu_object($menu_name);
		$menu_items = wp_get_nav_menu_items($menu->term_id, array('update_post_term_cache' => false));
		//self::_debug($menu_items);
		
		$sorted_menu = $sorted_menu_items = $menu_items_with_children = array();
		foreach((array)$menu_items as $menu_item){
			$sorted_menu_items[$menu_item->menu_order] = $menu_item;
			if($menu_item->menu_item_parent){
				$menu_items_with_children[$menu_item->menu_item_parent] = true;
			}
		}
		//self::_debug($menu_items_with_children);
		
		foreach($menu_items_with_children as $menu_section => $val){
			$sorted_menu[$menu_section] = '';
		}
		//self::_debug($sorted_menu);
		//self::_debug($sorted_menu_items);
		
		foreach($sorted_menu_items as $menu_item){
			if(array_key_exists($menu_item->ID, $sorted_menu)){
				$sorted_menu[$menu_item->ID] = array(
					'name'    => $menu_item->title,
					'url'     => $menu_item->url,
					'classes' => (isset($menu_item->classes) ? implode(' ', $menu_item->classes) : ''),
				);
			}
			
			if(array_key_exists($menu_item->menu_item_parent, $sorted_menu)){
				$sorted_menu[$menu_item->menu_item_parent]['items'][] = array(
					'name'    => $menu_item->title,
					'url'     => $menu_item->url,
					'classes' => (isset($menu_item->classes) ? implode(' ', $menu_item->classes) : ''),
				);
			}
		}
		//self::_debug($sorted_menu);
		return $sorted_menu;
	}
	
	public static function get_menu_tree($menu_location = 'main_menu', $menu_id = 0){
		global $post;
		
		#Helper::_debug($post);
		//$menu       = wp_get_nav_menu_object($menu_name);
		if(!empty($menu_location) && $menu_id == 0){
			$theme_locations = get_nav_menu_locations();
			$menu            = get_term($theme_locations[$menu_location], 'nav_menu');
			$menu_id = $menu->term_id;
		}
		$menu_items = wp_get_nav_menu_items($menu_id, ['update_post_term_cache' => false]);
		#Helper::_debug($menu);
		#Helper::_debug($menu_items);
		
		$sorted_menu = $sorted_menu_items = $menu_items_with_children = $menu_items_by_id = [];
		foreach($menu_items as $menu_item){
			$menu_items_by_id[$menu_item->ID] = $menu_item;
			
			$url = $menu_item->url;
			
			if($menu_item->object == 'category'){
				$url = str_replace(site_url('/category/'), $menu_items_by_id[$menu_item->menu_item_parent]->url.'?', $url);
				$url = rtrim($url, '/');
			}
			
			if($menu_item->menu_item_parent == 0){
				$sorted_menu[$menu_item->ID] = [
					'id'      => $menu_item->ID,
					'name'    => $menu_item->title,
					'url'     => $url,
					'target'     => $menu_item->target,
					'classes' => (isset($menu_item->classes) ? implode(' ', $menu_item->classes) : ''),
					'active_class' => is_object($post) ? (strstr($menu_item->url, $post->post_name) !== false || $post->ID == $menu_item->object_id || $post->post_name == $menu_item->post_name ? 'active' : '') : '',
					'active_child' => '',
					'items' => self::_populate_menu_children($menu_items, $menu_item),
				];
			}else{
				/*$active_class = '';
				if(strstr($menu_item->url, $post->post_name) !== false || $post->ID == $menu_item->object_id || $post->post_name == $menu_item->post_name){
					$active_class = 'active';
					$sorted_menu[$menu_item->menu_item_parent]['active_child'] = 'show';
					$sorted_menu[$menu_item->menu_item_parent]['active_class'] = $active_class;
				}
				$sorted_menu[$menu_item->menu_item_parent]['items'][] = [
					'id'      => $menu_item->ID,
					'name'    => $menu_item->title,
					'url'     => $url,
					'target'     => $menu_item->target,
					'classes' => (isset($menu_item->classes) ? implode(' ', $menu_item->classes) : ''),
					'active_class' => $active_class,
				];*/
			}
		}
		
		#Helper::_debug($sorted_menu);
		return $sorted_menu;
	}
	
	private static function _populate_menu_children($menu_array, $menu_item){
		global $post;
		
		$children = [];
		if(!empty($menu_array)){
			foreach($menu_array as $k => $m){
				if($m->menu_item_parent == $menu_item->ID){
					$active_class = $active_child = '';
					if(strstr($m->url, $post->post_name) !== false || $post->ID == $m->object_id || $post->post_name == $m->post_name){
						$active_class = 'active';
						#$active_child = 'show';
					}
					
					$children[$m->ID] = [];
					$children[$m->ID]['id'] = $m->ID;
					$children[$m->ID]['name'] = $m->title;
					$children[$m->ID]['url'] = $m->url;
					$children[$m->ID]['target'] = $m->target;
					$children[$m->ID]['classes'] = (isset($m->classes) ? implode(' ', $m->classes) : '');
					$children[$m->ID]['active_child'] = '';
					$children[$m->ID]['active_class'] = $active_class;
					unset($menu_array[$k]);
					$children[$m->ID]['items'] = self::_populate_menu_children($menu_array, $m);
				}
			}
		}
		
		return $children;
	}
	
	/** PAGINATION/POST NAVS **/
	
	public static function get_pagination($pages = '', $args = array()){
		global $wp_query;
		global $paged;
		
		$defaults = array(
			'wrap_class' => '',
			'range' => 2,
			'blog' => true,
			'infinite' => false,
			'echo' => true,
		);
		
		$args = wp_parse_args($args, $defaults);
		$range = $args['range'];
		$blog = $args['blog'];
		$infinite = $args['infinite'];
		$echo = $args['echo'];
		
		
		$blog_pagination = 'pages-bs-4';
		$output          = '';
		if($infinite == false){
			// we don't use infinite pagination, show display the chosen pagination style
			switch($blog_pagination){
				case 'next_prev':
					if($wp_query->max_num_pages > 1){
						$output .= '<nav id="nav-below" class="post-navigation padded '.$args['wrap_class'].'">';
						$output .= '<ul class="pager">';
						$output .= '<li class="previous">'.get_next_posts_link('<i class="fa fa-angle-left"></i>'.esc_html__('Previous', THEME_TD)).'</li>';
						$output .= '<li class="next">'.get_previous_posts_link(esc_html__('Next', THEME_TD).'<i class="fa fa-angle-right"></i>').'</li>';
						$output .= '</ul>';
						$output .= '</nav>';
					}
					break;
				case 'pages-bs-4':
					$showitems = ($range * 2) + 1;
					if(empty($paged)){
						$paged = 1;
					}
					
					if($pages == ''){
						global $wp_query;
						$pages = $wp_query->max_num_pages;
						if(!$pages){
							$pages = 1;
						}
					}
					$output = '<nav aria-label="Page navigation">';
					if(1 != $pages){
						$output .= '<ul class="pagination justify-content-center">';
						$output .= ($paged > 1) ? '<li class="page-item"><a href="'.get_pagenum_link($paged - 1).'" class="page-link arrow prev">&lsaquo;</a></li>' : '<li class="page-item disabled"><a class="page-link arrow prev">&lsaquo;</a></li>';
						
						for($i = 1; $i <= $pages; $i++){
							if(1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)){
								$output .= ($paged == $i) ? '<li class="page-item active"><span class="page-link current">'.$i.'</span></li>' : '<li class="page-item"><a href="'.get_pagenum_link($i).'" class="page-link inactive">'.$i.'</a></li>';
							}
						}
						
						$output .= ($paged < $pages) ? '<li class="page-item"><a href="'.get_pagenum_link($paged + 1).'" class="page-link arrow next">&rsaquo;</a></li>' : '<li class="page-item disabled"><a class="page-link arrow next">&rsaquo;</a></li>';
						$output .= "</ul>";
					}
					$output .= "</nav>";
					break;
				case 'pages':
				default:
					$showitems = ($range * 2) + 1;
					if(empty($paged)){
						$paged = 1;
					}
					
					if($pages == ''){
						global $wp_query;
						$pages = $wp_query->max_num_pages;
						if(!$pages){
							$pages = 1;
						}
					}
					$output = '<div class="text-center pagination-wrap '.$args['wrap_class'].'">';
					if(1 != $pages){
						$output .= '<ul class="post-navigation pagination">';
						$output .= ($paged > 1) ? '<li><a href="'.get_pagenum_link($paged - 1).'" class="arrow prev">&lsaquo;</a></li>' : '<li class="disabled"><a class="arrow prev">&lsaquo;</a></li>';
						
						for($i = 1; $i <= $pages; $i++){
							if(1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)){
								$output .= ($paged == $i) ? '<li class="active"><span class="current">'.$i.'</span></li>' : '<li><a href="'.get_pagenum_link($i).'" class="inactive">'.$i.'</a></li>';
							}
						}
						
						$output .= ($paged < $pages) ? "<li><a href='".get_pagenum_link($paged + 1)."' class='arrow next'>&rsaquo;</a></li>" : "<li class='disabled'><a class='arrow next'>&rsaquo;</a></li>";
						$output .= "</ul>";
					}
					$output .= "</div>\n";
					break;
			}
		}
		
		if($echo == true){
			echo $output;
		}else{
			return $output;
		}
	}
	
	public static function post_nav(){
		// Don't print empty markup if there's nowhere to navigate.
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );
		
		if ( ! $next && ! $previous ) {
			return;
		}
		?>
		<nav class="container navigation post-navigation">
			<h2 class="sr-only"><?php _e( 'Post navigation', 'understrap' ); ?></h2>
			<div class="row nav-links justify-content-between">
				<?php
				
				if ( get_previous_post_link() ) {
					previous_post_link( '<span class="nav-previous">%link</span>', _x( '<i class="fa fa-angle-left"></i>&nbsp;%title', 'Previous post link', 'understrap' ) );
				}
				if ( get_next_post_link() ) {
					next_post_link( '<span class="nav-next">%link</span>',     _x( '%title&nbsp;<i class="fa fa-angle-right"></i>', 'Next post link', 'understrap' ) );
				}
				?>
			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
		
		<?php
	}
	
	
}
