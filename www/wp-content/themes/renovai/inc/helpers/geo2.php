<?php
namespace Digidez;

//require_once('../vendor/autoload.php');
use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;

class Geo2 {

	private $geo_db_dir = "";
	public $country_code = '';
	public $state_code = '';
	public $postal_code = '';
	public static $city;
	public static $state;
	public static $country;
	
	public static function initialise(){
		$self = new self();
		
		//self::get_city();
		self::get_state();
		//self::get_country();
		
		add_action('init', [$self, 'init'], 0);
	}

	public function init(){
	}

	public static function get_city(){
		$reader = new Reader(VENDOR_DIR.'/geoip2/geoip2/maxmind-db/GeoLite2-City.mmdb');
		self::$city = $reader->city(self::get_ip());
	}
	
	public static function get_country(){
		$reader = new Reader(VENDOR_DIR.'/geoip2/geoip2/maxmind-db/GeoLite2-Country.mmdb');
		self::$country = $reader->country(self::get_ip());
	}
	
	public static function get_state(){
		
		if(empty(self::$state)){
			$geoDB = new Reader(VENDOR_DIR.'/geoip2/geoip2/maxmind-db/GeoLite2-City.mmdb');
			try{
				$ip = $_SERVER['REMOTE_ADDR'];
				if($ip == '127.0.0.1'){
					$ip = $_SERVER['HTTP_X_REAL_IP'];
				}
				$record = $geoDB->city($ip);
				#Functions::_debug($record->country->isoCode);
				if($record->country->isoCode == 'US'){
					if(isset($record->mostSpecificSubdivision)){
						if(self::$state !== $record->mostSpecificSubdivision->name){
							self::$state = $record->mostSpecificSubdivision->name;
						}
					}elseif(isset($record->subdivisions) && count($record->subdivisions) > 0){
						if(self::$state !== $record->subdivisions[0]->name){
							self::$state = $record->subdivisions[0]->name;
						}
					}
				}
			}catch(AddressNotFoundException $e){
				// TODO: notify that IP cannot be verified
			}
		}
		
		#Functions::_debug(self::$state, 1);
		
		return self::$state;
	}
	
	private function getCountryIsoCode(){
		
		if(empty($this->country_code)){
			$geoDB = new Reader(VENDOR_DIR.'/geoip2/geoip2/maxmind-db/GeoLite2-Country.mmdb');
			try{
				$ip = $_SERVER['REMOTE_ADDR'];
				if($ip == '127.0.0.1'){
					$ip = $_SERVER['HTTP_X_REAL_IP'];
				}
				$record = $geoDB->country($ip);
				if($this->country_code !== $record->country->isoCode){
					$this->country_code = $record->country->isoCode;
				}
			}catch(AddressNotFoundException $e){
				// TODO: notify that IP cannot be verified
			}
		}
		
		return $this->country_code;
	}
	
	private static function get_ip(){
		$ip_address = '';

		if(isset($_SERVER['HTTP_CF_CONNECTING_IP']) && !empty($_SERVER['HTTP_CF_CONNECTING_IP']) ){
			$ip_address = $_SERVER['HTTP_CF_CONNECTING_IP'];
		}elseif ( isset($_SERVER['HTTP_X_SUCURI_CLIENTIP']) && !empty($_SERVER['HTTP_X_SUCURI_CLIENTIP']) ) {
			$ip_address = $_SERVER['HTTP_X_SUCURI_CLIENTIP'];
		}elseif ( isset($_SERVER['HTTP_INCAP_CLIENT_IP']) && !empty($_SERVER['HTTP_INCAP_CLIENT_IP']) ) {
			$ip_address = $_SERVER['HTTP_INCAP_CLIENT_IP'];
		}elseif ( isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}elseif ( isset($_SERVER['HTTP_X_FORWARDED']) && !empty($_SERVER['HTTP_X_FORWARDED']) ) {
			$ip_address = $_SERVER['HTTP_X_FORWARDED'];
		}elseif ( isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP']) ) {
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		}elseif ( isset($_SERVER['HTTP_X_REAL_IP']) && !empty($_SERVER['HTTP_X_REAL_IP']) ) {
			$ip_address = $_SERVER['HTTP_X_REAL_IP'];
		}elseif ( isset($_SERVER['HTTP_FORWARDED']) && !empty($_SERVER['HTTP_FORWARDED']) ) {
			$ip_address = $_SERVER['HTTP_FORWARDED'];
		}elseif ( isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR'])){
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}

		// Get first ip if ip_address contains multiple addresses
		$ips = explode(',', $ip_address);
		$ip_address = trim($ips[0]);

		return $ip_address;
	}

}