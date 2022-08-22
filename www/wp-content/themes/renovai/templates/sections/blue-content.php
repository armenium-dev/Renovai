<?php
use Digidez\Helper;

#Helper::_debug($section_data);

?>
<section id="<?=$section_name;?>-section" class="<?=$section_name;?>-section bg-secondary py-5 py-md-7 sier">
	<div class="container text-center">
		<div class="row justify-content-center">
			<div class="col-12 mb-16 mb-md-24">
				<h1 class="text-white"><?=$section_data['section_title'];?></h1>
			</div>
			<div class="col-12 col-xl-10 col-xxl-8 content">
				<?=$section_data['section_content'];?>
			</div>
		</div>
	</div>
</section>



