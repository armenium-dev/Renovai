<?php

use Digidez\Functions;

$args = array(
	'prev_text'      => '<i class="fa fa-angle-left"></i> Back',
	'next_text'      => 'Next <i class="fa fa-angle-right"></i>',
	'in_same_term'   => false,
	'excluded_terms' => '',
	'taxonomy'       => 'category'
);

$previous = get_previous_post_link('%link', $args['prev_text'], $args['in_same_term'], $args['excluded_terms'], $args['taxonomy']);
if($previous){
	$previous = str_replace('<a', '<a class="button white font-hn fs23 prev"', $previous);
}

$next = get_next_post_link('%link', $args['next_text'], $args['in_same_term'], $args['excluded_terms'], $args['taxonomy']);
if($next){
	$next = str_replace('<a', '<a class="button white font-hn fs23 next"', $next);
}
?>
<nav class="navigation post-navigation">
	<?php if(Functions::$device == 'desktop'):?>
		<?=$previous;?>
		<div class="share-section">
			<?php if(function_exists('ssbd_social_icons')) echo ssbd_social_icons();?>
		</div>
		<?=$next;?>
	<?php else:?>
		<?=$previous;?><?=$next;?>
		<div class="share-section">
			<?php if(function_exists('ssbd_social_icons')) echo ssbd_social_icons();?>
		</div>
	<?php endif; ?>
</nav>
