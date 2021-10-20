<?php
namespace Digidez;

use Imagick;
use SimpleCssMinifier;
use WP_Query;

class Functions {

	public static $months = [
		1 => 'January',
		2 => 'February',
		3 => 'March',
		4 => 'April',
		5 => 'May',
		6 => 'June',
		7 => 'July',
		8 => 'August',
		9 => 'September',
		10 => 'October',
		11 => 'November',
		12 => 'December',
	];
	public static $shared_links = [
		'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=%POST_URL%',
		'mail' => 'mailto:?subject=%POST_TITLE%&body=%POST_URL%',
		'linkedin' => 'http://www.linkedin.com/shareArticle?mini=true&url=%POST_URL%&title=%POST_TITLE%&summary=%POST_EXCERPT%',
		'twitter' => 'http://twitter.com/intent/tweet?text=%POST_TITLE% %POST_URL%',
		'pinterest' => 'https://pinterest.com/pin/create/button/?description=%POST_TITLE%&media=%POST_IMG%&url=%POST_URL%',
		'instagram' => '',
		'youtube' => '',
		'google-plus' => 'https://plus.google.com/share?url=%POST_URL%',
		'reddit' => '',
		'vk' => 'https://vk.com/share.php?url=%POST_URL%',
		'ok' => 'https://connect.ok.ru/dk?st.cmd=WidgetSharePreview&st.shareUrl=%POST_URL%',
	];
	public static $element_align_classes = [
		1 => array('m-align-center'),
		2 => array('m-align-left', 'm-align-right'),
		3 => array('m-align-left', 'm-align-center', 'm-align-right'),
	];
	public static $in_col_align_classes = [
		1 => array('text-center'),
		2 => array('text-left', 'text-right'),
		3 => array('text-left', 'text-center', 'text-right'),
	];
	public static $blog_post_read_time_coefficient = 250;
	
	public static function initialise(){}

	/**
	 * Get the description of template files
	 *
	 * @param string $file_path Filesystem path width filename
	 * @return string Description of file from $wp_file_descriptions or basename of $file if description doesn't exist.
	 * Appends 'Template' to basename of $file if the file is a page template
	 */
	public static function _get_file_description($file_path){
		$template_data = implode( '', file( $file_path ) );
		if(preg_match( '|Template Name:(.*)$|mi', $template_data, $name) ) {
			return sprintf( __( '%s' ), _cleanup_header_comment( $name[1] ) );
		}

		return trim( basename( $file_path ) );
	}


	/** GLOBAL **/
	
	public static function set_vars_on_init(){
		$GLOBALS['display_header_notification'] = false;
		$GLOBALS['display_cookie_policy'] = false;
		
		if(class_exists('ACF')){
			$display = get_field('display_header_notification', 'option');
			
			if(isset($_COOKIE['acceptNotify']) && intval($_COOKIE['acceptNotify']) == 10){
				$display = false;
			}
			$GLOBALS['display_header_notification'] = $display;

			$display = get_field('display_cookie_policy_popup', 'option');
			
			if(isset($_COOKIE['acceptCookies']) && intval($_COOKIE['acceptCookies']) == 10){
				$display = false;
			}
			$GLOBALS['display_cookie_policy'] = $display;
			
			self::$blog_post_read_time_coefficient = get_field('post_read_time_coefficient', 'option');
		}
	}
	
	
	/** HELPERS **/

	public static function get_template_part_by_device($file = '', $base_path = 'common'){
		$base_path = trim($base_path, '/');
		$base_path = trim(PARTIALS_PATH, '/').'/'.$base_path.'/%device%/'.$file;
		$f_path = str_replace('%device%', self::$device, $base_path);

		if(!file_exists(THEME_DIR.$f_path.'.php')){
			switch(self::$device){
				case "desktop":
					$f_path = str_replace('%device%/', '', $base_path);
					break;
				case "tablet":
					$f_path = str_replace('%device%', 'mobile', $base_path);
					if(!file_exists(THEME_DIR.$f_path.'.php')){
						$f_path = str_replace('%device%', 'desktop', $base_path);
					}
					break;
				case "mobile":
					$f_path = str_replace('%device%', 'tablet', $base_path);
					if(!file_exists(THEME_DIR.$f_path.'.php')){
						$f_path = str_replace('%device%', 'desktop', $base_path);
					}
					break;
			}
		}
		#Helper::_debug($f_path);

		get_template_part('/'.$f_path);
	}
	
