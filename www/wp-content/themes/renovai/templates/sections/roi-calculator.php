<?php

use Digidez\Functions;
use Digidez\Helper;

#Helper::_debug($section_data);

?>
<section id="<?=$section_name;?>-section" class="roi-calc__calculator roi-calculator-section">
	<div class="container mt-auto max-w-1140">
		<div class="roi-calculator__row">
			<form class="roi-calculator__form roi-calculator-form">
				<div class="roi-calculator-form__wrapp">
					<div class="roi-calculator-form__title h4"><?=$section_data['range_slider_1_title'];?></div>
					<div class="roi-calculator-form__label">
						<span id="roi-calc-session-value"><?=$section_data['range_slider_1_default_value'];?></span>
						<span><?=$section_data['range_slider_1_description'];?></span>
					</div>
					<div class="roi-calculator-form__range-box">
						<input type="range" class="roi-calculator-form__range roi-calculator-form__range--sessions">
					</div>

					<div class="roi-calculator-form__title h4"><?=$section_data['range_slider_2_title'];?></div>
					<div class="roi-calculator-form__label">
						<span id="roi-calc-SKU-value"><?=$section_data['range_slider_2_default_value'];?></span>
						<span><?=$section_data['range_slider_2_description'];?></span>
					</div>
					<div class="roi-calculator-form__range-box">
						<input type="range" class="roi-calculator-form__range roi-calculator-form__range--SKU">
					</div>

					<div class="roi-calculator-form__title h4"><?=$section_data['range_slider_3_title'];?></div>
					<div class="roi-calculator-form__label">
						<span id="average-order-value"><?=$section_data['range_slider_3_default_value'];?></span>
						<span><?=$section_data['range_slider_3_description'];?></span>
					</div>
					<div class="roi-calculator-form__range-box">
						<input type="range" class="roi-calculator-form__range roi-calculator-form__range--average-order">
					</div>
				</div>
				<div class="roi-calculator-form__btn-wrapp">
					<button type="submit" id="calc-result" class="roi-calculator-form__btn btn btn-info btn-lg">Calculate</button>
				</div>
			</form>
			<div class="roi-calculator__result-box roi-calculator-result">
				<div class="roi-calculator-result__row">
					<div class="roi-calculator-result__title">Results</div>
				</div>

				<div class="roi-calculator-result__row">
					<div class="roi-calculator-result__item">
						<span class="roi-calculator-result__subtitle">AOV</span>
						<div class="roi-calculator-result__placeholder-line">-</div>
						<span id="AOV-result">500%</span>
					</div>
					<div class="roi-calculator-result__item">
						<span class="roi-calculator-result__subtitle">CVR</span>
						<div class="roi-calculator-result__placeholder-line">-</div>
						<span id="CVR-result">500%</span>
					</div>
				</div>

				<div class="roi-calculator-result__row">
					<div class="roi-calculator-result__item">
						<span class="roi-calculator-result__subtitle">ARPU</span>
						<div class="roi-calculator-result__placeholder-line">-</div>
						<span id="ARPU-result">500%</span>
					</div>
					<div id="total-uplift-box" class="roi-calculator-result__item">
						<span class="roi-calculator-result__subtitle roi-calculator-result__subtitle--total-uplift">Total Uplift</span>
						<div class="roi-calculator-result__placeholder-line roi-calculator-result__placeholder-line--total-uplift">-</div>
						<span class="roi-calculator-result__total-uplift" id="total-uplift">500%</span>
					</div>
				</div>

				<div id="calc-loader" class="roi-calculator-result__loader">
					<img src="<?=ASSETS_URI;?>/images/new-renovai-loading-roi.gif" alt="loader">
				</div>
			</div>
		</div>
		<div class="roi-calculator__row roi-calculator__content roi-calculator-content">
			<h3 class="roi-calculator-content__title"><?=$section_data['section_title'];?></h3>
			<p class="roi-calculator-content__text"><?=$section_data['section_description'];?></p>
		</div>
	</div>
</section>
