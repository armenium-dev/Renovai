<?php

namespace Digidez;

use WPCF7_Submission;

class Actions{
	
	public $blog_image_placeholder_id;
	
	var $active_sidebars = array(
		//'menu-bar',
		//'left-sidebar',
		'single-post-sidebar',
		#'single-job-sidebar',
		#'market-sidebar',
		//'hero',
		//'statichero',
		#'footer-full-top',
		#'footer-full-bottom',
		'footer_col_1',
		'footer_col_2',
		'footer_col_3',
		'footer_col_4',
		'sub_footer_top_full_width',
		'sub_footer_col_1',
		'sub_footer_col_2',
		'second_sub_footer_col_1',
		'second_sub_footer_col_2',
	);

	public static function initialise(){
		$self = new self();

		// define all action hooks here and document if not self explanatory
		remove_action('wp_head', 'feed_links_extra', 3); // ссылки на дополнительные rss категорий
		remove_action('wp_head', 'feed_links', 2); //ссылки на основной rss и комментарии
		remove_action('wp_head', 'rsd_link');  // для сервиса Really Simple Discovery
		remove_action('wp_head', 'wlwmanifest_link'); // для Windows Live Writer
		remove_action('wp_head', 'wp_generator');  // убирает версию wordpress
		//отключение Emoji start
		remove_action('wp_head', 'print_emoji_detection_script', 7);
		remove_action('wp_print_styles', 'print_emoji_styles');
		
		
		// убираем разные ссылки при отображении поста - следующая, предыдущая запись, оригинальный url и т.п.
		//remove_action('wp_head','start_post_rel_link',10,0);
		//remove_action('wp_head','index_rel_link');
		//remove_action('wp_head','rel_canonical');
		//remove_action('wp_head','adjacent_posts_rel_link_wp_head', 10, 0);
		//remove_action('wp_head','wp_shortlink_wp_head', 10, 0);

		//add_action('init', array($self, 'delete_post_type'));
		#add_action('init', [$self, 'unregister_tags']);
		add_action('widgets_init', [$self, 'sidebars_init']);
		//add_action('after_setup_theme', array($self, 'footer_enqueue_scripts'));

		add_action('wp_enqueue_scripts', [$self, 'enqueueCssAndJavascript'], 100);
		add_action('wp_enqueue_scripts', [$self, 'dequeueCssAndJavascript'], 9999);
		add_action('admin_enqueue_scripts', [$self, 'enqueueCssAndJavascriptAdmin']);
		//add_action('admin_print_scripts-widgets.php', [$self, 'enqueueWidgetsCssAndJSAdmin']);

		add_action('widgets.php', [$self, 'remove_from_cache'], 1, 1);
		add_action('delete_widget', [$self, 'remove_from_cache'], 1, 1);
		add_action('delete_post', [$self, 'remove_from_cache'], 1, 1);
		add_action('save_post', [$self, 'remove_from_cache'], 1, 1);
		add_action('saved_term', [$self, 'set_post_thumbnail'], 10, 3);
		add_action('edit_term', [$self, 'set_post_thumbnail'], 10, 3);
		add_action('delete_term', [$self, 'set_post_thumbnail'], 10, 3);
		
		add_action('save_post', [$self, 'set_post_thumbnail'], 10, 2);
		add_action('wp_after_insert_post', [$self, 'update_post_meta_fields'], PHP_INT_MAX, 2); # save post action

		add_action('manage_page_posts_custom_column', [$self, 'fetch_posts_columns']);
		add_action('manage_post_posts_custom_column', [$self, 'fetch_posts_columns']);
		add_action('manage_review_posts_custom_column', [$self, 'fetch_posts_columns']);
		add_action('manage_candidate_posts_custom_column', [$self, 'fetch_posts_columns']);
		add_action('manage_client_posts_custom_column', [$self, 'fetch_posts_columns']);
		add_action('manage_testimonial_posts_custom_column', [$self, 'fetch_posts_columns']);
		add_action('manage_news_posts_custom_column', [$self, 'fetch_posts_columns']);

		add_action('admin_menu', [$self, 'change_admin_menu'], 999);

		add_action('acf/init', [$self, 'acf_init']);
		
		
		add_action('init', [$self, 'init'], 10);
		
		add_action('wpcf7_before_send_mail', [$self, 'wpcf7_before_send_mail'], 10, 2);
		
	}
	