	public static function get_the_thumbnail($image, $size = 'full', $attr = '', $return_img_tag = true, $retina = true, $return_attrs = false){
		$html = '';

		if($image){

			@list($src, $width, $height) = $image;

			$original_src = !empty($src) ? $src : $image;

			//Get image sizes
			$aq_size = self::get_image_sizes($size);
			#Helper::_debug($original_src);
			
			if(is_array($aq_size) && !empty($aq_size['height'])){

				$resize_width  = $aq_size['width'];
				$resize_height = $aq_size['height'];
				$resize_crop   = $aq_size['crop'];

				if($resize_width >= $width){
					$resize_width = $width;
				}
				if($resize_height >= $height && !empty($resize_height)){
					$resize_height = $height;
				}

				//Double the size for the retina display
				$retina_width  = $resize_width * 2;
				$retina_height = $resize_height * 2;
				if($retina_width >= $width){
					$retina_width = $width;
				}
				if($retina_height >= $height){
					$retina_height = $height;
				}

				//Get resized images
				if($retina){
					$retina_src = aq_resize($src, $retina_width, $retina_height, true);
				}
				$src        = aq_resize($src, $resize_width, $resize_height, $resize_crop);
				$hwstring   = image_hwstring($resize_width, $resize_height);
				
				if(empty($src)){
					//$src = $original_src;
				}

				if(!$retina){
					$retina_src = $src;
				}

			}else{
				$retina_src = $src;
				$hwstring = ($width && $height) ? image_hwstring($width, $height) : '';
			}

			if($return_img_tag){
				$size_class = $size;
				if(is_array($size_class)){
					$size_class = implode('x', $size_class);
				}
				//$attachment   = get_post($attachment_id);
				$default_attr = [
					'src'      => !empty($src) ? $src : $original_src,
					'class'    => "attachment-$size_class size-$size_class",
					'alt'      => get_the_title(),
					'data-rjs' => $retina_src,
				];

				$attr = wp_parse_args($attr, $default_attr);
				
				$attr = array_map('esc_attr', $attr);
				$html = rtrim("<img $hwstring");
				foreach($attr as $name => $value){
					$html .= " $name=".'"'.$value.'"';
				}
				$html .= ' />';
			}else{
				if($return_attrs){
					$html = ['src' => $src, 'w' => $resize_width, 'h' => $resize_height];
				}else{
					$html = $src;
				}
			}
		}else{
			if(isset($attr['default_image'])){
				$src = $attr['default_image'];

				if($return_img_tag){
					$size_class = $size;
					if(is_array($size_class)){
						$size_class = implode('x', $size_class);
					}

					$default_attr = array(
						'src'      => $src,
						'class'    => "attachment-$size_class size-$size_class",
						'alt'      => get_the_title(),
					);

					$attr = wp_parse_args($attr, $default_attr);
					$attr = array_map('esc_attr', $attr);
					$html = "<img";
					foreach($attr as $name => $value){
						$html .= " $name=".'"'.$value.'"';
					}
					$html .= ' />';
				}else{
					$html = $src;
				}

			}
		}

		return $html;
	}

	public static function get_the_attachment_thumbnail($attachment_id, $size = 'full', $attr = '', $return_img_tag = true, $retina = true, $return_attrs = false){
		return self::get_the_thumbnail(wp_get_attachment_image_src($attachment_id, 'full', false), $size, $attr, $return_img_tag, $retina, $return_attrs);
	}

	public static function get_the_post_thumbnail($post_id, $size = 'full', $attr = '', $return_img_tag = true, $retina = true){
		$attachment_id = get_post_thumbnail_id($post_id);
		return self::get_the_attachment_thumbnail($attachment_id, $size, $attr, $return_img_tag, $retina);
	}

	public static function get_image_sizes($size){

		$sizes = [];

		if(!isset($sizes[THEME_SHORT.'-'.$size])){
			if(strstr($size, 'x') !== false){
				$a = explode('x', $size);
				$sizes[THEME_SHORT.'-'.$size] = array('width' => $a[0], 'height' => $a[1], 'crop' => true);
			}
		}

		$image_sizes = !empty($sizes[THEME_SHORT.'-'.$size]) ? $sizes[THEME_SHORT.'-'.$size] : $size;

		return $image_sizes;
	}

	public static function get_file_ext($file_path){
		$base_name = basename($file_path);
		$a = explode('.', $base_name);
		$ext = end($a);
		#\Digidez\Functions::_debug($ext);
		return strtolower($ext);
	}

	public static function create_excerpt($text, $max_length = 100){
		$_text = strip_tags($text);
		if(mb_strlen($_text, 'utf-8') <= $max_length){
			return $text;
		}

		$_text = trim($_text, ".,?:><;");
		$a = explode(' ', $_text);

		$r = '';
		$n = array();
		foreach($a as $k => $t){
			$r .= $t.' ';
			if(mb_strlen($r, 'utf-8') >= $max_length){
				continue;
			}else{
				$n[$k] = $t;
			}
		}

		return implode(' ', $n).'...';

	}

	public static function format_iframe_video($iframe){

		// use preg_match to find iframe src
		preg_match('/src="(.+?)"/', $iframe, $matches);
		$src = $matches[1];
		// add extra params to iframe src
		$params = array(
			'controls' => 0,
			'hd' => 1,
			'autohide' => 1,
			'rel' => 0,
			'showinfo' => 0,
			'autoplay' => 0,
			'enablejsapi' => 1,
			'modestbranding' => 1,
			'iv_load_policy' => 3,
			'color' => 'white',
			'title' => 0,
			'byline' => 0,
			'portrait' => 0,
		);
		$new_src = add_query_arg($params, $src);
		$iframe = str_replace($src, $new_src, $iframe);

		preg_match('/width="(.+?)"/', $iframe, $matches);
		$width = $matches[1];
		$iframe = str_replace('width="'.$width.'"', 'width="100%"', $iframe);

		preg_match('/height="(.+?)"/', $iframe, $matches);
		$height = $matches[1];
		$iframe = str_replace('height="'.$height.'"', 'height="100%"', $iframe);

		// add extra attributes to iframe html
		$attributes = 'frameborder="0"';
		$iframe = str_replace('></iframe>', ' '.$attributes.'></iframe>', $iframe);

		return $iframe;
	}

