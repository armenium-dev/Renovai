<?php
use Digidez\Functions;
use Digidez\Helper;

#Helper::_debug($section_data);

?>
<section id="<?=$section_name;?>-section" class="animation-header-section bg-primary position-relative overflow-hidden">
	<div class="container position-relative">
		<div class="animation-header-text">
			<?=$section_data['section_title'];?><br>
			<?=Functions::render_section_button($section_data['section_button'], ['class' => 'btn btn-secondary shadow mt-2']);?>
		</div>
	</div>
	<div class="animation-header-container">
		<div class="pillar-container w-100 h-100 animation-header-slide">
			<div class="pillar-left"></div>
			<div class="pillar-center"></div>
			<div class="pillar-right"></div>
		</div>
		<div class="overflow-hidden w-100 h-100 animation-header-slide-01 d-none d-md-block">
			<div class="woman"></div>
			<div class="properties-container">
				<div class="property"><i class="i i-demographic"></i>
					<div class="property-text"><b>Demographic:</b><span> 21/single</span></div>
				</div>
				<div class="property"><i class="i i-style"></i>
					<div class="property-text"><b>Style:</b><span> Preppy</span></div>
				</div>
				<div class="property"><i class="i i-materials"></i>
					<div class="property-text"><b>Materials:</b><span> Leather & Suede</span></div>
				</div>
				<div class="property"><i class="i i-budget"></i>
					<div class="property-text"><b>Budget:</b><span> €100-€400</span></div>
				</div>
			</div>
			<div class="scene-02">
				<div class="phone-animation-slide-01"></div>
				<img class="scene-01-img-01" src="<?=IMAGES_URI?>/scene-01-img-01.png" alt="" title=""><img class="scene-01-img-02" src="<?=IMAGES_URI?>/scene-01-img-02.png" alt="" title=""><img class="scene-01-img-03" src="<?=IMAGES_URI?>/scene-01-img-03.png" alt="" title=""><img class="scene-01-img-04" src="<?=IMAGES_URI?>/scene-01-img-04.png" alt="" title=""><img class="scene-01-img-05" src="<?=IMAGES_URI?>/scene-01-img-05.png" alt="" title=""><img class="scene-01-img-06" src="<?=IMAGES_URI?>/scene-01-img-06.png" alt="" title="">
			</div>
		</div>
		<div class="overflow-hidden w-100 h-100 animation-header-slide-02">
			<div class="woman"></div>
			<div class="properties-container">
				<div class="property"><i class="i i-demographic"></i>
					<div class="property-text"><b>Demographic:</b><span> 32/single</span></div>
				</div>
				<div class="property"><i class="i i-retro"></i>
					<div class="property-text"><b>Style:</b><span> Retro</span></div>
				</div>
				<div class="property"><i class="i i-plush-velvet"></i>
					<div class="property-text"><b>Materials:</b><span> Plush Velvet</span></div>
				</div>
				<div class="property"><i class="i i-budget"></i>
					<div class="property-text"><b>Budget:</b><span> €100-€400</span></div>
				</div>
			</div>
			<div class="scene-02">
				<div class="phone-animation-slide-02"></div>
				<img class="scene-02-img-02" src="<?=IMAGES_URI?>/scene-02-img-02.png" alt="" title=""><img class="scene-02-img-03" src="<?=IMAGES_URI?>/scene-02-img-03.png" alt="" title=""><img class="scene-02-img-04" src="<?=IMAGES_URI?>/scene-02-img-04.png" alt="" title=""><img class="scene-02-img-05" src="<?=IMAGES_URI?>/scene-02-img-05.png" alt="" title=""><img class="scene-02-img-01" src="<?=IMAGES_URI?>/scene-02-img-01.png" alt="" title="">
			</div>
		</div>
		<div class="overflow-hidden w-100 h-100 animation-header-slide-03 d-none d-md-block">
			<div class="man"></div>
			<div class="properties-container">
				<div class="property"><i class="i i-demographic"></i>
					<div class="property-text"><b>Demographic:</b><span> 26/single</span></div>
				</div>
				<div class="property"><i class="i i-minimal"></i>
					<div class="property-text"><b>Style:</b><span> Minimal</span></div>
				</div>
				<div class="property"><i class="i i-organic-cotton"></i>
					<div class="property-text"><b>Materials:</b><span> Organic Cotton</span></div>
				</div>
				<div class="property"><i class="i i-budget"></i>
					<div class="property-text"><b>Budget:</b><span> €100-€400</span></div>
				</div>
			</div>
			<div class="scene-02">
				<div class="phone-animation-slide-03"></div>
				<img class="scene-03-img-02" src="<?=IMAGES_URI?>/scene-03-img-02.png" alt="" title=""><img class="scene-03-img-01" src="<?=IMAGES_URI?>/scene-03-img-01.png" alt="" title=""><img class="scene-03-img-03" src="<?=IMAGES_URI?>/scene-03-img-03.png" alt="" title=""><img class="scene-03-img-04" src="<?=IMAGES_URI?>/scene-03-img-04.png" alt="" title=""><img class="scene-03-img-05" src="<?=IMAGES_URI?>/scene-03-img-05.png" alt="" title=""><img class="scene-03-img-06" src="<?=IMAGES_URI?>/scene-03-img-06.png" alt="" title="">
			</div>
		</div>
		<div class="overflow-hidden w-100 h-100 animation-header-slide-04 d-none d-md-block">
			<div class="man"></div>
			<div class="properties-container">
				<div class="property"><i class="i i-demographic"></i>
					<div class="property-text"><b>Demographic:</b><span> 51/married +2</span></div>
				</div>
				<div class="property"><i class="i i-industrial"></i>
					<div class="property-text"><b>Style:</b><span> Industrial</span></div>
				</div>
				<div class="property"><i class="i i-steel-stone-marble"></i>
					<div class="property-text"><b>Materials:</b><span> Steel/Stone/Marble</span></div>
				</div>
				<div class="property"><i class="i i-budget"></i>
					<div class="property-text"><b>Budget:</b><span> €200-€600</span></div>
				</div>
			</div>
			<div class="scene-02">
				<div class="phone-animation-slide-04"></div>
				<img class="scene-04-img-02" src="<?=IMAGES_URI?>/scene-04-img-02.png" alt="" title=""><img class="scene-04-img-03" src="<?=IMAGES_URI?>/scene-04-img-03.png" alt="" title=""><img class="scene-04-img-05" src="<?=IMAGES_URI?>/scene-04-img-05.png" alt="" title=""><img class="scene-04-img-01" src="<?=IMAGES_URI?>/scene-04-img-01.png" alt="" title=""><img class="scene-04-img-04" src="<?=IMAGES_URI?>/scene-04-img-04.png" alt="" title="">
			</div>
		</div>
		<div class="animation-plus-container">
			<div class="animation-plus s-1"></div>
			<div class="animation-plus s-2"></div>
			<div class="animation-plus s-3"></div>
			<div class="animation-plus s-4"></div>
			<div class="animation-plus s-5"></div>
		</div>
	</div>
</section>
