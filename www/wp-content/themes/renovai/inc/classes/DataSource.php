<?php
namespace Digidez;

use WP_Query;

class DataSource{

	public static $table_custom_name = "prefix_custom_name";
	public static $table_custom_name_cols = [
		'id' => 'ID',
		//....
		'created_at' => 'Created at',
		'updated_at' => 'Updated at',
	];

	public static function initialise(){}

	public static function insert_data($post_data){
		global $wpdb;

		//CFM_Helper::log('[function '.__FUNCTION__.'] is called');

		$id = 0;

		if(!empty($post_data) && isset($post_data['table'])){

			$db_table = str_replace('prefix_', $wpdb->prefix, $post_data['table']);
			unset($post_data['table'], $post_data['primary']);

			if($wpdb->insert($db_table, $post_data)){
				$id = $wpdb->insert_id;
			}

			unset($db_table, $post_data);
			//CFM_Helper::log('[function '.__FUNCTION__.']: posts updated');
		}

		return $id;
	}

	public static function delete_data($post_data){
		global $wpdb;
		$ret = false;

		if(!empty($post_data) && isset($post_data['table'])){
			$db_table = $post_data['table'];
			$db_table = str_replace('prefix_', $wpdb->prefix, $db_table);
			unset($post_data['table'], $post_data['primary']);

			$where = isset($post_data['where']) ? $post_data['where'] : [];

			$ret = $wpdb->delete($db_table, $where);

			unset($db_table, $post_data);
		}

		return $ret;
	}

	public static function update_data($post_data){
		global $wpdb;

		#WCPL_Helper::log('[function '.__FUNCTION__.'] is called');

		$id = 0;

		if(!empty($post_data) && isset($post_data['table'])){

			$value = $post_data['primary']['value'];
			$name = $post_data['primary']['name'];
			$db_table = $post_data['table'];
			$db_table = str_replace('prefix_', $wpdb->prefix, $db_table);
			unset($post_data['table'], $post_data['primary']);

			$wpdb->update($db_table, $post_data, [$name => $value]);

			unset($db_table, $post_data);
			#WCPL_Helper::log('[function '.__FUNCTION__.']: posts updated');
		}

		return $id;
	}

	public static function query($sql){
		global $wpdb;
		$sql = str_replace('prefix_', $wpdb->prefix, $sql);
		return $wpdb->query($sql);
	}

	public static function get_var($sql){
		global $wpdb;

		$sql = str_replace('prefix_', $wpdb->prefix, $sql);

		return $wpdb->get_var($sql);
	}

	public static function get_row($sql, $output = OBJECT){
		global $wpdb;

		$sql = str_replace('prefix_', $wpdb->prefix, $sql);

		return $wpdb->get_row($sql, $output);
	}

	public static function get_col($sql){
		global $wpdb;

		$sql = str_replace('prefix_', $wpdb->prefix, $sql);

		return $wpdb->get_col($sql);
	}

	public static function get_results($sql, $output = OBJECT){
		global $wpdb;

		$sql = str_replace('prefix_', $wpdb->prefix, $sql);

		return $wpdb->get_results($sql, $output);
	}

	public static function get_found_rows(){
		return self::get_var("SELECT FOUND_ROWS()");
	}

	public static function db_input($string){
		global $wpdb;
		return $wpdb->_real_escape($string);
	}
	
	/** CPTs **/
	
	public static function get_cpt_custom_fields($post){
		$cf = [];
		
		if(is_object($post)){
			$cpt = $post->post_type;
			$cf = get_fields($post->ID);
		}elseif(is_numeric($post)){
			$cpt = '';
			$cf = get_fields($post);
		}
		
		switch($cpt){
			case "event":
				$terms = wp_get_post_terms($post->ID, 'event-cat', array('fields' => 'id=>name'));
				$d = strtotime($cf['event_datetime']);
				$cf['day_month'] = date('jS F', $d);
				$cf['weekday'] = date('l', $d);
				$cf['time'] = date('H:i', $d);
				$cf['year'] = date('Y', $d);
				$cf['weekday_time_cat'] = date('l | G:i', $d).'<br>'.current($terms);
				$cf['categories'] = implode(', ', $terms);
				break;
			case "faq":
				$terms = wp_get_post_terms($post->ID, 'faq-cat', array('fields' => 'id=>name'));
				$cf['categories'] = implode(', ', $terms);
				break;
			default:
				break;
		}
		return $cf;
	}
	
