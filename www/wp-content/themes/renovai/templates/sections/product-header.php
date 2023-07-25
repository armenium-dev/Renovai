<?php
use Digidez\Functions;
use Digidez\Helper;

#Helper::_debug($section_data);

$section_class = ($section_data['section_desktop_illustration_type'] == 'nothing') ? 'without-bg product-header' : 'product-header';

$option_h1_title_field = $section_data['option_h1_title_field'];
switch($option_h1_title_field){
	case "section_title":
		$section_title_tag = 'h1';
		$section_content_tag = 'p';
		break;
	case "section_content":
		$section_title_tag = 'div';
		$section_content_tag = 'h1';
		break;
	default:
		$section_title_tag = 'h1';
		$section_content_tag = 'p';
		break;
}

?>
<section id="<?=$section_name;?>-section" class="<?=$section_class;?>">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-xxl-10">
				<div class="row justify-content-center">
					<div class="col-lg-10 col-xxl-12 text-center">
						<<?=$section_title_tag;?> class="h1"><?=$section_data['section_title'];?></<?=$section_title_tag;?>>
						<<?=$section_content_tag;?> class="section-content"><?=$section_data['section_content'];?></<?=$section_content_tag;?>>
						<div><?=Functions::render_section_button($section_data['section_button'], ['class' => 'btn btn-secondary shadow']);?></div>

						<?php if($section_data['section_desktop_illustration_type'] != 'nothing'):?>
							<?php if(!empty($section_data['section_mobile_image'])):?>
								<div class="mobile-content d-lg-none pt-6 pb-3">
									<img class="w-100 h-auto" src="<?=$section_data['section_mobile_image'];?>" alt="" title="">
								</div>
							<?php endif;?>
						<?php endif;?>

						<?php if($section_data['section_desktop_illustration_type'] == 'image'):?>
							<div class="tablet-container d-none d-lg-inline-block">
								<img class="w-100 h-auto" src="<?=$section_data['section_desktop_image'];?>" alt="" title="">
							</div>
						<?php elseif($section_data['section_desktop_illustration_type'] == 'video'):?>
							<div class="tablet-container d-none d-lg-inline-block">
								<div class="video-carousel play">
									<div class="poster" style="background-image: url(<?=$section_data['section_desktop_video_poster'];?>);"></div>
									<video class="w-100" autoplay muted loop controls>
										<source src="<?=$section_data['section_desktop_video'];?>">
									</video>
								</div>
							</div>
						<?php endif;?>
				
						<?php if($section_data['section_desktop_illustration_type'] == 'lifestyle_image'):?>
							<div id="js_lifestyle_generator" class="lifestyle-generator">
								<div id="js_dst_images" class="dst-images">
									<?php foreach($section_data['section_destination_images'] as $image_url):?>
										<img class="" src="<?=$image_url;?>">
									<?php endforeach;?>
								</div>
								<div id="js_source_images" class="source-images">
									<?php foreach($section_data['section_source_images'] as $k => $image_url):?>
										<img class="img-<?=$k;?>" src="<?=$image_url;?>">
									<?php endforeach;?>
								</div>
								<a class="lifestyle-btn" href="/book-a-demo/">
									<span><?=__('Book a Demo');?></span>
								</a>
							</div>
						<?php endif;?>
				
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
