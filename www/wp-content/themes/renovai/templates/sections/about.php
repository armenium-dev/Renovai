<?php

use Digidez\DataSource;
use Digidez\Functions;
use Digidez\Helper;

#Helper::_debug($section_data);
?>
<section id="<?=$section_name;?>-section" class="about-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-12 col-xxl-9">
				<div class="row">
					<?php foreach($section_data['dynamic_content'] as $content_item):?>
						<?php Functions::get_template_part(PARTIALS_PATH.'/dynamic-content/'.$content_item['acf_fc_layout'], [
							'sub_id' => $section_name.'_'.$content_item['acf_fc_layout'],
							'item_data' => $content_item
						]);?>
					<?php endforeach;?>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="about-end-section"></section>