	public static function get_play_btn_svg(){
		return '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="btn-video-play" width="138" height="138" viewBox="0 0 138 138"><defs><path id="cjcza" d="M951.049 3345.785v52.113l26.056-26.056-26.056-26.056zm8.953 85.633c-8.064 0-15.889-1.58-23.256-4.695a59.773 59.773 0 0 1-18.99-12.802 60.117 60.117 0 0 1-7.295-8.841 59.744 59.744 0 0 1-5.51-10.148c-3.115-7.364-4.695-15.188-4.695-23.256 0-8.067 1.58-15.89 4.695-23.253a59.743 59.743 0 0 1 5.51-10.148 60.11 60.11 0 0 1 16.137-16.137 59.794 59.794 0 0 1 10.148-5.508c7.367-3.116 15.191-4.695 23.256-4.695 8.066 0 15.889 1.58 23.252 4.695a59.646 59.646 0 0 1 10.148 5.508 60.068 60.068 0 0 1 16.137 16.137 59.744 59.744 0 0 1 5.51 10.148c3.115 7.363 4.695 15.186 4.695 23.253 0 8.068-1.58 15.892-4.695 23.256a59.743 59.743 0 0 1-5.51 10.148 60.118 60.118 0 0 1-16.137 16.136 59.625 59.625 0 0 1-10.148 5.507c-7.363 3.115-15.186 4.695-23.252 4.695z"/><mask id="cjczc" width="2" height="2" x="-1" y="-1"><path fill="#fff" d="M900 3311h120v121H900z"/><use xlink:href="#cjcza"/></mask><filter id="cjczb" width="164" height="165" x="878" y="3289" filterUnits="userSpaceOnUse"><feOffset in="SourceGraphic" result="FeOffset1023Out"/><feGaussianBlur in="FeOffset1023Out" result="FeGaussianBlur1024Out" stdDeviation="4.8 4.8"/></filter></defs><g><g transform="translate(-891 -3303)"><g filter="url(#cjczb)"><use fill="none" stroke-opacity=".16" stroke-width="0" mask="url(&quot;#cjczc&quot;)" xlink:href="#cjcza"/><use fill-opacity=".16" xlink:href="#cjcza"/></g><use class="circle" fill="#fff" xlink:href="#cjcza"/></g></g></svg>';
	}

	public static function get_svg_inline($file_path, $return_attrs = false){
		if(strstr($file_path, site_url()) !== false){
			$file_path = str_replace(site_url(), ABSPATH, $file_path);
		}
		if(!file_exists($file_path)){
			return '';
		}
		if($return_attrs){
			$svg_content = file_get_contents($file_path);
			$svgXML = simplexml_load_string($svg_content);
			list($originX, $originY, $relWidth, $relHeight) = explode(' ', $svgXML['viewBox']);
			unset($svgXML);
			
			return ['x' => $originX, 'y' => $originY, 'width' => $relWidth, 'height' => $relHeight, 'xml' => $svg_content];
		}else{
			return file_get_contents($file_path);
		}
	}
	
	public static function replace_svg_content($post_id, $svg_content, $random = false){
		$cf = self::get_cpt_custom_fields($post_id);
		#Helper::_debug($cf);
		if(isset($cf['section_hero'])){
			if(isset($cf['section_hero']['staff_list'])){
				if($random){
					shuffle($cf['section_hero']['staff_list']);
				}
				foreach($cf['section_hero']['staff_list'] as $k => $staff){
					$n = $k+1;
					$svg_content = str_replace(['{TITLE_'.$n.'}', '{IMAGE_'.$n.'}'], [$staff['name'], $staff['photo']], $svg_content);
				}
			}
			if(isset($cf['section_hero']['clients_list'])){
				if($random){
					shuffle($cf['section_hero']['clients_list']);
				}
				foreach($cf['section_hero']['clients_list'] as $k => $photo){
					$n = $k+1;
					$svg_content = str_replace('{IMAGE_S_'.$n.'}', $photo, $svg_content);
				}
			}
			
		}
		
		if(isset($cf['section_our_formula'])){
			if(isset($cf['section_our_formula']['section_image_points'])){
				foreach($cf['section_our_formula']['section_image_points'] as $k => $item){
					$n = $k + 1;
					$svg_content = str_replace('{TEXT_'.$n.'}', $item['label'], $svg_content);
				}
			}
		}
		
		#file_put_contents(CACHE_DIR.'/hero-cover.svg', $svg_content);
		
		return $svg_content;
	}
	
	public static function clean_svg_attrs($file_path){
		$svg_content = file_get_contents($file_path);
		if(strstr($svg_content, 'data-name') !== false){
		
		}
		
		return $svg_content;
	}
	
	public static function sort_page_section($cf){
		$ret_cf = $cf;
		
		if(isset($cf['sections_ordering']) && !empty($cf['sections_ordering'])){
			
			$a = $cf['sections_ordering'];
			asort($a);
			#Helper::_debug($a);
			$ret_cf = array();
			foreach($a as $k => $v){
				$ret_cf[$k] = $cf[$k];
			}
		}
		
		return $ret_cf;
	}
	
	public static function sort_posts_by_cats($posts){
		$posts_by_cats = [];
		
		if($posts->found_posts){
			foreach($posts->posts as $post){
				foreach($post->terms as $term){
					$posts_by_cats[$term->term_id][$post->ID] = $post;
				}
			}
		}
		
		$posts->posts_by_cats = $posts_by_cats;
		
		return $posts;
	}
	
	public static function calc_post_read_time($_post){
		
		if("post" != $_post->post_type) return;
		
		$e = chr(13).chr(10);
		$text = $_post->post_content;
		$text = Caches::minify_html($text);
		$text = strip_tags($text);
		$text = str_replace([' ', PHP_EOL, $e, '\n\r', '\n', '\r', '.', ',', '!', '’', '”', '-', '_', '"', "'"], '', $text);
		$text = trim($text);
		$lenght = mb_strlen($text, 'utf-8');
		$time = round($lenght / self::$blog_post_read_time_coefficient, 0, PHP_ROUND_HALF_DOWN);
		#Helper::_debug([$_post->ID, $_post->post_title, $text, $lenght, $time]);
		
		if($time < 60){
			$t = 'min';
		}else{
			$time = $time / 60;
			if($time > 1){
				$t = 'hours';
			}else{
				$t = 'hour';
			}
		}
		$p = '%d %s read';
		$value = sprintf($p, $time, $t);
		
		return $value;
	}
	
	
	/** RENDERING **/
	
