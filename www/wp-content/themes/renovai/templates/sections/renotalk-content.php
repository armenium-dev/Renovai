<?php

use Digidez\DataSource;
use Digidez\Functions;
use Digidez\Helper;
global $post;

$subtitle_length = get_field('blog_subtitle_length', 'option');
$excerpt_length = get_field('blog_excerpt_length', 'option');

$order = explode('-', $section_data['order']);
$posts = DataSource::get_blog_posts([
	'post_type' => 'renotalk',
	'include_custom_fields' => true,
	'include_author_data' => true,
	'remove_post_content' => true,
	'posts_per_page' => $section_data['posts_per_page_first'],
	'orderby' => $order[0],
	'order' => strtoupper($order[1]),
]);
#Helper::_debug($posts->posts);
?>
<section id="<?=$section_name;?>-section" class="talks talks-posts-section sm-toggle-position">
	<div class="container">
        <?php if($posts->found_posts):?>
            <div id="posts_container" class="talks-list" data-total="<?=$posts->found_posts;?>" data-offset="<?=$section_data['posts_per_page_first'];?>" data-parent_post_id="<?=$post->ID;?>">
                <?php foreach($posts->posts as $k => $_post):?>
                    <?php Functions::get_template_part(PARTIALS_PATH.'/talk/item', [
                        '_post' => $_post,
                        'subtitle_length' => $subtitle_length,
                        'excerpt_length' => $excerpt_length
                    ]);?>
                <?php endforeach;?>
            </div>

            <?php if($posts->found_posts > $section_data['posts_per_page_first']):?>
                <div class="row">
                    <div class="col-12 text-center">
                        <button type="button" class="btn btn-info btn-lg" data-trigger="js_action_click" data-action="load_more_talks" data-target="#posts_container"><?=$section_data['button_label'];?></button>
                    </div>
                </div>
            <?php endif;?>
        <?php endif;?>
	</div>
</section>
<?php
echo Functions::render_modal_custom([
	'template' => MODALS_PATH.'/video-preview',
	'size' => 4, // 1,2,3,4
	'id' => 'videoPreviewModal',
	'class' => 'video-preview-modal light-errors',
	'modal_params' => [],
	'form_title' => '',
	'form' => '',
]);
