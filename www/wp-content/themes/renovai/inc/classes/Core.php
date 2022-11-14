<?php
namespace Digidez;


class Core{
	
	private static $sql_structure = array();
	private static $slug = "renovai_settings";
	public static $options = [];
	
	public static function initialise(){
		$self = new self();
		
		self::get_options();
		
		#self::create_tables();
		self::fillCountryTable();
	}
	
	public static function getSlug(){
		return self::$slug;
	}
	
	public static function set_option($key = '', $value = '', $update = false){
		if($key == '')
			return false;
		
		self::$options[$key] = $value;
		
		if($update){
			self::update_options();
		}
	}
	
	public static function update_options($options = array()){
		if(!empty($options)){
			self::$options = $options;
		}
		
		return update_option(self::$slug, self::$options);
	}
	
	public static function get_option($key = ''){
		$settings = self::get_options();
		
		return !empty($settings[$key]) ? $settings[$key] : false;
	}
	
	public static function get_options(){
		if(isset(self::$options) && is_array(self::$options) && !empty(self::$options)){
			return self::$options;
		}
		
		return self::$options = get_option(self::$slug, array());
	}
	
	public static function create_tables(){
		global $wpdb;
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		//$wpdb->show_errors();
		$charset_collate = '';

		if($wpdb->has_cap('collation')){
			$charset_collate = $wpdb->get_charset_collate();
		}

		self::$sql_structure = include_once THEME_DIR."/inc/sql/structure.php";

		$sql_tables = self::$sql_structure['tables'];
		$sql_views = self::$sql_structure['views'];

		if(!empty($sql_tables)){
			$sql_tables = str_replace(['{charset_collate}', '{prefix}'], [$charset_collate, $wpdb->prefix], $sql_tables);
			dbDelta($sql_tables);
		}
		if(!empty($sql_views)){
			$sql_views = str_replace(['{db_name}', '{prefix}'], [DB_NAME, $wpdb->prefix], $sql_views);
			dbDelta($sql_views);
		}
	}

	public static function fillCountryTable(){
		$count = DataSource::get_var("SELECT COUNT(*) AS rows_count FROM prefix_country");
		#Helper::_debug($count); exit;
		
		if($count == 0){
			$sql = file_get_contents(THEME_DIR."/inc/sql/data/countries.sql");
			DataSource::query($sql);
		}
	}
	
}
