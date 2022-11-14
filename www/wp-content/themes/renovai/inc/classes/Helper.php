<?php


namespace Digidez;


class Helper {
	
	public static $log_file = "theme.log";
	public static $device = 'desktop';
	public static $device_os = '';
	public static $device_name = '';
	public static $device_version = '';
	public static $device_browser = '';
	
	public static function initialise(){
		$self = new self();
		
		$detect = new Device();
		
		if($detect->isTablet()){
			self::$device = 'tablet';
		}elseif($detect->isMobile()){
			self::$device = 'mobile';
		}
		#self::_debug(self::$device);
		
		if($detect->isiOS()){
			self::$device_os = 'iOS';
			if($detect->isIphone()){
				self::$device_name = 'iPhone';
				$vers = $detect->version('iPhone', $detect::VERSION_TYPE_FLOAT);
				if(strstr($vers, '.') !== false){
					$v = explode('.', $vers);
					$vers = $v[0];
				}
				self::$device_version = 'v'.$vers;
				if($detect->isSafari()){
					self::$device_browser = 'Safari';
				}
				if($detect->isChrome()){
					self::$device_browser = 'Chrome';
				}
			}
		}
		
		if($detect->isAndroidOS()){
			self::$device_os = 'Android';
		}
		
		
		if(!is_dir(DOWNLOAD_DIR)){
			@mkdir(DOWNLOAD_DIR, 0777);
		}
		
		if(!is_dir(LOGS_DIR)){
			@mkdir(LOGS_DIR, 0777);
		}
		
		
		if(!file_exists(LOGS_DIR.'/'.self::$log_file)){
			self::_log('#START');
			@chmod(LOGS_DIR.'/'.self::$log_file, 0666);
		}
		
	}
	
	/**
	 * Displaying debug information
	 * @param array $data
	 * @param bool $echo
	 * @param bool $strip_tags
	 * @param bool $show_for_users
	 *
	 * @return array|mixed|string
	 */
	public static function _debug($data = array(), $show_for_users = false, $format = 'html', $echo = true, $strip_tags = true){
		if(current_user_can('manage_options') || $show_for_users){
			$count = 0;
			if(is_array($data) || is_object($data)){
				$count = count($data);
				$data = print_r($data, true);
			}
			$data = htmlspecialchars($data);
			if($strip_tags)
				$data = strip_tags($data);
			if($echo){
				switch($format){
					case "html":
						echo '<pre class="debug"><div class="d-title">Debug info:(', $count, ')</div><div class="d-content">', $data, '</div></pre>';
						break;
					case "json":
						echo json_encode($data);
						break;
					case "raw":
						print_r($data);
						break;
				}
			}else{
				return $format == 'json' ? json_encode($data) : $data;
			}
		}
	}
	
	/**
	 * @param $content
	 */
	public static function _log($content){
		$enter = chr(13).chr(10);
		$date  = date('Y-m-d H:i:s');
		
		if(is_array($content) || is_object($content)){
			$content = '['.$date.'] - '.print_r($content, true).$enter;
		}else{
			$content = '['.$date.'] - '.$content.$enter;
		}
		
		file_put_contents(LOGS_DIR.'/'.self::$log_file, $content, FILE_APPEND);
	}
	
	/** SECURITY **/
	
	public static function xss_clean($data){
		// Fix &entity\n;
		$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
		$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
		$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
		$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
		
		// Remove any attribute starting with "on" or xmlns
		$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
		
		// Remove javascript: and vbscript: protocols
		$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
		$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
		$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);
		
		// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);
		
		// Remove namespaced elements (we do not need them)
		$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
		
		do
		{
			// Remove really unwanted tags
			$old_data = $data;
			$data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
		}
		while ($old_data !== $data);
		
		// we are done...
		return $data;
	}
	
	public static function filter_var($var){
		return filter_var($var, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
	}
	
	public static function filter_var_array($vars){
		return filter_var_array($vars, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
	}
	
}