	public function init(){
		if(class_exists('ACF')){
			$this->blog_image_placeholder_id = get_field('blog_image_placeholder', 'option');
			Functions::set_vars_on_init();
		}
	}
	
	public function remove_from_cache($post_id = 0){
		#Caches::rem_cache_file($post_id);
		Caches::rem_pages_cache();
	}
	
	public function sidebars_init(){
		$sidebars = include_once __DIR__."/../options/sidebars.php";
		
		foreach($sidebars as $sidebar){
			if(in_array($sidebar['id'], $this->active_sidebars)){
				register_sidebar($sidebar);
			}
		}
	}
	
	public function footer_enqueue_scripts(){
		remove_action('wp_head', 'wp_print_scripts');
		remove_action('wp_head', 'wp_print_head_scripts', 9);
		//remove_action('wp_head','wp_enqueue_scripts',1);

		add_action('wp_footer', 'wp_print_scripts', 5);
		add_action('wp_footer', 'wp_print_head_scripts', 5);
		//add_action('wp_footer','wp_enqueue_scripts',5);
	}

	public function enqueueCssAndJavascript(){
		global $post;
		$page_template = DataSource::get_page_template();
		#Helper::_debug([$page_template, $post->post_type]);

		if(WP_PRODUCTION_MODE){
			$script_version = '2.0.0';
		}else{
			$script_version = time();
		}

		wp_enqueue_style('fonts-google', 'https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap');
		wp_enqueue_style(THEME_SHORT.'-theme', CSS_URI.'/style.css', [], $script_version, 'all');
		wp_enqueue_style(THEME_SHORT.'-theme-2', CSS_URI.'/frontend.css', [], $script_version, 'all');
		#wp_enqueue_style(THEME_SHORT.'-calendly', CSS_URI.'/calendly-widget.css', [], $script_version, 'all');

		if($page_template == 'blog' || $post->post_type == 'post' || $page_template == 'talk'){
			wp_enqueue_style(THEME_SHORT.'-theme-blog', CSS_URI.'/blog.css', [], $script_version, 'all');
		}
		if($page_template == 'talk'){
			wp_enqueue_style(THEME_SHORT.'-theme-talk', CSS_URI.'/renotalk.css', [], $script_version, 'all');
		}

		wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.6.0.min.js', [], $script_version, false);
		wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js', ['jquery'], $script_version, true);

		#wp_enqueue_script('popper', 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js', ['jquery'], $script_version, true);
		#wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js', ['jquery', 'popper'], $script_version, true);

		#wp_enqueue_script('popper', JS_URI.'/popper.min.js', ['jquery'], $script_version, true);
		#wp_enqueue_script('bootstrap', JS_URI.'/bootstrap.bundle.min.js', ['jquery'], $script_version, true);

		wp_enqueue_script('slick', JS_URI.'/slick.js', ['jquery'], $script_version, true);
		wp_enqueue_script('splide', JS_URI.'/splide.min.js', ['jquery'], $script_version, true);
		wp_enqueue_script('scroll-toggle-menu', JS_URI.'/scroll-toggle-menu.js', ['jquery'], $script_version, true);
		wp_enqueue_script('jquery-inputmask', JS_URI.'/jquery.inputmask.min.js', ['jquery'], $script_version, true);
		wp_enqueue_script('ion-rangeSlider', JS_URI.'/ion.rangeSlider.min.js', ['jquery'], $script_version, true);
		wp_enqueue_script(THEME_SHORT.'-common', JS_URI.'/common.js', ['jquery'], $script_version, true);
		#wp_enqueue_script(THEME_SHORT.'-calendly', JS_URI.'/calendly-widget.js', ['jquery'], $script_version, true);
		#wp_enqueue_script('calendly-widget', 'https://assets.calendly.com/assets/external/widget.js', [], $script_version, true);

		/*
		$google  = get_field('google', 'option');
		$api_key = $google['map_api_key'];
		$api_key = !empty($api_key) ? 'key='.$api_key : '';
		$api_key = esc_attr($api_key);
		wp_enqueue_script(THEME_SHORT.'-google-map-api', 'https://maps.googleapis.com/maps/api/js?'.$api_key.'&v=3.35');
		wp_enqueue_script(THEME_SHORT.'-google-map', JS_URI.'/map.js', array('jquery', THEME_SHORT.'-google-map-api'));
		wp_enqueue_script(THEME_SHORT.'-google-map', JS_URI.'/acf-map.js', array('jquery', THEME_SHORT.'-google-map-api'));
		*/

		if(!is_admin()){
			if(is_singular() && comments_open() && (get_option('thread_comments') == 1)){
				wp_enqueue_script('comment-reply');
			}
		}
		
		
		$globals_atts = [
			'domain'   => $_SERVER['HTTP_HOST'],
			'device'   => Helper::$device,
			'ajax_url' => admin_url('admin-ajax.php'),
			'nonce'    => wp_create_nonce('wcpc-ajax-nonce'),
			'token' => isset($_COOKIE['token']) ? $_COOKIE['token'] : '',
			'current_page_id' => get_queried_object_id(),
			'post_type' => $post ? $post->post_type : '',
			'notification_hide_days_limit' => get_field('notification_hide_days_limit', 'option'),
			'actions' => [
			],
			'lang' => [],
		];

		wp_enqueue_script(THEME_SHORT.'-frontend', JS_URI.'/frontend.js', [], $script_version, true);
		wp_localize_script(THEME_SHORT.'-frontend', 'globals', $globals_atts);
	}

