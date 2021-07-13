<?php
use Digidez\Functions;
use Digidez\Helper;

#Helper::_debug($section_data);

?>
<section class="dark-blue-section position-relative">
	<div class="dark-blue-container">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-12 col-xxl-9">
					<div class="row justify-content-center">
						<div class="col-12 text-center dark-blue-content">
							<div class="h1"><?=$section_data['section_title'];?></div>
							<?=$section_data['section_content'];?>
							<a class="btn btn-light" href="#" data-toggle="modal" data-target="#reportsWhitePapersModal"><?=$section_data['section_button_text'];?></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="dark-blue-bg-img" style="background-image: url(<?=$section_data['section_image'];?>)"></div>
</section>

<?=Functions::render_modal_custom([
	'template' => MODALS_PATH.'/reports-item',
	'size' => 4, // 1,2,3,4
	'id' => 'reportsWhitePapersModal',
	'class' => 'job-application-modal light-errors',
	'modal_params' => [],
	'title' => $section_data['item_popup']['modal_title'],
	'form_title' => $section_data['item_popup']['request_form_title'],
	'form' => $section_data['item_popup']['request_form'],
]);?>
<?=Functions::render_modal_custom([
	'template' => MODALS_PATH.'/reports-gotit',
	'size' => 4, // 1,2,3,4
	'id' => 'reportsWhitePapersSendMailModal',
	'class' => 'job-application-modal',
	'modal_params' => [],
	'title' => $section_data['got_it_popup']['popup_title'],
	'content' => $section_data['got_it_popup']['popup_content'],
	'button' => $section_data['got_it_popup']['popup_button'],
]);?>
