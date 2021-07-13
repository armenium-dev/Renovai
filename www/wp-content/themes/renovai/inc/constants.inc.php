<?php
$home_url = home_url();

//define('THEME_VERSION', '5.9.7');
define('THEME_SHORT', 'renovai');
define('THEME_TD', 'understrap');

define('THEME_DIR', get_template_directory().'/');
define('THEME_URI', get_template_directory_uri().'/');


define('VC_COMPONENTS_DIR', THEME_DIR.'components/shortcodes');
define('VC_COMPONENTS_URI', THEME_URI.'components/shortcodes');

define('INC_DIR', THEME_DIR.'inc');
define('INC_URI', THEME_URI.'inc');
define('VENDOR_DIR', INC_DIR.'/vendor');

define('ASSETS_DIR', THEME_DIR.'assets');
define('ASSETS_URI', THEME_URI.'assets');

define('CSS_DIR', ASSETS_DIR.'/css');
define('CSS_URI', ASSETS_URI.'/css');

define('JS_DIR', ASSETS_DIR.'/js');
define('JS_URI', ASSETS_URI.'/js');

define('IMG_DIR', ASSETS_DIR.'/img');
define('IMG_URI', ASSETS_URI.'/img');

define('IMAGES_DIR', ASSETS_DIR.'/images');
define('IMAGES_URI', ASSETS_URI.'/images');

define('FONTS_DIR', ASSETS_DIR.'/fonts');
define('FONTS_URI', ASSETS_URI.'/fonts');

define('FONT_ICONS_DIR', ASSETS_DIR.'/fontawesome');
define('FONT_ICONS_URI', ASSETS_URI.'/fontawesome');

define('ICONS_DIR', ASSETS_DIR.'/icons');
define('ICONS_URI', ASSETS_URI.'/icons');

define('SHORTCODES_PATH', '/templates/shortcodes');
define('PARTIALS_PATH', '/templates/partials');
define('SECTIONS_PATH', '/templates/sections');
define('MODALS_PATH', '/templates/modals');
define('PAGE_TEMPLATES_PATH', '/templates/page/');
define('POST_TEMPLATES_PATH', '/templates/post/');

define('DOWNLOAD_DIR', ABSPATH.'/wp-downloads');
define('DOWNLOAD_URI', $home_url.'/wp-downloads');

define('LOGS_DIR', ABSPATH.'/wp-logs');
define('LOGS_URI', $home_url.'/wp-logs');

define('CACHE_DIR', ABSPATH.'wp-cache');
define('CACHE_URL', $home_url.'/wp-cache');
define('CACHE_PAGES_DIR', ABSPATH.'wp-cache/pages');
