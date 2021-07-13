<?php

$logos = get_field('logos', 'option');
$small_logo = $logos['user_menu_icon'];
?>

<a href="<?=site_url('/');?>" class="nav-logo vam">
	<span class="d-cell">
		<img class="logo-img" src="<?=$small_logo;?>">
	</span>
</a>
<a role="button" class="user-menu-close">
	<span></span>
	<span></span>
</a>