	public static function render_page_404(){
		$section_data = get_field('404_page', 'option');
		
		self::_render_section_template('404', $section_data);
	}
	
	public static function render_post_single($post){
		#Helper::_debug($post->post_type);
		#self::_render_section_template('section_'.$post->post_type, []);
		
		$post_type = ($post->post_type == 'post') ? 'blog' : $post->post_type;
		
		$file = PARTIALS_PATH.'/'.$post_type.'/single/post';
		
		self::get_template_part($file, ['section_name' => $post->post_type, 'section_data' => []]);
	}
	
	public static function render_page_simple($post){
		$page_template = DataSource::get_page_template();
		#Helper::_debug($page_template);
		self::_render_section_template('section_'.$page_template, []);
	}
	
	public static function render_page_single_section($post){
		$_SESSION['form_id'] = 0;
		$post->cf = get_fields($post->ID);
		$post->cf = self::sort_page_section($post->cf);
		
		#Helper::_debug($post->cf);
		
		foreach($post->cf as $k => $section_data){
			self::_render_section_template($k, $section_data);
		}
		
	}
	
	public static function render_page_sections($post){
		$_SESSION['form_id'] = 0;
		$post->cf = get_fields($post->ID);
		$post->cf = self::sort_page_section($post->cf);
		
		#Helper::_debug($post->ID);
		#Helper::_debug($post->cf);
		
		foreach($post->cf as $k => $section_data){
			if(isset($section_data['display_this_section']) && $section_data['display_this_section']){
				self::_render_section_template($k, $section_data);
			}
		}
		
	}
	
	public static function render_page_sections2($post){
		$_SESSION['form_id'] = 0;
		
		$_sql = "SELECT meta_key FROM prefix_postmeta WHERE post_id={$post->ID} AND meta_key LIKE '%display_this_section' AND meta_value NOT LIKE 'field_%' AND meta_value = 1";
		$results = DataSource::get_col($_sql);
		#Helper::_debug($results);
		
		if(!empty($results)){
			$results[] = 'sections_ordering';
			$cf = [];
			foreach($results as $meta_key){
				$key = str_replace('_display_this_section', '', $meta_key);
				$data = get_field($key, $post->ID);
				if($data)
					$cf[$key] = $data;
			}
			#Helper::_debug($cf);
			
			#$post->cf = get_fields($post->ID);
			if(count($cf) > 1){
				$post->cf = self::sort_page_section($cf);
				
				#Helper::_debug($post->cf);
				
				if(!empty($post->cf)){
					foreach($post->cf as $k => $section_data){
						if(isset($section_data['display_this_section']) && $section_data['display_this_section']){
							self::_render_section_template($k, $section_data);
						}
					}
				}
			}
		}
	}
	
	private static function _render_section_template($iterator, $section_data){
		$section_name = str_replace(['section_', '_'], ['', '-'], $iterator);
		#Helper::_debug($section_name);
		
		if(isset($section_data['menu_target_hash']) && !empty($section_data['menu_target_hash'])){
			$menu_target_hash = str_replace(array('/', '#'), '', $section_data['menu_target_hash']);
			echo '<div id="'.$menu_target_hash.'-section"></div>';
		}
		$file = SECTIONS_PATH.'/'.$section_name;
		
		self::get_template_part($file, ['section_name' => $section_name, 'section_data' => $section_data]);
	}
	
	public static function get_template_part($slug, $params = array(), $echo = true){
		$file = THEME_DIR.trim($slug, '/').'.php';
		if(!file_exists($file) && WP_DEBUG){
			Helper::_debug($file);
		}
		
		if($echo){
			if(!empty($params)){
				foreach($params as $k => $param){
					set_query_var($k, $param);
				}
			}
			get_template_part($slug);
		}else{
			ob_start();
			extract($params);
			include locate_template($slug.'.php');
			return ob_get_clean();
		}
	}
	
	public static function addCSS($app_styles, $css_id){
		$minifier = new SimpleCssMinifier();
		$output = $minifier->minify($app_styles);
		echo '<style id="mk-custom-style-'.$css_id.'" type="text/css">'.$output.'</style>';
		return;
	}

	public static function render_social_share($socail_links = [], $echo = false){
		$html = '';
		
		foreach($socail_links as $k => $item){
			$link = str_replace('%POST_URL%', $item['link'], self::$shared_links[$item['service']]);
			$html .= '<a href="'.$link.'" title="'.$item['service'].'"><i class="fa fa-'.$item['service'].' fa-fw"></i></a>';
		}

		if(!$echo){
			return $html;
		}

	}
	
