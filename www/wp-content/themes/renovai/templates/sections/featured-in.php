<?php

use Digidez\DataSource;
use Digidez\Helper;

#Helper::_debug($section_data);
?>
<section id="<?=$section_name;?>-section" class="<?=$section_name;?>-section">
	<div class="container max-w-1140">
		<h2 class="text-center"><?=$section_data['section_title'];?></h2>
		<div class="d-flex flex-nowrap justify-content-between align-items-center text-center featured-logos-carousel">
			<?php foreach($section_data['section_items'] as $k => $url):?>
				<img class="img-fluid m-logo w-auto h-auto" src="<?=$url;?>" alt="" title="" width="116" height="27">
			<?php endforeach;?>
		</div>
	</div>
</section>

