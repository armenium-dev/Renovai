<?php

namespace Digidez;

class Shortcodes{
	
	
	public static function initialise(){
		$self = new self();
		
		#include_once 'shortcodes/faq_accordion.php';
		
		add_shortcode('job_title_logo', [$self, 'job_title_logo']);
		#add_shortcode('recent_blogs', [$self, 'get_recent_blog']);
		#add_shortcode('last_blog_post', [$self, 'get_last_blog_post']);
		#add_shortcode('social_sharing', [$self, 'social_sharing']);
		add_shortcode('social_buttons', [$self, 'social_buttons']);
		add_shortcode('insert_button', [$self, 'insert_button']);
		add_shortcode('insert_link', [$self, 'insert_link']);
		add_shortcode('insert_page_link', [$self, 'insert_page_link']);
		add_shortcode('insert_image', [$self, 'insert_image']);
		add_shortcode('insert_copyright', [$self, 'insert_copyright']);
		add_shortcode('insert_copyright_and_page_links', [$self, 'insert_copyright_and_page_links']);
		#add_shortcode('related_posts', [$self, 'related_posts']);
		#add_shortcode('press_posts', [$self, 'get_press_posts']);
		#add_shortcode('testimonials_posts', [$self, 'get_testimonials_posts']);
	}
	
	public function get_recent_blog($attr){
		
		if(isset($attr['items'])){
			$number = $attr['items'];
		}else{
			$number = 5;
		}
		$output = '<div class="recent-jobs"><ul class="blog-list">';
		
		$args   = array('post_type' => 'post', 'orderby' => 'post_date', 'order' => 'DESC', 'post_status' => 'publish', 'posts_per_page' => $number);
		$result = query_posts($args);
		
		foreach($result as $row){
			$output .= '<li class="blog-item">
            <a href="'.get_permalink($row->ID).'"><h3>'.$row->post_title.'</h3>
			<div class="meta">'.date('M d, Y', strtotime($row->post_date)).'</div></a></li>';
		}
		wp_reset_query();
		$output .= '</ul></div>';
		
		return $output;
		
	}

	public function get_last_blog_post($attr){
		
		$last = DataSource::get_latest_post();
		$last->post->author = DataSource::get_author_data($last->post->post_author);
		#Functions::_debug($last->post->author);
		
		/*$output = '<div class="last-blog-post">';
		
		$args   = array('post_type' => 'post', 'orderby' => 'post_date', 'order' => 'DESC', 'post_status' => 'publish', 'posts_per_page' => 1);
		$result = query_posts($args);
		
		foreach($result as $row){
			$output .= '
            <a href="'.get_permalink($row->ID).'"><h3>'.$row->post_title.'</h3>
			<div class="meta">'.date('M d, Y', strtotime($row->post_date)).'</div></a>';
		}
		wp_reset_query();
		$output .= '</ul></div>';*/
		
		return Functions::get_template_part(SHORTCODES_PATH.'/footer-post', ['post' => $last->post], false);
		
	}
	
	public function social_sharing(){
		return Functions::get_social_shareing_html(null);
	}
	
	public function social_buttons($attr){
		$attr = wp_parse_args($attr, [
			'wrap_class' => '',
			'icons_size' => '',
			'display_only' => '',
		]);

		return Functions::get_social_buttons_html($attr);
	}
	
	public function related_posts($attr){
		return Functions::get_template_part(PARTIALS_PATH.'/blog/related/posts', ['display_title' => false], false);
	}
	
	public function get_press_posts($attr){
		$output = '';
		
		
		$args = [
			'post_type' => 'press',
			'post_status' => 'publish',
			'orderby' => isset($attr['orderby']) ? $attr['orderby'] : 'post_date',
			'order' => isset($attr['order']) ? $attr['order'] : 'ASC',
			'posts_per_page' => isset($attr['count']) ? $attr['count'] : 3,
		];
		
		if(isset($attr['terms'])){
			$term_ids = explode(',', $attr['terms']);
			
			foreach($term_ids as $term_id){
				$args['tax_query'] = [
					[
						'taxonomy' => 'press-cat',
						'field'    => 'term_id',
						'terms'    => $term_id,
					]
				];
				
				$results = query_posts($args);
				#Functions::_debug($results);
				if($results){
					$company_logo_id = get_term_meta($term_id, 'company_logo', true);
					$company_logo = Functions::get_the_attachment_thumbnail($company_logo_id, 'full', [], false);
					$output .= Functions::get_template_part(SHORTCODES_PATH.'/press-post', ['items' => $results, 'company_logo' => $company_logo], false);
				}
				wp_reset_query();
			}
		}else{
			$results = query_posts($args);
			if($results){
				$output = Functions::get_template_part(SHORTCODES_PATH.'/press-post', ['items' => $results, 'company_logo' => false], false);
			}
			wp_reset_query();
		}
		
		return $output;
	}
	
