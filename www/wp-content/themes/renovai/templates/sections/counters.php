<section id="<?=$section_name;?>-section" class="py-2 py-md-10 counter-section-rcsar rcsar">
	<div class="container">
		<div class="row">
			<div class="col-12 col-xxl-8 offset-xxl-2">
				<h2 class="text-center mb-3 mb-md-9 h1 text-secondary"><?=$section_data['section_title'];?></h2>
				<?php if(count($section_data['section_items'])):?>
					<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 counters">
						<?php foreach($section_data['section_items'] as $item):?>
							<div class="col text-center mb-5 mb-lg-0">
								<div class="h1" data-counter="<?=$item['max_value'];?>" data-suffix="<?=$item['prefix'];?>" data-prefix="<?=$item['suffix'];?>"></div>
								<div class="h5"><?=$item['title'];?></div>
							</div>
						<?php endforeach;?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
