<?php
/**
 * Shows a simple single post
 */

use Digidez\DataSource;
use Digidez\Functions;
use Digidez\Helper;

$job_popup_params = get_field('job_popup_params', 'option');

$parent_cf = DataSource::get_cpt_custom_fields(DataSource::get_page_id_by_template_name(PAGE_TEMPLATES_PATH.'career.php'));
#Helper::_debug($parent_cf);

$request_form_title = get_field('single_job_request_form_title', 'option');
$request_form = get_field('single_job_request_form', 'option');
$single_job_main_title = get_field('single_job_main_title', 'option');
if(!empty($single_job_main_title)){
	$single_job_main_title = do_shortcode($single_job_main_title);
}

while(have_posts()):
	the_post();
	$post_id = get_the_ID();
	$post_title = get_the_title();
	$cf = get_fields($post_id);
	
	$location_label = [];
	$location_label[] = $cf['location'];
	if(isset($cf['job_remote']) && $cf['job_remote'] == 'Yes'){
		$location_label[] = 'Remote';
	}
	$location_label = implode(' / ', $location_label);
	#Helper::_debug($cf);
?>
	<section id="job-<?=$post_id;?>" class="job-application-section bg-gradient-blue">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-12 col-xxl-9">
					<div class="row">
						<div class="col-12 col-md-10">
							<h1 class="h1 mb-3"><?=$single_job_main_title;?></h1>
							<h2 class="h2 text-purple3 mb-4"><?=$post_title;?></h2>
							<ul class="list-vacation mb-7">
								<li><i class="i i-time i-sm mr-md-3 mr-2"></i><?=$cf['types_of_work_schedules'];?></li>
								<li><i class="i i-map-point i-sm mr-md-3 mr-2"></i><?=$location_label;?></li>
								<li><i class="i i-pan i-sm mr-md-3 mr-2"></i><a role="button" href="javascript:void(0);" data-trigger="js_action_click" data-action="scroll_to_el" data-target="#apply_form">Apply here</a></li>
							</ul>
							<div class="sm-toggle-position"></div>
							<h2 class="h2 mb-4"><?=$cf['description_title'];?></h2>
							<?=$cf['description_content'];?>
							<h2 class="h2 mb-4 mt-7"><?=$cf['responsibilities_title'];?></h2>
							<?=$cf['responsibilities_content'];?>
							<h2 class="h2 mb-4 mt-7"><?=$cf['requirements_title'];?></h2>
							<?=$cf['requirements_content'];?>
							<div id="apply_form"></div>
							<h2 class="h2 mb-4 mt-7"><?=$request_form_title;?></h2>
							<?=do_shortcode($request_form);?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php endwhile;?>
<?=Functions::get_template_part(SECTIONS_PATH.'/request-a-demo', ['section_name' => 'request_a_demo', 'section_data' => $parent_cf['section_request_a_demo']], false);?>
<?=Functions::render_modal_custom([
	'template' => MODALS_PATH.'/job-application',
	'size' => 4, // 1,2,3,4
	'id' => 'jobApplicationModal',
	'class' => 'job-application-modal',
	'modal_params' => [],
	'title' => $job_popup_params['popup_title'],
	'content' => $job_popup_params['popup_content'],
	'button' => $job_popup_params['popup_button'],
]);?>
