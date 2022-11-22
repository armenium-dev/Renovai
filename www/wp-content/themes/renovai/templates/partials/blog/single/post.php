<?php
/**
 * Shows a simple single post
 */

use Digidez\DataSource;
use Digidez\Functions;
use Digidez\Helper;

global $post, $authordata;

$parent_cf = DataSource::get_cpt_custom_fields(DataSource::get_page_id_by_template_name(PAGE_TEMPLATES_PATH.'blog.php'));

$cf = get_fields($post->ID);
$bg = IMAGES_URI.'/spacer.gif';
if(has_post_thumbnail($post)){
	$bg = Functions::get_the_post_thumbnail($post->ID, '492x260', ['alt' => $post->post_title, 'title' => $post->post_title], false, false);
}
$wp_tag_cloud = DataSource::get_tag_cloud(['post_id' => $post->ID]);

?>
<?php while(have_posts()): the_post();
    $author = DataSource::get_author_data();
    $content_data = Functions::generateContentWithList(get_the_content());
	#Helper::_debug($author);?>
	<section class="blog-item-header-section position-relative">
		<div class="blog-item-header-container">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-12 col-xxl-9">
						<div class="row">
							<div class="col-12 blog-header-content">
								<h1 class="h1"><?=get_the_title();?></h1>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="blog-item-header-img" style="background-image: url(<?=$bg;?>);"></div>
	</section>
    <section class="breadcrumbs-wrap">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-xxl-9">
		            <?=Functions::breadcrumbs();?>
                </div>
            </div>
        </div>
    </section>
	<section id="post-<?=$post->ID;?>" class="blog-content-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-12 col-xxl-9">

                    <div class="mb-3 mb-md-1 d-flex align-items-start flex-row flex-nowrap justify-content-start">
                        <div class="flex-fill">
                            <div class="d-flex flex-row flex-nowrap justify-content-between align-items-center">
                                <div class="a-data">
                                    <div class="published"><?=get_post_time('F jS, Y');?></div>
                                </div>
                                <div class="d-none d-md-block">
                                    <?=Functions::get_social_shareing_html($post);?>
                                </div>
                            </div>
                        </div>
					</div>

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
                    <div class="mb-3 d-md-none">
						<?=Functions::get_social_shareing_html($post);?>
                    </div>
                    <h2 class="post-subtitle"><?=$cf['post_subtitle'];?></h2>
                    <?php if(!empty($content_data['list'])):?>
                    <div class="table-of-content">
                        <div class="label">Table of Contents</div>
                        <ul>
                            <?php foreach($content_data['list'] as $list):?>
                            <li><a href="<?=$list['anchor'];?>"><?=$list['title'];?></a></li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                    <?php endif;?>
                    <?=$content_data['content'];?>
					<?php #the_content();?>

                    <div class="author-box d-flex align-items-start flex-row flex-nowrap justify-content-start">
                        <img class="avatar" src="<?=$author['avatar_src'];?>" alt="<?=$author['name'];?>" title="<?=$author['name'];?>">
                        <div class="flex-fill">
                            <div class="author d-flex flex-row flex-nowrap justify-content-between align-items-center">
                                <div class="a-data">
                                    <div class="a-name">
                                        <?php if(!empty($author['user_linked_in_profile_link'])):?>
                                            <?=sprintf('<a href="%s" target="%s" rel="nofollow">%s</a>', $author['user_linked_in_profile_link'], '_blank', $author['name'])?>
                                        <?php else:?>
                                            <?=$author['name'];?>
                                        <?php endif;?>
                                    </div>
									<?php if(!empty($author['position'])):?>
                                        <div class="a-position"><?=$author['position'];?></div>
									<?php endif;?>
                                </div>
                                <div class="d-none d-md-block">
                                </div>
                            </div>
                            <div class="a-description"><?=$author['description'];?></div>
                        </div>
                    </div>


				</div>
			</div>
		</div>
	</section>
<?php endwhile;?>
<?=Functions::get_template_part(SECTIONS_PATH.'/blog-featured-posts', ['section_name' => 'blog_featured_posts', 'section_data' => []], false);?>
<?=Functions::get_template_part(SECTIONS_PATH.'/subscription-form', ['section_name' => 'subscription_form', 'section_data' => $parent_cf['section_subscription_form']], false);?>
<?=Functions::get_template_part(SECTIONS_PATH.'/request-a-demo', ['section_name' => 'request_a_demo', 'section_data' => $parent_cf['section_request_a_demo']], false);?>
