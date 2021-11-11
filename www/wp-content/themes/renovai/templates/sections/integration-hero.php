<?php
use Digidez\Functions;
use Digidez\Helper;

#Helper::_debug($section_data);

?>
<section id="<?=$section_name;?>-section" class="integration-header-section">
	<div class="integration-header-container">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-12 integration-header-content text-center">
					<h1 class="integration-first-screen__title"><?=$section_data['section_title'];?></h1>
					<div class="integration-first-screen__subtitle"><?=$section_data['section_description'];?></div>
				</div>
			</div>
		</div>
	</div>
</section>
