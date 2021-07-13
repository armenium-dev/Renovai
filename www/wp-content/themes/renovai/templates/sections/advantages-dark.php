<?php

use Digidez\DataSource;
use Digidez\Helper;

#Helper::_debug($section_data);
?>
<section id="<?=$section_name;?>-section" class="tbcfyw-section pt-lg-9 pb-lg-10 bg-primary text-white">
	<div class="title">
		<div class="container">
			<div class="h2 text-center mb-5 mb-lg-9 py-4 py-lg-0"><?=$section_data['section_title'];?></div>
		</div>
	</div>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-xxl-9">
				<?php if(count($section_data['section_items'])):?>
				<div class="row row-cols-md-2 row-cols-lg-3 tbcfyw-carousel overflow-hidden">
					<?php foreach($section_data['section_items'] as $item):?>
						<div class="col">
							<div class="tbcfyw-item-circle solid blue"><img src="<?=$item['icon'];?>" alt="<?=$item['title'];?>" title="<?=$item['title'];?>">
								<h3 class="h3"><?=$item['title'];?></h3>
								<p><?=$item['description'];?></p>
							</div>
						</div>
					<?php endforeach;?>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

