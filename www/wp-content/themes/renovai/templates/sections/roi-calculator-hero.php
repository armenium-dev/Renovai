<?php

use Digidez\Functions;
use Digidez\Helper;

#Helper::_debug($section_data);

?>
<section id="<?=$section_name;?>-section" class="roi-calc__first-screen first-screen">
	<div class="container mt-auto">
		<div class="first-screen__info">
			<h1 class="first-screen__title"><?=$section_data['section_title'];?></h1>
			<div class="first-screen__subtitle"><?=$section_data['section_description'];?></div>
		</div>
		
		<div class="first-screen__backgound first-screen-bg">
			<img src="<?=$section_data['section_desktop_image'];?>" class="first-screen__bg first-screen__bg--large-screen">
			<img src="<?=$section_data['section_mobile_image'];?>" class="first-screen__bg first-screen__bg--mobile-screen">
		</div>
	</div>
</section>
