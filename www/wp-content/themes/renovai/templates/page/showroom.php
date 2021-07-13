<?php
/**
 * Template Name: Showroom
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 */

use Digidez\Functions;
use Digidez\Caches;

global $post;
Caches::get_page_from_cahce($post, 'render_page_sections');

