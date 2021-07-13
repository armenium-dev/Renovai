<?php
use Digidez\Functions;

#Functions::_debug($section_data);

?>
<section id="<?=$section_name;?>-section" class="bg-secondary py-5 py-md-7 sier">
	<div class="container text-center">
		<div class="row justify-content-center">
			<div class="col-12">
				<h1 class="h7 mb-2 text-white"><?=$section_data['section_title'];?></h1>
			</div>
			<div class="col-12 col-xl-10 col-xxl-8 h5">
				<p><?=$section_data['section_content'];?></p>
			</div>
		</div>
	</div>
</section>



