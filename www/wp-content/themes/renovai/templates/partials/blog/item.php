<?php
use Digidez\Functions;
use Digidez\DataSource;

$bg = IMAGES_URI.'/spacer.gif';
if(has_post_thumbnail($_post)){
	$bg = Functions::get_the_post_thumbnail($_post->ID, '492x260', ['alt' => $_post->post_title, 'title' => $_post->post_title], false, false);
}
$link = get_permalink($_post);
$wp_tag_cloud = DataSource::get_tag_cloud(['post_id' => $_post->ID, 'show_count' => 1]);
$cols_class = !empty($cols_class) ? $cols_class : 'col-12 col-md-6 col-lg-4 col-xl-3';
?>
<div class="<?=$cols_class;?> single-item">
	<div class="media align-items-stretch flex-column">
		<div class="image">
			<div class="img" style="background-image: url(<?=$bg;?>);"></div>
            <div class="tag-cloud position-relative">
				<?php
				if(!empty($wp_tag_cloud)):
					foreach($wp_tag_cloud as $tag):
						printf('<a href="%1$s"%2$s class="%3$s" style="%4$s"%5$s>%6$s</a>',
							esc_url(('#' !== $tag->link) ? $tag->link : '#'),
							('#' !== $tag->link ? '' : ' role="button"'),
							esc_attr('link tag-link-'.$tag->id),
							sprintf('background-color: %s; color: %s;', 'rgba(255, 255, 255, 0.1);', '#fff'),
							sprintf(' aria-label="%1$s"', esc_attr($tag->name)),
							esc_html($tag->name)
						);
					endforeach;
				endif;
				?>
            </div>
            <div class="title">
                <a class="" href="<?=$link;?>" title="<?=$_post->post_title;?>" data-trigger="-ga"
                   onclick="ga('send', 'event', 'Blog Post View', 'click', '<?=$_post->post_title;?>');"><?=$_post->post_title;?></a>
            </div>
		</div>
		<div class="body d-flex flex-column">
			<div class="h3"><?=Functions::create_excerpt($_post->cf['post_subtitle'], $subtitle_length);?></div>
			<div class="d-flex justify-content-between align-items-center mb-16">
				<div class="published"><?=get_post_time('F jS, Y', false, $_post);?></div>
                <div class="read-time"><?=$_post->cf['post_read_time'];?></div>
			</div>
            <p><?=Functions::create_excerpt($_post->cf['post_excerpt'], $excerpt_length);?></p>
			<div class="mt-auto d-flex justify-content-between align-items-center">
				<div class="avatar"><img src="<?=$_post->post_author['avatar_src'];?>" alt="" title=""><b><?=$_post->post_author['name'];?></b></div>
				<a class="item-link" href="<?=$link;?>" title="<?=$_post->post_title;?>" data-trigger="-ga"
				   onclick="ga('send', 'event', 'Blog Post View', 'click', '<?=$_post->post_title;?>');">Read more</a>
			</div>
		</div>
	</div>
</div>
