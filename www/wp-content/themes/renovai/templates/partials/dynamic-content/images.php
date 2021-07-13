<div id="<?=$sub_id;?>" class="col-12 position-relative mb-5 mb-xl-0">
	<div class="hyper-personalizes"></div>
	<div class="row align-items-center justify-content-center flex-column flex-xl-row align-items-xl-end">
		<?php if(!empty($item_data['image_1'])):?>
			<div class="col-auto col-about-auto pl-xl-0"><img class="img-fluid" src="<?=$item_data['image_1'];?>" alt="" title=""></div>
		<?php endif;?>
		<?php if(!empty($item_data['image_2'])):?>
			<div class="col-auto col-about-auto"><img class="img-fluid" src="<?=$item_data['image_2'];?>" alt="" title=""></div>
		<?php endif;?>
		<?php if(!empty($item_data['image_3'])):?>
			<div class="col-auto col-about-auto pr-xl-0"><img class="img-fluid" src="<?=$item_data['image_3'];?>" alt="" title=""></div>
		<?php endif;?>
	</div>
</div>
