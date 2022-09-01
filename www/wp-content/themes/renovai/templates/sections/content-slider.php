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
                                                    <?php if(!empty($item->cf['json_scheme'])):?>
													    <?=str_replace('{VIDEO_FILE_URL}', $item->cf['video'], $item->cf['json_scheme']);?>
                                                    <?php endif;?>
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
							<?php foreach($section_data['section_items'] as $k => $item):
                                $class = ($k == 0 ? 'active' : '');
								$collapse_btn = '';
								$description = $item->cf['content'];
								if(!empty($item->cf['collapsable_content'])){
									$description = trim($description, '.').'.';
									$collapse_btn = '<button class="collapse-btn" data-trigger="js_action_click" data-action="toggle_description"><svg width="12" height="7" viewBox="0 0 12 7" fill="#fff" xmlns="http://www.w3.org/2000/svg"><path fill="" fill-rule="evenodd" clip-rule="evenodd" d="M6.66989 6.62503L6 5.93078L5.33011 6.62503C5.70008 7.00845 6.29992 7.00845 6.66989 6.62503ZM5.7889 0.000165939H1.61726C0.922522 0.000165939 1.52252 0.000165939 0.277478 0.000165939C-0.0924926 0.383589 -0.0924926 1.00524 0.277478 1.38867L5.33011 6.62503L6 5.93078L6.66989 6.62503L11.7225 1.38867C12.0925 1.00524 12.0925 0.383589 11.7225 0.000165939C11.1225 0.000146866 11.1225 0.000146866 10.3827 0.000165939H5.7889Z"/></svg></button>';
								}
                            ?>
								<div class="ren-carousel-item">
									<div class="row text-center text-md-left">
										<div class="col-12 col-md-10 order-2">
											<div class="js_dyn_desc h5 mb-2">
                                                <?=$item->cf['content'];?>
												<?php if(!empty($item->cf['collapsable_content'])):?>
                                                    <span class="js_hidden_desc d-none"><br><?=$item->cf['collapsable_content'];?></span>
												<?php endif;?>
												<?=$collapse_btn;?>
                                            </div>
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