	public static function render_modals($echo = true){
		$html = '';
		
		if(class_exists('ACF')){
			$modals_data = [];
			
			$display_cookie_policy_popup = get_field('display_cookie_policy_popup', 'option');
			if($display_cookie_policy_popup){
				$cookie_policy_params = get_field('cookie_policy_params', 'option');
				#Helper::_debug($cookie_policy_params);
				
				if(!empty($cookie_policy_params['popup_content_page'])){
					$title = $cookie_policy_params['popup_content_page']->post_title;
					$content = apply_filters('the_content', $cookie_policy_params['popup_content_page']->post_content);
				}else{
					$title = $cookie_policy_params['popup_title'];
					$content = $cookie_policy_params['popup_content'];
				}
				
				$buttons = [];
				if(!empty($cookie_policy_params['display_popup_buttons'])){
					foreach($cookie_policy_params['display_popup_buttons'] as $button){
						if(!empty($cookie_policy_params[$button.'_button_text'])){
							$buttons[$button] = $cookie_policy_params[$button.'_button_text'];
						}
					}
				}
				
				$modals_data['cookie-policy'] = [
					'title'   => $title,
					'content' => $content,
					'buttons' => $buttons,
				];
			}
			
			
			if(!empty($modals_data)){
				if($echo){
					set_query_var('modals_data', $modals_data);
					get_template_part(PARTIALS_PATH.'/modal');
				}else{
					ob_start();
					include locate_template(PARTIALS_PATH.'/modal.php');
					$html = ob_get_clean();
				}
			}
		}
		
		if(!$echo){
			return $html;
		}
	}
	
	public static function render_tracker_scripts($echo = true){
		
		$html = get_field('tracker_scripts', 'option');
		
		if(!empty($html)){
		
		}
		
		if(!$echo){
			return $html;
		}else{
			echo $html;
		}
		
	}
	
	public static function render_hubspot_embed_code($echo = true){
		$post_id = get_queried_object_id();
		$hubspot = get_field('hubspot', 'option');
		$html = $hubspot['embed_code'];
		$for_pages = $hubspot['embed_code_for_pages'];
		
		if(!empty($html)){
			if(!empty($for_pages)){
				if(!in_array($post_id, $for_pages)){
					$html = '';
				}
			}else{
				$html = '';
			}
		}else{
			$html = '';
		}
		
		if(!$echo){
			return $html;
		}else{
			echo $html;
		}
		
	}
	
	public static function render_cookiebox($echo = true, $in_footer = true){
		$html = '';
		
		$cookies_notify_type = get_field('cookies_notify_type', 'option');
		
		if($cookies_notify_type == 'custom' && $in_footer){
			/** the variable is set in the self::set_vars_on_init() **/
			if($GLOBALS['display_cookie_policy']){
				$box_data = array(
					'text'   => get_field('cookies_box_text', 'option'),
					'button' => get_field('cookies_box_button', 'option')
				);
				
				if($echo){
					set_query_var('box_data', $box_data);
					get_template_part(PARTIALS_PATH.'/cookiebox');
				}else{
					ob_start();
					include locate_template(PARTIALS_PATH.'/cookiebox.php');
					$html = ob_get_clean();
				}
			}

			if(!$echo){
				return $html;
			}
		}elseif($cookies_notify_type == 'embed' && !$in_footer){
			if(WP_PRODUCTION_MODE){
				$html = get_field('cookies_embed_code_live', 'option');
			}else{
				$html = get_field('cookies_embed_code_dev', 'option');
			}
			
			if(!$echo){
				return $html;
			}else{
				echo $html;
			}
		}
		
	}
	
	public static function render_notifybox($echo = true){
		$html = '';
		
		/** the variable is set in the function self::set_vars_on_init() **/
		if($GLOBALS['display_header_notification']){
			$box_data = array(
				'text'   => get_field('notification_box_content', 'option'),
			);
			
			if($echo){
				set_query_var('box_data', $box_data);
				get_template_part(PARTIALS_PATH.'/notifybox');
			}else{
				ob_start();
				include locate_template(PARTIALS_PATH.'/notifybox.php');
				$html = ob_get_clean();
			}
		}
		
		if(!$echo){
			return $html;
		}
	}
	
	public static function render_footer($echo = true){
		global $post;
		$html = '';
		
		if(class_exists('ACF')){
			$footer = get_field('footer', 'option');
			$data   = array(
				'copyright_bar_color' => '', //$footer['copyright_bar_color'],
				'footer_color'        => '', //$footer['footer_color'],
				'copyright_text'      => '', //$footer['copyright_text'],
				'creator_text'        => '', //$footer['creator_text'],
				'nav'                 => [], //Theme::get_menu_tree('footer-menu'),
				'col'                 => 12,
			);
			if(!empty($data['nav'])){
				$data['col'] = floor(12 / count($data['nav']));
			}
			//Helper::_debug($data);
			if($echo){
				set_query_var('data', $data);
				get_template_part(PARTIALS_PATH.'/footer');
			}else{
				ob_start();
				include locate_template(PARTIALS_PATH.'/footer.php');
				$html = ob_get_clean();
			}
		}
		
		if(!$echo){
			return $html;
		}
	}
	
	public static function render_header($echo = true){
		global $post;
		$html = '';
		
		if(class_exists('ACF')){
			$page_options = get_field('page_options', $post->ID);
			
			$single_post_main_nav_style = 'light';
			
			switch($post->post_type){
				case "job":
					$single_post_main_nav_style = get_field('single_job_main_nav_style', 'option');
					break;
				/*case "case-studies":
					$single_post_main_nav_style = get_field('single_case_study_main_nav_style', 'option');
					break;*/
			}
			
			if($echo){
				set_query_var('single_post_main_nav_style', $single_post_main_nav_style);
				set_query_var('page_options', $page_options);
				get_template_part(PARTIALS_PATH.'/header');
			}else{
				ob_start();
				include locate_template(PARTIALS_PATH.'/header.php');
				$html = ob_get_clean();
			}
		}
		
		if(!$echo){
			return $html;
		}
	}
	