	public function enqueueCssAndJavascriptAdmin(){
		$script_version = '1.0.0';
		$script_version = time();
		$screen = get_current_screen();
		#Functions::_debug($screen->id); exit;
		
		wp_enqueue_style('fonts-google', 'https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap');
		
		#wp_enqueue_style(THEME_SHORT.'-fontawesome', ICONS_URI.'/css/fontawesome.min.css', array(), '5', 'all');
		#wp_enqueue_style('bootstrap', CSS_URI.'/bootstrap-admin.css');
		#wp_enqueue_style(THEME_SHORT.'-animate', CSS_URI.'/animate.css', array(), '3.7.0', 'all');
		#wp_enqueue_style('bootstrap-select', CSS_URI.'/bootstrap-select.css');
		wp_enqueue_style(THEME_SHORT.'-admin-styles', CSS_URI.'/admin.css', [], $script_version, false);

		#wp_enqueue_script('bootstrap', JS_URI.'/bootstrap.min.js', array('jquery'), '3.3.7', true);
		#wp_enqueue_script('bootstrap-select', JS_URI.'/bootstrap-select.js', array('jquery'), '1.12.2', true);

		$globals_atts = [
			'device'   => Helper::$device,
			'ajax_url' => admin_url('admin-ajax.php'),
			'nonce'    => wp_create_nonce('wcpc-ajax-nonce'),
			'export_webinar_cutomers_action' => 'export_webinar_cutomers_request',
			'lang' => [
				'confirm' => esc_html__('Do you really want to delete this item?', THEME_TD)
			],
		];
		wp_enqueue_script(THEME_SHORT.'-child-theme-js', JS_URI.'/backend.js', ['jquery'], $script_version, true);
		wp_localize_script(THEME_SHORT.'-child-theme-js', 'globals', $globals_atts);
	}

	public function enqueueWidgetsCssAndJSAdmin(){}
	
	public function dequeueCssAndJavascript(){
		//wp_dequeue_style('divi-style');
		//wp_dequeue_style('roboto');
		//wp_dequeue_style('open-sans');
		#wp_dequeue_script('gform_gravityforms');
		#wp_deregister_script('jquery');
		#wp_deregister_script('jquery-core');
		#wp_deregister_script('jquery-migrate');
	}

	public function page_excerpt(){
		//add_post_type_support('page', array('excerpt'));
		remove_post_type_support('page', 'comments');
	}

	public function delete_post_type(){}

	public function unregister_tags(){
		unregister_taxonomy_for_object_type('post_tag', 'post');
	}

	public function acf_init(){
		$google  = get_field('google', 'option');
		$api_key = $google['map_api_key'];
		if(!empty($api_key)){
			$api_key = esc_attr($api_key);
			acf_update_setting('google_api_key', $api_key);
		}
	}

