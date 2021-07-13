<?php

use Digidez\Functions;

global $post;
//Functions::_debug($post->cf['gallery_item_options']['products_collection']);

$link = get_permalink($post->ID);
$categories = get_the_category($post->ID);
$blog_image_placeholder_id = get_field('blog_image_placeholder', 'option');
#Functions::_debug($categories);
$cats = array();
foreach($categories as $cat){
	$cats[] = $cat->name;
}
?>
<article id="post-<?=$post->ID;?>" <?php post_class('flex-col col-xs-12 col-sm-6 col-md-4'); ?>>
	<div class="item">
		<a href="<?=$link;?>">
			<figure>
				<?php if(has_post_thumbnail()):?>
					<?=Functions::get_the_post_thumbnail($post->ID, '767x480', array('alt' => get_the_title()));?>
				<?php else:?>
					<?=Functions::get_the_attachment_thumbnail($blog_image_placeholder_id, '767x480', array('alt' => get_the_title()));?>
				<?php endif;?>
				<span class="overlay"></span>
			</figure>
		</a>
		<div class="content">
			<h2 class="entry-title"><a href="<?=$link;?>"><?php the_title();?></a></h2>
			<p class="post-meta">By <span class="author vcard"><?php the_author();?></span> | <span class="published"><?php the_time('F j, Y');?></span></p>
			<div class="post-content"><?=Functions::create_excerpt($post->post_content, 300);?></div>
		</div>

	</div>
</article>