	public static function get_blog_posts($params = []){
		$args = wp_parse_args($params, [
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'offset' => 0,
			'orderby' => 'post_date',
			'order' => 'DESC',
		]);
		#Helper::_debug($args);
		if(isset($params['terms'])){
			$args['tax_query'] = [[
				'taxonomy' => 'category',
				'field' => 'term_id',
				'terms' => $params['terms'],
			]];
		}
		
		if(isset($params['tags'])){
			$args['tax_query'] = [[
				'taxonomy' => 'post_tag',
				'field' => 'term_id',
				'terms' => $params['tags'],
			]];
		}

		$_posts = new WP_Query($args);
		#Helper::_debug($_posts->posts);
		
		if($_posts->found_posts > 0){
			foreach($_posts->posts as $k => $_post){
				if(isset($params['include_term_by_tax']) && !empty($params['include_term_by_tax'])){
					$_posts->posts[$k]->terms = self::get_cpt_cats($params['include_term_by_tax'], $_post, 'all');
				}
				if(true == $params['include_custom_fields']){
					$_posts->posts[$k]->cf = self::get_cpt_custom_fields($_post);
					$_posts->posts[$k]->cf['post_read_time'] = Functions::calc_post_read_time($_post);
				}
				if($params['remove_post_content']){
					$_posts->posts[$k]->post_content = '';
				}
				if($params['include_author_data']){
					$_posts->posts[$k]->post_author = self::get_author_data($_posts->posts[$k]->post_author);
				}
			}
			
			if(isset($params['sort_posts_by_cats']) && $params['sort_posts_by_cats']){
				$_posts = Functions::sort_posts_by_cats($_posts);
			}
		}
		
		return $_posts;
	}
	
