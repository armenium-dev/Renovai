<?php

use Digidez\DataSource;
use Digidez\Functions;
use Digidez\Helper;

$section_data['section_items'] = DataSource::fill_cpt_cf($section_data['section_items']);
#Helper::_debug($section_data);

$style = '';
if(!empty($section_data['section_background'])){
	$style = sprintf('background-image: url(%s);', $section_data['section_background']);
}
?>

<section id="<?=$section_name;?>-section" class="overflow-hidden" style="<?=$style;?>">
	<div class="container text-center mb-50 mb-md-100">
		<h2><?=$section_data['section_title'];?></h2>
		<?php if(!empty($section_data['section_sub_title'])):?>
		<h3 class="mt-2"><p><?=$section_data['section_sub_title'];?></p></h3>
		<?php endif;?>
	</div>
	
	<?php if(count($section_data['section_items'])):?>
		<div id="splideReviews" class="splide" aria-label="Clients reviews">
			<div class="splide__arrows">
				<button class="splide__arrow splide__arrow--prev">Prev</button>
				<button class="splide__arrow splide__arrow--next">Next</button>
			</div>
			
			<div class="splide__track">
				<ul class="splide__list">
					<?php foreach($section_data['section_items'] as $k => $item): $type = $item->cf['testimonial_user_quote_video'] ? 'video' : 'image';?>
						<li class="splide__slide">
							<div class="position-relative review-item" type="<?=$type;?>">
								<?php if($item->cf['testimonial_user_photo']):?>
									<div class="review-img">
										<?php if($item->cf['testimonial_user_quote_video']):?>
										<a class="video_intro_btn" href="javascript:void(0);" data-trigger="js_action_click" data-action="open_video_modal" data-target="#videoPreviewModal" data-video="<?=$item->cf['testimonial_user_quote_video'];?>">
											<img src="<?=IMAGES_URI;?>/icon-video-play.svg" alt="Play video" class="w-auto h-auto" width="77" height="77">
										</a>
										<?php endif;?>
										<?=Functions::get_the_attachment_thumbnail($item->cf['testimonial_user_photo'], '722x403', ['alt' => $item->post_title, 'class' => 'd-none d-md-block'], true, false);?>
										<?=Functions::get_the_attachment_thumbnail($item->cf['testimonial_user_photo_mobile'], '767x427', ['alt' => $item->post_title, 'class' => 'd-block d-md-none'], true, false);?>
									</div>
								<?php endif;?>
								<div class="review-attrs">
									<?php if($item->cf['testimonial_user_quote_video']):?>
										<img src="<?=IMAGES_URI;?>/logo-renovai.svg" alt="" title="" class="renovai-logo d-block d-md-none w-auto h-auto" width="136" height="28">
										<div class="review-title"><?=$item->post_title;?></div>
									<?php endif;?>
									<?php if($item->cf['testimonial_company_name']):?>
										<div class="review-company"><?=$item->cf['testimonial_company_name'];?></div>
									<?php endif;?>
									<?php if($item->cf['testimonial_company_logo']):?>
										<img src="<?=$item->cf['testimonial_company_logo'];?>" alt="" title="" class="review-logo d-none d-md-block w-auto h-auto" width="136" height="28">
									<?php endif;?>
									<?php if($item->cf['testimonial_company_logo_mobile']):?>
										<img src="<?=$item->cf['testimonial_company_logo_mobile'];?>" alt="" title="" class="review-logo d-block d-md-none w-auto h-auto" width="136" height="28">
									<?php endif;?>
									<?php if(!$item->cf['testimonial_user_quote_video']):?>
										<div class="review-title"><b><?=$item->post_title;?> /</b> <span><?=$item->cf['testimonial_job_title'];?></span></div>
										<div class="review-content"><?=$item->cf['testimonial_user_quote'];?></div>
									<?php endif;?>
								</div>
							</div>
						</li>
					<?php endforeach;?>
				</ul>
			</div>
		</div>
	<?php endif; ?>
	
	<?php if(count($section_data['section_badge_images'])):?>
		<div class="container-fluid mt-30 mt-md-100">
			<div class="badges badges-carousel d-flex justify-content-between align-items-center flex-nowrap max-w-1100 m-auto">
			<?php
				$pattern_1 = '<a href="%s" target="_blank"><img src="%s" alt="" title="" width="158" height="152" class="w-auto h-auto"></a>';
				$pattern_2 = '<img src="%s" alt="" title="" width="158" height="152" class="w-auto h-auto">';
			?>
			<?php foreach($section_data['section_badge_images'] as $item):?>
				<?=(!empty($item['link']) ? sprintf($pattern_1, $item['link'], $item['image']) : sprintf($pattern_2, $item['image']));?>
			<?php endforeach;?>
			</div>
		</div>
	<?php endif;?>
</section>

<?php
echo Functions::render_modal_custom([
	'template' => MODALS_PATH.'/video-preview',
	'size' => 4, // 1,2,3,4
	'id' => 'videoPreviewModal',
	'class' => 'video-preview-modal light-errors',
	'modal_params' => [],
	'form_title' => '',
	'form' => '',
]);
