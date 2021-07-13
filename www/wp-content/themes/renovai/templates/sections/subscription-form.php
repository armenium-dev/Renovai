<section id="<?=$section_name;?>-section" class="blog-sign-up-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-xxl-9 text-center">
				<h2 class="h2"><?=$section_data['section_title'];?></h2>
				<p><?=$section_data['section_content'];?></p>
				<div class="row justify-content-center">
					<div class="col-xl-5">
						<?=do_shortcode($section_data['section_form']);?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
