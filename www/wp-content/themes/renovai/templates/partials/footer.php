<?php
use Digidez\Functions;
use Digidez\Core;
?>
<footer class="py-5 pt-md-6 pb-md-7 text-white bg-primary">
	<div class="container">
		<div class="row d-none d-md-flex justify-content-lg-between justify-content-xl-start">
			<div class="col-md-6 col-lg-auto pr-xl-9 pr-md-8">
				<?php dynamic_sidebar('footer_col_1');?>
			</div>
			<div class="col-md-6 col-lg-auto pr-xl-9 pr-md-8">
				<?php dynamic_sidebar('footer_col_2');?>
			</div>
			<div class="col-md-6 col-lg-auto pr-xl-9 pr-md-8">
				<?php dynamic_sidebar('footer_col_3');?>
			</div>
			<div class="col-md-6 col-lg-auto">
				<?php dynamic_sidebar('footer_col_4');?>
			</div>
		</div>
		<div class="row mt-md-9 align-items-end">
			<div class="col-12 text-center d-md-none mb-4 order-md-0 order-1">
				<?php dynamic_sidebar('sub_footer_top_full_width');?>
			</div>
			<div class="col-md-6 col-12 order-md-1 order-2">
				<?php dynamic_sidebar('sub_footer_col_1');?>
			</div>
			<div class="col-md-6 text-md-right col-12 text-center order-md-2 order-0">
				<?php dynamic_sidebar('sub_footer_col_2');?>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-md-6 col-lg-3">
				<?php dynamic_sidebar('second_sub_footer_col_1');?>
			</div>
			<div class="col-12 col-lg-9 col-xl-6 text-white text-center">
				<?php dynamic_sidebar('second_sub_footer_col_2');?>
			</div>
		</div>
	</div>
</footer>
