<?php
use Digidez\Functions;
use Digidez\Helper;

#Helper::_debug($section_data);

?>
<section id="<?=$section_name;?>-section" class="product-content py-6 py-lg-10">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-xxl-9">
				<?php if(count($section_data['section_items'])):?>
					<?php foreach($section_data['section_items'] as $item):?>
					<div class="row align-items-center text-center text-lg-left item-row">
						<?php Functions::get_template_part(PARTIALS_PATH.'/solutions/'.$item['display_direction'], ['item' => $item]);?>
					</div>
					<?php endforeach;?>
				<?php endif; ?>
			</div>
		</div>
		
		<?php if($section_data['section_button']['type'] != 'hidden'):?>
		<div class="row">
			<div class="col-12 btn-wrap text-center">
				<?=Functions::render_section_button($section_data['section_button'], ['class' => 'shadow btn btn-secondary']);?>
			</div>
		</div>
		<?php endif;?>
	</div>
</section>
