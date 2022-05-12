<?php
use Digidez\Functions;
use Digidez\Helper;

#Helper::_debug($section_data);
?>
<section id="<?=$section_name;?>-section" class="bg-experience-renovai d-flex experience-renovai">
	<?php if($section_data['section_display_image']):?>
		<div class="container mt-auto">
			<div class="row">
				<div class="col-12 col-xxl-8 offset-xxl-2">
					<div class="row align-items-start justify-content-center">
						
						<div class="col-12 col-md-8 col-lg-6 align-content-start">
							<div class="text-center d-lg-inline-block mt-6 mt-lg-0 mb-6">
								<div class="h1 mb-4">
									<p><?=$section_data['section_title'];?></p>
								</div>
								<?=Functions::render_section_button($section_data['section_button'], ['class' => 'btn-lg d-none d-md-inline-block shadow btn btn-primary']);?>
								<?=Functions::render_section_button($section_data['section_button'], ['class' => 'd-md-none shadow btn btn-primary']);?>
							</div>
						</div>
						
						<div class="col-12 col-md-8 col-lg-6">
							<div class="text-right">
								<img class="img-fluid" src="<?=$section_data['section_image'];?>" alt="" title="">
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
	<?php else:?>
		<div class="container max-w-420 max-w-xl-550 m-auto text-center wrapper">
			<div class="h1 mb-4"><p><?=$section_data['section_title'];?></p></div>
			<?=Functions::render_section_button($section_data['section_button'], ['class' => 'btn-lg d-none d-md-inline-block shadow btn btn-primary']);?>
			<?=Functions::render_section_button($section_data['section_button'], ['class' => 'd-md-none shadow btn btn-primary']);?>
		</div>
	<?php endif;?>
</section>
