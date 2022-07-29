<?php

use Digidez\DataSource;
use Digidez\Functions;
use Digidez\Helper;

$section_data['section_items'] = DataSource::fill_cpt_cf($section_data['section_items']);
#Helper::_debug($section_data);
?>

<section id="<?=$section_name;?>-section" class="bg-secondary py-5 py-md-8 lp-main-section bg-gradient-blue">
	<div class="container text-center">
		<div class="max-w-1180 m-auto">
			<div class="row justify-content-center">
				<div class="col-12 mb-4">
					<h2><?=$section_data['section_title'];?></h2>
				</div>
			</div>
			<?php if(count($section_data['section_items'])):?>
			<div class="row justify-content-center">
				<?php foreach($section_data['section_items'] as $k => $item):?>
				<div class="col-12 col-md-6 col-lg-4 item d-flex justify-content-center">
					<div class="lp-col-content text-center h-100 d-flex flex-column align-items-center">
						<img class="img-fluid w-auto" width="49" height="40" src="<?=$item->cf['section_icon'];?>" alt="<?=$item->post_title;?>" title="<?=$item->post_title;?>">
						<div class="lp-col-title">
							<small>renovai</small>
							<p><?=$item->post_title;?></p>
						</div>
						<h3 class="mb-2"><?=$item->cf['section_subtitle'];?></h3>
						<p class="desc"><?=$item->cf['section_description'];?></p>
						<a href="<?=get_permalink($item);?>" title="<?=$item->post_title;?>">Learn more</a>
					</div>
				</div>
				<?php endforeach;?>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>