	public function get_testimonials_posts($attr){
		$output = '';
		
		$args = [
			'posts_per_page' => isset($attr['count']) ? $attr['count'] : 3,
			'include_custom_fields' => true,
		];
		
		$results = DataSource::get_testimonial_posts($args);

		if($results->found_posts){
			$output = Functions::get_template_part(SHORTCODES_PATH.'/testimonial-post', ['items' => $results->posts], false);
		}
		
		return $output;
	}
	
	public function job_title_logo($attr){
		$output = '';
		
		$attr = wp_parse_args($attr, [
			'class' => ''
		]);
		
		$site_logo = get_field('single_job_main_title_logo', 'option');
		
		if(!empty($site_logo)){
			$output = Functions::get_the_thumbnail($site_logo, 'full', ['alt' => '', 'class' => $attr['class']], true, false, true);
		}
		
		return $output;
	}
	
	public function insert_button($attr){
		$attr = wp_parse_args($attr, [
			'url' => '#',
			'class' => 'btn btn-secondary',
			'label' => 'Book a Demo'
		]);
		
		$output = '<a class="'.$attr['class'].'" href="'.$attr['url'].'">'.$attr['label'].'</a>';
		
		return $output;
	}
	
	public function insert_link($attr){
		$output = [];
		
		$attr = wp_parse_args($attr, [
			'url' => '#',
			'wrap_class' => 'text-center text-md-left mb-2 mb-md-3',
			'class' => 'text-white',
			'label' => ''
		]);
		
		$output[] = '<div class="'.$attr['wrap_class'].'">';
		$output[] = '<a class="'.$attr['class'].'" href="'.$attr['url'].'">'.$attr['label'].'</a>';
		$output[] = '</div>';
		
		return implode('', $output);
	}
	
	public function insert_page_link($attr){
		$output = [];
		
		$attr = wp_parse_args($attr, [
			'id' => 0,
			'class' => 'text-white',
			'wrap_class' => '',
		]);
		
		if(intval($attr['id']) > 0){
			$page_title = DataSource::get_var("SELECT post_title FROM prefix_posts WHERE ID = ".$attr['id']);
			$page_link  = get_permalink($attr['id']);
			
			if(!empty($attr['wrap_class'])){
				$output[] = '<div class="'.$attr['wrap_class'].'">';
			}
			
			$output[] = '<a class="'.$attr['class'].'" href="'.$page_link.'">'.$page_title.'</a>';
			
			if(!empty($attr['wrap_class'])){
				$output[] = '</div>';
			}
		}
		
		return implode('', $output);
	}
	
	public function insert_image($attr){
		$attr = wp_parse_args($attr, [
			'url' => 'images/mobile-footer-logo.svg',
			'wrap_class' => '',
			'image_class' => '',
			'width' => '',
			'height' => '',
		]);
		
		if(!empty($attr['wrap_class'])){
			$output = '<div class="'.$attr['wrap_class'].'"><img class="'.$attr['image_class'].'" src="'.$attr['url'].'" alt="" title="" width="'.$attr['width'].'" height="'.$attr['height'].'"></div>';
		}else{
			$output = '<img class="'.$attr['image_class'].'" src="'.$attr['url'].'" alt="" title="" width="'.$attr['width'].'" height="'.$attr['height'].'">';
		}
		
		return $output;
	}
	
	public function insert_copyright($attr){
		$attr = wp_parse_args($attr, [
			'text' => '',
			'wrap_class' => '',
		]);
		
		if(empty($attr['text'])){
			$a = explode('.', $_SERVER['HTTP_HOST']);
			$attr['text'] = '&copy; '.$a[0].' '.date('Y').' All Rights Reserved';
		}
		
		$output = '<span class="'.$attr['wrap_class'].'">'.$attr['text'].'</span>';
		
		return $output;
	}
	
	public function insert_copyright_and_page_links($attr){
		$output = [];
		
		$attr = wp_parse_args($attr, [
			'ids' => '',
			'text' => '',
			'class' => 'text-white',
			'wrap_class' => '',
		]);
		
		if(!empty($attr['wrap_class'])){
			$output[] = '<div class="'.$attr['wrap_class'].'">';
		}
		
		if(empty($attr['text'])){
			$a = explode('.', $_SERVER['HTTP_HOST']);
			$host = $a[0] == 'www' ? $a[1] : $a[0];
			$attr['text'] = '&copy; '.$host.' '.date('Y').' All Rights Reserved';
		}
		
		$output[] = '<span>'.$attr['text'].'</span>';
		
		if(!empty($attr['ids'])){
			foreach(explode(',', $attr['ids']) as $id){
				$page_title = DataSource::get_var("SELECT post_title FROM prefix_posts WHERE ID = ".$id);
				$page_link  = get_permalink($id);
				
				$output[] = '<div class="border-left border-white pt-5 d-inline-block mx-1"></div>';
				$output[] = '<a class="'.$attr['class'].'" href="'.$page_link.'">'.$page_title.'</a>';
			}
		}
		
		if(!empty($attr['wrap_class'])){
			$output[] = '</div>';
		}
		
		return implode('', $output);
	}
	
	
}
