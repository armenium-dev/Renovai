<?php

use Digidez\Functions;

$post_link = get_permalink($post);
?>
<div class="blog-last-post">
	<h2 class="title"><a href="<?=$post_link;?>"><?=$post->post_title;?></a></h2>
	<div class="meta tk-aktiv-grotesk-thin">
		<div class="author"><?=$post->author['name'];?></div>
		<div class="sep">|</div>
		<div class="published"><?=date('M d, Y', strtotime($post->post_date));?></div>
	</div>
	<figure>
		<?php if(has_post_thumbnail($post)):?>
			<a href="<?=$post_link;?>"><?=Functions::get_the_post_thumbnail($post->ID, '200x108', array('alt' => $post->post_title, 'class' => 'thumb'));?></a>
		<?php endif; ?>
	</figure>
	<p class="content tk-aktiv-grotesk-thin">
		<?=Functions::create_excerpt($post->post_content, 300);?>
	</p>
</div>