<?php

namespace Digidez;

class Widgets{
	
	public static function initialise(){
		$self = new self();
		
		#include_once 'widgets/social_icons.php';
		#include_once 'widgets/nav_menu.php';
		
		add_action('widgets_init', [$self, 'widgets_init']);
	}
	
	
	public function widgets_init(){
		#register_widget('Digidez\Social_Icons');
		register_widget('Digidez\Nav_Menu');
	}
	
}
