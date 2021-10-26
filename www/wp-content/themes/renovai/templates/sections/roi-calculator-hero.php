<?php

use Digidez\Functions;
use Digidez\Helper;

Helper::_debug($section_data);

?>
<section id="<?=$section_name;?>-section" class="roi-calc__first-screen first-screen">
	<div class="container mt-auto">
		<div class="first-screen__info">
			<h1 class="first-screen__title"><?=$section_data['section_title'];?></h1>
			<div class="first-screen__subtitle"><?=$section_data['section_description'];?></div>
		</div>
		
		<div class="first-screen__backgound first-screen-bg">
			<img src="./images/roi-calc/first-screen-vector.png" alt="" class="first-screen-bg__vector">
			<img src="./images/roi-calc/first-screen-wooman.png" alt="" class="first-screen-bg__wooman">
			<img src="./images/roi-calc/first-screen-card.png" class="first-screen-bg__card">
			<img src="./images/roi-calc/first-screen-range-decor.png" alt="" class="first-screen-bg__range-decor">
			<div class="first-screen-bg__add-all-items-wrapp">
				<div class="first-screen-bg__add-all-items-body">Add all items to cart</div>
			</div>
		</div>
	</div>
</section>