	public function change_admin_menu(){
		global $menu;
		global $submenu;
		#Functions::_debug($submenu);

		//$menu[5][0] = __('News', THEME_TD);
		//$submenu['edit.php'][5][0] = __('News Items', 'avia_framework');
		//$submenu['edit.php'][10][0] = __('Add News Item', 'avia_framework');


		//remove_menu_page('options-general.php'); // Удаляем раздел Настройки
		//remove_menu_page('tools.php'); // Инструменты
		//remove_menu_page('users.php'); // Пользователи
		//remove_menu_page('plugins.php'); // Плагины
		//remove_menu_page('themes.php'); // Внешний вид
		//remove_menu_page('edit.php'); // Посты блога
		//remove_menu_page('upload.php'); // Медиабиблиотека
		//remove_menu_page('edit.php?post_type=page'); // Страницы
		remove_menu_page('edit-comments.php'); // Комментарии
		remove_menu_page('link-manager.php'); // Ссылки
		//remove_menu_page('wpcf7');   // Contact form 7
		//remove_menu_page('options-framework'); // Cherry Framework

		//remove_submenu_page( 'themes.php', 'themes.php'); // Удаляем подпункт с выбором тем
		remove_submenu_page( 'themes.php', 'theme-editor.php'); // Редактирование шаблона
		remove_submenu_page('themes.php', 'customize.php?return=%2Fwp-admin%2Fthemes.php'); // Редактирование шаблона
		//remove_submenu_page( 'themes.php', 'widgets.php' );
		//remove_submenu_page( 'themes.php', 'theme_options' ); // Настройки темы
		//remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' ); // Скрытие Тегов для Постов
		//remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=category' ); // Скрытие Категорий для Постов

		// Removing customize.php
		//unset($submenu['themes.php'][6]);
	}

