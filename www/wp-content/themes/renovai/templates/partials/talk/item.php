<?php
use Digidez\Functions;
use Digidez\DataSource;

$link = get_permalink($_post);
$wp_tag_cloud = DataSource::get_tag_cloud(['post_id' => $_post->ID, 'show_count' => 0]);
?>
<div class="talk-item d-flex flex-column flex-md-row mb-7">
    <div class="d-flex d-md-none talk-item-col-2-title-box justify-content-between align-items-end">
        <h2 class="talk-item-col-2-title"><?=$_post->post_title;?></h2>
        <div class="talk-item-date"><?=get_post_time('M jS, Y', false, $_post);?></div>
    </div>
    <div class="d-flex d-md-none tags-wrap mb-2 mb-md-4">
        <div class="tag-cloud position-relative">
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
    </div>
    <div class="talk-item-col-1 d-flex flex-row w-100 w-md-50 mb-1 mb-md-0">
        <div class="talk-item-content d-flex flex-column w-50 align-items-start">
            <div>
                <span class="talk-item-subtitle light-micro-icon">reno<span class="talk-item-subtitle-bold">Talk</span></span>
            </div>
            <div class="talk-item-episode"><?=$_post->cf['episode_number'];?></div>
            <h2 class="talk-item-col-1-title m-0"><?=$_post->cf['podcast_title'];?></h2>
            <div class="my-1 my-xxl-2 talk-item-col-1-hr"></div>
            <div class="talk-item-feature-medium">Featuring:</div>
            <span class="talk-item-feature-light"><?=$_post->cf['featuring_names'];?></span>
        </div>
        <div class="w-50 text-center">
            <div class="talk-item-img-wrapper mt-1 mt-xxl-2 d-flex justify-content-center align-items-start h-100">
                <?=Functions::get_the_attachment_thumbnail($_post->cf['renotalk_post_image'], '294x294', ['class' => 'talk-item-img h-auto mb-2', 'alt' => 'renotalk spiker', 'title' => 'renotalk spiker']);?>
            </div>
        </div>
    </div>
    <div class="talk-item-col-2 w-100 w-md-50">
        <div class="d-none d-md-block tags-wrap mb-2 mb-md-4">
            <div class="tag-cloud position-relative">
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
        </div>
        <div class="d-none d-md-flex talk-item-col-2-title-box justify-content-between align-items-end">
            <h2 class="talk-item-col-2-title"><?=$_post->post_title;?></h2>
            <div class="talk-item-date"><?=get_post_time('M jS, Y', false, $_post);?></div>
        </div>
        <p class="talk-item-description"><?=$_post->post_excerpt;?></p>
        <div class="d-flex justify-content-between align-items-center mb-2 mb-xxl-3">
            <?php if(!empty($_post->cf['episode_youtube_link'])):?>
                <a href="<?=$_post->cf['episode_youtube_link'];?>" target="_blank" class="talk-item-view-btn d-flex align-items-center justify-content-center light-youtube-icon">
                    <span>View episode</span>
                </a>
            <?php elseif($_post->cf['episode_self-hosted_link']):?>
                <a class="talk-item-view-btn d-flex align-items-center justify-content-center light-youtube-icon" href="javascript:void(0);" data-trigger="js_action_click" data-action="open_video_modal" data-target="#videoPreviewModal" data-video="<?=$_post->cf['episode_self-hosted_link'];?>">
                    <span>View episode</span>
                </a>
            <?php endif;?>
            <div class="talk-item-minutes d-flex align-items-center oclock-icon">
                <span><?=$_post->cf['episode_duration'];?> mins</span>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <a href="<?=$_post->cf['episode_spotify_link'];?>" class="d-flex align-items-center spotify-icon" target="_blank">
                <span class="talk-item-spotify-link">Listen on spotify</span>
            </a>
            <div class="d-flex align-items-end">
                <span class="talk-item-subtitle talk-item-subtitle-dark-text talk-item-subtitle-medium dark-micro-icon">reno<span class="talk-item-subtitle-bold">Talk</span></span>
            </div>
        </div>
    </div>
</div>
