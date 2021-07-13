<?php
/**
 * Theme functions loads the main theme class and extra options
 */

namespace Digidez;

require 'constants.inc.php';
if($_SERVER['HTTP_HOST'] != 'renovai'){
	//require 'vendor/autoload.php';
}
#require 'updates.php';
require 'class.core.inc.php';
require 'class.helper.inc.php';
require 'class.caches.inc.php';
#require 'class.tools.inc.php';
#require 'class.cron.inc.php';
require 'class.admin.inc.php';
require 'class.datasource.inc.php';
require 'class.actions.inc.php';
require 'class.ajax_actions.inc.php';
require 'class.filters.inc.php';
require 'class.theme.inc.php';
require 'class.editor.inc.php';
require 'class.functions.inc.php';
require 'class.custom_post_types.inc.php';
require 'class.custom_taxonomies.inc.php';
require 'class.shortcodes.inc.php';
require 'class.widgets.inc.php';
require 'class.meta_og.inc.php';
#require 'classes/geo2.php';
require 'classes/device.php'; #* Mobile Detect Library
#require 'classes/browser.php'; #* Browser Detect Library
#require 'class.api.inc.php';
require 'classes/aq_resizer.php';
require 'override-functions.php';
#require 'classes/paginate_navigation_builder.php';
#require 'classes/PHPExcel.php';


Core::initialise();
Helper::initialise();
Caches::initialise();
#Tools::initialise();
#Cron::initialise();
Theme::initialise();
Editor::initialise();
Functions::initialise();
DataSource::initialise();
if($_SERVER['HTTP_HOST'] != 'renovai'){
	//Geo2::initialise();
}
Admin::initialise();
Actions::initialise();
Ajax_Actions::initialise();
Filters::initialise();
Custom_Post_Types::initialise();
Custom_Taxonomies::initialise();
Shortcodes::initialise();
Widgets::initialise();
Meta_OG::initialise();
#API::initialise();
