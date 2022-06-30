<?php
use Digidez\Caches;
use Digidez\Functions;
use Digidez\DataSource;
use Digidez\Helper;

defined('ABSPATH') || exit;

$subtitle_length = get_field('blog_subtitle_length', 'option');
$excerpt_length = get_field('blog_excerpt_length', 'option');
$parent_cf = DataSource::get_cpt_custom_fields(DataSource::get_page_id_by_template_name(PAGE_TEMPLATES_PATH.'blog.php'));
#Helper::_debug($parent_cf);
get_header();?>

<?=Functions::get_template_part(SECTIONS_PATH.'/blog-header', ['section_name' => 'blog_header', 'section_data' => $parent_cf['section_blog_header']], false);?>
<?=Functions::get_template_part(SECTIONS_PATH.'/breadcrumbs', ['section_name' => 'breadcrumbs_main', 'section_data' => $parent_cf['section_breadcrumbs']], false);?>
<?=Functions::get_template_part(SECTIONS_PATH.'/blog-tag-cloud', ['section_name' => 'tag_cloud', 'section_data' => $parent_cf['section_blog_tag_cloud']], false);?>
<section class="blog-posts-section sm-toggle-position">
	<div class="container-1650">
        <h2 class="section-recent-title text-center text-lg-left"><?=single_tag_title('',false);?></h2>
        <p class="section-recent-subtitle text-center text-lg-left"><?=tag_description();?></p>
        <div id="posts_container" class="row mb-xl-10 posts-container">
            <?php
            while(have_posts()): the_post();
                global $post;
                $post->cf = DataSource::get_cpt_custom_fields($post);
                $post->post_author = DataSource::get_author_data($post->post_author);
                Functions::get_template_part(PARTIALS_PATH.'/blog/item', [
                    '_post' => $post,
                    'subtitle_length' => $subtitle_length,
                    'excerpt_length' => $excerpt_length
                ]);?>
            <?php endwhile;?>
        </div>
	</div>
</section>
<?=Functions::get_template_part(SECTIONS_PATH.'/subscription-form', ['section_name' => 'subscription_form', 'section_data' => $parent_cf['section_subscription_form']], false);?>
<?=Functions::get_template_part(SECTIONS_PATH.'/request-a-demo', ['section_name' => 'request_a_demo', 'section_data' => $parent_cf['section_request_a_demo']], false);?>

<?php get_footer();?>
