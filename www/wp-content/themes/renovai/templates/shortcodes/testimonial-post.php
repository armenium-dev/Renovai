<?php foreach($items as $item):?>
	<div class="shadow-box">
		<blockquote class="balloon2">
			<p class="tk-aktiv-grotesk-thin"><?=$item->post_excerpt;?></p>
			<div class="name"><?=$item->post_title;?></div>
			<?php if(!empty($item->cf['testimonial_user_position'])):?>
			<div class="position tk-aktiv-grotesk-thin"><?=$item->cf['testimonial_user_position'];?></div>
			<?php endif;?>
		</blockquote>
	</div>
<?php endforeach;?>
