<?php
/**
 * Template Name: Contact Us
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 */

use Digidez\Caches;
use Digidez\Functions;

global $post;
Caches::get_page_from_cahce($post, 'render_page_sections');

/*get_header();
Functions::render_page_sections($post);
get_footer();*/
