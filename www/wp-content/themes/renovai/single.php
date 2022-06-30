<?php

use Digidez\Caches;
use Digidez\Functions;

global $post;
/** Template file path: /wp-content/themes/renovai/templates/partials/blog/single/post.php **/
Caches::get_page_from_cahce($post, 'render_post_single');