	public static function get_related_blog_posts($current_post_id, $include_custom_fields = false, $only_featured = false, $by_cat = true){
		if($by_cat){
			$terms = wp_get_post_terms($current_post_id, 'category', array('fields' => 'id=>name'));
			#Functions::_debug($terms);
		}
		
		$args = array(
			'paged'          => 1,
			'posts_per_page' => 7,
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'orderby'        => 'ID',
			'order'          => 'DESC',
			'post__not_in'   => array($current_post_id),
		);
		
		if($only_featured){
			$args['meta_key'] = 'featured_post';
			$args['meta_value'] = '1';
		}else{
			if($by_cat){
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => array_keys($terms),
					)
				);
			}
		}
		
		
		
		$_posts = new WP_Query($args);
		#Functions::_debug($_posts->found_posts);
		
		if($_posts->found_posts == 0){
			$_posts = self::get_related_blog_posts($current_post_id, $include_custom_fields, $only_featured, false);
		}
		
		if($include_custom_fields){
			foreach($_posts->posts as $k => $_post){
				$_posts->posts[$k]->cf = Functions::get_cpt_custom_fields($_post);
			}
		}
		
		return $_posts;
	}
	
	public static function get_latest_post($args = [], $include_custom_fields = false){
		$defaults = array(
			'paged'          => 1,
			'posts_per_page' => 1,
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'orderby'        => 'date',
			'order'          => 'DESC',
		);
		
		$args = wp_parse_args($args, $defaults);
		$result = new WP_Query($args);
		
		#self::_debug($result);
		
		if($result->found_posts){
			if($include_custom_fields){
				if($args['posts_per_page'] == 1){
					$result->post->cf = self::get_cpt_custom_fields($result->post);
				}else{
					foreach($result->posts as $k => $_post){
						$result->posts[$k]->cf = self::get_cpt_custom_fields($_post);
					}
				}
			}
		}
		
		return $result;
	}
	
	public static function get_blog_items($params = []){
		#self::_debug($params);
		$args = array(
			'post_type'         => 'post',
			'post_status'       => 'publish',
			'posts_per_page'    => isset($params['count']) ? $params['count'] : 5,
			'offset'            => isset($params['offset']) ? $params['offset'] : 0,
		);
		
		if(!isset($params['include_custom_fields'])){
			$params['include_custom_fields'] = false;
		}
		
		if(!isset($params['remove_post_content'])){
			$params['remove_post_content'] = false;
		}
		
		if(isset($params['ordering'])){
			$standart_order_fields = array('ID', 'title', 'date', 'menu_order');
			foreach($params['ordering'] as $order){
				if(in_array($order['order_by'], $standart_order_fields)){
					$args['orderby'][$order['order_by']] = $order['order'];
				}else{
					$args['meta_key'] = $order['order_by'];
					$args['orderby']['meta_value'] = $order['order'];
				}
			}
		}
		
		
		if(!empty($params['terms'])){
			$tax_query = [];
			foreach($params['terms'] as $taxonomy => $term_id){
				if(intval($term_id) > 0){
					$tax_query[] = array(
						'taxonomy'         => $taxonomy,
						'field'            => 'term_id',
						'terms'            => $term_id,
						'include_children' => 0,
					);
				}
			}
			
			if(!empty($tax_query)){
				$args['tax_query']             = $tax_query;
				if(isset($params['terms_relation']) && !empty($params['terms_relation'])){
					$args['tax_query']['relation'] = $params['terms_relation'];
				}else{
					$args['tax_query']['relation'] = 'AND';
				}
			}
		}
		#self::_debug($args);
		
		$_posts = new WP_Query($args);
		#self::_debug($_posts);
		
		if($_posts->found_posts > 0){
			foreach($_posts->posts as $k => $_post){
				if(isset($params['include_term_by_tax']) && !empty($params['include_term_by_tax'])){
					$_posts->posts[$k]->terms = self::get_cpt_cats($params['include_term_by_tax'], $_post, 'all');
				}
				if(true == $params['include_custom_fields']){
					$_posts->posts[$k]->cf = self::get_cpt_custom_fields($_post);
				}
				if($params['remove_post_content']){
					$_posts->posts[$k]->post_content = '';
				}
			}
		}
		
		#self::_debug($_posts->request);
		return $_posts;
	}
	
	public static function get_jobs_form_items(){
		return [
			['title' => 'Locations', 'shortcode' => '[matador_taxonomy tax=location as=list method=filter show_all_option=before_if]'],
			['title' => 'Categories', 'shortcode' => '[matador_taxonomy tax=category as=list method=filter show_all_option=before_if]'],
			['title' => 'Contract Types', 'shortcode' => '[matador_taxonomy tax=type as=list method=filter show_all_option=before_if]'],
			['title' => 'Industry', 'shortcode' => '[matador_taxonomy tax=industries as=list method=filter show_all_option=before_if]'],
		];
	}
	
	public static function fill_cpt_cf($posts){
		if(!empty($posts)){
			foreach($posts as $k => $post){
				$posts[$k]->cf = self::get_cpt_custom_fields($post);
			}
		}
		
		return $posts;
	}
	
	public static function get_testimonial_posts($params = []){
		#self::_debug($params);
		$args = array(
			'post_type'         => 'testimonial',
			'post_status'       => 'publish',
			'posts_per_page'    => isset($params['posts_per_page']) ? $params['posts_per_page'] : 5,
			'offset'            => isset($params['offset']) ? $params['offset'] : 0,
			'orderby' => isset($params['orderby']) ? $params['orderby'] : 'post_date',
			'order' => isset($params['order']) ? $params['order'] : 'ASC',
		);
		
		if(!isset($params['include_custom_fields'])){
			$params['include_custom_fields'] = false;
		}
		
		if(!isset($params['remove_post_content'])){
			$params['remove_post_content'] = false;
		}
		
		if(!empty($params['terms'])){
			$tax_query = [];
			foreach($params['terms'] as $taxonomy => $term_id){
				if(intval($term_id) > 0){
					$tax_query[] = array(
						'taxonomy'         => $taxonomy,
						'field'            => 'term_id',
						'terms'            => $term_id,
						'include_children' => 0,
					);
				}
			}
			
			if(!empty($tax_query)){
				$args['tax_query']             = $tax_query;
				if(isset($params['terms_relation']) && !empty($params['terms_relation'])){
					$args['tax_query']['relation'] = $params['terms_relation'];
				}else{
					$args['tax_query']['relation'] = 'AND';
				}
			}
		}
		#self::_debug($args);
		
		$_posts = new WP_Query($args);
		#self::_debug($_posts);
		
		if($_posts->found_posts > 0){
			foreach($_posts->posts as $k => $_post){
				if(isset($params['include_term_by_tax']) && !empty($params['include_term_by_tax'])){
					$_posts->posts[$k]->terms = self::get_cpt_cats($params['include_term_by_tax'], $_post, 'all');
				}
				if(true == $params['include_custom_fields']){
					$_posts->posts[$k]->cf = self::get_cpt_custom_fields($_post);
				}
				if($params['remove_post_content']){
					$_posts->posts[$k]->post_content = '';
				}
			}
		}
		
		#self::_debug($_posts->request);
		return $_posts;
	}
	
	public static function get_job_posts($params = []){
		$args = wp_parse_args($params, [
			'post_type' => 'job',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'offset' => 0,
			'orderby' => 'post_date',
			'order' => 'DESC',
		]);
		
		if(isset($params['terms'])){
			$args['tax_query'] = [
				[
					'taxonomy' => 'job-cat',
					'field' => 'term_id',
					'terms' => $params['terms'],
				]
			];
		}
		
		$_posts = new WP_Query($args);
		
		if($_posts->found_posts > 0){
			foreach($_posts->posts as $k => $_post){
				if(isset($params['include_term_by_tax']) && !empty($params['include_term_by_tax'])){
					$_posts->posts[$k]->terms = self::get_cpt_cats($params['include_term_by_tax'], $_post, 'all');
				}
				if(true == $params['include_custom_fields']){
					$_posts->posts[$k]->cf = self::get_cpt_custom_fields($_post);
				}
				if($params['remove_post_content']){
					$_posts->posts[$k]->post_content = '';
				}
			}
			
			if(isset($params['sort_posts_by_cats']) && $params['sort_posts_by_cats']){
				$_posts = Functions::sort_posts_by_cats($_posts);
			}
		}
		
		return $_posts;
	}
	
	public static function get_case_studies_posts($params = []){
		$args = wp_parse_args($params, [
			'post_type' => 'case-studies',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'offset' => 0,
			'orderby' => 'post_date',
			'order' => 'DESC',
		]);
		
		if(isset($params['terms'])){
			$args['tax_query'] = [
				[
					'taxonomy' => 'case-studies-cat',
					'field' => 'term_id',
					'terms' => $params['terms'],
				]
			];
		}
		
		$_posts = new WP_Query($args);
		
		if($_posts->found_posts > 0){
			foreach($_posts->posts as $k => $_post){
				if(isset($params['include_term_by_tax']) && !empty($params['include_term_by_tax'])){
					$_posts->posts[$k]->terms = self::get_cpt_cats($params['include_term_by_tax'], $_post, 'all');
				}
				if(true == $params['include_custom_fields']){
					$_posts->posts[$k]->cf = self::get_cpt_custom_fields($_post);
				}
				if($params['remove_post_content']){
					$_posts->posts[$k]->post_content = '';
				}
			}
			
			if(isset($params['sort_posts_by_cats']) && $params['sort_posts_by_cats']){
				$_posts = Functions::sort_posts_by_cats($_posts);
			}
		}
		
		return $_posts;
	}
	
	public static function get_news_posts($params = []){
		$args = wp_parse_args($params, [
			'post_type' => 'news',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'offset' => 0,
			'orderby' => 'post_date',
			'order' => 'DESC',
		]);
		#Helper::_debug($args);
		if(isset($params['terms'])){
			$args['tax_query'] = [[
				'taxonomy' => 'case-studies-cat',
				'field' => 'term_id',
				'terms' => $params['terms'],
			]];
		}
		
		$_posts = new WP_Query($args);
		
		if($_posts->found_posts > 0){
			foreach($_posts->posts as $k => $_post){
				if(isset($params['include_term_by_tax']) && !empty($params['include_term_by_tax'])){
					$_posts->posts[$k]->terms = self::get_cpt_cats($params['include_term_by_tax'], $_post, 'all');
				}
				if(true == $params['include_custom_fields']){
					$_posts->posts[$k]->cf = self::get_cpt_custom_fields($_post);
				}
				if($params['remove_post_content']){
					$_posts->posts[$k]->post_content = '';
				}
			}
			
			if(isset($params['sort_posts_by_cats']) && $params['sort_posts_by_cats']){
				$_posts = Functions::sort_posts_by_cats($_posts);
			}
		}
		
		return $_posts;
	}
	
	public static function get_related_pages($exclude_id = 0, $parnet_id = 0, $short = true){
		global $wpdb;
		
		$fields = $short ? "ID, post_title" : "*";
		$_sql = "SELECT {$fields} FROM {$wpdb->posts} WHERE ID != {$exclude_id} AND post_parent = {$parnet_id} AND post_type = 'page' AND post_status = 'publish' AND post_title != ''";
		$result = $wpdb->get_results($_sql);
		//\Digidez\Functions::_debug($result);
		
		return $result;
	}
	
	public static function get_post_type_related_posts($post_id, $number_posts = 6, $post_type = 'post', $taxonomy = 'category'){
		
		if( 0 == $number_posts ) {
			return false;
		}
		
		$item_array = [];
		$item_cats = get_the_terms( $post_id, $taxonomy );
		if ( $item_cats ) {
			foreach( $item_cats as $item_cat ) {
				$item_array[] = $item_cat->term_id;
			}
		}
		
		if( empty( $item_array ) ) {
			return false;
		}
		
		$args = array(
			'post_type'				=> $post_type,
			'posts_per_page'		=> $number_posts,
			'post__not_in'			=> array( $post_id ),
			'ignore_sticky_posts'	=> 0,
			'tax_query'				=> array(
				array(
					'field'		=> 'id',
					'taxonomy'	=> $taxonomy,
					'terms'		=> $item_array
				)
			)
		);
		
		return new WP_Query( $args );
	}
	
	public static function get_parent_pageID_by_term($post_terms){
		$terms_ids = [];
		foreach($post_terms as $term){
			$terms_ids[] = $term->term_id;
		}
		
		$args   = array(
			'posts_per_page' => -1,
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'orderby'        => 'ID',
			'order'          => 'ASC',
			'meta_query'     => array(
				array(
					'key'     => 'events_section_category',
					'value'   => $terms_ids,
					'compare' => 'IN',
				)
			)
		);
		$_posts = get_posts($args);
		//Functions::_debug($_posts);
		$pID = 0;
		if(!empty($_posts)){
			foreach($_posts as $_post){
				if($_post->post_name == 'events' && $_post->post_parent > 0){
					$pID = $_post->post_parent;
				}
			}
		}
		
		return $pID;
	}
	
	public static function get_posts_by_term($term, array $args){
		
		$defaults = array(
			'posts_per_page' => -1,
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'orderby'        => 'ID',
			'order'          => 'ASC',
			'tax_query'     => array(
				array(
					'taxonomy'         => $term->taxonomy,
					'field'            => 'term_id',
					'terms'            => intval($term->term_id),
					'include_children' => 0,
				)
			)
		);
		
		$include_custom_fields = isset($args['include_custom_fields']) ? $args['include_custom_fields'] : false;
		unset($args['include_custom_fields']);
		
		$args = wp_parse_args($args, $defaults);
		
		$_posts = new WP_Query($args);
		
		if($_posts->found_posts > 0){
			foreach($_posts->posts as $k => $_post){
				if($include_custom_fields){
					$_posts->posts[$k]->cf = self::get_cpt_custom_fields($_post);
				}
			}
		}else{
			return false;
		}
		
		return $_posts;
	}
	
	public static function get_posts_by_terms($taxonomy, $term_ids, array $args){
		
		$defaults = array(
			'posts_per_page' => -1,
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'orderby'        => 'ID',
			'order'          => 'ASC',
			'tax_query'     => array(
				array(
					'taxonomy'         => $taxonomy,
					'field'            => 'term_id',
					'terms'            => $term_ids,
					'include_children' => 0,
				)
			)
		);
		
		$include_custom_fields = isset($args['include_custom_fields']) ? $args['include_custom_fields'] : false;
		unset($args['include_custom_fields']);
		
		$args = wp_parse_args($args, $defaults);
		
		$_posts = new WP_Query($args);
		
		if($_posts->found_posts > 0){
			foreach($_posts->posts as $k => $_post){
				if($include_custom_fields){
					$_posts->posts[$k]->cf = self::get_cpt_custom_fields($_post);
				}
			}
		}else{
			return false;
		}
		
		return $_posts;
	}
	
	public static function get_page_by_term($term, $post_type = 'page'){
		
		$args   = array(
			'posts_per_page' => 1,
			'post_type'      => $post_type,
			'post_status'    => 'publish',
			'orderby'        => 'ID',
			'order'          => 'ASC',
			'tax_query'     => array(
				array(
					'taxonomy'         => $term->taxonomy,
					'field'            => 'term_id',
					'terms'            => intval($term->term_id),
					'include_children' => 0,
				)
			)
		);
		$_posts = new WP_Query($args);
		#self::_debug($_posts->found_posts);
		
		//return $_posts->found_posts;
		//return json_encode($_posts->posts);
		return $_posts->found_posts ? $_posts->posts[0] : false;
	}
	
	public static function get_post_type_list(){
		$postTypes         = get_post_types(array(
			'public' => true
		), 'objects');
		$postTypesList     = [];
		$excludedPostTypes = array(
			'revision',
			'nav_menu_item',
			'rella-footer',
			'rella-header',
			'rella-mega-menu',
			'wpcf7_contact_form',
			'vc_grid_item',
			'oxy_modal',
			'oxy_portfolio_image',
			'oxy_testimonial',
			'oxy_service',
		);
		#\Digidez\Functions::_debug($postTypes);
		
		if(is_array($postTypes) && !empty($postTypes)){
			foreach($postTypes as $postType => $obj){
				if(!in_array($postType, $excludedPostTypes)){
					$postTypesList[$postType] = $obj->label;
				}
			}
		}
		/*$postTypesList[] = array(
			'custom',
			esc_html__('Custom query', 'infinite-addons'),
		);
		$postTypesList[] = array(
			'ids',
			esc_html__('List of IDs', 'infinite-addons'),
		);*/
		
		return $postTypesList;
	}
	
	public static function get_post_types() {
		$post_types_list = [];
		$post_types = get_post_types( array(
			'public' => true
		) );
		if ( $post_types ) {
			foreach ( $post_types as $post_type ) {
				if ( 'revision' != $post_type && 'nav_menu_item' != $post_type && 'attachment' != $post_type ) {
					$post_types_list[$post_type] = $post_type;
				}
			}
		}
		return $post_types_list;
	}
	
	public static function get_user_custom_fields($user_id){
		return get_fields($user_id, 'user_form');
	}
	
	public static function sort_terms_hierarchicaly(array $cats, $parentId = 0){
		$into = [];
		foreach($cats as $i => $cat){
			if($cat->parent == $parentId){
				$cat->children = self::sort_terms_hierarchicaly($cats, $cat->term_id);
				$into[$cat->term_id] = $cat;
			}
		}
		
		return $into;
	}
	
	public static function get_cpt_terms($taxonomy, $args = [], $custom_sort_by_ids = false, $include_custom_fields = false){
		
		$defaults = [
			'taxonomy' => $taxonomy,
			'fields' => 'all',
			'hide_empty' => false
		];
		
		$queried_category = get_term_by('id', get_query_var($taxonomy), $taxonomy);
		
		$args = wp_parse_args($args, $defaults);
		#self::_debug($queried_category);
		
		$terms = get_terms($args);
		#self::_debug($terms);
		
		if(!empty($terms)){
			if(strstr($args['fields'], 'id=>') === false){
				foreach($terms as $k => $term){
					$terms[$k]->active       = 0;
					$terms[$k]->active_class = '';
					$terms[$k]->selected     = '';
					if(!empty($queried_category) && $queried_category->term_id == $term->term_id){
						$terms[$k]->active       = 1;
						$terms[$k]->active_class = 'active';
						$terms[$k]->selected     = 'selected="selected"';
					}
					if($include_custom_fields){
						$terms[$k]->cf = get_fields($term);
					}
				}
			}
		}
		
		if($custom_sort_by_ids){
		
		}
		
		if(isset($args['hierarchical']) && $args['hierarchical'] == true){
			$terms = self::sort_terms_hierarchicaly($terms);
		}
		
		return $terms;
	}
	
	public static function get_cpt_cats($tax, $post, $fields = 'id=>name'){
		//$tax = $post->post_type.'-cat';
		$terms = wp_get_post_terms($post->ID, array($tax), array('fields' => $fields));
		
		return $terms;
	}
	
	public static function get_post_terms($post){
		$taxonomies = self::get_all_taxonomies(false);
		#self::_debug($taxonomies);
		$post_terms = wp_get_post_terms($post->ID, array_keys($taxonomies));
		
		return $post_terms;
	}
	
	public static function get_page_id_by_template_name($template_path){
		/*$pages = get_pages([
			'meta_key' => '_wp_page_template',
			'meta_value' => $template_path
		]);*/
		
		$page_id = self::get_var("SELECT post_id FROM prefix_postmeta WHERE meta_key = '_wp_page_template' AND meta_value = '".$template_path."' ORDER BY post_id ASC LIMIT 1");
		
		return $page_id;
	}
	
	public static function get_page_template(){
		global $post;
		
		$template_name = '';
		
		if(!is_null($post)){
			$_wp_page_template = get_post_meta($post->ID, '_wp_page_template', true);
			
			if(!empty($_wp_page_template)){
				$a = explode('/', $_wp_page_template);
				$template_name = str_replace('.php', '', end($a));
			}
		}
		
		return $template_name;
	}
	
	public static function get_all_taxonomies($display_null_value = true, $null_value = ''){
		$ret = [];
		
		if($display_null_value){
			if(empty($null_value)){
				$null_value = esc_html__('- Autodetect -', THEME_TD);
			}
			$ret[0] = $null_value;
		}
		
		$exclude = array('vc_snippet_cat', 'staff_tag');
		
		$args = array(
			'public'   => true,
			'_builtin' => false
		);
		
		$taxonomies = get_taxonomies($args, 'objects', 'and');
		
		foreach($taxonomies as $taxonomy){
			if(!in_array($taxonomy->name, $exclude)){
				$ret[$taxonomy->name] = $taxonomy->label;
			}
		}
		
		return $ret;
	}
	
	public static function get_post_names($post_ids){
		global $wpdb;
		
		$results = $wpdb->get_col("SELECT post_name FROM $wpdb->posts WHERE ID IN(".implode(',', $post_ids).")");
		
		$results = array_unique($results);
		
		return $results;
	}
	
	public static function get_author_link($args = []){
		global $authordata;
		
		if(!is_object($authordata)){
			return;
		}
		
		$before = $after = '';
		
		$defaults = array(
			'before' => '<i class="fa fa-user"></i> ',
			'after' => ''
		);
		extract(wp_parse_args($args, $defaults));
		
		$link = sprintf(
			'<a class="url fn" href="%1$s" title="%2$s" rel="author">%3$s</a>',
			esc_url(get_author_posts_url($authordata->ID, $authordata->user_nicename)),
			esc_attr(sprintf(esc_html__('Posts by %s', 'boo'), get_the_author())),
			$before.get_the_author().$after
		);
		return $link;
	}
	
	public static function get_author_data($author_id = 0, $post = null){
		global $authordata;
		
		if($author_id == 0){
			if($authordata){
				$author_id = $authordata->ID;
			}else{
				$author_id = get_the_author_meta('ID');
			}
		}
		#Helper::_debug($author_id);
		
		//$user_position = get_the_author_meta('user_position');
		//$user_avatar_id = get_the_author_meta('user_avatar');
		$user_position = get_field('user_position', 'user_'.$author_id);
		$user_avatar_id = get_field('user_avatar', 'user_'.$author_id);
		$user_social_links = get_field('user_social_links', 'user_'.$author_id);
		$user_linked_in_profile_link = get_field('user_linked_in_profile_link', 'user_'.$author_id);

		if(!empty($user_social_links)){
			foreach($user_social_links as $k => $v){
				if(empty($v['icon'])){
					switch($v['service']){
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
							break;
					}
					$user_social_links[$k]['icon'] = '<i class="i '.$class.' i-reverse i-social"></i>';
				}else{
					$user_social_links[$k]['icon'] = '<img src="'.$v['icon'].'" />';
				}
			}
		}
		
		#Helper::_debug($user_social_links);


		$user = get_user_by('ID', $author_id);
		$user_description = get_user_meta($author_id, 'description', true);
		$user_name = $user->display_name;
		
		
		if($user_avatar_id){
			$avatar_src = Functions::get_the_attachment_thumbnail($user_avatar_id, '70x70', [], false);
			if(strstr($avatar_src, site_url()) !== false){
				$avatar_src = str_replace(site_url(), '', $avatar_src);
			}
			#Helper::_debug(site_url());
		}else{
			$avatar_src = get_avatar_url($author_id);
			if(strstr($avatar_src, 'gravatar') !== false){
				$avatar_src = get_field('user_default_avatar', 'option');
			}
		}
		
		return [
			'avatar_src' => $avatar_src,
			'name' => $user_name,
			'position' => $user_position,
			'user_linked_in_profile_link' => $user_linked_in_profile_link,
			'social_links' => $user_social_links,
			'description' => $user_description
		];
	}

	public static function get_tag_cloud($args = []){
		$defaults = [
			'post_id' => 0,
			'smallest' => 8,
			'largest' => 22,
			'unit' => 'pt',
			'number' => 45,
			'format' => 'flat',
			'separator' => "\n",
			'orderby' => 'count',
			'order' => 'DESC',
			'exclude' => '',
			'include' => '',
			'link' => 'view',
			'taxonomy' => 'post_tag',
			'post_type' => '',
			'echo' => false,
			'show_count' => 0
		];

		$args = wp_parse_args($args, $defaults);
		#Helper::_debug($args);

		if($args['post_id'] == 0){
			$_tags = get_terms($args);
		}else{
			$_tags = wp_get_post_tags($args['post_id'], $args);
		}

		if(empty($_tags) || is_wp_error($_tags)){
			return;
		}

		if($args['show_count']){
			shuffle($_tags);
		}

		$i = 0;
		$args['show_count'] = intval($args['show_count']);
		$tags = [];
		foreach($_tags as $key => $tag){
			if($args['show_count'] > 0 && $i >= $args['show_count']){
				continue;
			}

			$tags[$key] = $tag;

			if('edit' === $args['link']){
				$link = get_edit_term_link($tag, $tag->taxonomy, $args['post_type']);
			}else{
				$link = get_term_link($tag, $tag->taxonomy);
			}

			if(is_wp_error($link)){
				return;
			}

			$tags[$key]->link = $link;
			$tags[$key]->id = $tag->term_id;
			$tags[$key]->bg_color = get_field('tag_bg_color', 'term_'.$tag->term_id);
			$tags[$key]->fg_color = get_field('tag_fg_color', 'term_'.$tag->term_id);

			$i++;
		}

		return $tags;
	}

	public static function get_post_tags_ids($args = []){
		$defaults = [
			'post_id' => 0,
			'format' => 'flat',
			'separator' => "\n",
			'orderby' => 'count',
			'order' => 'DESC',
			'exclude' => '',
			'include' => '',
			'link' => 'view',
			'taxonomy' => 'post_tag',
			'post_type' => '',
			'echo' => false,
			'show_count' => 0
		];

		$args = wp_parse_args($args, $defaults);
		#Helper::_debug($args);

		if($args['post_id']){
			$_tags = wp_get_post_tags($args['post_id'], $args);
		}

		if(empty($_tags) || is_wp_error($_tags)){
			return [];
		}

		$i = 0;
		$args['show_count'] = intval($args['show_count']);
		$tags = [];
		foreach($_tags as $key => $tag){
			if($args['show_count'] > 0 && $i >= $args['show_count']){
				continue;
			}

			$tags[] = $tag->term_id;

			$i++;
		}

		return $tags;
	}


}
