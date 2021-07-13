<?php
/**
 * Template Name: Company
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 */

use Digidez\Caches;
use Digidez\Functions;
use Digidez\Theme;

global $post;
Caches::get_page_from_cahce($post, 'render_page_sections');

/*get_header();
Functions::render_page_sections($post);
get_footer();*/

