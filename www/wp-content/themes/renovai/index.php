<?php
/**
 * The main template file.
 */


use Digidez\Functions;
use Digidez\Tools;
use Digidez\Theme;
use Digidez\Helper;

global $wp_query;

$cf = get_fields(get_option('page_for_posts'));
set_query_var('cf', $cf);
#Helper::_debug($page_for_posts_id);

get_header();
?>

<?php if($cf['section_hero_display']):?>
	<?php get_template_part(PARTIALS_PATH.'/hero/section');?>
<?php endif;?>

<section id="news" class="news">
	<div class="cloud-s">
		<div class="container">
			<div class="row">
				<?php if(have_posts()):?>
					<?php while(have_posts()): the_post();?>
						<?php get_template_part(PARTIALS_PATH.'/news/loop/post');?>
					<?php endwhile; ?>
				<?php else:?>
					<?php get_template_part(PARTIALS_PATH.'/news/post', 'no-posts'); ?>
				<?php endif; ?>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?php Theme::get_pagination($wp_query->max_num_pages, array('wrap_class' => 'indigo'));?>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
