<div class="shadow-box">
	<?php if(false !== $company_logo):?>
		<figure><img src="<?=$company_logo;?>"></figure>
	<?php endif;?>
	<?php foreach($items as $item):?>
		<blockquote class="balloon2">
			<p class="tk-aktiv-grotesk-thin"><?=$item->post_excerpt;?></p>
		</blockquote>
	<?php endforeach;?>
</div>
