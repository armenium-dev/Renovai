<?php

namespace Digidez;


class Browser{

	const UNKNOWN = 'unknown';

	const PLATFORM_ANDROID = 'android';
	const PLATFORM_IOS = 'iOS';
	const PLATFORM_LINUX = 'linux';
	const PLATFORM_MAC = 'mac';
	const PLATFORM_WINDOWS = 'windows';

	static $this;

	/**
	 * ABC_Core constructor.
	 */
	public function __construct(){
		self::$this;

	}

	/**
	 * Get users browser details
	 * @return array
	 */
	public function get_browser(){
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		$platform   = $this->get_platform($user_agent);
		$browser    = $this->get_browser_name($user_agent);

		// finally get the correct version number
		$known = array('Version', $browser['name'], 'rv');
		if($browser['name'] === 'Opera'){
			$known = array('Version', $browser['name'], 'OPR', 'rv');
		}
		$pattern = '#(?<browser>'.implode('|', $known).')[/ |:]+(?<version>[0-9.|a-zA-Z.]*)#';
		preg_match_all($pattern, $user_agent, $matches);

		// see how many we have
		$i = count($matches['browser']);

		if($i != 1){
			//we will have two since we are not using 'other' argument yet
			//see if version is before or after the name
			if(strripos($user_agent, 'Version') < strripos($user_agent, $browser['name'])){
				$version = $matches['version'][0];
			}else{
				$version = $matches['version'][1];
			}
		}else{
			$version = $matches['version'][0];
		}

		// check if we have a number
		if($version === null || $version === '' || $version === 0){
			$version = self::UNKNOWN;
		}

		return array(
			'user_agent' => $user_agent,
			'name'       => $browser['full_name'],
			'short_name' => $browser['short_name'],
			'version'    => floor($version),
			'platform'   => $platform,
			'pattern'    => $pattern
		);
	}


	/**
	 * Default browsers settings. This builds the browser drop downs on the admin page
	 * @return array
	 */
	public function default_browsers(){
		// Included version numbers is current stable (since latest plugin update)
		// and 5 future versions as most
		// and 8 older versions as most

		return array(
			'safari' => array(0, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13),
			'opera'  => array(0, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40),
			'ff'     => array(0, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 51, 52),
			'chrome' => array(0, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56),
			'ie'     => array(0, 7, 8, 9, 10, 11),
			'edge'   => array(0, 12, 13, 14, 15, 16)
		);
	}

	/**
	 * Get browser name details
	 *
	 * @param $user_agent
	 *
	 * @return array
	 */
	protected function get_browser_name($user_agent){
		// Next get the name of the useragent yes seperately and for good reason
		if(preg_match('/Opera/i', $user_agent) || preg_match('/OPR/i', $user_agent)){
			return array(
				'full_name'  => 'Opera',
				'name'       => 'Opera',
				'short_name' => 'opera'
			);
		}elseif(preg_match('/Edge/i', $user_agent)){
			return array(
				'full_name'  => 'Microsoft Edge',
				'name'       => 'Edge',
				'short_name' => 'edge'
			);

		}elseif(preg_match('/Firefox/i', $user_agent)){
			return array(
				'full_name'  => 'Mozilla Firefox',
				'name'       => 'Firefox',
				'short_name' => 'ff'
			);
		}elseif(preg_match('/Chrome/i', $user_agent)){
			return array(
				'full_name'  => 'Google Chrome',
				'name'       => 'Chrome',
				'short_name' => 'chrome'
			);
		}elseif(preg_match('/Safari/i', $user_agent)){
			return array(
				'full_name'  => 'Apple Safari',
				'name'       => 'Safari',
				'short_name' => 'safari'
			);
		}elseif(preg_match('/MSIE/i', $user_agent) || preg_match('/Windows NT/i', $user_agent)){
			return array(
				'full_name'  => 'Internet Explorer',
				'name'       => 'MSIE',
				'short_name' => 'ie'
			);
		}

		return array(
			'full_name'  => self::UNKNOWN,
			'name'       => self::UNKNOWN,
			'short_name' => self::UNKNOWN
		);
	}

	/**
	 * Get users platform (OS)
	 *
	 * @param $user_agent
	 *
	 * @return string
	 */
	protected function get_platform($user_agent){
		if(preg_match('/android/i', $user_agent)){
			return self::PLATFORM_ANDROID;
		}elseif(preg_match('/iphone/i', $user_agent) || preg_match('/ipad/i', $user_agent) || preg_match('/ipod/i', $user_agent)){
			return self::PLATFORM_IOS;
		}elseif(preg_match('/linux/i', $user_agent)){
			return self::PLATFORM_LINUX;
		}elseif(preg_match('/macintosh|mac os x/i', $user_agent)){
			return self::PLATFORM_MAC;
		}elseif(preg_match('/windows|win32/i', $user_agent)){
			return self::PLATFORM_WINDOWS;
		}

		return self::UNKNOWN;
	}


}