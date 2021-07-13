<?php
use Digidez\Functions;
use Digidez\Helper;
global $post;
$main_nav_style = $post->cf['page_options']['main_nav_style'];
#Helper::_debug($main_nav_style);

Functions::get_template_part(PARTIALS_PATH.'/confirm/'.$main_nav_style, ['section_name' => $section_name, 'section_data' => $section_data]);
