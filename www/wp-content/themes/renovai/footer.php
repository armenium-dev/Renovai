<?php
use Digidez\Functions;

/*if(stristr($_SERVER['HTTP_USER_AGENT'], 'Lighthouse') === false){
}else{
	$google['tag_body_code'] = '';
}*/
?>
		</main>
		<?php Functions::render_footer();?>
		<?php Functions::render_cookiebox(true, true);?>
	    <?php Functions::render_modals();?>
		<a role="button" class="scroll-top trans_me"></a>
		<a role="button" class="scroll-bottom trans_me"></a>
		<div class="mob-overlay"></div>
		<div class="main-overlay" style="display: none;"></div>
		<div class="user-overlay" style="display: none;"></div>
		<div class="filter-overlay" style="display: none;"></div>
<!-- W3TC-include-js-head -->
        <?php wp_footer(); ?>
    </body>
</html>
