<?php

use Digidez\DataSource;
use Digidez\Functions;
use Digidez\Helper;

$section_data['section_items'] = DataSource::fill_cpt_cf($section_data['section_items']);
#Helper::_debug($section_data);
?>
<div class="overflow-hidden">
	<section id="<?=$section_name;?>-section-titles" class="<?=$section_name;?>-section-titles reviews">
		<div class="container text-center mt-5 mt-md-6 mb-8 mb-md-6 pb-md-8">
			<h2 class="h-lg h2 mb-2 text-secondary"><?=$section_data['section_title'];?></h2>
			<div class="h4">
				<p><?=$section_data['section_sub_title'];?></p>
			</div>
		</div>
	</section>
	
	<?php if(count($section_data['section_items'])):?>
	<section id="<?=$section_name;?>-section-reviews" class="bg-reviews reviews">
		<div class="container h-inherit">
			<div class="row h-inherit">
				<div class="col-10 offset-1 col-md-8 offset-md-2 col-xl-10 offset-xl-1 h-inherit">
					<div class="carousel-reviews text-white" id="carouselReviews">
						<?php foreach($section_data['section_items'] as $k => $item): $class = ($k == 0 ? 'carousel-item active' : 'carousel-item');?>
							<div class="h-100">
								<div class="text-center position-relative review-item d-flex flex-column align-items-center h-100">
									<div class="bg-image" style="background-image: url(<?=Functions::get_the_attachment_thumbnail($item->cf['testimonial_background_image'], 'full', [], false, false);?>)"></div>
									<div class="review-img mb-2" style="background-image: url(<?=Functions::get_the_attachment_thumbnail($item->cf['testimonial_user_photo'], '220x220', ['alt' => $item->post_title], false, false);?>);"></div>
									<div class="mb-2" style="height: 37px;"><img src="<?=$item->cf['testimonial_company_logo'];?>" alt="" title="" style="height:auto;"></div>
									<div class="mb-2">
										<p><b><?=$item->post_title;?></b> / <span><?=$item->cf['testimonial_job_title'];?></span></p>
									</div>
									<div class="text-review-content">
										<p><?=$item->cf['testimonial_user_quote'];?></p>
									</div>
								</div>
							</div>
						<?php endforeach;?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php endif; ?>
</div>

