<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 25.02.2019
 * Time: 23:24
 */

use Digidez\Functions;

$navigation = get_field('navigation', 'option');
$social_links = $navigation['social_links'];
//Functions::_debug($social_links);
?>
<?php if(!empty($social_links)):?>
<ul class="nav-list socials-list">
	<?php foreach($social_links as $item):?>
	<li class="social-item">
		<a class="dib" href="<?=$item['link'];?>" target="_blank" title="<?=$item['title'];?>">
			<img class="db" src="<?=$item['icon'];?>" style="width: 20px; height: 20px;">
		</a>
	</li>
	<?php endforeach;?>
</ul>
<?php endif;?>