	public function fetch_posts_columns($column){
		global $post;
		$editlink = get_edit_post_link($post->ID);

		#Helper::_debug($column);

		switch($column){
			case 'news_post_date':
				if(class_exists('ACF')){
					echo get_field($column, $post->ID);
				}
				break;
			case 'news_post_image':
				if(class_exists('ACF')){
					echo '<a href="'.$editlink.'">';
					$image_id = get_field($column, $post->ID);
					echo Functions::get_the_attachment_thumbnail($image_id, '50x50', [], true);
					echo '</a>';
				}
				break;
			case 'testimonial_user_photo':
				if(class_exists('ACF')){
					echo '<a href="'.$editlink.'">';
					$image_id = get_field('testimonial_user_photo', $post->ID);
					echo Functions::get_the_attachment_thumbnail($image_id, '100x100', [], true);
					echo '</a>';
				}
				break;
			case 'testimonial_job_title':
				if(class_exists('ACF')){
					echo get_field($column, $post->ID);
				}
				break;
			case 'testimonial_company_name':
				if(class_exists('ACF')){
					echo get_field($column, $post->ID);
				}
				break;
			case 'news_post_logo':
			case 'client_logo':
				echo '<a href="'.$editlink.'">';
				if(class_exists('ACF')){
					$img_url = get_field($column, $post->ID);
					echo '<img src="'.$img_url.'">';
				}
				echo '</a>';
				break;
			case 'client_url':
				if(class_exists('ACF')){
					echo get_field('client_url', $post->ID);
				}
				break;
			case 'candidate_base_id':
				if(class_exists('ACF')){
					echo '<span class="badge badge-success">'.get_field('candidate_base_id', $post->ID).'</span>';
				}
				break;
			case 'candidate_position':
				if(class_exists('ACF')){
					echo get_field('candidate_position', $post->ID);
				}
				break;
			case 'candidate_location':
				if(class_exists('ACF')){
					echo get_field('candidate_location', $post->ID);
				}
				break;
			case 'candidate_skills':
				if(class_exists('ACF')){
					$candidate_skills = get_field('candidate_skills', $post->ID);
					echo '<span class="badge badge-danger m-1">'.implode('</span><span class="badge badge-danger m-1">', $candidate_skills).'</span>';
				}
				break;
			case 'featured-image':
				echo '<a href="'.$editlink.'">';
				if(has_post_thumbnail()){
					echo get_the_post_thumbnail($post->ID, 'medium');
				}else{
					#Functions::_debug($post->ID);
					if($this->blog_image_placeholder_id){
						echo Functions::get_the_attachment_thumbnail($this->blog_image_placeholder_id, '150x150', [], true);
					}
				}
				echo '</a>';
				break;
			case 'user_avatar':
				if(class_exists('ACF')){
					echo '<a href="'.$editlink.'">';
					$user_avatar = get_post_meta($post->ID, 'user_avatar', true);
					echo Functions::get_the_attachment_thumbnail($user_avatar, '100x100', [], true);
					echo '</a>';
				}
				break;
			case 'user_name':
				if(class_exists('ACF')){
					echo get_field('user_name', $post->ID);
				}
				break;
			case 'review_date':
				if(class_exists('ACF')){
					echo get_field('review_date', $post->ID);
				}
				break;
			case 'review_rate':
				if(class_exists('ACF')){
					echo get_field('review_rate', $post->ID);
				}
				break;
			case 'template':
				echo trim(str_replace(
					array(ABSPATH.'wp-content/themes/', '//'),
					array('', '/'),
					get_page_template()
				), '/');
				//echo get_post_meta($post->ID, 'lambda_partner_link', true);
				break;
			case 'language':
				if(class_exists('ACF')){
					echo strtoupper(get_post_meta($post->ID, 'page_language', true));
				}else{
					echo '';
				}
				break;
			case 'layout_template':
				if(class_exists('ACF')){
					$layout_template = get_field('layout_template', $post->ID);
					if($layout_template){
						echo '<a href="'.admin_url('/post.php?post='.$layout_template->ID.'&action=edit').'">['.$layout_template->ID.'] '.$layout_template->post_title.'</a>';
					}
				}else{
					echo get_post_meta($post->ID, 'layout_template', true);
				}
				break;
			case 'webinar-cat':
				// Get the genres for the post.
				$terms = get_the_terms( $post->ID, 'webinar-cat' );
				/* If terms were found. */
				if ( !empty( $terms ) ) {
					$out = array();
					// Loop through each term, linking to the 'edit posts' page for the specific term.
					foreach ( $terms as $term ) {
						$out[] = sprintf( '<a href="%s">%s</a>',
							esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'webinar-cat' => $term->slug ), 'edit.php' ) ),
							esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'webinar-cat', 'display' ) )
						);
					}
					// Join the terms, separating them with a comma.
					echo join( ', ', $out );
				}else {// If no terms were found, output a default message.
					_e( 'No Articles' );
				}
				break;
			case 'review-cat':
				$terms = get_the_terms($post->ID, 'review-cat');
				if(!empty($terms)){
					$out = array();
					foreach($terms as $term){
						$out[] = sprintf(
							'<a href="%s">%s</a>',
							esc_url(add_query_arg(array('post_type' => $post->post_type, 'review-cat' => $term->slug), 'edit.php')),
							esc_html(sanitize_term_field('name', $term->name, $term->term_id, 'review-cat', 'display'))
						);
					}
					echo join(', ', $out);
				}else{
					_e('No Articles');
				}
				break;
			case 'candidate-cat':
				$terms = wp_get_post_terms($post->ID, 'candidate-cat', ['hierarchical' => true, 'orderby' => 'parent', 'order' => 'ASC']);
				if(!empty($terms)){
					$out = array();
					foreach($terms as $term){
						$out[] = sprintf(
							'<a href="%s">%s</a>',
							esc_url(add_query_arg(array('post_type' => $post->post_type, 'candidate-cat' => $term->slug), 'edit.php')),
							esc_html(sanitize_term_field('name', $term->name, $term->term_id, 'candidate-cat', 'display'))
						);
					}
					echo join(', ', $out);
				}else{
					_e('No Articles');
				}
				break;
			case 'menu_order':
				echo $post->menu_order;
				break;
			default:
				break;
		}
	}
	
	public function set_post_thumbnail($post_id, $post){
		
		if("post" != $post->post_type) return;
		
		if(!has_post_thumbnail($post)){
			set_post_thumbnail($post, $this->blog_image_placeholder_id);
		}
	}
	
	public function update_post_meta_fields($post_id, $post){
		MetaOG::update_post_meta_fields($post_id, $post);
	}
	
	public function wpcf7_before_send_mail($contact_form, &$abort){
		$abort = false;

		$submission = WPCF7_Submission::get_instance();
		$submited['posted_data'] = $submission->get_posted_data();

		$exclude_forms_for_validating_business_emails = get_field('common_exclude_forms_for_validating_business_emails', 'option');
		#Helper::_log($exclude_forms_for_validating_business_emails);
		#Helper::_log($contact_form->id);
		#Helper::_log($submited);

		if(isset($submited['posted_data']['your-email'])){
			if(!in_array($contact_form->id, $exclude_forms_for_validating_business_emails)){
				if(!Functions::is_business_email($submited['posted_data']['your-email'])){
					$abort = true;
				}
			}
		}
		
		return $contact_form;
	}

}

