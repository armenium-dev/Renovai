<?php
use Digidez\Functions;

#Functions::_debug($section_data);

?>
<section id="<?=$section_name;?>-section" class="bg-secondary py-4 pt-lg-9 pb-lg-7 itmmb-section sm-toggle-position">
	<div class="container text-center">
		<div class="text-white mb-4">
			<p><?=$section_data['section_title'];?></p>
			<p><b><?=$section_data['section_subtitle'];?></b></p>
		</div>
		<?=Functions::render_section_button($section_data['section_button'], ['class' => 'btn btn-light shadow d-inline-block d-lg-none']);?>
		<?=Functions::render_section_button($section_data['section_button'], ['class' => 'btn btn-light shadow btn-lg d-none d-lg-inline-block']);?>
	</div>
</section>
