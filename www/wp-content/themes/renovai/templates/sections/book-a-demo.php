<?php
use Digidez\Functions;
use Digidez\Helper;

#Helper::_debug($section_data);

?>
<section id="<?=$section_name;?>-section" class="book-a-demo-section">
	<div class="container">
		<div class="row">
			<div class="col-12 col-xxl-8 offset-xxl-2">
				<div class="row">
					<div class="col-12 col-lg-6 order-1 order-lg-0">
						<div class="book-a-demo-carousel">
							<?php foreach($section_data['section_slider'] as $item_url):?>
							<img src="<?=$item_url;?>" alt="" title="">
							<?php endforeach;?>
						</div>
					</div>
					<div class="col-12 col-lg-5 offset-lg-1 order-0 order-lg-1 mb-6">
						<div class="form-title"><?=$section_data['section_title'];?></div>
						<?=do_shortcode($section_data['section_form']);?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
