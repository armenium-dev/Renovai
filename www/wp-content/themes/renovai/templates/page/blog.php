<?php
/**
 * Template Name: Blog
 */

use Digidez\Caches;
use Digidez\Functions;
use Digidez\DataSource;
use Digidez\Helper;

defined('ABSPATH') || exit;

global $post;
Caches::get_page_from_cahce($post, 'render_page_sections');
