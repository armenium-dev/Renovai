<?php

use Digidez\Functions;
use Digidez\Helper;

#Helper::_debug($_post->cf['case_study_download_file']);

#$download_attr = !empty($_post->cf['case_study_download_file']) ? 'download' : '';
$download_link = !empty($_post->cf['case_study_download_file']) ? $_post->cf['case_study_download_file'] : '#';
?>

<div class="col-12 col-xl-10 offset-xl-1 mb-6 mb-md-10">
	<div class="media shadow bg-white flex-column flex-lg-row align-items-stretch">
		<div class="case-studies-img d-flex align-items-center justify-content-center" style="background-image: url(<?=$_post->cf['case_study_image'];?>)">
			<img class="mt-3 mt-lg-0 mb-3 mb-lg-0" src="<?=$_post->cf['case_study_big_logo'];?>" alt="" title="">
		</div>
		<div class="media-body" data-case="<?=$_post->post_title;?>">
			<img class="d-none" data-src="logo" src="<?=$_post->cf['case_study_big_logo'];?>" alt="" title="">
			<img class="mb-3" src="<?=$_post->cf['case_study_small_logo'];?>" alt="" title="">
			<h2 class="h2" data-src="title"><?=$_post->cf['case_study_title'];?></h2>
			<p data-src="content"><?=$_post->cf['case_study_description'];?></p>
			<div class="text-left text-lg-right">
				<a class="btn btn-secondary btn-icon shadow" href="#"
				   data-trigger="js_action_click"
				   data-action="open_case_modal"
				   data-target="#caseStudiesItemModal"
				   data-download="<?=$download_link;?>">
					<span><?=$section_data['button_label'];?></span>
					<i class="i i-sm i-right-arrow"></i>
				</a>
			</div>
		</div>
	</div>
</div>
