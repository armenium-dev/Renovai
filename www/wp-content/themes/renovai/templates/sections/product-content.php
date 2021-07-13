<?php
use Digidez\Functions;
use Digidez\Helper;

#Helper::_debug($section_data);

?>
<section id="<?=$section_name;?>-section" class="product-content pt-8 pb-9">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-xxl-9">
				<?php if(count($section_data['section_items'])):?>
					<div class="row align-items-center text-center text-lg-left">
						<?php foreach($section_data['section_items'] as $item):?>
							<?php Functions::get_template_part(PARTIALS_PATH.'/solutions/'.$item['display_direction'], ['item' => $item]);?>
						<?php endforeach;?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
