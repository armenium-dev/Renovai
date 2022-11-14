<?php


namespace Digidez;


class MetaOG {
	
	private static $keys = [
		'_yoast_wpseo_opengraph-image',
		'_yoast_wpseo_opengraph-image-id',
		'_yoast_wpseo_opengraph-title',
		'_yoast_wpseo_opengraph-description',
		'_yoast_wpseo_twitter-image',
		'_yoast_wpseo_twitter-image-id',
		'_yoast_wpseo_twitter-title',
		'_yoast_wpseo_twitter-description',
		'_yoast_wpseo_metadesc',
	];
	
	private static $og = [
		'image' => '',
		'image-id' => '',
		'title' => '%%title%% %%sep%% %%sitename%%',
		'desc' => '',
	];
	
	public static function initialise(){}
	
	public static function update_post_meta_fields($post_id, $post){
		$default_image = get_field('meta_og_default_logo', 'option');
		self::$og['image'] = $default_image['url'];
		self::$og['image-id'] = $default_image['ID'];
		
		$results = DataSource::get_results("SELECT * FROM prefix_postmeta WHERE post_id = {$post_id} AND meta_key LIKE '_yoast_wpseo_%'");
		#Helper::_log($results);
		
		$create_for_keys = self::$keys;
		
		if(!empty($results)){
			$create_for_keys = array_flip($create_for_keys);
			
			foreach($results as $result){
				if(in_array($result->meta_key, self::$keys)){
					unset($create_for_keys[$result->meta_key]);
				}
			}
			
		}else{
			$create_for_keys = [];
		}
		
		if(!empty($create_for_keys)){
			$create_for_keys = array_flip($create_for_keys);
			
			$post_cf = DataSource::get_cpt_custom_fields($post);
			#Helper::_debug($post_cf); exit;
			
			$update = true;
			
			switch($post->post_type){
				case "job":
					self::$og['desc'] = strip_tags($post_cf['description_content']);
					break;
				case "vaid_solution":
					self::$og['title'] = str_replace('{POST_TITLE}', '%%title%%', $post_cf['section_title']).' %%sep%% %%sitename%%';
					#self::$og['image'] = $post_cf['section_icon'];
					#self::$og['image-id'] = 0;
					self::$og['desc'] = strip_tags($post_cf['section_subtitle']).'. '.strip_tags($post_cf['section_description']);
					break;
				default:
					$update = false;
					break;
			}
			
			if($update){
				self::do_update_post_meta_fields($create_for_keys, $post_id, $post, $post_cf);
			}
		}
		
		#Helper::_debug($create_for_keys); exit;
	}
	
	private static function do_update_post_meta_fields($create_for_keys, $post_id, $post, $post_cf){
		foreach($create_for_keys as $key){
			$value = '';
			
			switch($key){
				case "_yoast_wpseo_opengraph-image":
				case "_yoast_wpseo_twitter-image":
					$value = self::$og['image'];
					break;
				case "_yoast_wpseo_opengraph-image-id":
				case "_yoast_wpseo_twitter-image-id":
					$value = self::$og['image-id'];
					break;
				case "_yoast_wpseo_opengraph-title":
				case "_yoast_wpseo_twitter-title":
					$value = self::$og['title'];
					break;
				case "_yoast_wpseo_opengraph-description":
				case "_yoast_wpseo_twitter-description":
				case "_yoast_wpseo_metadesc":
					$value = self::$og['desc'];
					break;
			}
			
			#add_post_meta($post_id, $key, $value);
			#Helper::_log([$post->post_type, $post_id, $key, $value]);
			
			$data = [
				'table' => 'prefix_postmeta',
				'post_id' => $post_id,
				'meta_key' => $key,
				'meta_value' => $value,
			];
			DataSource::insert_data($data);
			self::update_wpseo_indexable_fields($post_id);
		}
	}
	
	private static function update_wpseo_indexable_fields($post_id){
		$data = [
			'primary' => ['name' => 'object_id', 'value' => $post_id],
			'table' => 'prefix_yoast_indexable',

			'description' => self::$og['desc'],
			
			'twitter_image' => self::$og['image'],
			'twitter_image_id' => self::$og['image-id'],
			'twitter_image_source' => 'set-by-user',
			'twitter_title' => self::$og['title'],
			'twitter_description' => self::$og['desc'],

			'open_graph_image' => self::$og['image'],
			'open_graph_image_id' => self::$og['image-id'],
			'open_graph_image_source' => 'set-by-user',
			'open_graph_title' => self::$og['title'],
			'open_graph_description' => self::$og['desc'],
			'open_graph_image_meta' => json_encode([
				'width' => 252,
				'height' => 268,
				'url' => self::$og['image'],
				'path' => '',
				'size' => 'full',
				'id' => self::$og['image-id'],
				'alt' => '',
				'pixels' => 67536,
				'type' => 'image/jpeg',
			]),
		];
		DataSource::update_data($data);
		
	}
	
}