	public static function get_comments_callback( $comment, $args, $depth ) {

		// Get the comment type of the current comment.
		$comment_type = get_comment_type( $comment->comment_ID );

		// Create an empty array if the comment template array is not set.
		$comment_template = array();

		// Check if a template has been provided for the specific comment type.  If not, get the template.
		if(!isset($comment_template[$comment_type])){

			// Create an array of template files to look for.
			$templates = array( "templates/comment/{$comment_type}.php" );

			// If the comment type is a 'pingback' or 'trackback', allow the use of 'comment-ping.php'.
			if ( 'pingback' == $comment_type || 'trackback' == $comment_type ) {
				$templates[] = 'templates/comment/ping.php';
			}

			// Add the fallback 'comment.php' template.
			$templates[] = 'templates/comment/comment.php';

			// Allow devs to filter the template hierarchy.
			//$templates = apply_filters( 'rella_comment_template_hierarchy', $templates, $comment_type );

			// Locate the comment template.
			$template = locate_template( $templates );

			// Set the template in the comment template array.
			$comment_template[ $comment_type ] = $template;
		}

		// If a template was found, load the template.
		if ( ! empty($comment_template[ $comment_type ] ) ) {
			require($comment_template[ $comment_type ] );
		}
	}
	
	public static function breadcrumbs($options = [], $content = ''){
		global $post;
		//_debug($post);
		$position = 1;
		$output = '<nav aria-label="breadcrumb" class="breadcrumb-row" itemscope="" itemtype="http://schema.org/BreadcrumbList">';
		$output .= '<ol class="breadcrumb">';
		$output .= '<li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a href="'.home_url().'" itemprop="item"><span itemprop="name">'.__('Home', THEME_TD).'</span></a><meta itemprop="position" content="'.$position.'" /></li>';
		if(is_single()){
			$position++;
			$output .= '<li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a href="/blog/" itemprop="item"><span itemprop="name">'.__('Blog', THEME_TD).'</span></a><meta itemprop="position" content="'.$position.'" /></li>';
		}
		if(is_page() || is_post_type_viewable($post->post_type)){
			$ancestors = get_post_ancestors($post);
			foreach($ancestors as $ancestor){
				$position++;
				$parent_post = get_post($ancestor);
				$parent_title = $parent_post->post_title;
				$output .= '<li class="breadcrumb-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
							<a href="'.get_permalink($ancestor).'" itemprop="item"><span itemprop="name">'.$parent_title.'</span></a>
							<meta itemprop="position" content="'.$position.'" />
						</li>';
			}
			$position++;
			$output .= '<li class="breadcrumb-item active" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem" aria-current="page"><a href="#content" itemprop="item"><span itemprop="name">'.$post->post_title.'</span></a><meta itemprop="position" content="'.$position.'" /></li>';
		}
		if(is_search()){
			$position++;
			$output .= '<li class="breadcrumb-item active" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem" aria-current="page"><a href="#content" itemprop="item"><span itemprop="name">'.__('Results for ', THEME_TD).get_search_query().'</span></a><meta itemprop="position" content="'.$position.'" /></li>';
		}
		$output .= '</ol>';
		$output .= '</nav>';
		return $output;
	}
	
