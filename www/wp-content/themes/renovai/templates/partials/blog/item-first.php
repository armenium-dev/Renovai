<?php
use Digidez\Functions;

$bg = IMAGES_URI.'/spacer.gif';
if(has_post_thumbnail($_post)){
	$bg = Functions::get_the_post_thumbnail($_post->ID, '598x514', ['alt' => $_post->post_title, 'title' => $_post->post_title], false, false);
}
$link = get_permalink($_post);
?>
<div class="col-12">
	<div class="media first-blog-item align-items-stretch flex-column flex-lg-row">
		<div class="media-body d-flex flex-column order-1 order-lg-0">
			<div class="blog-carousel-item-date d-flex justify-content-between">
				<div><?=get_post_time('F jS, Y', false, $_post);?></div>
			</div>
			<div class="h3"><?=$_post->cf['post_subtitle'];?></div>
			<div class="d-none d-md-block">
				<p><?=$_post->cf['post_excerpt'];?></p>
			</div>
			<div class="mt-auto">
				<a class="text-decoration-underline blog-carousel-item-link d-xl-none" href="<?=$link;?>" title="<?=$_post->post_title;?>" data-trigger="ga">Read more</a>
				<a class="btn btn-secondary shadow btn-icon d-none d-xl-inline-block" href="<?=$link;?>" title="<?=$_post->post_title;?>" data-trigger="ga"><span>Read more</span><i class="i i-sm i-right-arrow"></i></a>
			</div>
		</div>
		<div class="blog-carousel-item-image order-0 order-lg-1">
			<div class="img" style="background-image: url(<?=$bg;?>);"></div>
			<div class="title">
				<div><?=$_post->post_title;?></div>
			</div>
		</div>
		<div class="slide-item-white d-lg-none"></div>
		<div class="slide-item-shadow d-lg-none"></div>
	</div>
</div>
