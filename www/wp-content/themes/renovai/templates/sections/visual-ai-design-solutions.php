<?php

use Digidez\DataSource;
use Digidez\Functions;
use Digidez\Helper;

$section_data['section_items'] = DataSource::fill_cpt_cf($section_data['section_items']);
#Helper::_debug($section_data);
?>

<section id="<?=$section_name;?>-section" class="bg-secondary py-5 py-md-8 lp-main-section bg-gradient-blue">
	<div class="container text-center">
		<div class="row">
			<div class="col-12 col-xxl-8 offset-xxl-2">
				<div class="row justify-content-center">
					<div class="col-12 mb-6">
						<h2><?=$section_data['section_title'];?></h2>
					</div>
				</div>
				<?php if(count($section_data['section_items'])):?>
				<div class="row justify-content-center">
					<?php foreach($section_data['section_items'] as $k => $item):?>
					<div class="col-12 col-lg-4 col-xl-4 col-xxl-4 pb-9 px-3">
						<div class="lp-col-content text-center h-100 d-flex flex-column align-items-center">
							<img class="img-fluid mb-2" src="<?=$item->cf['section_icon'];?>" alt="<?=$item->post_title;?>" title="<?=$item->post_title;?>">
							<div class="lp-col-title">
								<small>renovai</small>
								<p><?=$item->post_title;?></p>
							</div>
							<h3 class="mb-2"><?=$item->cf['section_subtitle'];?></h3>
							<p><?=$item->cf['section_description'];?></p>
							<a href="<?=get_permalink($item);?>">Learn more</a>
						</div>
					</div>
					<?php endforeach;?>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
