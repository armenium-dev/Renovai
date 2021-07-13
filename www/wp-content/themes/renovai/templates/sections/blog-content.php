<?php

use Digidez\DataSource;
use Digidez\Functions;
use Digidez\Helper;
global $post;

$subtitle_length = get_field('blog_subtitle_length', 'option');
$excerpt_length = get_field('blog_excerpt_length', 'option');

$order = explode('-', $section_data['order']);
$posts = DataSource::get_blog_posts([
	'include_custom_fields' => true,
	'include_author_data' => true,
	'remove_post_content' => true,
	'posts_per_page' => $section_data['posts_per_page_first'],
	'orderby' => $order[0],
	'order' => strtoupper($order[1]),
]);
#Helper::_debug($posts->posts);
?>
<section id="<?=$section_name;?>-section" class="blog-carousel-section sm-toggle-position">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-xxl-9">
				
				<?php if($posts->found_posts):?>
					<div class="row">
						<?php Functions::get_template_part(PARTIALS_PATH.'/blog/item-first', ['_post' => $posts->posts[0]]);?>
					</div>
					<div id="posts_container" class="row align-self-stretch mb-xl-10" data-total="<?=$posts->found_posts;?>" data-offset="<?=$section_data['posts_per_page_first'];?>" data-parent_post_id="<?=$post->ID;?>">
						<?php foreach($posts->posts as $k => $_post):?>
							<?php if($k > 0):?>
								<?php Functions::get_template_part(PARTIALS_PATH.'/blog/item', [
									'_post' => $_post,
									'subtitle_length' => $subtitle_length,
									'excerpt_length' => $excerpt_length
								]);?>
							<?php endif;?>
						<?php endforeach;?>
					</div>
					
					<?php if($posts->found_posts > $section_data['posts_per_page_first']):?>
						<div class="row">
							<div class="col-12 text-center">
								<button type="button" class="btn btn-info btn-lg" data-trigger="js_action_click" data-action="load_more_posts" data-target="#posts_container"><?=$section_data['button_label'];?></button>
							</div>
						</div>
					<?php endif;?>
				<?php endif;?>
				
			</div>
		</div>
	</div>
</section>

