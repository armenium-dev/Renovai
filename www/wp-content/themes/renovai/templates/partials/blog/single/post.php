<?php
/**
 * Shows a simple single post
 */

use Digidez\DataSource;
use Digidez\Functions;

global $post, $authordata;

$parent_cf = DataSource::get_cpt_custom_fields(DataSource::get_page_id_by_template_name(PAGE_TEMPLATES_PATH.'blog.php'));

$cf = get_fields($post->ID);
$bg = IMAGES_URI.'/spacer.gif';
if(has_post_thumbnail($post)){
	$bg = Functions::get_the_post_thumbnail($post->ID, '492x260', ['alt' => $post->post_title, 'title' => $post->post_title], false, false);
}

?>
<?php while(have_posts()): the_post(); $author = DataSource::get_author_data();?>
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
	<section id="post-<?php the_ID();?>" class="blog-content-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-12 col-xxl-9">
					<h2 class="mb-6"><?=$cf['post_subtitle'];?></h2>
					<div class="mb-6 d-flex align-items-md-center flex-column flex-md-row">
						<div class="avatar d-inline-block mr-4 mb-3 mb-md-0">
							<img src="<?=$author['avatar_src'];?>" alt="" title=""><b><?=$author['name'];?></b> |<span> <?=get_post_time('F jS, Y');?></span>
						</div>
						<?php if(!empty($author['social_links'])):?>
							<div>
								<?php foreach($author['social_links'] as $social_link):?>
									<a class="mr-2" href="<?=$social_link['link'];?>" target="_blank" title="<?=$social_link['service'];?>"><?=$social_link['icon'];?></a>
								<?php endforeach;?>
							</div>
						<?php endif;?>
					</div>
					<?php the_content();?>
				</div>
			</div>
		</div>
	</section>
<?php endwhile;?>
<?=Functions::get_template_part(SECTIONS_PATH.'/subscription-form', ['section_name' => 'subscription_form', 'section_data' => $parent_cf['section_subscription_form']], false);?>
<?=Functions::get_template_part(SECTIONS_PATH.'/request-a-demo', ['section_name' => 'request_a_demo', 'section_data' => $parent_cf['section_request_a_demo']], false);?>
