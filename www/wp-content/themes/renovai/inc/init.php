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
require 'classes/Core.php';
require 'classes/Helper.php';
require 'classes/Caches.php';
#require 'classes/Tools.php';
#require 'classes/Cron.php';
require 'classes/Backend.php';
require 'classes/DataSource.php';
require 'classes/Actions.php';
require 'classes/Ajax.php';
require 'classes/Filters.php';
require 'classes/Theme.php';
require 'classes/Editor.php';
require 'classes/Functions.php';
require 'classes/PostTypes.php';
require 'classes/Taxonomies.php';
require 'classes/Shortcodes.php';
require 'classes/Widgets.php';
require 'classes/MetaOG.php';
#require 'helpers/geo2.php';
require 'helpers/device.php'; #* Mobile Detect Library
#require 'helpers/browser.php'; #* Browser Detect Library
#require 'classes/Api.php';
require 'helpers/aq_resizer.php';
require 'override-functions.php';
#require 'helpers/paginate_navigation_builder.php';
#require 'helpers/PHPExcel.php';
require 'widgets/nav_menu.php';

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
Backend::initialise();
Actions::initialise();
Ajax::initialise();
Filters::initialise();
PostTypes::initialise();
Taxonomies::initialise();
Shortcodes::initialise();
Widgets::initialise();
MetaOG::initialise();
#Api::initialise();
