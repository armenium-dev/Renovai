<?php
use Digidez\Functions;
use Digidez\Helper;

#Helper::_debug($section_data);

?>
<section id="<?=$section_name;?>-section" class="contact-us-header-section">
	<div class="contact-us-header-container">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-12 col-xxl-9">
					<div class="row contact-us-header-content">
						<div class="col-12 col-md-5 text-center text-md-left">
							<h1 class="h1"><?=$section_data['section_title'];?></h1>
							<p class="mb-md-6"><?=$section_data['section_content'];?></p>
						</div>
						<div class="col-12 col-md-5 offset-md-1">
							<?=do_shortcode($section_data['section_shortcode']);?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
