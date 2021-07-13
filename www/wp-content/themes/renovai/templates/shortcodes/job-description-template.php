<?php
use Digidez\Functions;

#Functions::_debug($post_id);
#Functions::_debug($post_cf);
?>

<div id="job_description_<?=$post_id;?>" class="job-description-template">
	<div class="heading">
		<div class="title"><?=$post_cf['template_window_title'];?></div>
		<button type="button" class="button js_copy_to_clipboard" data-clipboard-target="#copy_text_<?=$post_id;?>"><?=$post_cf['template_window_button_text'];?></button>
	</div>
	<div id="copy_text_<?=$post_id;?>" class="content">
		<?=$post_cf['template_content'];?>
	</div>
</div>
