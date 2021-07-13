<?php
/**
 * 'Faq Accordion
 * @subpackage VC Functions
 * @version 1.0
 */

use Digidez\Functions;

class Faq_Accordion {

	/**
	 * Main constructor
	 * @since 3.5.0
	 */
	public function __construct(){

		// Add shortcode
		add_shortcode('vcex_latest_post_tile', array($this, 'output'));

		// Map to VC
		vc_lean_map('vcex_latest_post_tile', array($this, 'map'));

		// Admin filters
		if(is_admin()){
			// Move content design elements into new entry CSS field
			add_filter('vc_edit_form_fields_attributes_vcex_latest_post_tile', 'vcex_parse_deprecated_grid_entry_content_css');

			add_filter('vc_form_fields_render_field_vcex_latest_post_tile_tax_query_term_filter_param', array($this, 'fields_render_tax_query_term_filter_param'), 10, 4);

			// Set image height to full if crop/width are empty
			add_filter('vc_edit_form_fields_attributes_vcex_latest_post_tile', array($this, 'edit_form_fields'));

			add_action('wp_ajax_filter_terms_by_tax', array($this, 'ajax_filter_terms_by_tax'));

		}

	}

	public function fields_render_tax_query_term_filter_param($param, $value, $settings, $atts){
		#Functions::_debug(func_get_args());

		$taxonomy = trim($atts['tax_query_taxonomy_filter']);
		$args = array(
			'taxonomy'   => $taxonomy,
			'fields'     => 'all',
			'hide_empty' => true,
			'orderby'    => 'name',
			'order'      => 'ASC',
		);
		$terms = get_terms($args);
		if(!empty($terms)){
			$options = array(esc_html__('- Autodetect -', THEME_TD) => 0);
			foreach($terms as $term){
				$options[html_entity_decode($term->name)] = $term->term_id;
			}

			$param['value'] = $options;
		}


		return $param;
	}

	public function edit_form_fields($atts){
		#Functions::_debug($atts);
		return $atts;
	}

	/**
	 * Shortcode output => Get template file and display shortcode
	 * @since 3.5.0
	 */
	public function output($atts, $content = null){
		#Functions::_debug($atts);
		ob_start();
		include(locate_template('vcex_templates/vcex_latest_post_tile.php'));

		return ob_get_clean();
	}

	public function map(){
		return array(
			"name" => __("FAQ accordion", "mk_framework") ,
			"base" => "mk_faq_accordion",
			'icon' => 'icon-mk-faq vc_mk_element-icon',
			"category" => __('Loops', 'mk_framework') ,
			'description' => __('Shows FAQ posts in multiple styles.', 'mk_framework') ,
			"params" => array(
				array(
					"type" => "dropdown",
					"heading" => __("Style", "mk_framework") ,
					"param_name" => "style",
					"width" => 150,
					"value" => array(
						__('Fancy', "mk_framework") => "fancy",
						__('Simple', "mk_framework") => "simple"
					) ,
					"description" => __("", "mk_framework")
				) ,
				array(
					"type" => "textfield",
					"heading" => __("[All] Link Title", "mk_framework"),
					"param_name" => "view_all_text",
					"value" => "All",
					"description" => __("", "mk_framework")
				),
				array(
					"type" => "toggle",
					"heading" => __("Sortable?", "mk_framework") ,
					"param_name" => "sortable",
					"value" => "true",
					"description" => __("Disable this option if you do not want sortable filter navigation.", "mk_framework")
				) ,
				array(
					"type" => "range",
					"heading" => __("Count", "mk_framework") ,
					"param_name" => "count",
					"value" => "50",
					"min" => "-1",
					"max" => "300",
					"step" => "1",
					"unit" => 'FAQs'
				) ,
				array(
					"type" => "range",
					"heading" => __("Offset", "mk_framework") ,
					"param_name" => "offset",
					"value" => "0",
					"min" => "0",
					"max" => "50",
					"step" => "1",
					"unit" => 'posts',
					"description" => __("Number of post to displace or pass over. It means based on your order of the loop, this number will define how many posts to pass over and start from the nth number of the offset.", "mk_framework")
				) ,
				array(
					'type'        => 'autocomplete',
					'heading'     => __( 'Select specific Categories', 'mk_framework' ),
					'param_name'  => 'faq_cat',
					'settings' => array(
						'multiple' => true,
						'sortable' => true,
						'unique_values' => true,
						// In UI show results except selected. NB! You should manually check values in backend
					),
					'description' => __( 'Search for category name to get autocomplete suggestions', 'mk_framework' ),
				),
				array(
					'type'        => 'autocomplete',
					'heading'     => __( 'Select specific Posts', 'mk_framework' ),
					'param_name'  => 'posts',
					'settings' => array(
						'multiple' => true,
						'sortable' => true,
						'unique_values' => true,
						// In UI show results except selected. NB! You should manually check values in backend
					),
					'description' => __( 'Search for post ID or post title to get autocomplete suggestions', 'mk_framework' ),
				),
				array(
					"heading" => __("Order", 'mk_framework') ,
					"description" => __("Designates the ascending or descending order of the 'orderby' parameter.", 'mk_framework') ,
					"param_name" => "order",
					"value" => array(
						__("ASC (ascending order)", 'mk_framework') => "ASC",
						__("DESC (descending order)", 'mk_framework') => "DESC"
					) ,
					"type" => "dropdown"
				) ,
				array(
					"heading" => __("Orderby", 'mk_framework') ,
					"description" => __("Sort retrieved FAQ items by parameter.", 'mk_framework') ,
					"param_name" => "orderby",
					"value" => $mk_orderby,
					"type" => "dropdown"
				) ,
				array(
					"type" => "alpha_colorpicker",
					"heading" => __("Pane Content Background Color", "mk_framework") ,
					"param_name" => "background_color",
					"value" => "",
					"description" => __("", "mk_framework") ,
				) ,
				$add_device_visibility,
				array(
					"type" => "textfield",
					"heading" => __("Extra class name", "mk_framework") ,
					"param_name" => "el_class",
					"value" => "",
					"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in Custom CSS Shortcode or Masterkey Custom CSS option.", "mk_framework")
				)
			)
		);
	}

	public function ajax_filter_terms_by_tax(){
		$up_arrow = html_entity_decode('&uarr;');

		$ret = array(
			'error' => 0,
			'html' => '<option value="0">'.$up_arrow.' Terms not found '.$up_arrow.'</option>',
		);

		$taxonomy = trim($_REQUEST['taxonomy']);
		$args = array(
			'taxonomy'   => $taxonomy,
			'fields'     => 'all',
			'hide_empty' => true,
			'orderby'    => 'name',
			'order'      => 'ASC',
		);
		$terms = get_terms($args);
		if(!empty($terms)){
			$html = '<option value="0">'.esc_html__('- Autodetect -', THEME_TD).'</option>';
			foreach($terms as $term){
				//$html .= '<option value="'.$term->term_id.'">'.$term->name.' ('.$term->count.')</option>';
				$html .= '<option value="'.$term->term_id.'">'.$term->name.'</option>';
			}

			$ret['html'] = $html;
		}

		die(json_encode($ret));
	}

}

new Faq_Accordion;