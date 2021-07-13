<?php
use Digidez\Functions;
use Digidez\Helper;

#Helper::_debug($section_data);

?>
<section id="<?=$section_name;?>-section" class="careers-header-section">
	<div class="container h-100">
		<div class="row h-100">
			<div class="col-12 col-xxl-8 offset-xxl-2 h-100">
				<div class="row align-items-center h-100">
					<div class="col-12 col-md-7 mb-10">
						<h1 class="h1"><?=$section_data['section_title'];?></h1>
						<p><?=$section_data['section_content'];?></p>
						<?=Functions::render_section_button($section_data['section_button'], ['class' => 'btn btn-primary shadow mt-3 d-md-none']);?>
						<?=Functions::render_section_button($section_data['section_button'], ['class' => 'btn btn-lg btn-primary shadow mt-3 d-none d-md-inline-block']);?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>