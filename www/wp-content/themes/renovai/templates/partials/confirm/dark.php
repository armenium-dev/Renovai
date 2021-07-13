<?php

use Digidez\Functions;

?>
<section id="<?=$section_name;?>-section" class="book-a-demo-section thank-you-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-xxl-9">
				<div class="row">
					<div class="col-12 col-md-8 offset-md-2 text-center">
						<div class="h1"><?=$section_data['section_title'];?></div>
						<p class="mb-6"><?=$section_data['section_content'];?></p>
						<?=Functions::render_section_button($section_data['section_button'], ['class' => 'btn btn-primary btn-icon', 'icon' => '<i class="i i-sm i-right-arrow"></i>']);?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
