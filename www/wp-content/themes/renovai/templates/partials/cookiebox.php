<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 25.02.2019
 * Time: 11:48
 */
?>
<?php if(!empty($box_data)):?>
	<div class="cookies-box">
		<div class="cookie-content">
			<div>
				<p>
					<?=$box_data['text'];?>
				</p>
			</div>
			<div class="btns-wrapper">
				<a href="javascript:void(0);" class="send-btn got-it-btn"><?=$box_data['button'];?></a>
			</div>
		</div>
	</div>
<?php endif;?>

