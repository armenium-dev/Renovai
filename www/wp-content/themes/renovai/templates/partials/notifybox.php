<?php
use Digidez\Functions;
?>
<?php if(!empty($box_data)):?>
	<div id="js_notify_box" class="notify-box">
		<a role="button" class="close got-it-btn" aria-label="Close"><?=Functions::get_svg_inline(ICONS_DIR.'/icon-close-white.svg');?></a>
		<div class="notify-content"><?=$box_data['text'];?></div>
	</div>
<?php endif;?>

