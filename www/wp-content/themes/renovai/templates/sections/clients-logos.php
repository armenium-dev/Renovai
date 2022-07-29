<?php

use Digidez\DataSource;
use Digidez\Helper;

$section_data['section_items'] = DataSource::fill_cpt_cf($section_data['section_items']);
#Helper::_debug($section_data);
?>
<section id="<?=$section_name;?>-section" class="sm-toggle-position bg-primary py-1 py-md-4">
	<div class="container px-0 px-md-2">

		<?php if(count($section_data['section_items'])):?>
		<div class="slick-logos">
			<?php foreach($section_data['section_items'] as $item):?>
					<?php if(!empty($item->cf['client_url'])):?>
						<a href="<?=$item->cf['client_url'];?>" title="<?=$item->post_title;?>">
					<?php endif;?>
						<img class="w-100 w-md-auto" src="<?=$item->cf['client_logo'];?>" alt="<?=$item->post_title;?>" width="70" height="26">
					<?php if(!empty($item->cf['client_url'])):?>
						</a>
					<?php endif;?>
			<?php endforeach;?>
		</div>
		<?php endif; ?>
		
	</div>
</section>


