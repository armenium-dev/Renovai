<?php
use Digidez\Functions;
use Digidez\Helper;

#Helper::_debug($section_data);

?>
<section id="<?=$section_name;?>-section" class="news-header-section">
	<div class="news-header-container">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-12 col-xxl-9">
					<div class="row">
						<div class="col-12 col-md-6 news-header-content">
							<h1 class="h1"><?=$section_data['section_title'];?></h1>
							<p><?=$section_data['section_content'];?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
