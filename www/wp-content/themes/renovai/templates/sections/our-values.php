<?php

use Digidez\DataSource;
use Digidez\Helper;

#Helper::_debug($section_data);
?>
<section id="<?=$section_name;?>-section" class="careers-grandmother-section position-relative sm-toggle-position">
	<div class="careers-grandmother-container">
		<div class="careers-grandmother"></div>
		<?php foreach($section_data['section_items'] as $k => $item):?>
			<?php $class = ($k == 0) ? 'active' : '';?>
			<a class="careers-grandmother-link <?=$item['css_class'];?>-link <?=$class;?>" href="#"><span><?=$item['title'];?></span></a>
		<?php endforeach;?>
		<div class="careers-grandmother-pillar-container">
			<?php foreach($section_data['section_items'] as $k => $item):?>
				<?php $class = ($k == 0) ? 'active' : '';?>
				<div class="be-text <?=$item['css_class'];?>-text <?=$class;?>"><?=$item['description'];?></div>
			<?php endforeach;?>
		</div>
		<div class="title text-center"><b><?=$section_data['section_title'];?></b> <span class="d-block d-md-inline"><?=$section_data['section_subtitle'];?></span></div>
	</div>
</section>


