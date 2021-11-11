<?php

use Digidez\Functions;
use Digidez\Helper;

#Helper::_debug($section_data);

?>
<section id="<?=$section_name;?>-section" class="integration__steps integration-steps">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12">
				<?php foreach($section_data['section_items'] as $k => $item):
					$class = ($k % 2 == 0) ? 'integration-steps__row' : 'integration-steps__row integration-steps__row--reverse';?>
				<div class="<?=$class;?>">
					<div class="integration-steps__col">
						<img class="integration-steps__step-1-icon" src="<?=$item['icon'];?>" alt="">
					</div>
					<div class="integration-steps__col">
						<span class="integration-steps__step-num">Step <?=($k+1);?></span>
					</div>
					<div class="integration-steps__col">
						<h2 class="integration-steps__title"><?=$item['title'];?></h2>
						<div class="integration-steps__subtitle"><?=$item['desc'];?></div>
					</div>
				</div>
				<?php endforeach;?>
			</div>
		</div>
	</div>
</section>
