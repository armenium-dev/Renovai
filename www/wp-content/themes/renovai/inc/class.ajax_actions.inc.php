<?php
namespace Digidez;

class Ajax_Actions{

	public static function initialise(){
		$self = new self();

		add_action('wp_ajax_load_countries_list', [$self, 'load_countries_list']);
		add_action('wp_ajax_nopriv_load_countries_list', [$self, 'load_countries_list']);

		add_action('wp_ajax_load_more_news', [$self, 'load_more_news']);
		add_action('wp_ajax_nopriv_load_more_news', [$self, 'load_more_news']);

		add_action('wp_ajax_load_more_posts', [$self, 'load_more_posts']);
		add_action('wp_ajax_nopriv_load_more_posts', [$self, 'load_more_posts']);

	}

	public function load_countries_list(){
		$return = ['error' => 0, 'message' => esc_attr__('Data received successfully', THEME_TD), 'result' => ''];
		
		$results = DataSource::get_results("SELECT nicename, phonecode FROM prefix_country ORDER BY nicename ASC");
		
		if($results){
			$a = [];
			$p = '<option value="%s" %s>%s</option>';
			$a[] = sprintf($p, '', 'disabled', 'Country');
			
			foreach($results as $result)
				$a[] = sprintf($p, $result->phonecode, '', $result->nicename);
				
			$return['result'] = implode('', $a);
		}
		
		
		die(json_encode($return));
	}

	public function load_more_news(){
		$return = ['error' => 0, 'message' => esc_attr__('Data received successfully', THEME_TD), 'result' => '', 'offset' => 0];

		$offset = $_REQUEST['offset'];
		$parent_post_id = $_REQUEST['parent_post_id'];

		$parent_post_cf = DataSource::get_cpt_custom_fields($parent_post_id)['section_news'];
		#Helper::_debug($parent_post_cf);

		$order = explode('-', $parent_post_cf['order']);
		$posts = DataSource::get_news_posts([
			'include_custom_fields' => true,
			'remove_post_content' => true,
			'posts_per_page' => $parent_post_cf['posts_per_page'],
			'orderby' => $order[0].($order[0] == 'menu_order' ? ' post_date' : ''),
			'order' => strtoupper($order[1]),
			'offset' => $offset,
		]);
		
		#Helper::_debug($posts->posts);

		$return['found_posts'] = count($posts->posts);

		if(count($posts->posts)){
			$a = [];
			foreach($posts->posts as $k => $_post){
				$a[] = Functions::get_template_part(PARTIALS_PATH.'/news/item', ['_post' => $_post], false);
			}
			$return['result'] = implode('', $a);
		}

		$return['offset'] = $offset + count($posts->posts);

		die(json_encode($return));
	}

	public function load_more_posts(){
		$return = ['error' => 0, 'message' => esc_attr__('Data received successfully', THEME_TD), 'result' => '', 'offset' => 0];

		$offset = $_REQUEST['offset'];
		$parent_post_id = $_REQUEST['parent_post_id'];

		$parent_post_cf = DataSource::get_cpt_custom_fields($parent_post_id)['section_blog_content'];
		#Helper::_debug($parent_post_cf);
		$subtitle_length = get_field('blog_subtitle_length', 'option');
		$excerpt_length = get_field('blog_excerpt_length', 'option');

		$order = explode('-', $parent_post_cf['order']);
		$posts = DataSource::get_blog_posts([
			'include_custom_fields' => true,
			'include_author_data' => true,
			'remove_post_content' => true,
			'posts_per_page' => $parent_post_cf['posts_per_page'],
			'orderby' => $order[0],
			'order' => strtoupper($order[1]),
			'offset' => $offset,
		]);
		
		#Helper::_debug($posts->posts);

		$return['found_posts'] = count($posts->posts);

		if(count($posts->posts)){
			$a = [];
			foreach($posts->posts as $k => $_post){
				$a[] = Functions::get_template_part(PARTIALS_PATH.'/blog/item', [
					'_post' => $_post,
					'subtitle_length' => $subtitle_length,
					'excerpt_length' => $excerpt_length
				], false);
			}
			$return['result'] = implode('', $a);
		}

		$return['offset'] = $offset + count($posts->posts);

		die(json_encode($return));
	}


	
}
