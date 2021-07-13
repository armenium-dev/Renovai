<?php

use Digidez\Functions;

get_header();
?>
<section id="page-section" class="page-section">
	<div class="container" tabindex="-1">
		<div class="row">
			<div class="col-sm-12">
				<div class="content">
					<?php while(have_posts()): the_post();?>
						<?php the_content();?>
					<?php endwhile;?>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
