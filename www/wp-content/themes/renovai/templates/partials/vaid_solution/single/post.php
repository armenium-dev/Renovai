<?php
/**
 * Shows a simple single post
 */

use Digidez\DataSource;
use Digidez\Functions;
use Digidez\Helper;

$vaid_solution_section_request_a_demo = get_field('vaid_solution_section_request_a_demo', 'option');
$vaid_solution_section_advantages = get_field('vaid_solution_section_advantages', 'option');

#Helper::_debug($vaid_solution_section_advantages);

while(have_posts()):
	the_post();
	$post_id = get_the_ID();
	$post_title = get_the_title();
	$cf = get_fields($post_id);
	#Helper::_debug($cf);
	$style = $cf['section_first_item_style'] == 'dark' ? '' : 'row-chessboard-reverse';
	$btn_style = $cf['section_first_item_style'] == 'dark' ? 'btn-light' : 'btn-primary';
	$section_small_images_direct_link = (bool) $cf['section_small_images_direct_link'];

    $option_h1_title_field = $cf['option_h1_title_field'];
    switch($option_h1_title_field){
        case "page_title":
			$page_title_tag = 'h1';
			$sub_title_tag = 'p';
            break;
        case "subtitle":
			$page_title_tag = 'div';
			$sub_title_tag = 'h1';
            break;
        default:
            $page_title_tag = 'h1';
            $sub_title_tag = 'p';
            break;
    }
?>
	<section id="vaids-<?=$post_id;?>" class="vaids-section bg-primary">
		<div class="container lp-container text-center pb-5 pb-md-0">
			<img class="img-fluid mb-6" src="<?=$cf['section_icon'];?>" alt="" title="">
			<<?=$page_title_tag;?> class="h1 mb-3"><small>renovai</small><span><?=$post_title;?></span></<?=$page_title_tag;?>>
			<<?=$sub_title_tag;?> class="mb-8 subtitle"><?=$cf['section_subtitle'];?></<?=$sub_title_tag;?>>
			<?=Functions::render_section_button($cf['section_button'], ['class' => 'btn btn-light']);?>
		</div>
	</section>
	<section class="bg-gradient-blue pt-5 pb-6 sm-toggle-position">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-12 col-xxl-9">
					<div class="row">
						<div class="col-12">
							<div class="text-center mb-7 lp-title-block">
								<p>renovai</p>
								<h2 class="h2"><?=str_replace('{POST_TITLE}', $post_title, $cf['section_title']);?></h2>
							</div>
							<div class="d-flex justify-content-between flex-column flex-md-row">
								<?php foreach($cf['section_items'] as $k => $item):?>
								<div class="text-center mb-5 lp-list-item">
                                    <?php if($section_small_images_direct_link):
									$link = Functions::render_section_button($item['button'], [], true);?>
									<a role="link" href="<?=$link;?>">
                                    <?php else:?>
									<a role="button" data-trigger="js_action_click" data-action="scroll_to_el" data-target="#item_<?=$k;?>">
									<?php endif;?>
										<img class="img-fluid mb-3" src="<?=$item['small_image'];?>" alt="" title="">
										<p><?=$item['small_image_caption'];?></p>
									</a>
								</div>
								<?php endforeach;?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section>
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-12 col-xxl-9">
					<div class="row">
						<div class="col-12">
							<div class="row row-chessboard <?=$style;?>">
								<?php foreach($cf['section_items'] as $k => $item):?>
									<?php if($k % 2 == 1):?>
										<div class="col-12 col-md-6 col-chessboard">
											<?php if($item['big_media_type'] == 'image'):?>
												<?php if(!empty($item['big_image'])):?>
													<img class="img-fluid" src="<?=$item['big_image'];?>" alt="" title="">
												<?php endif;?>
											<?php elseif($item['big_media_type'] == 'video'):?>
												<?php if(!empty($item['big_video'])):?>
													<video class="w-100" autoplay muted loop>
														<source src="<?=$item['big_video'];?>">
													</video>
												<?php endif;?>
											<?php endif;?>
										</div>
									<?php endif;?>
								
									<div id="item_<?=$k;?>" class="col-12 col-md-6 col-chessboard">
										<h3 class="h3"><?=$item['title'];?>
											<?php if(!empty($item['sub_title'])):?>
												<p class="sub-title"><?=$item['sub_title'];?></p>
											<?php endif;?>
										</h3>
										<p><?=$item['description'];?></p>
										<div class="mt-3">
											<?=Functions::render_section_button($item['button'], ['class' => 'btn '.$btn_style]);?>
										</div>
									</div>
								
									<?php if($k % 2 == 0):?>
										<div class="col-12 col-md-6 col-chessboard">
											<?php if($item['big_media_type'] == 'image'):?>
												<?php if(!empty($item['big_image'])):?>
													<img class="img-fluid" src="<?=$item['big_image'];?>" alt="" title="">
												<?php endif;?>
											<?php elseif($item['big_media_type'] == 'video'):?>
												<?php if(!empty($item['big_video'])):?>
													<video class="w-100" autoplay muted loop>
														<source src="<?=$item['big_video'];?>">
													</video>
												<?php endif;?>
											<?php endif;?>
										</div>
									<?php endif;?>

									<?php $btn_style = ($btn_style == 'btn-light') ? 'btn-primary' : 'btn-light';?>
								<?php endforeach;?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php endwhile;?>
<?=Functions::get_template_part(SECTIONS_PATH.'/advantages-dark', [
		'section_name' => 'advantages_dark',
		'section_data' => $vaid_solution_section_advantages
], false);?>
<?=Functions::get_template_part(SECTIONS_PATH.'/request-a-demo', [
		'section_name' => 'request_a_demo',
		'section_data' => $vaid_solution_section_request_a_demo
], false);?>
