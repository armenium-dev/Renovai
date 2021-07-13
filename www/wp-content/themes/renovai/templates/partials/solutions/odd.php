<?php

use Digidez\Functions;

?>
<div class="col-12 col-lg-5 mb-lg-10 pt-lg-7 order-1 pt-4 mb-7 order-lg-0">
	<h2 class="h2"><?=$item['title'];?></h2>
	<p><?=$item['content'];?></p>
	<?=Functions::render_section_button($item['button'], ['class' => 'mt-4 shadow btn btn-primary']);?>
</div>
<div class="col-12 col-lg-6 text-lg-right offset-lg-1 mb-lg-10 pt-lg-7 order-0 order-lg-1">
	<?php if($item['mobile_image_type'] == 'gallery' && !empty($item['mobile_gallery'])):?>
		<div class="solution-carousel overflow-hidden">
			<?php foreach($item['mobile_gallery'] as $gallery_image_url):?>
				<img class="img-fluid img-static" src="<?=$gallery_image_url;?>" alt="" title="">
			<?php endforeach;?>
		</div>
	<?php else:?>
		<img class="img-fluid d-md-none" src="<?=$item['mobile_image'];?>" alt="<?=$item['title'];?>" title="<?=$item['title'];?>">
	<?php endif;?>
	<img class="img-fluid img-static d-none d-md-inline-block" src="<?=$item['desktop_image'];?>" alt="<?=$item['title'];?>" title="<?=$item['title'];?>">
</div>
