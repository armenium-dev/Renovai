<?php

use Digidez\DataSource;
use Digidez\Functions;
use Digidez\Helper;

#Helper::_debug($section_data);

#$case_studies_gotit_popup_params = get_field('case_studies_got_it_popup_params', 'option');
#$case_studies_item_popup_params = get_field('case_studies_item_popup_params', 'option');

$order = explode('-', $section_data['order']);
$posts = DataSource::get_case_studies_posts([
	'include_custom_fields' => true,
	'remove_post_content' => true,
	'posts_per_page' => $section_data['posts_per_page'],
	'orderby' => $order[0],
	'order' => strtoupper($order[1]),
]);
#Helper::_debug($posts->posts);
?>
<section id="<?=$section_name;?>-section" class="case-studies-content-section sm-toggle-position">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-xxl-9">
				<?php if($posts->found_posts):?>
				<div class="row">
					<?php foreach($posts->posts as $_post):?>
						<?php Functions::get_template_part(PARTIALS_PATH.'/case-studies/item', [
							'section_name' => $section_name,
							'section_data' => $section_data,
							'_post' => $_post
						]);?>
					<?php endforeach;?>
				</div>
				<?php endif;?>
			</div>
		</div>
	</div>
</section>
<?php
echo Functions::render_modal_custom([
	'template' => MODALS_PATH.'/case-studies-item',
	'size' => 4, // 1,2,3,4
	'id' => 'caseStudiesItemModal',
	'class' => 'case-studies-item-modal light-errors',
	'modal_params' => [],
	'form_title' => $section_data['item_popup']['request_form_title'],
	'form' => $section_data['item_popup']['request_form'],
]);

echo Functions::render_modal_custom([
	'template'     => MODALS_PATH.'/case-studies-gotit',
	'size'         => 4, // 1,2,3,4
	'id'           => 'caseStudiesGotItModal',
	'class'        => 'case-studies-item-modal',
	'modal_params' => [],
	'title'        => $section_data['got_it_popup']['popup_title'],
	'content'      => $section_data['got_it_popup']['popup_content'],
	'button'       => $section_data['got_it_popup']['popup_button'],
	'logo'         => $section_data['got_it_popup']['popup_logo'],
]);

echo Functions::render_modal_custom([
	'template'     => MODALS_PATH.'/case-studies-download',
	'size'         => 4, // 1,2,3,4
	'id'           => 'caseStudiesDownloadModal',
	'class'        => 'case-studies-item-modal',
	'modal_params' => [],
	'image'        => $section_data['download_popup']['popup_image'],
	'content'      => $section_data['download_popup']['popup_content'],
	'logo'         => $section_data['download_popup']['popup_logo'],
]);
