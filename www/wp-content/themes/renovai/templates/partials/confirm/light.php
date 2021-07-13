<?php
use Digidez\Functions;
?>
<section id="<?=$section_name;?>-section" class="contact-us-header-section thank-you">
	<div class="contact-us-header-container">
		<div class="container">
			<div class="row">
				<div class="col-12 col-xxl-8 offset-xxl-2">
					<div class="row contact-us-header-content justify-content-center">
						<div class="col-12 col-md-6 text-center">
							<div class="h1"><?=$section_data['section_title'];?></div>
							<p class="mb-6"><?=$section_data['section_content'];?></p>
							<?=Functions::render_section_button($section_data['section_button'], ['class' => 'btn btn-light btn-icon', 'icon' => '<i class="i i-sm i-right-arrow"></i>']);?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
