<?php
namespace Digidez;

class Filters {

    /**
     * Static function must be called after require within functions.inc.php
     * This will setup all filter hooks
     */
    public static function initialise(){
        $self = new self();

        // define all filter hooks here and document if not self explanatory
	
	    add_filter('widget_text', 'do_shortcode');
	    add_filter('the_excerpt', 'do_shortcode');
	    
		add_filter('theme_page_templates', [$self, 'redefine_page_templates']);
	    add_filter('theme_post_templates', [$self, 'redefine_post_templates'], 100);
	    //add_filter('dynamic_sidebar_params', [$self, 'redefine_dynamic_sidebar_params'], 0);


	    add_filter('manage_edit-page_columns', [$self, 'edit_columns_page']);
	    add_filter('manage_edit-post_columns', [$self, 'edit_columns_post']);
	    add_filter('manage_edit-review_columns', [$self, 'edit_columns_review']);
	    add_filter('manage_edit-candidate_columns', [$self, 'edit_columns_candidate']);
	    add_filter('manage_edit-client_columns', [$self, 'edit_columns_client']);
	    add_filter('manage_edit-testimonial_columns', [$self, 'edit_columns_testimonial']);
	    add_filter('manage_edit-news_columns', [$self, 'edit_columns_news']);


	    //add_filter('acf/rest_api/field_settings/show_in_rest', '__return_true');
	    //add_filter('acf/rest_api/field_settings/edit_in_rest', '__return_true');

		add_filter('body_class', [$self, 'body_class'], 999999, 2);
		
	    add_filter('comment_form_defaults', [$self, 'oxy_filter_comment_form_defaults']);
	    add_filter('comment_reply_link', [$self, 'comment_reply_link'], 10, 4);
	    add_filter('get_avatar', [$self, 'get_avatar'], 10, 6);

	    add_filter('wpcf7_form_tag', [$self, 'wpcf7_form_tag'], 10, 1);

	    #add_filter('wpseo_opengraph_desc', [$self, 'wpseo_opengraph_desc'], 10, 2);
    }

    /** CORE **/
    

	/** TEMPLATES **/
	
	public function body_class($classes, $class){
    	global $post;
		
		$classes[] = 'd-flex flex-column';

	    $classes[] = Helper::$device;
	    $classes[] = Helper::$device_os;
	    $classes[] = Helper::$device_name;
	    $classes[] = Helper::$device_version;
	    $classes[] = Helper::$device_browser;

	    $classes[] = $post->post_type;

	    $uri = trim($_SERVER['REQUEST_URI'], '/');
	    if(!empty($uri)){
	    	if(strstr($uri, '?') !== false){
			    $a = explode('?', $uri);
			    $uri = $a[0];
		    }
	    	//$a = explode('/', $uri);
		    //$classes[] = $a[0];
		    $classes[] = str_replace('/', ' ', $uri);
	    }else{
		    $classes[] = 'homepage';
	    }

	    if($GLOBALS['display_header_notification']){
		    $classes[] = 'header-notify-box';
	    }
	    
        //Functions::_debug($uri);
        //Functions::_debug($class);
        //Functions::_debug($classes); exit;

        return $classes;
    }

	public function redefine_page_templates($post_templates){
		$templates_files = array_diff(scandir(THEME_DIR.PAGE_TEMPLATES_PATH), [".", "..", "index.php"]);
		if(!empty($templates_files)){
			$post_templates = [];
			foreach($templates_files as $file){
				if(!is_dir(THEME_DIR.PAGE_TEMPLATES_PATH.$file)){
					$post_templates[PAGE_TEMPLATES_PATH.$file] = Functions::_get_file_description(THEME_DIR.PAGE_TEMPLATES_PATH.$file);
				}
			}
		}

		return $post_templates;
	}

	public function redefine_post_templates($post_templates){
		$templates_files = array_diff(scandir(THEME_DIR.POST_TEMPLATES_PATH), [".", "..", "index.php"]);
		if(!empty($templates_files)){
			$post_templates = [];
			foreach($templates_files as $file){
				if(!is_dir(THEME_DIR.POST_TEMPLATES_PATH.$file)){
					$post_templates[POST_TEMPLATES_PATH.$file] = Functions::_get_file_description(THEME_DIR.POST_TEMPLATES_PATH.$file);
				}
			}
		}
		#Functions::_debug($post_templates);
		return $post_templates;
	}

	public function redefine_dynamic_sidebar_params($params){
		//Functions::_debug($params);
		$params['before_widget'] = '<div id="quick-browsing" class="mb-4"><div class="quick-browsing">';
		$params['after_widget'] = '</div></div>';
		$params['before_title'] = '<h2>';
		$params['after_title'] = '</h2>';

		return $params;
	}
	
	public function oxy_filter_comment_form_defaults($defaults){
		$commenter = wp_get_current_commenter();
		
		$defaults['fields']['author'] = '<div class="row"><div class="form-group col-md-4"><label for="author">' . __('Your name *', THEME_TD) . '</label><input id="author" name="author" type="text" class="input-block-level form-control" value="' . esc_attr($commenter['comment_author']) .  '"/></div>';
		$defaults['fields']['email']  = '<div class="form-group col-md-4"><label for="email">' . __('Your email *', THEME_TD) . '</label><input id="email" name="email" type="text" class="input-block-level form-control" value="' . esc_attr($commenter['comment_author_email']) . '" /></div>';
		$defaults['fields']['url'] = '<div class="form-group col-md-4"><label for="url">' . __('Website', THEME_TD) . '</label><input id="url" name="url" type="text" class="input-block-level form-control" value="' . esc_attr($commenter['comment_author_url']) . '" /></div></div>';
		
		
		$defaults['comment_field'] = '<div class="row"><div class="form-group col-md-12"><label for="comment">' . __('Your message', THEME_TD) . '</label><textarea id="comment" name="comment" class="input-block-level form-control" rows="5"></textarea></div></div>';
		$defaults['format'] = 'html5';
		$defaults['comment_notes_after'] = '';
		$defaults['class_submit'] = 'btn btn-primary';
		
		return $defaults;
	}
	
