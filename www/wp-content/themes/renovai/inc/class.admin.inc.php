<?php


namespace Digidez;


use Paginate_Navigation_Builder;

class Admin{

	protected $screen_hook_suffix = null;
	public $upload_dir;
	public $upload_base_url;

	public static function initialise(){
		$self = new self();

		#add_action('admin_menu', [$self, 'register_my_custom_menu_page']);
		add_action('admin_menu', [$self, 'true_wp_admin_block']);
		#add_action('admin_init', [$self, 'register_settings'], 10);
	}
	
	public static function true_wp_admin_block(){
		global $user_ID;
		if(!current_user_can('administrator')){
			header('HTTP/1.0 404 Not Found');
			$user = get_userdata($user_ID);
			echo "<h2>Hey, {$user->first_name} {$user->last_name}, you're not allowed here!</h2>";
			exit();
		}
	}

	public function register_my_custom_menu_page(){
		$capability = 'manage_options';

		/*$this->screen_hook_suffix = add_menu_page(
			__('Custom item', THEME_TD),
			__('Custom item', THEME_TD),
			'edit_pages',
			'custom-item',
			array($this, 'display_custom_page'),
			'dashicons-groups',
			21
		);*/

		add_submenu_page(
			'options-general.php',
			__('Focus GTS', THEME_TD),
			__('Focus GTS', THEME_TD),
			$capability,
			'focus-settings',
			array($this, 'display_custom_page'));

		//add_action('load-'.$import_page, array($this, 'wpeie_contextual_help_import'));
		//add_action('load-'.$export_page, array($this, 'wpeie_contextual_help_export'));
	}

	public function display_custom_page(){
		$this->displayCustomSection("focus-settings");
	}

	public function displayCustomSection($admin_page){
		echo '<div class="wrap">';
		include_once(THEME_DIR.'templates/admin/'.$admin_page.'.php');
		echo '</div>';
	}
	
	public static function register_settings(){
		$slug = Core::getSlug();
		
		if(!get_option($slug)){
			update_option($slug, [
				'cron_interval' => '5',
				'candidates_order_next_update' => time(),
			]);
		}else{
			Core::get_options();
		}
		
		register_setting('renovai-options', $slug, [__CLASS__, 'validate_options']);
		
		add_settings_section(
			'settings_section',
			esc_attr__('Settings', THEME_TD),
			[Tools::class, 'inner_section_description'],
			$slug
		);
		
		add_settings_field(
			'cron_interval',
			esc_attr__('Cron upadte interval (minutes)', THEME_TD),
			[Tools::class, 'text_field'],
			$slug,
			'settings_section',
			[
				'id'      => 'cron_interval',
				'page'    => $slug,
				'classes' => ['auto-text'],
				'type'    => 'text',
				'sub_desc'=> '',
				'desc'    => '3 hours = 180 minutes<br>6 hours = 360 minutes<br>12 hours = 720 minutes<br>24 hours = 1440 minutes<br>2 days = 2880 minutes<br>5 days = 7200 minutes<br>10 days = 14400 minutes',
			]
		);
		
		add_settings_field(
			'candidates_order_next_update',
			__('Candidates ordering update time', THEME_TD),
			[Tools::class, 'text_field'],
			$slug,
			'settings_section',
			[
				'id'      => 'candidates_order_next_update',
				'page'    => $slug,
				'classes' => [],
				'type'    => 'radio',
				'sub_desc'=> '',
				'desc'    => '',
			]
		);
		
	}
	
	public static function validate_options($input){
		Functions::_log('[function '.__FUNCTION__.'] is called');
		Cron::stop();
		
		$output = array();
		
		if(isset($input['candidates_order_next_update'])){
			//$output['candidates_order_next_update'] = time();
		}
		
		// merge with current settings
		$output = array_merge(Core::$options, $input, $output);
		
		return $output;
	}
}
