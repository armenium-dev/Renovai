<?php
use Digidez\Functions;
use Digidez\Helper;

#Helper::_debug($section_data);

?>
<section id="<?=$section_name;?>-section" class="animation-header-section bg-primary position-relative overflow-hidden">
	<div class="container position-relative">
		<div class="animation-header-text">
			<?=$section_data['section_title'];?><br>
			<?php if($section_data['media_response_type'] == 'form'):?>
				<?=do_shortcode($section_data['section_form']);?>
			<?php elseif($section_data['media_response_type'] == 'button'):?>
				<?=Functions::render_section_button($section_data['section_button'], ['class' => 'btn btn-secondary shadow']);?>
			<?php endif;?>
		</div>
	</div>

	<div class="animation-header-container">
		<div class="pillar-container w-100 h-100 animation-header-slide">
			<div class="pillar-left"></div>
			<div class="pillar-center"></div>
			<div class="pillar-right"></div>
		</div>
		<div class="animation-scenes">
			<!--+AnimationHeaderSlide01()-->
			<div class="animation-scene overflow-hidden w-100 h-100 animation-header-slide-02 animation">
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
					<div class="property"><i class="i i-dollar"></i>
						<div class="property-text"><b>Budget:</b><span> $100-$400</span></div>
					</div>
				</div>
				<div class="scene-02">
					<div class="phone-animation-slide-02"></div>
					<img class="scene-02-img-02" src="<?=IMAGES_URI?>/scene-02-img-02.png" alt="" title=""><img class="scene-02-img-03" src="<?=IMAGES_URI?>/scene-02-img-03.png" alt="" title=""><img class="scene-02-img-04" src="<?=IMAGES_URI?>/scene-02-img-04.png" alt="" title=""><img class="scene-02-img-05" src="<?=IMAGES_URI?>/scene-02-img-05.png" alt="" title=""><img class="scene-02-img-01" src="<?=IMAGES_URI?>/scene-02-img-01.png" alt="" title="">
				</div>
			</div>
			<!--+AnimationHeaderSlide03()-->
			<div class="animation-scene overflow-hidden w-100 h-100 animation-header-slide-04">
				<div class="man"></div>
				<div class="properties-container">
					<div class="property"><i class="i i-demographic"></i>
						<div class="property-text"><b>Demographic:</b><span> 51/single</span></div>
					</div>
					<div class="property"><i class="i i-industrial"></i>
						<div class="property-text"><b>Style:</b><span> Industrial</span></div>
					</div>
					<div class="property"><i class="i i-steel-stone-marble"></i>
						<div class="property-text"><b>Materials:</b><span> Steel/Stone/Marble</span></div>
					</div>
					<div class="property"><i class="i i-dollar"></i>
						<div class="property-text"><b>Budget:</b><span> $400-$800</span></div>
					</div>
				</div>
				<div class="scene-02">
					<div class="phone-animation-slide-04"></div>
					<img class="scene-04-img-02" src="<?=IMAGES_URI?>/scene-04-img-02.png" alt="" title=""><img class="scene-04-img-03" src="<?=IMAGES_URI?>/scene-04-img-03.png" alt="" title=""><img class="scene-04-img-05" src="<?=IMAGES_URI?>/scene-04-img-05.png" alt="" title=""><img class="scene-04-img-01" src="<?=IMAGES_URI?>/scene-04-img-01.png" alt="" title=""><img class="scene-04-img-04" src="<?=IMAGES_URI?>/scene-04-img-04.png" alt="" title="">
				</div>
			</div>
			<div class="animation-scene overflow-hidden w-100 h-100 animation-header-slide-05">
				<div class="woman"></div>
				<div class="properties-container">
					<div class="property"><i class="i i-demographic"></i>
						<div class="property-text"><b>Demographic:</b><span> 53/married</span></div>
					</div>
					<div class="property"><i class="i i-boho"></i>
						<div class="property-text"><b>Style:</b><span> Boho</span></div>
					</div>
					<div class="property"><i class="i i-rattan-wood"></i>
						<div class="property-text"><b>Materials:</b><span> Rattan & Wood</span></div>
					</div>
					<div class="property"><i class="i i-dollar"></i>
						<div class="property-text"><b>Budget:</b><span> €900-€2000</span></div>
					</div>
				</div>
				<div class="scene-05">
					<div class="phone-animation-slide-05"></div>
					<img class="scene-05-img-02" src="<?=IMAGES_URI?>/scene-05-img-02.png" alt="" title=""><img class="scene-05-img-03" src="<?=IMAGES_URI?>/scene-05-img-03.png" alt="" title=""><img class="scene-05-img-01" src="<?=IMAGES_URI?>/scene-05-img-01.png" alt="" title=""><img class="scene-05-img-04" src="<?=IMAGES_URI?>/scene-05-img-04.png" alt="" title="">
				</div>
			</div>
			<div class="animation-scene overflow-hidden w-100 h-100 animation-header-slide-06">
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
					<div class="property"><i class="i i-dollar"></i>
						<div class="property-text"><b>Budget:</b><span> €200-€600</span></div>
					</div>
				</div>
				<div class="scene-06">
					<div class="phone-animation-slide-06"></div>
					<img class="scene-04-img-02" src="<?=IMAGES_URI?>/scene-06-img-02.png" alt="" title=""><img class="scene-04-img-03" src="<?=IMAGES_URI?>/scene-06-img-03.png" alt="" title=""><img class="scene-04-img-01" src="<?=IMAGES_URI?>/scene-06-img-01.png" alt="" title=""><img class="scene-04-img-04" src="<?=IMAGES_URI?>/scene-06-img-04.png" alt="" title="">
				</div>
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