	public function comment_reply_link($html, $args, $comment, $post){
    	return str_replace('comment-reply-link', 'comment-reply-link2 button', $html);
	}
	
	public function get_avatar($avatar, $id_or_email, $size, $default, $alt, $args){
    	if(!is_object($id_or_email)){
    		return '';
	    }
		$author = DataSource::get_author_data($id_or_email->user_id);

    	return '<img alt="'.$author['name'].'" src="'.$author['avatar_src'].'" class="avatar avatar-48 photo" height="48" width="48" />';
	}
	
	/** CPT **/
	
	public function edit_columns_page($columns){
		$columns = [
			'cb'             => '<input type="checkbox" />',
			'title'          => __('Name', THEME_TD),
			//'language' => __('Language', THEME_TD),
			'template'       => __('Template', THEME_TD),
			'author'         => __('Author', THEME_TD),
			//'featured-image' => __('Image', THEME_TD),
			'date'           => __('Date', THEME_TD),
		];

		return $columns;
	}

	public function edit_columns_post($columns){
		$columns = [
			'cb'             => '<input type="checkbox" />',
			'featured-image' => __('Image', THEME_TD),
			'title'          => __('Name', THEME_TD),
			//'language' => __('Language', THEME_TD),
			'categories'       => __('Categories', THEME_TD),
			'author'         => __('Author', THEME_TD),
			'date'           => __('Date', THEME_TD),
		];

		return $columns;
	}
	
	public function edit_columns_review($columns){
		$columns = [
			'cb'          => '<input type="checkbox" />',
			'title'       => __('Name', THEME_TD),
			'user_avatar' => __('User avatar', THEME_TD),
			'user_name'   => __('User name', THEME_TD),
			'review_date' => __('Review date', THEME_TD),
			'review_rate' => __('Review rate', THEME_TD),
			'review-cat'  => __('Categories', THEME_TD),
			//'author'      => __('Author', THEME_TD),
			//'date'        => __('Date', THEME_TD),
		];
		
		return $columns;
	}
	
	public function edit_columns_candidate($columns){
		$columns = [
			'cb'                 => '<input type="checkbox" />',
			'featured-image'     => __('Photo', THEME_TD),
			'title'              => __('Name', THEME_TD),
			'candidate_base_id'  => __('Base ID', THEME_TD),
			'candidate_position' => __('Position', THEME_TD),
			'candidate_location' => __('Location', THEME_TD),
			'candidate-cat'      => __('Categories', THEME_TD),
			'candidate_skills'   => __('Skills', THEME_TD),
			'date'               => __('Date', THEME_TD),
		];
		
		return $columns;
	}
	
	public function edit_columns_client($columns){
		$columns = [
			'cb'          => '<input type="checkbox" />',
			'client_logo' => __('Logo', THEME_TD),
			'title'       => __('Title', THEME_TD),
			'client_url'  => __('External URL', THEME_TD),
			#'menu_order'  => __('Order', THEME_TD),
			'date'        => __('Date', THEME_TD),
		];
		
		return $columns;
	}
	
	public function edit_columns_testimonial($columns){
		$columns = [
			'cb'          => '<input type="checkbox" />',
			'testimonial_user_photo' => __('Photo', THEME_TD),
			'title'       => __('Title', THEME_TD),
			'testimonial_company_name'  => __('Company', THEME_TD),
			'testimonial_job_title'  => __('Job title', THEME_TD),
			'date'        => __('Date', THEME_TD),
		];
		
		return $columns;
	}
	
	public function edit_columns_news($columns){
		$columns = [
			'cb'          => '<input type="checkbox" />',
			'news_post_image' => __('Image', THEME_TD),
			'title'       => __('Title', THEME_TD),
			#'news_post_logo'  => __('Logo', THEME_TD),
			'news_post_date'  => __('Custom Date', THEME_TD),
			'menu_order'  => __('Order', THEME_TD),
			'date'        => __('Date', THEME_TD),
		];
		
		return $columns;
	}
	
	/** CF7 **/
	
	public function wpcf7_form_tag($tag){
		$datas = [];
		foreach((array)$tag['options'] as $option){
			if(strpos($option, 'data-') === 0){
				$option            = explode(':', $option, 2);
				$datas[$option[0]] = apply_filters('wpcf7_option_value', $option[1], $option[0]);
			}
		}
		if(!empty($datas)){
			$name        = $tag['name'];
			$tag['name'] = $id = uniqid('wpcf');
			add_filter('wpcf7_form_elements', function($content) use ($name, $id, $datas){
				return str_replace($id, $name, str_replace("name=\"$id\"", "name=\"$name\" ".wpcf7_format_atts($datas), $content));
			});
		}
		
		return $tag;
	}

	/** WPSEO **/
	
	public function wpseo_opengraph_desc($description, $presentation){
		#$description = $GLOBALS['og']['description'];
		#$description = Meta_OG::get('description');
		
		return $description;
	}
}
