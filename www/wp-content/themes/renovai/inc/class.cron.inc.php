<?php

namespace Digidez;


class Cron {

	public static $options;
	private static $cron_task_name = "renovai_data_updater";

	public static function initialise(){
		$self = new self();

		add_action('init', array($self, 'init'), 0);
		add_action(self::$cron_task_name, array($self, 'renovai_cron_task_exec'));
		add_filter('cron_schedules', array($self, 'renovai_cron_add_schedule'));
	}

	public function init() {
		self::$options = Core::get_options();
		self::run();
	}

	function renovai_cron_add_schedule(){
		$schedules['renovai_cron_interval'] = array('interval' => (intval(self::$options['cron_interval']) * 60), 'display' => 'Every '.self::$options['cron_interval'].' minute(s)');
		return $schedules;
	}

	public static function run(){
		#Functions::log('[function '.__FUNCTION__.'] is called');
		if(wp_next_scheduled(self::$cron_task_name) === false){
			Functions::_log('[function '.__FUNCTION__.'], wp_next_scheduled = false');
			wp_schedule_event(time()+self::$options['cron_interval'] * 60, 'renovai_cron_interval', self::$cron_task_name);
		}else{
			/*$timestamp = wp_next_scheduled(self::$cron_task_name);
			if($timestamp > time()+self::$options['cron_interval']*60){
				Functions::log('[function '.__FUNCTION__.'], schedule restart, timestamp = '.$timestamp);
				self::stop();
				//self::run();
			}*/
		}
	}

	public static function stop(){
		#Functions::log('[function '.__FUNCTION__.'] is called');
		$timestamp = wp_next_scheduled(self::$cron_task_name);
		wp_unschedule_event($timestamp, self::$cron_task_name);
		wp_clear_scheduled_hook(self::$cron_task_name);
	}

	public function renovai_cron_task_exec(){
		Functions::_log('------------------- START CRON -------------------');
		Functions::_log('[function '.__FUNCTION__.'] is called');

		/*WCPL_Data_Source::cron__restore_broken_products();
		WCPL_Data_Source::cron__sync_mod_products();
		WCPL_Data_Source::cron__update_mod_products_new_ids();
		WCPL_Data_Source::cron__checking_for_fix_seo_fields();
		WCPL_Data_Source::cron__generate_product_seo_fields();
		WCPL_Data_Source::cron__generate_product_thumb_fields();
		WCPL_Data_Source::wc_update_product_lookup_tables_column();
		*/
		
		Functions::_log('------------------- END CRON -------------------');
	}

}
