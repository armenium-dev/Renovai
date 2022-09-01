<?php

use Digidez\Functions;

$collapse_btn = '';
$description = $item['content'];
if(!empty($item['collapsable_content'])){
	$description = trim($description, '.').'.';
	$collapse_btn = '<button class="collapse-btn" data-trigger="js_action_click" data-action="toggle_description"><svg width="12" height="7" viewBox="0 0 12 7" fill="#0D0D30" xmlns="http://www.w3.org/2000/svg"><path fill="" fill-rule="evenodd" clip-rule="evenodd" d="M6.66989 6.62503L6 5.93078L5.33011 6.62503C5.70008 7.00845 6.29992 7.00845 6.66989 6.62503ZM5.7889 0.000165939H1.61726C0.922522 0.000165939 1.52252 0.000165939 0.277478 0.000165939C-0.0924926 0.383589 -0.0924926 1.00524 0.277478 1.38867L5.33011 6.62503L6 5.93078L6.66989 6.62503L11.7225 1.38867C12.0925 1.00524 12.0925 0.383589 11.7225 0.000165939C11.1225 0.000146866 11.1225 0.000146866 10.3827 0.000165939H5.7889Z"/></svg></button>';
}
?>
<div class="col-12 col-lg-6 mt-lg-10 order-2">
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
<div class="col-12 col-lg-5 offset-lg-1 mt-lg-10 order-3 pt-4 pt-lg-0">
	<h2 class="h2"><?=$item['title'];?></h2>
    <p class="js_dyn_desc">
		<?=$item['content'];?>
		<?php if(!empty($item['collapsable_content'])):?>
            <span class="js_hidden_desc d-none"><br><?=$item['collapsable_content'];?></span>
		<?php endif;?>
		<?=$collapse_btn;?>
    </p>
	<?=Functions::render_section_button($item['button'], ['class' => 'mt-4 shadow btn btn-primary']);?>
</div>
