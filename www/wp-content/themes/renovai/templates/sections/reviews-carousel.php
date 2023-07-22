<?php

use Digidez\DataSource;
use Digidez\Functions;
use Digidez\Helper;

$section_data['section_items'] = DataSource::fill_cpt_cf($section_data['section_items']);
#Helper::_dd($section_data);

$style = '';
if(!empty($section_data['section_background'])){
	$style = sprintf('background-color: %s;', $section_data['section_background']);
}
?>
<section id="section-<?=$section_name;?>" class="section-<?=$section_name;?>" style="<?=$style;?>">
		<h2 class="text-center title"><?=$section_data['section_title'];?></h2>

		<?php if(count($section_data['section_items'])):?>
		<div id="js_slick_carousel" class="overflow-hidden">
			<?php foreach($section_data['section_items'] as $k => $item): $class = ($k == 0 ? 'carousel-item active' : 'carousel-item');?>
				<div class="h-100 review-item-wrap">
					<div class="position-relative review-item h-100">
						<div class="d-flex flex-row flex-nowrap justify-content-between align-items-start gap-12 mb-20">
							<img src="<?=$item->cf['review_avatar'];?>" alt="" title="" style="height:auto; width: 40px;">
							<div class="flex-grow-1 flex-shrink-1">
								<div class="d-flex flex-row flex-nowrap justify-content-between align-items-end">
									<div class="uname"><?=$item->post_title;?></div>
									<div class="d-flex flex-row flex-nowrap gap-5 review-rate">
										<?=Functions::render_review_stars($item->cf['review_rate']);?>
									</div>
								</div>
								<div class="ucompany"><?=$item->cf['review_job_title'];?>, <?=$item->cf['review_company'];?></div>
							</div>
						</div>
						<div class="review-content">
							<?=$item->cf['review_message'];?>
						</div>
					</div>
				</div>
			<?php endforeach;?>
		</div>
		<?php endif; ?>
		
</section>

