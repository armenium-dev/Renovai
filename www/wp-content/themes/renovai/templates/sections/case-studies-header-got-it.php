<?php
use Digidez\Functions;
use Digidez\Helper;

#Helper::_debug($section_data);

?>
<section id="<?=$section_name;?>-section" class="case-studies-got-it-header-section">
	<div class="container h-100">
		<div class="row">
			<div class="col-12 col-lg-10 offset-lg-1">
				<div class="case-studies-got-it-container text-center d-flex flex-column justify-content-center">
					<h1 class="h1"><?=$section_data['section_title'];?></h1>
					<p><?=$section_data['section_content'];?></p>
				</div>
			</div>
		</div>
	</div>
</section>
