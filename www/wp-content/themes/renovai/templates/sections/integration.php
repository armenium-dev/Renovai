<?php

use Digidez\DataSource;
use Digidez\Helper;

#Helper::_debug($section_data);
?>
<section id="<?=$section_name;?>-section" class="bg-pink5 pt-lg-7 pt-4 pb-6 siriyp-section">
	<div class="container">
		<div class="row mb-lg-6 mb-5">
			<div class="col-12 col-xxl-7 text-center mx-auto">
				<h2 class="display-h2"><?=$section_data['section_title'];?></h2>
			</div>
		</div>
		<div class="row row-cols-lg-4 row-cols-2 justify-content-center text-center">
			<?php foreach($section_data['section_items'] as $k => $url):?>
				<div class="col py-lg-4 py-2"><img class="img-fluid" src="<?=$url;?>" alt="" title=""></div>
			<?php endforeach;?>
		</div>
	</div>
</section>

