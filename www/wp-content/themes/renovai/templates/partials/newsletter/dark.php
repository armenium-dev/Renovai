<?php

use Digidez\Functions;

?>
<section id="<?=$section_name;?>-section" class="book-a-demo-section thank-you-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-xxl-9">
				<div class="row">
					<div class="col-12 col-md-8 offset-md-2 text-center">
						<div class="h1"><?=$section_data['subscribe_title'];?></div>
						<p class="mb-6"><?=$section_data['subscribe_text'];?></p>
						<?=do_shortcode($section_data['subscribe_form']);?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
