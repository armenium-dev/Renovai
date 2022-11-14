<?php
use Digidez\Functions;
use Digidez\Helper;
use Digidez\DataSource;

$wp_tag_cloud = DataSource::get_tag_cloud();
#Helper::_debug($wp_tag_cloud);
if(!empty($section_data['tags_to_display'])){
    foreach($wp_tag_cloud as $k => $tag){
        if(!in_array($tag->term_id, $section_data['tags_to_display'])){
            unset($wp_tag_cloud[$k]);
        }
    }
}
?>
<?php if(!empty($wp_tag_cloud)):?>
	<section class="tags-wrap">
		<div class="container tags-row">
			<div class="tags-title" aria-label="Popular Tags">Popular Tags</div>
			<div class="tag-cloud">
				<?php
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
				?>
			</div>
		</div>
	</section>
<?php endif;?>
