<?php

use Digidez\DataSource;
use Digidez\Functions;
use Digidez\Helper;

#Helper::_debug($section_data);
?>

<section id="<?=$section_name;?>-section" class="page-not-found-section">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-8">
				<p><small><?=$section_data['sub_title'];?></small></p>
				<p class="h1"><?=$section_data['title'];?></p>
				<p><?=$section_data['content'];?></p>
				<?=Functions::render_section_button($section_data['button'], ['class' => 'btn btn-light shadow']);?>
			</div>
		</div>
	</div>
</section>
