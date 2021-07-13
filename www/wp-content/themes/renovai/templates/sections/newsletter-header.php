<?php
use Digidez\Functions;
use Digidez\Helper;
global $post;
$main_nav_style = $post->cf['page_options']['main_nav_style'];
#Helper::_debug($main_nav_style);

if(isset($_GET['nm']) && $_GET['nm'] == 'confirmed'){
	$section_data['section_title'] = $section_data['confirm_title'];
	$section_data['section_content'] = $section_data['confirm_text'];
	$section_data['section_button'] = $section_data['confirm_button'];
	Functions::get_template_part(PARTIALS_PATH.'/confirm/'.$main_nav_style, ['section_name' => $section_name, 'section_data' => $section_data]);
}else{
	Functions::get_template_part(PARTIALS_PATH.'/newsletter/'.$main_nav_style, ['section_name' => $section_name, 'section_data' => $section_data]);
}
