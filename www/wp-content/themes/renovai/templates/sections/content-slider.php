<?php

use Digidez\DataSource;
use Digidez\Functions;
use Digidez\Helper;

$section_data['section_items'] = DataSource::fill_cpt_cf($section_data['section_items']);
#Helper::_debug($section_data);
?>

<section id="<?=$section_name;?>-section" class="pt-3 pt-md-5 pb-3 pb-lg-7 position-relative bg-primary slider-navy overflow-hidden">
	<div class="container min-vh-100">
		<div class="row align-items-center min-vh-100">
			<div class="col-12 col-xxl-8 offset-xxl-2">
				
				<?php if(count($section_data['section_items'])):?>
					<div class="ren-carousel">
						<div class="ren-carousel-slick-first text-white">
							<?php foreach($section_data['section_items'] as $k => $item): $class = ($k == 0 ? 'active' : '');?>
								<div class="ren-carousel-item">
									<div class="row text-center text-md-left">
										<div class="col-12 order-1 order-md-0 h--100">
											<?php if($item->cf['media_type'] == 'image'):?>
												<img src="<?=$item->cf['image'];?>" class="d-block w-100 mb-2" alt="<?=$item->post_title;?>" title="<?=$item->post_title;?>" />
											<?php elseif($item->cf['media_type'] == 'video'):?>
												<div class="video-carousel">
													<div class="poster" style="background-image: url(<?=$item->cf['video_poster'];?>);"></div>
													<video class="w-100" muted loop>
														<source src="<?=$item->cf['video'];?>">
													</video>
												</div>
											<?php endif;?>
										</div>
										<div class="col-12 order-0 order-md-1">
											<h4 class="h2 mb-2"><?=$item->post_title;?></h4>
										</div>
									</div>
								</div>
							<?php endforeach;?>
						</div>
						<div class="ren-carousel-indicators my-4 my-md-0"></div>
						<div class="ren-carousel-slick-second text-white">
							<?php foreach($section_data['section_items'] as $k => $item): $class = ($k == 0 ? 'active' : '');?>
								<div class="ren-carousel-item">
									<div class="row text-center text-md-left">
										<div class="col-12 col-md-10 order-2">
											<div class="h5 mb-2"><?=$item->cf['content'];?></div>
											<?=Functions::render_section_button($item->cf['button'], ['class' => 'btn btn-pink btn-icon', 'icon' => '<i class="i i-sm i-right-arrow"></i>']);?>
										</div>
									</div>
								</div>
							<?php endforeach;?>
						</div>
					</div>
				<?php endif; ?>
				
			</div>
		</div>
	</div>
</section>
