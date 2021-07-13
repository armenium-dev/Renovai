<?php
use Digidez\Functions;
use Digidez\DataSource;

global $post;

$loop = DataSource::get_related_blog_posts($post->ID, false);
$blog_image_placeholder_id = get_field('blog_image_placeholder', 'option');
$categories = get_the_category($post->ID);
#Functions::_debug($categories);
$cats = array();
foreach($categories as $cat){
	$cats[] = $cat->name;
}

$excerpt_length = (Functions::$device == 'desktop') ? 300 : 400;

if(!isset($display_title)){
	$display_title = true;
}

$thumb_size['w'] = 150;
$thumb_size['h'] = 94;
$thumb_size = implode('x', $thumb_size);
?>

<?php if($loop->have_posts()):?>
	<section class="related-posts">
		<?php if($display_title):?>
		<h2 class="section-title">Related Posts</h2>
		<?php endif;?>
		<div class="content">
			<?php while($loop->have_posts()): $loop->the_post();?>
			<?php $link = get_permalink();?>
			<div class="row item">
				<div class="col-5">
					<a href="<?=$link;?>">
					<?php if(has_post_thumbnail()):?>
						<figure><?=Functions::get_the_post_thumbnail($post->ID, $thumb_size, array('alt' => get_the_title()));?></figure>
					<?php else:?>
						<?=Functions::get_the_attachment_thumbnail($blog_image_placeholder_id, $thumb_size, array('alt' => get_the_title()));?>
					<?php endif; ?>
					</a>
				</div>
				<div class="col-7">
					<a class="title" href="<?=$link;?>"><?php the_title();?></a>
					<div class="published"><?php the_time('M j, Y');?></div>
				</div>
			</div>
			<?php endwhile;?>
		</div>
	</section>
	<?php wp_reset_postdata();?>
<?php endif;?>
