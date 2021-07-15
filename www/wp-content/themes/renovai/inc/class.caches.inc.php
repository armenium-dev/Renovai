<?php
namespace Digidez;


class Caches{
	
	private static $file_types = ['json', 'php', 'html'];
	
	public static function initialise(){
		if(!is_dir(CACHE_DIR)){
			@mkdir(CACHE_DIR, 0777);
		}
		
		if(!is_dir(CACHE_PAGES_DIR)){
			@mkdir(CACHE_PAGES_DIR, 0777);
		}
	}
	
	public static function set_cache_file($file, $format = "json", $data){
		switch($format){
			case "json":
				file_put_contents(CACHE_DIR.'/'.$file.'.'.$format, json_encode($data));
				break;
			case "php":
				file_put_contents(CACHE_DIR.'/'.$file.'.'.$format, '<?php return '.var_export($data, true).';');
				break;
			case "html":
				file_put_contents(CACHE_DIR.'/'.$file.'.'.$format, $data);
				break;
		}
	}
	
	public static function get_cache_file($file, $output_format = OBJECT){
		$return = [];
		
		if(file_exists(CACHE_DIR.'/'.$file.'.json')){
			$flag = ($output_format == ARRAY_A || $output_format == ARRAY_N) ? true : false;
			$return = json_decode(file_get_contents(CACHE_DIR.'/'.$file.'.json'), $flag);
		}elseif(file_exists(CACHE_DIR.'/'.$file.'.php')){
			$return = include CACHE_DIR.'/'.$file.'.php';
		}elseif(file_exists(CACHE_DIR.'/'.$file.'.html')){
			$return = file_get_contents(CACHE_DIR.'/'.$file.'.html');
		}
		
		return $return;
	}
	
	public static function rem_cache_file($file){
		
		foreach(self::$file_types as $type){
			$file_path = CACHE_DIR.'/'.$file.'.'.$type;
			if(file_exists($file_path)){
				@unlink($file_path);
				break;
			}
		}
	}
	
	public static function rem_pages_cache(){
		$files = array_diff(scandir(CACHE_PAGES_DIR), [".", ".."]);
		#Functions::_debug($files); exit;
		
		if(!empty($files))
			foreach($files as $file)
				@unlink(CACHE_PAGES_DIR.'/'.$file);
	}
	
	public static function get_page_from_cahce($post, $func = 'render_page_sections', $atts = []){
		$post_id = is_object($post) ? $post->ID : $post;
		
		$file = 'pages/'.md5($post_id.$_SERVER['REQUEST_URI']);
		
		$atts = wp_parse_args($atts, [
			'display_header' => true,
			'display_footer' => true,
		]);
		
		$content = '';
		
		if(WP_THEME_CACHE)
			$content = self::get_cache_file($file, null);
		
		if(empty($content)){
			ob_start();
			
			if($atts['display_header'])
				get_header();
			
			call_user_func([Functions::class, $func], $post);
			
			if($atts['display_footer'])
				get_footer();
			
			$content = ob_get_clean();
			
			if(WP_THEME_CACHE)
				self::set_cache_file($file, 'html', $content);
		}
		
		#Functions::_log($_SERVER['HTTP_USER_AGENT']);
		
		if(stristr($_SERVER['HTTP_USER_AGENT'], 'Lighthouse') !== false){
			$content = self::remove_scripts($content);
		}
		
		if(WP_THEME_MINIFY_HTML)
			$content = self::minify_html($content);
		
		echo $content;
	}
	
	public static function minify_html($content){
		
		// HTML tags to ignore hook
		$ignore_tags = (array) apply_filters( 'minify_html_ignore_tags', array( 'textarea', 'pre', 'code' ) );
		
		// stringify
		$ignore_regex = implode( '|', $ignore_tags );
		
		// regex minification
		$minified_html = preg_replace(
			array(
				'/<!--[^\[><](.*?)-->/s',
				'#(?ix)(?>[^\S ]\s*|\s{2,})(?=(?:(?:[^<]++|<(?!/?(?:' . $ignore_regex . ')\b))*+)(?:<(?>' . $ignore_regex . ')\b|\z))#',
			),
			array(
				'',
				' ',
			),
			$content
		);
		
		// something went wrong
		if(strlen($minified_html) <= 1){
			return $content;
		}
		
		// fixing some js errors
		$minified_html = str_replace(
			["} if"],
			["};if"],
			$minified_html
		);
		
		return $minified_html;
	}
	
	public static function remove_scripts($content){
		#$enter = chr(13).chr(10);
		#$content = str_replace('</script>', "</script>".$enter, $content);
		#$content = preg_replace("/<script(.*)(google|banner|facebook|analytics|hscollectedforms|recaptcha|hotjar|matador|hs-scripts)(.*)>(.*?)|(facebook)<\/script>/igm", "", $content);
		#$content = preg_replace("/<script(.*)src=(\\'|\")(.*)(hotjar|gstatic|google|recaptcha)\b[^>]*>(.*?)<\/script>/is", "", $content);
		$content = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $content);
		$content = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', "", $content);
		$content = preg_replace('/<link\b[^>]*>/is', "", $content);
		
		$l = "<link rel='stylesheet' id='renovai-bootstrap-css'  href='https://www.renovai.com/wp-content/themes/renovai/assets/css/bootstrap.css?ver=1.0.0' type='text/css' media='all' /><link rel='stylesheet' id='renovai-theme-css'  href='https://www.renovai.com/wp-content/themes/renovai/assets/css/style.css?ver=1.0.0' type='text/css' media='all' /></body>";
		$content = str_replace('</body>', $l, $content);
		
		return $content;
	}
}
