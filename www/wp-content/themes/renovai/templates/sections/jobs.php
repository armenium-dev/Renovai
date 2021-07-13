<?php

use Digidez\DataSource;
use Digidez\Functions;
use Digidez\Helper;

$cats = DataSource::get_cpt_terms('job-cat', ['fields' => 'all', 'include' => $section_data['job_categories'], 'orderby' => 'include'], true);
$posts = DataSource::get_job_posts(['include_term_by_tax' => 'job-cat', 'include_custom_fields' => true, 'remove_post_content' => true, 'sort_posts_by_cats' => true]);
#Helper::_debug($section_data);
$active_cat_id = $section_data['selected_job_category'];
?>
<section id="<?=$section_name;?>-section" class="careers-family-section bg-gradient-blue pt-5 pb-10">
	<div class="container">
		<div class="row">
			<div class="col-12 col-xxl-8 offset-xxl-2">
				<div class="text-center mb-5">
					<h2 class="h2"><?=$section_data['section_title'];?></h2>
				</div>
				<div class="mb-9">
					<img class="careers-family-img img-fluid" src="<?=$section_data['section_image'];?>" alt="" title="">
				</div>
				<div class="mb-6">
					<h3 class="h3"><?=$section_data['jobs_title'];?></h3>
				</div>
				<select class="custom-select select-careers-tab d-md-none">
					<?php foreach($cats as $k => $cat):?>
					<?php $selected = ($active_cat_id == $cat->term_id ? 'selected="selected"' : '');?>
					<option value="<?=$k;?>" <?=$selected;?>><?=$cat->name;?></option>
					<?php endforeach;?>
				</select>
				<ul class="nav nav-pills nav-justified d-none d-md-flex" id="pillsTab" role="tablist">
					<?php foreach($cats as $cat):
						$active_class = '';
						if($active_cat_id == $cat->term_id){
							#if(!empty($posts->posts_by_cats[$cat->term_id])){
								$active_cat_id = $cat->term_id;
								$active_class = 'active';
							#}
						}
					?>
					<li class="nav-item" role="presentation"><a class="nav-link <?=$active_class;?>" data-toggle="pill" href="#<?=$cat->slug;?>" role="tab" aria-controls="<?=$cat->slug;?>" aria-selected="true"><?=$cat->name;?></a></li>
					<?php endforeach;?>
				</ul>
				<div class="tab-content jobs" id="pillsTabContent">
					<?php foreach($cats as $cat):?>
					<?php $active_class = ($cat->term_id == $active_cat_id) ? 'show active' : '';?>
					<div class="tab-pane fade <?=$active_class;?>" id="<?=$cat->slug;?>" role="tabpanel">
						<?php if(empty($posts->posts_by_cats[$cat->term_id])):?>
							<div class="no-vacation">
								<p><?=$section_data['no_jobs_available_text'];?></p>
							</div>
						<?php else:?>
							<?php foreach($posts->posts_by_cats[$cat->term_id] as $_post): $permalink = get_permalink($_post);?>
								<div class="row">
									<div class="col-12 col-md-6">
										<a class="h4 text-decoration-none d-flex justify-content-between align-items-center" href="<?=$permalink;?>">
											<span><?=$_post->post_title;?></span>
											<div class="d-none d-md-inline-block"><i class="i i-double-arrow-right"></i></div>
										</a>
										<ul class="list-vacation">
											<li><i class="i i-time i-sm mr-3"></i><?=$_post->cf['types_of_work_schedules'];?></li>
											<li><i class="i i-map-point i-sm mr-3"></i><?=$_post->cf['location'];?></li>
											<li><i class="i i-pan i-sm mr-3"></i><a href="<?=$permalink;?>">Apply here</a></li>
										</ul>
										<div class="border-bottom pt-3"></div>
									</div>
								</div>
							<?php endforeach;?>
						<?php endif;?>
					</div>
					<?php endforeach;?>
				</div>
			</div>
		</div>
	</div>
</section>


