<?php
use Digidez\Functions;
use Digidez\DataSource;
use Digidez\Helper;

$bg = IMAGES_URI.'/spacer.gif';
if(has_post_thumbnail($_post)){
	$bg = Functions::get_the_post_thumbnail($_post->ID, '825x551', ['alt' => $_post->post_title, 'title' => $_post->post_title], false, false);
}
$link = get_permalink($_post);
$wp_tag_cloud = DataSource::get_tag_cloud(['post_id' => $_post->ID]);
#Helper::_debug($wp_tag_cloud);
?>
<div class="media first-item align-items-stretch flex-column flex-lg-row">
    <div class="image">
        <div class="title">
            <a href="<?=$link;?>" title="<?=$_post->post_title;?>"
               onclick="ga('send', 'event', 'Blog Post View', 'click', '<?=$_post->post_title;?>');"><?=$_post->post_title;?></a>
        </div>
        <div class="img" style="background-image: url(<?=$bg;?>);"></div>
    </div>
    <div class="body d-flex flex-column">
        <div class="d-flex justify-content-between align-items-center mb-25">
            <div class="tag-cloud">
				<?php
                if(!empty($wp_tag_cloud)):
                    foreach($wp_tag_cloud as $tag):
                        printf('<a href="%1$s"%2$s class="%3$s" style="%4$s"%5$s>%6$s</a>',
                            esc_url(('#' !== $tag->link) ? $tag->link : '#'),
                            ('#' !== $tag->link ? '' : ' role="button"'),
                            esc_attr('link tag-link-'.$tag->id),
                            sprintf('background-color: %s; color: %s;', $tag->bg_color, $tag->fg_color),
                            sprintf(' aria-label="%1$s"', esc_attr($tag->name)),
                            esc_html($tag->name)
                        );
                    endforeach;
				endif;
                ?>
            </div>
            <div class="read-time"><?=$_post->cf['post_read_time'];?></div>
        </div>
        <div class="h3">
            <a class="text-decoration-none" href="<?=$link;?>" title="<?=$_post->post_title;?>"
               onclick="ga('send', 'event', 'Blog Post View', 'click', '<?=$_post->post_title;?>');"><?=Functions::create_excerpt($_post->cf['post_subtitle'], 50);?></a>
        </div>
        <p><?=$_post->cf['post_excerpt'];?></p>
        <div class="mt-auto d-flex justify-content-between align-items-center">
            <div class="avatar"><img src="<?=$_post->post_author['avatar_src'];?>" alt="" title=""><b><?=$_post->post_author['name'];?></b></div>
            <div class="published"><?=get_post_time('d F, Y', false, $_post);?></div>
            <a class="item-link" href="<?=$link;?>" title="<?=$_post->post_title;?>" data-trigger="-ga"
               onclick="ga('send', 'event', 'Blog Post View', 'click', '<?=$_post->post_title;?>');">Read more</a>
        </div>
    </div>
</div>