	public static function oxy_comment_callback($comment, $args, $depth){
	    $GLOBALS['comment'] = $comment;
	    $tag = $depth === 1 ? 'li' : 'div'; ?>
	    <<?php echo $tag ?> <?php comment_class('media media-comment'); ?>>
	        <div class="media-avatar media-left">
	            <?php echo get_avatar($comment, 48); ?>
	        </div>
	        <div class="media-body">
	            <div class="media-inner">
	                <div id="comment-<?php comment_ID(); ?>">
	                    <div class="media-heading clearfix">
	                        <strong>
	                            <?php comment_author_link(); ?>
	                        </strong>
	                        -
	                        <?php comment_date(); ?>
	                        <strong class="comment-reply pull-right">
	                            <?php comment_reply_link(array_merge($args, array('reply_text' => __('reply', THEME_TD), 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
	                        </strong>
	                    </div>
	                    <?php comment_text(); ?>
	                </div>
	            </div>
	    <?php
	}
	
	public static function oxy_comment_end_callback($comment, $args, $depth){
		// we need to add 1 to the depth to get this to work
		$tag = $depth + 1 === 1 ? 'li' : 'div'; ?>
		</div>
		</<?php echo $tag ?>>
		<?php
	}
	
	public static function get_social_shareing_html($_post = null, $wrap_class = ''){
		global $post;
		
		if(is_null($_post) || !is_object($_post)){
			$_post = $post;
		}
		
		$popst_title = get_the_title($_post);
		//$post_thumbnail_id = get_post_thumbnail_id($_post);
		$post_link = get_the_permalink($_post);
		$post_excerpt = Functions::create_excerpt(get_the_excerpt($_post));
		
		$sharing_options = get_field('social_share_links', 'option');
		
		$html = '<div class="social-sharing trans_all '.$wrap_class.'">';
		foreach($sharing_options as $option){
			$class = '';
			$action = 'social_shraing_service';
			if(empty($option['icon'])){
				switch($option['service']){
					case "facebook":
						$class = 'i-fb';
						break;
					case "linkedin":
						$class = 'i-in';
						break;
					case "twitter":
						$class = 'i-tw';
						break;
					case "email":
						$class = 'i-ml';
						break;
					case "instagram":
						$class = 'i-ig';
						break;
					case "pinterest":
						$class = 'i-pt';
						break;
					case "youtube":
						$class = 'i-yt';
						break;
					case "google-plus":
						$class = 'i-gp';
						break;
					case "reddit":
						$class = 'i-rd';
					case "copy":
						$class = 'i-copy';
						$action = 'social_shraing_copy_link';
						break;
				}
				$icon = '<i class="i '.$class.' i-reverse i-social"></i>';
			}else{
				$icon = '<img class="icon" src="'.$option['icon'].'" />';
			}
			$link = str_replace(['%POST_URL%', '%POST_TITLE%', '%POST_EXCERPT%'], [$post_link, $popst_title, $post_excerpt], $option['link']);
			if($option['type'] == 'repost'){
				$html .= '<a class="mr-2 shraing-service" href="javascript:;" data-trigger="js_action_click" data-action="'.$action.'" data-url="'.$link.'" data-service="'.$option['service'].'">'.$icon.'</a>';
			}elseif($option['type'] == 'direct'){
				$html .= '<a class="mr-2" href="'.$link.'" title="'.$option['service'].'" target="_blank">'.$icon.'</a>';
			}
		}
		$html .= '<div class="c-share__copied-message text-white rounded custom-toast">URL copied to your clipboard!</div>';
		$html .= '</div>';
		
		return $html;
	}
	
	public static function get_social_buttons_html($attr = []){
		$sharing_options = get_field('social_buttons', 'option');
		
		$display_only_items = [];
		
		if(!empty($attr['display_only']))
			$display_only_items = explode(",", $attr['display_only']);
		
		$html = '';
		if(!empty($attr['wrap_class']))
			$html .= '<div class="'.$attr['wrap_class'].'">';
		
		$count = count($sharing_options);
		
		foreach($sharing_options as $n => $option){
			if(!empty($option['icon'])){
				$icon = '<img class="icon" src="'.$option['icon'].'">';
				$icon_class = '';
			}else{
				$icon = '';
				switch($option['service']){
					case "facebook":
						$icon_class = 'i i-fb i-social '.$attr['icons_size'];
						break;
					case "instagram":
						$icon_class = 'i i-inst i-social '.$attr['icons_size'];
						break;
					case "linkedin":
						$icon_class = 'i i-in i-social '.$attr['icons_size'];
						break;
					case "youtube":
						$icon_class = 'i i-youtube i-social '.$attr['icons_size'];
						break;
					case "pinterest":
						$icon_class = 'i i-pinterest i-social '.$attr['icons_size'];
						break;
					case "twitter":
						$icon_class = 'i i-twitter i-social '.$attr['icons_size'];
						break;
					case "google-plus":
						$icon_class = 'i i-google-plus i-social '.$attr['icons_size'];
						break;
					case "reddit":
						$icon_class = 'i i-reddit i-social '.$attr['icons_size'];
						break;
					case "email":
						$icon_class = 'i i-email i-social '.$attr['icons_size'];
						break;
				}
				
				if($n+1 < $count){
					$icon_class .= ' mr-3';
				}
			}
			
			if(empty($display_only_items) || in_array($option['service'], $display_only_items))
				$html .= '<a class="'.$icon_class.'" href="'.$option['link'].'" title="'.$option['service'].'" target="_blank">'.$icon.'</a>';
		}
		
		if(!empty($attr['wrap_class']))
			$html .= '</div>';
		
		return $html;
	}
	
	/**
	 * @param $pdf_file
	 * @param $page
	 *
	 * @throws \ImagickException
	 *
	 * @usage
	 * $pdf = ABSPATH.'/wp-content/uploads/2020/08/AEMHiringGuide_Finalp07072020_1-swt_page.pdf';
	 * Functions::render_pdf_to_image($pdf, 0);
	 */
	public static function render_pdf_to_image($pdf_file, $page){
		$pdf_file_name = $pdf_file['filename'];
		$img_file_name = str_replace('.pdf', '.jpg', $pdf_file_name);
		
		$pdf_file_path = str_replace(site_url('/'), ABSPATH, $pdf_file['url']);
		$img_file_path = str_replace($pdf_file_name, $img_file_name, $pdf_file_path);
		$img_file_url = str_replace($pdf_file_name, $img_file_name, $pdf_file['url']);
		
		if(!file_exists($img_file_path)){
			try {
				// create Imagick object
				$imagick = new Imagick();
				// Read image from PDF
				$imagick->readImage($pdf_file_path.'['.$page.']');
				// Writes an image
				$imagick->writeImage($img_file_path);
			}catch(\ImagickException $e){
				return $e->getMessage();
			}
		}
		
		if(file_exists($img_file_path)){
			list($width, $height) = @getimagesize($img_file_path);
			$image = [$img_file_url, $width, $height];
			
			return self::get_the_thumbnail($image, '346x490', '', false, false);
		}else{
			return '';
		}
	}
	
	public static function render_blog_video($post_id){
		$video_start_time = get_field('video_start_time', $post_id);
		$parsed = date_parse($video_start_time);
		$seconds = $parsed['hour'] * 3600 + $parsed['minute'] * 60 + $parsed['second'];
		
		$iframe = get_field('video_url', $post_id);
		preg_match('/src="(.+?)"/', $iframe, $matches);
		$src = $matches[1];
		$params = array(
			'controls'  => 1,
			'hd'        => 1,
			'autohide'  => 1,
			'start' => $seconds
		);
		$new_src = add_query_arg($params, $src);
		$iframe = str_replace($src, $new_src, $iframe);
		
		// Add extra attributes to iframe HTML.
		$attributes = 'frameborder="0"';
		$iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);
		
		return $iframe;
	}
	
	public static function create_cats_filter_url($page_url, $subcats){
		$get_cats = array_keys($_GET);
		#Helper::_debug($_GET);
		$filter_buttons_url = $page_url.'/'.(!empty($get_cats) ? '?'.implode('&', $get_cats) : '');
		#Helper::_debug($filter_buttons_url);
		#Helper::_debug($subcats);

		foreach($subcats as $k => $cat){
			if(in_array($cat->slug, $get_cats)){
				$subcats[$k]->active = 1;
				$subcats[$k]->active_class = 'active';
				$_get_cats = $_GET;
				unset($_get_cats[$cat->slug]);
				$_filter_buttons_url = $page_url.'/'.(!empty($_get_cats) ? '?'.implode('&', array_keys($_get_cats)) : '');
				if($cat->cf['candidate_page']){
					$_filter_buttons_url = get_permalink($cat->cf['candidate_page']);
				}
				$subcats[$k]->url = $_filter_buttons_url;
				//$subcats[$k]->url = (strstr($filter_buttons_url, '?') !== false) ? str_replace('?'.$cat->slug, '', $filter_buttons_url) : str_replace('&'.$cat->slug, '', $filter_buttons_url);
			}else{
				$_filter_buttons_url = (strstr($filter_buttons_url, '?') !== false) ? $filter_buttons_url.'&'.$cat->slug : $filter_buttons_url.'?'.$cat->slug;
				if($cat->cf['candidate_page']){
					$_filter_buttons_url = get_permalink($cat->cf['candidate_page']);
				}
				$subcats[$k]->url = $_filter_buttons_url;
			}
			
			if(!empty($cat->children)){
				$cat->children = self::create_cats_filter_url($page_url, $cat->children);
			}
		}
		
		return $subcats;
	}
	
	public static function replace_page_term_link($page_url, $term, $term_post_type){
		$term_link = get_term_link($term);
		
		$find_pattern = site_url($term_post_type);
		
		$term_link = str_replace($find_pattern, '', $term_link);
		$term_link = trim($term_link, '/');
		#$term_link = str_replace('/', '&sc[]=', $term_link);
		
		return $page_url.'/?cat[]='.$term_link;
	}
	
	public static function render_modal_custom($params){
		$template = MODALS_PATH.'/default';
		
		if(isset($params['template'])){
			$template = $params['template'];
		}
		
		return self::get_template_part($template, ['params' => $params], false);
	}
	
	public static function render_section_button($section_button, $atts = []){
		
		$atts = wp_parse_args($atts, [
			'data' => [],
			'class' => 'btn',
			'icon' => '',
		]);
		
		$button = '';
		
		if(!empty($section_button)){
			if($section_button['style'] == 'link'){
				$atts['class'] = '';
			}
			
			switch($section_button['type']){
				case "custom":
					if(substr($section_button['custom_link'], 0, 1) == '#'){
						$atts['data'][] = [
							'trigger' => 'js_action_click',
							'action' => 'scroll_to_el',
							'target' => $section_button['custom_link'],
						];
						#$data_anchore = 'data-trigger="js_action_click" data-action="scroll_to_el" data-target="'.$section_button['custom_link'].'"';
						$section_button['custom_link'] = 'javascript:void(0);';
					}
					$data_anchore = self::create_button_data_attributes($atts['data']);
					#$data_anchore = (substr($section_button['custom_link'], 0, 1) == '#') ? 'data-trigger="js_action_click" data-action="scroll_to_el" data-target="'.$section_button['custom_link'].'"' : '';
					#$section_button['custom_link'] = 'javascript:void(0);';
					$button = '<a role="button" class="'.$atts['class'].'" '.$data_anchore.' href="'.$section_button['custom_link'].'" target="'.$section_button['target'].'"><span>'.$section_button['text'].'</span>'.$atts['icon'].'</a>';
					break;
				case "internal":
					if(strstr($section_button['internal_link'], '/book-a-demo/') !== false){
						$atts['data'][] = [
							'trigger' => 'js_action_click',
							'action' => 'save_to_storage',
							'referer' => get_permalink(get_queried_object()),
						];
					}
					$data_anchore = self::create_button_data_attributes($atts['data']);
					$button = '<a role="button" class="'.$atts['class'].'" '.$data_anchore.' href="'.$section_button['internal_link'].'" target="'.$section_button['target'].'"><span>'.$section_button['text'].'</span>'.$atts['icon'].'</a>';
					break;
				case "shortcode":
					$button = do_shortcode($section_button['shortcode']);
					break;
				case "hidden":
					$button = '';
					break;
			}
		}
		
		return $button;
	}
	
	public static function create_button_data_attributes($data){
		$data_anchore = '';

		if(!empty($data)){
			$data_anchore = [];
			foreach($data as $data_attr){
				foreach($data_attr as $k => $v){
					$data_anchore[] = 'data-'.$k.'="'.$v.'"';
				}
			}
			
			if(!empty($data_anchore)){
				$data_anchore = implode(' ', $data_anchore);
			}
		}
		
		return $data_anchore;
	}
	
	public static function render_section_item_link($section_item){
		
		$link = '';
		
		switch($section_item['type']){
			case "custom":
				$data_anchore = (substr($section_item['custom_link'], 0, 1) == '#') ? 'data-action="scrollto"' : '';
				$link = '<a role="link" '.$data_anchore.' href="'.$section_item['custom_link'].'" target="'.$section_item['target'].'">'.$section_item['title'].'</a>';
				break;
			case "internal":
				$link = '<a role="link" href="'.$section_item['internal_link'].'" target="'.$section_item['target'].'">'.$section_item['title'].'</a>';
				break;
			case "shortcode":
				$link = do_shortcode($section_item['shortcode']);
				break;
			case "hidden":
				$link = '';
				break;
		}
		
		return $link;
	}

}
