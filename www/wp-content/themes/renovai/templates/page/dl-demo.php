<?php
/**
 * Template Name: DL-demo
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 */

use Digidez\Caches;
use Digidez\Functions;

global $post;
Caches::get_page_from_cahce($post, 'render_page_sections');

