<?php
use Digidez\DataSource;
use Digidez\Functions;
use Digidez\Helper;

global $post;

$blog_featured_posts_title = get_field('blog_featured_posts_title', 'option');
$blog_featured_posts_subtitle = get_field('blog_featured_posts_subtitle', 'option');
$subtitle_length = get_field('blog_subtitle_length', 'option');
$excerpt_length = get_field('blog_excerpt_length', 'option');

$posts = DataSource::get_blog_posts([
	'include_custom_fields' => true,
	'include_author_data' => true,
	'remove_post_content' => true,
	'posts_per_page' => -1,
	'orderby' => 'post_date',
	'order' => 'desc',
	'tags' => DataSource::get_post_tags_ids(['post_id' => $post->ID]),
]);
#Helper::_debug($posts);
?>

<?php if($posts->found_posts):?>
<section id="<?=$section_name;?>-section" class="blog-posts-section featured-posts sm-toggle-position">
	<div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-xxl-9">
                <h2 class="section-latest-title text-left"><?=$blog_featured_posts_title;?></h2>
                <p class="section-recent-subtitle text-left"><?=$blog_featured_posts_subtitle;?></p>
                <div id="posts_container" class="row mb-xl-10 posts-container js_featured_slick_carousel">
                    <?php foreach($posts->posts as $k => $_post):?>
                        <?php Functions::get_template_part(PARTIALS_PATH.'/blog/item', [
                            '_post' => $_post,
                            'subtitle_length' => $subtitle_length,
                            'excerpt_length' => $excerpt_length,
                            'cols_class' => 'featured-item',
                        ]);?>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
	</div>
</section>
<?php endif;?>
