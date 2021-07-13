<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 25.02.2019
 * Time: 15:46
 */

add_filter('pre_site_transient_update_core', '__return_null');
wp_clear_scheduled_hook('wp_version_check');

remove_action('load-update-core.php', 'wp_update_plugins');
add_filter('pre_site_transient_update_plugins', '__return_null');
wp_clear_scheduled_hook('wp_update_plugins');

remove_action('load-update-core.php', 'wp_update_themes');
add_filter('pre_site_transient_update_themes', '__return_null');
wp_clear_scheduled_hook('wp_update_themes');

function remove_admin_menu_items(){
	remove_submenu_page('index.php', 'update-core.php');
}
add_action('admin_menu', 'remove_admin_menu_items');
