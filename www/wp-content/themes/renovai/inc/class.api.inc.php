<?php

namespace Digidez;

use \Digidez\Functions;

class API {

	private static $token = '';
	private static $slug = 'digidez-api';
	private static $options = array();

	//  Hook WordPress
	public static function initialise(){
		$self = new self();

		add_filter('query_vars', array($self, 'add_query_vars'), 0);
		add_action('parse_request', array($self, 'sniff_requests'), 0);
		add_action('init', array($self, 'add_endpoint'), 0);
		add_action('admin_init', array($self, 'register_settings'), 10);
		add_action('admin_menu', array($self, 'add_option_field_to_general_admin_page'));
		add_action('wp_head', array($self, 'add_meta_to_head'), 100);
	}

	public function _debug($data = array(), $show_for_users=false, $echo=true, $strip_tags=true){
		if(current_user_can('manage_options') || $show_for_users){
			$count = count($data);
			if(is_array($data) || is_object($data))
				$data = print_r($data, true);
			$data = htmlspecialchars($data);
			if($strip_tags)
				$data = strip_tags($data);
			if($echo)
				echo '<pre class="debug">Debug info:(', $count, ')<br>', $data, '</pre>';
			else return $data;
		}
	}

	public function add_meta_to_head(){
		echo '<link rel="api-token" href="'.self::$options['wp_my_api_token'].'" />';
	}

	/*
		Add public query vars
		@param array $vars List of current public query vars
		@return array $vars
	*/
	public function add_query_vars($vars){
		$vars[] = '__wp-api';
		$vars[] = 'pugs';
		return $vars;
	}

	//  Add API Endpoint
	public function add_endpoint(){
		self::$options = get_option(self::$slug);
		self::$token = !empty(self::$options['wp_my_api_token']) ? self::$options['wp_my_api_token'] : md5($_SERVER['HTTP_HOST']);

		//add_rewrite_rule('^wp-api/?([^/]+)?/?','index.php?__wp-api=1&pugs=$matches[1]','top');
		add_rewrite_rule('^wp-api/'.self::$token.'/?([^/]+)?/?','index.php?__wp-api=1&token=$matches[0]&pugs=$matches[1]','top');
		flush_rewrite_rules();
	}

	/*
		Sniff Requests
		This is where we hijack all API requests
		If $_GET['__api'] is set, we kill WP and serve our data
		@return die if API request
	*/
	public function sniff_requests(){
		global $wp;
		if(isset($wp->query_vars['__wp-api'])){
			self::handle_request();
			exit;
		}
	}

	/**
	 * For testing:
	 * Call <site_url>/wp-api/<token>/version
	 * <site_url> = your web-site URL
	 * <token> value you can find in Admin Console > Settins > Reading Settings > "WP MY API Token" field value
	 *
	 * @return string|void
	 */
	protected function get_wp_version(){
		return get_bloginfo('version');
	}

	/**
	 *  This is where we handle incoming requests
	 */
	protected function handle_request(){
		global $wp;

		$pugs = $wp->query_vars['pugs'];

		switch($pugs){
			case 'recruiting_item':
				self::send_response('recruiting_item', Functions::get_recruiting_items());
				break;
			case 'version':
				self::send_response('wp-version', self::get_wp_version());
				break;
			case 'something':
				self::send_response('something', 'something');
				break;
			default:
				self::send_response('token', self::$token);
				break;
		}
	}

	/**
	 * This sends a JSON response to the browser
	 */
	protected function send_response($key, $val){
		$response[$key] = $val;
		header('content-type: application/json; charset=utf-8');
		echo json_encode($response)."\n";
		exit;
	}

	/**
	 * WP-ADMIN AREA
	 */
	public function register_settings(){
		/*
		 * If no options exist, create them.
		 */
		if(!get_option(self::$slug)){
			update_option(self::$slug, array(
				'wp_my_api_token' => self::$token,
			));
		}
	}

	public function add_option_field_to_general_admin_page(){
		$my_options = array(
			'wp_my_api_token' => array(
				'id' => 'wp_my_api_token',
				'label' => __('WP MY API Token'),
				'func' => __CLASS__.'::myprefix_setting_callback_text',
				'show_page' => 'reading',
			),

		);

		foreach($my_options as $k => $v){
			register_setting($v['show_page'], $k);
			// добавляем поле
			add_settings_field(
				$v['id'],
				$v['label'],
				$v['func'],
				$v['show_page'],
				'default',
				array(
					'id' => $v['id'],
					'label_for' => $v['id'],
					'option_name' => $k,
					'description' => $v['description'],
				)
			);
		}

	}

	public function myprefix_setting_callback_textarea($val){
		$id = $val['id'];
		$option_name = $val['option_name'];
		$html = '<textarea name="'.$option_name.'" id="'.$id.'" rows="4" cols="170">'.esc_attr(get_option($option_name)).'</textarea>';
		if(isset($val['description'])){
			$html .= '<p class="description">'.$val['description'].'</p>';
		}
		echo $html;
	}

	public function myprefix_setting_callback_text($val){
		$options = get_option('digidez-api');
		$id = $val['id'];
		$option_name = $options[$val['option_name']];
		$html = '<input type="text" name="'.$option_name.'" id="'.$id.'" value="'.esc_attr($option_name).'" readonly="readonly" size="36" />';
		if(isset($val['description'])){
			$html .= '<p class="description">'.$val['description'].'</p>';
		}
		echo $html;
	}


}


