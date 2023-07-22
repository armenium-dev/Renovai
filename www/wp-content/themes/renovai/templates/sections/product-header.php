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
							<div class="mobile-content d-lg-none pt-6 pb-3">
								<img class="w-100 h-auto" src="<?=$section_data['section_mobile_image'];?>" alt="" title="">
							</div>
						<?php endif;?>

						<?php if($section_data['section_desktop_illustration_type'] == 'image'):?>
							<div class="tablet-container d-none d-lg-inline-block">
								<img class="w-100 h-auto" src="<?=$section_data['section_desktop_image'];?>" alt="" title="">
							</div>
						<?php elseif($section_data['section_desktop_illustration_type'] == 'video'):?>
							<div class="tablet-container d-none d-lg-inline-block">
								<div class="video-carousel play">
									<div class="poster" style="background-image: url(<?=$section_data['section_desktop_video_poster'];?>);"></div>
									<video class="w-100" autoplay muted loop>
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
								<button class="lifestyle-btn" data-trigger="js_action_click" data-action="generate_lifestyle_image">
									<svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M17.9337 9.10195C18.5003 9.2908 18.5003 10.0909 17.9337 10.2797L14.6081 11.3871C13.8771 11.6309 13.2129 12.0415 12.6681 12.5866C12.1233 13.1316 11.713 13.7961 11.4697 14.5273L10.3623 17.8511C10.1734 18.4177 9.37337 18.4177 9.18452 17.8511L8.07713 14.5256C7.83338 13.7945 7.42271 13.1303 6.87765 12.5855C6.3326 12.0408 5.66815 11.6305 4.93697 11.3871L1.6131 10.2797C1.48903 10.239 1.381 10.1601 1.3044 10.0544C1.22781 9.94865 1.18657 9.82141 1.18657 9.69084C1.18657 9.56026 1.22781 9.43302 1.3044 9.32727C1.381 9.22152 1.48903 9.14266 1.6131 9.10195L4.93868 7.99456C5.66955 7.75099 6.33365 7.34057 6.8784 6.79583C7.42314 6.25109 7.83356 5.58698 8.07713 4.85612L9.18452 1.53053C9.22523 1.40646 9.30409 1.29843 9.40984 1.22184C9.51559 1.14524 9.64283 1.104 9.77341 1.104C9.90398 1.104 10.0312 1.14524 10.137 1.22184C10.2427 1.29843 10.3216 1.40646 10.3623 1.53053L11.4697 4.85612C11.7133 5.58698 12.1237 6.25109 12.6684 6.79583C13.2132 7.34057 13.8773 7.75099 14.6081 7.99456L17.9337 9.10195Z" fill="white"/>
										<path d="M23.9992 19.2985C24.2812 19.3925 24.2812 19.7908 23.9992 19.8849L22.3436 20.4361C21.9796 20.5575 21.649 20.7619 21.3778 21.0333C21.1066 21.3046 20.9023 21.6354 20.7812 21.9994L20.2299 23.6541C20.1358 23.9362 19.7375 23.9362 19.6435 23.6541L19.0922 21.9986C18.9709 21.6346 18.7664 21.304 18.4951 21.0328C18.2238 20.7616 17.893 20.5573 17.529 20.4361L15.8742 19.8849C15.8125 19.8646 15.7587 19.8253 15.7206 19.7727C15.6824 19.72 15.6619 19.6567 15.6619 19.5917C15.6619 19.5267 15.6824 19.4633 15.7206 19.4107C15.7587 19.358 15.8125 19.3188 15.8742 19.2985L17.5298 18.7472C17.8937 18.626 18.2243 18.4217 18.4955 18.1505C18.7667 17.8793 18.971 17.5487 19.0922 17.1848L19.6435 15.5292C19.6638 15.4675 19.7031 15.4137 19.7557 15.3756C19.8083 15.3374 19.8717 15.3169 19.9367 15.3169C20.0017 15.3169 20.065 15.3374 20.1177 15.3756C20.1703 15.4137 20.2096 15.4675 20.2299 15.5292L20.7812 17.1848C20.9024 17.5487 21.1067 17.8793 21.3779 18.1505C21.6491 18.4217 21.9797 18.626 22.3436 18.7472L23.9992 19.2985Z" fill="white"/>
									</svg>
									<span><?=__('Generate lifestyle image');?></span>
								</button>
							</div>
						<?php endif;?>
				
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
