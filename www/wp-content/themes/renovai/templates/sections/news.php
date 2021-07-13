<?php

use Digidez\DataSource;
use Digidez\Functions;
use Digidez\Helper;
global $post;

$order = explode('-', $section_data['order']);
$posts = DataSource::get_news_posts([
	'include_custom_fields' => true,
	'remove_post_content' => true,
	'posts_per_page' => $section_data['posts_per_page_first'],
	'orderby' => $order[0],
	'order' => strtoupper($order[1]),
]);
#Helper::_debug($posts->found_posts);
?>
<section id="<?=$section_name;?>-section" class="news-content-section sm-toggle-position">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-xxl-9">
				<?php if($posts->found_posts):?>
					<div id="posts_container" class="row" data-total="<?=$posts->found_posts;?>" data-offset="<?=$section_data['posts_per_page_first'];?>" data-parent_post_id="<?=$post->ID;?>">
						<?php foreach($posts->posts as $k => $_post):?>
							<?php $template = ($k == 0 ? 'item-first' : 'item');?>
							<?php Functions::get_template_part(PARTIALS_PATH.'/news/'.$template, ['section_name' => $section_name, 'section_data' => $section_data, '_post' => $_post]);?>
						<?php endforeach;?>
					</div>
					<?php if($posts->found_posts > $section_data['posts_per_page_first']):?>
					<div class="row">
						<div class="col-12 text-center py-8">
							<a class="btn btn-secondary btn-lg d-none d-md-inline-block shadow" role="button" data-trigger="js_action_click" data-action="load_more_news" data-target="#posts_container"><?=$section_data['button_label'];?></a>
							<a class="btn btn-secondary d-md-none shadow" role="button" data-trigger="js_action_click" data-action="load_more_news" data-target="#posts_container"><?=$section_data['button_label'];?></a>
						</div>
					</div>
					<?php endif;?>
				<?php endif;?>
			</div>
		</div>
	</div>
</section>
