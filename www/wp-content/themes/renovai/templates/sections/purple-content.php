<?php
use Digidez\Functions;
use Digidez\Helper;

#Helper::_debug($section_data);

?>
<section id="<?=$section_name;?>-section" class="bg-purple3 py-4 pt-lg-8 pb-lg-7 purple-section sm-toggle-position">
	<div class="container text-center">
		<div class="text-white mx-auto mb-3 max-w-780">
			<p><?=$section_data['section_title'];?></p>
			<div class="subtitle"><?=$section_data['section_subtitle'];?></div>
		</div>
		<?=Functions::render_section_button($section_data['section_button'], ['class' => 'btn btn-light shadow d-inline-block d-lg-none']);?>
		<?=Functions::render_section_button($section_data['section_button'], ['class' => 'btn btn-light shadow btn-lg d-none d-lg-inline-block']);?>
	</div>
</section>
