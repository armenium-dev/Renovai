<?php
use Digidez\Functions;
use Digidez\Theme;
use Digidez\Helper;

/*wp_nav_menu(array(
	'fallback_cb'    => '__return_empty_string',
	'theme_location' => 'main',
	'menu_class'     => 'clear nav-list',
	'menu_id'        => 'main-menu',
	'container'      => 'ul',
));*/

$header = get_field('header', 'option');

$menu = Theme::get_menu('icons');
#Helper::_debug($header);
?>
<ul id="icons-menu" class="clear nav-list trans_all">
	<?php if(!empty($header['book_a_call_button_shortcode'])):?>
		<li class="menu-item"><?=do_shortcode($header['book_a_call_button_shortcode']);?></li>
	<?php endif;?>
	<?php foreach($menu as $k => $item):;?>
	<li id="menu-icon-item-<?=$item['id'];?>" class="menu-item <?=$item['classes'];?>">
		<a class="nav-link" href="<?=$item['url'];?>"><?=Functions::get_svg_inline(ICONS_DIR.'/'.$item['classes'].'.svg');?></a>
	</li>
	<?php endforeach;?>
</ul>
