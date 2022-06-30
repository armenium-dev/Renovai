<?php
use Digidez\Functions;
use Digidez\Helper;
use Digidez\DataSource;

$wp_tag_cloud = DataSource::get_tag_cloud();
#Helper::_debug($wp_tag_cloud);
?>
<section id="<?=$section_name;?>-section" class="blog-header-section position-relative">
	<div class="blog-header-container">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-12 col-xxl-9">
					<div class="row">
						<div class="col-12 col-lg-8 col-xl-6 blog-header-content">
							<h1 class="h1"><?=$section_data['section_title'];?></h1>
							<p><?=$section_data['section_content'];?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<img class="blog-header-img" src="<?=$section_data['section_image'];?>" alt="" title="">
</section>

