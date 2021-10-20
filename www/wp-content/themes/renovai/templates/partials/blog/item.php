<?php
use Digidez\Functions;

$bg = IMAGES_URI.'/spacer.gif';
if(has_post_thumbnail($_post)){
	$bg = Functions::get_the_post_thumbnail($_post->ID, '492x260', ['alt' => $_post->post_title, 'title' => $_post->post_title], false, false);
}
$link = get_permalink($_post);
?>
<div class="col-md-6">
	<div class="media align-items-stretch flex-column">
		<div class="blog-carousel-item-image">
			<div class="img" style="background-image: url(<?=$bg;?>);"></div>
			<div class="title">
				<div><?=$_post->post_title;?></div>
			</div>
		</div>
		<div class="media-body d-flex flex-column">
			<div class="blog-carousel-item-date d-flex justify-content-between">
				<div><?=$_post->cf['post_read_time'];?></div>
				<div><?=get_post_time('F jS, Y', false, $_post);?></div>
			</div>
			<div class="h3"><?=Functions::create_excerpt($_post->cf['post_subtitle'], $subtitle_length);?></div>
			<div class="d-none d-md-block">
				<p><?=Functions::create_excerpt($_post->cf['post_excerpt'], $excerpt_length);?></p>
			</div>
			<div class="mt-auto d-flex justify-content-between align-items-center">
				<div class="avatar"><img src="<?=$_post->post_author['avatar_src'];?>" alt="" title=""><b><?=$_post->post_author['name'];?></b></div>
				<a class="text-decoration-underline blog-carousel-item-link" href="<?=$link;?>" title="<?=$_post->post_title;?>" data-trigger="-ga"
				   onclick="ga('send', 'event', 'Blog Post View', 'click', '<?=$_post->post_title;?>');">Read more</a>
			</div>
		</div>
		<div class="slide-item-white"></div>
		<div class="slide-item-shadow"></div>
	</div>
</div>
