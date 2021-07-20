<?php
use Digidez\Helper;

#Helper::_debug($single_job_main_nav_style);

$header_class = [
	'd-flex',
	'align-items-md-center',
	'sm-toggle-menu',
	'position-static',
	'w-100',
	'shadow',
];

if((isset($page_options['main_nav_style']) && $page_options['main_nav_style'] == 'dark') || $single_post_main_nav_style == 'dark'){
	$header_class[] = 'black-header-menu';
}
$header_class = implode(' ', $header_class);

?>
<header id="site_header" class="<?=$header_class;?>">
	<div class="container-md container-fluid">
		<?php if(is_front_page()):?>
			<?php get_template_part(PARTIALS_PATH.'/header/nav-primary');?>
		<?php else:?>
		<div class="row justify-content-center">
			<div class="col-12">
				<?php get_template_part(PARTIALS_PATH.'/header/nav-primary');?>
			</div>
		</div>
		<?php endif;?>
	</div>
</header>
