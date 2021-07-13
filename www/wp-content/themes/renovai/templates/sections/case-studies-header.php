<?php
use Digidez\Functions;
use Digidez\Helper;

#Helper::_debug($section_data);

?>
<section id="<?=$section_name;?>-section" class="case-studies-header-section text-white position-relative">
	<div class="case-studies-header-container">
		<div class="container h-100">
			<div class="row h-100">
				<div class="col-12 col-xxl-8 offset-xxl-2 h-100">
					<div class="row h-100 align-items-center">
						<div class="col-12 col-lg-8 col-xl-6 mb-md-10">
							<h1 class="h1"><?=$section_data['section_title'];?></h1>
							<p><?=$section_data['section_content'];?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<img class="case-studies-header-img" src="<?=$section_data['section_image'];?>" alt="" title="">
</section>
