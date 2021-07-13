<?php

namespace Digidez;

use WP_Widget;

/**
 * Adds the Social_Icons widget
 */
class Social_Icons extends WP_Widget {
	
	/**
	 * Default widget settings
	 * @var array
	 */
	protected $defaults;
	
	/**
	 * Register widget with WordPress
	 */
	public function __construct(){
		
		$widget_ops = [
			'classname'                   => 'social_icons_widget',
			'description'                 => __('Display your social icons.', THEME_TD),
			'customize_selective_refresh' => true,
		];
		
		parent::__construct('social_icons', __('Social Icons', THEME_TD), $widget_ops);
		
		$this->defaults = [
			'title'       => __('Follow Us', THEME_TD),
			'description' => '',
			'icon_dims'   => 34,
			'icon_size'   => 16,
			'icon_shape'  => 'round',
			'icon_type'  => 'svg',
			'url_target'  => '_blank',
			'profiles'    => [],
		];
		
		add_action('wp_enqueue_scripts', [$this, 'front_scripts']);
	}
	
	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget($args, $instance){
		$html = '';
		
		extract($args);
		
		extract(wp_parse_args((array)$instance, $this->defaults));
		
		$style = '<style type="text/css">
		.social_icons_widget ul .cswi-icon {%s}
		@media all and (max-width: 991px){
			.social_icons_widget ul .cswi-icon {%s}
		}
		</style>';
		$inline_style = '';
		$inline_style_mob = '';
		
		$html .= $before_widget;
		
		if($title = apply_filters('widget_title', $title)){
			$html .= wp_kses_post($before_title.$title.$after_title);
		}
		
		if($description){
			$html .= '<div class="siw-desc">'.wpautop(wp_kses_post($description)).'</div>';
		}
		
		if($profiles){
			$social_ops = $this->get_social_ops();
			$html .= '<ul class="siw-shape-'.esc_attr($icon_shape).' siw-type-'.$icon_type.'">';
			
			$icon_dims = absint($icon_dims);
			$icon_dims_mob = $icon_dims - 16;
			
			if($icon_dims && $this->defaults['icon_dims'] !== $icon_dims){
				$icon_dims = $icon_dims.'px';
				$icon_dims_mob = $icon_dims_mob.'px';
				
				$inline_style .= ' width:'.$icon_dims.';height:'.$icon_dims.';line-height: '.$icon_dims.';';
				$inline_style_mob .= ' width:'.$icon_dims_mob.';height:'.$icon_dims_mob.';line-height: '.$icon_dims_mob.';';
			}
			
			if($icon_size && $this->defaults['icon_size'] !== $icon_size){
				$inline_style .= ' font-size:'.$icon_size.'px;';
			}
			
			if($inline_style){
				$inline_style = sprintf($style, $inline_style, $inline_style_mob);
			}
			
			foreach($profiles as $k => $v){
				if(is_customize_preview()){
					$url = isset($v['url']) ? esc_url($v['url']) : '#';
				}else{
					$url = isset($v['url']) ? esc_url($v['url']) : '';
				}
				
				if(!isset($social_ops[$v['site']]) || !$url){
					continue;
				}
				
				$target = '_blank' == $url_target ? ' target="blank"' : '';
				
				if(strstr($url, 'tel:') !== false || strstr($url, 'mailto:') !== false){
					$target = '';
				}
				
				
				if($icon_type == 'font'){
					$html .= '<li class="siw-'.esc_attr($v['site']).'"><a href="'.esc_url($url).'"'.$target.'><span class="'.$social_ops[$v['site']]['icon_class'].' cswi-icon"></span><span class="screen-reader-text">'.$social_ops[$v['site']]['name'].'</span></a></li>';
				}elseif($icon_type == 'svg'){
					$html .= '<li class="siw-'.esc_attr($v['site']).'"><a href="'.esc_url($url).'"'.$target.' class="'.$social_ops[$v['site']]['icon_class'].' cswi-icon" title="'.$social_ops[$v['site']]['name'].'">'.Functions::get_svg_inline(ICONS_DIR.'/'.$social_ops[$v['site']]['icon_svg']).'</a></li>';
				}
			}
		
			$html .= '</ul>';
		}
		
		$html .= $after_widget;
		
		echo $inline_style.$html;
	}
	
	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form($instance){
		
		extract(wp_parse_args($instance, $this->defaults));
		
		$social_ops = $this->get_social_ops(); ?>

		<div class="siw-form">
			<p>
				<label for="<?=esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', THEME_TD); ?>:</label>
				<input id="<?=esc_attr($this->get_field_id('title')); ?>" type="text" name="<?=esc_attr($this->get_field_name('title')); ?>" value="<?=esc_attr($title); ?>" class="widefat"/>
			</p>

			<p>
				<label for="<?=esc_attr($this->get_field_id('description')); ?>"><?php esc_html_e('Description', THEME_TD); ?>:</label>
				<textarea id="<?=esc_attr($this->get_field_id('description')); ?>" rows="1" name="<?=esc_attr($this->get_field_name('description')); ?>" class="widefat"><?=wp_kses_post($description); ?></textarea>
			</p>

			<p>
				<label for="<?=esc_attr($this->get_field_id('icon_dims')); ?>"><?php esc_html_e('Icon Dimensions', THEME_TD); ?>:</label>
				<input id="<?=esc_attr($this->get_field_id('icon_dims')); ?>" type="number" name="<?=esc_attr($this->get_field_name('icon_dims')); ?>" value="<?=absint($icon_dims); ?>" class="small-text" step="1" min="12" max="100"/> px
			</p>
			
			<?php /*
			<p>
				<label for="<?=esc_attr($this->get_field_id('icon_size')); ?>"><?php esc_html_e('Icon Font Size', THEME_TD); ?>:</label>
				<input id="<?=esc_attr($this->get_field_id('icon_size')); ?>" type="number" name="<?=esc_attr($this->get_field_name('icon_size')); ?>" value="<?=absint($icon_size); ?>" class="small-text" step="1" min="12" max="100"/> px
			</p>
			*/?>
			<p>
				<label for="<?=esc_attr($this->get_field_id('icon_shape')); ?>"><?php esc_html_e('Icon Shape', THEME_TD); ?>:</label>
				<select id="<?=$this->get_field_id('icon_shape'); ?>" name="<?=$this->get_field_name('icon_shape'); ?>">
					<option value="rounded" <?php selected('rounded', $icon_shape); ?>><?php esc_html_e('Rounded', THEME_TD); ?></option>
					<option value="round" <?php selected('round', $icon_shape); ?>><?php esc_html_e('Round', THEME_TD); ?></option>
					<option value="square" <?php selected('square', $icon_shape); ?>><?php esc_html_e('Square', THEME_TD); ?></option>
				</select>
			</p>
			
			<p>
				<label for="<?=esc_attr($this->get_field_id('icon_type')); ?>"><?php esc_html_e('Icon Type', THEME_TD); ?>:</label>
				<select id="<?=$this->get_field_id('icon_type'); ?>" name="<?=$this->get_field_name('icon_type'); ?>">
					<option value="svg" <?php selected('svg', $icon_shape); ?>><?php esc_html_e('SVG', THEME_TD); ?></option>
					<option value="font" <?php selected('font', $icon_shape); ?>><?php esc_html_e('Font', THEME_TD); ?></option>
				</select>
			</p>
			
			<p>
				<label for="<?=esc_attr($this->get_field_id('url_target')); ?>"><?php esc_html_e('Link Target', THEME_TD); ?>:</label>
				<select id="<?=$this->get_field_id('url_target'); ?>" name="<?=$this->get_field_name('url_target'); ?>">
					<option value="_blank" <?php selected('_blank', $url_target); ?>><?php esc_html_e('New Tab', THEME_TD); ?></option>
					<option value="_self" <?php selected('_self', $url_target); ?>><?php esc_html_e('Same Tab', THEME_TD); ?></option>
				</select>
			</p>

			<h4><?php esc_html_e('Social Profiles', THEME_TD); ?>:</h4>

			<ul id="<?=esc_attr($this->get_field_id('profiles')); ?>" class="siw-sortable">
				
				<?php foreach($profiles as $profile_k => $profile_v) : ?>

					<li>

						<span class="siw-remove dashicons dashicons-no-alt"></span>

						<p>

							<label><?php esc_html_e('Profile', THEME_TD); ?>:</label>

							<select type="text" name="<?=$this->get_field_name('social_site'); ?>[]">
								<?php foreach($social_ops as $k => $v) : ?>
									<option value="<?=esc_attr($k); ?>" <?php selected($k, $profile_v['site']); ?>><?=esc_attr($v['name']); ?></option>
								<?php endforeach; ?>
							</select>

						</p>

						<p>

							<label><?php esc_html_e('URL', THEME_TD); ?>:</label>

							<input type="text" name="<?=$this->get_field_name('social_url'); ?>[]" value="<?=$profile_v['url']; ?>"/>

						</p>

					</li>
				
				<?php endforeach; ?>

			</ul>

			<p><a href="#" class="siw-add button"><?php _e('Add Profile', THEME_TD); ?></a></p>

			<div class="siw-clone">

				<span class="siw-remove dashicons dashicons-no-alt"></span>

				<p>
					<label><?php esc_html_e('Profile', THEME_TD); ?>:</label>

					<select type="text" name="<?=$this->get_field_name('social_site'); ?>[]">
						<?php foreach($social_ops as $k => $v) : ?>
							<option value="<?=esc_attr($k); ?>"><?=esc_attr($v['name']); ?></option>
						<?php endforeach; ?>
					</select>

				</p>

				<p>

					<label><?php esc_html_e('URL', THEME_TD); ?>:</label>

					<input type="text" name="<?=$this->get_field_name('social_url'); ?>[]"/>

				</p>

			</div>

		</div>
	
	<?php }
	
	/**
	 * Processing widget options on save
	 *
	 * @param array $new The new options
	 * @param array $old The previous options
	 *
	 * @return array
	 */
	public function update($new, $old){
		
		$instance                = $old;
		$instance['title']       = !empty($new['title']) ? wp_strip_all_tags($new['title']) : '';
		$instance['description'] = !empty($new['description']) ? wp_kses_post($new['description']) : '';
		$instance['icon_dims']   = !empty($new['icon_dims']) ? absint($new['icon_dims']) : $this->defaults['icon_dims'];
		$instance['icon_size']   = !empty($new['icon_size']) ? absint($new['icon_size']) : $this->defaults['icon_size'];
		$instance['icon_shape']  = !empty($new['icon_shape']) ? wp_strip_all_tags($new['icon_shape']) : $this->defaults['icon_shape'];
		$instance['icon_type']   = !empty($new['icon_type']) ? wp_strip_all_tags($new['icon_type']) : $this->defaults['icon_type'];
		$instance['url_target']  = !empty($new['url_target']) ? wp_strip_all_tags($new['url_target']) : $this->defaults['url_target'];
		
		$instance['profiles'] = [];
		
		if(!empty($new['social_site'])){
			for($i = 0; $i < (count($new['social_site']) - 1); $i++){
				$instance['profiles'][] = [
					'site' => $new['social_site'][$i],
					'url'  => esc_url($new['social_url'][$i])
				];
			}
		}
		
		return $instance;
		
	}
	
	/**
	 * Load front-end scripts for this widget
	 * @return null
	 */
	public function front_scripts($hook){
		$script_version = '1.0';
		$script_version = time();
		wp_enqueue_style('social-icons-widget', CSS_URI.'/widgets-frontend.css', false, $script_version);
	}
	
	/**
	 * Returns array of social options
	 * @return array
	 */
	public function get_social_ops(){
		return [
			#'android'     => ['name' => 'Android', 'icon_class' => 'cswi cswi-android', 'icon_svg' => '.svg'],
			#'amazon'      => ['name' => 'Amazon', 'icon_class' => 'cswi cswi-amazon', 'icon_svg' => '.svg'],
			#'buffer'      => ['name' => 'Buffer', 'icon_class' => 'cswi cswi-buffer', 'icon_svg' => '.svg'],
			#'dribbble'    => ['name' => 'Dribbble', 'icon_class' => 'cswi cswi-dribbble', 'icon_svg' => '.svg'],
			'email'     => ['name' => 'Email', 'icon_class' => 'cswi cswi-email', 'icon_svg' => 'icon-email.svg'],
			'facebook'  => ['name' => 'Facebook', 'icon_class' => 'cswi cswi-facebook', 'icon_svg' => 'icon-facebook.svg'],
			#'flickr'      => ['name' => 'Flickr', 'icon_class' => 'cswi cswi-flickr', 'icon_svg' => '.svg'],
			#'google_plus' => ['name' => 'Google Plus', 'icon_class' => 'cswi cswi-gplus', 'icon_svg' => '.svg'],
			'instagram' => ['name' => 'Instagram', 'icon_class' => 'cswi cswi-instagram', 'icon_svg' => 'icon-instagram.svg'],
			'linkedin'  => ['name' => 'Linkedin', 'icon_class' => 'cswi cswi-linkedin', 'icon_svg' => 'icon-linkedin.svg'],
			#'paypal'      => ['name' => 'Paypal', 'icon_class' => 'cswi cswi-paypal', 'icon_svg' => '.svg'],
			'phone'     => ['name' => 'Phone', 'icon_class' => 'cswi cswi-phone', 'icon_svg' => 'icon-phone.svg'],
			#'pinterest'   => ['name' => 'Pinterest', 'icon_class' => 'cswi cswi-pinterest', 'icon_svg' => '.svg'],
			#'pocket'      => ['name' => 'Pocket', 'icon_class' => 'cswi cswi-pocket', 'icon_svg' => '.svg'],
			#'reddit'      => ['name' => 'Reddit', 'icon_class' => 'cswi cswi-reddit', 'icon_svg' => '.svg'],
			#'rss'         => ['name' => 'RSS', 'icon_class' => 'cswi cswi-rss', 'icon_svg' => '.svg'],
			#'steam'       => ['name' => 'Steam', 'icon_class' => 'cswi cswi-steam', 'icon_svg' => '.svg'],
			#'stripe'      => ['name' => 'Stripe', 'icon_class' => 'cswi cswi-stripe', 'icon_svg' => '.svg'],
			#'stumbleupon' => ['name' => 'Stumbleupon', 'icon_class' => 'cswi cswi-stumbleupon', 'icon_svg' => '.svg'],
			'twitter'   => ['name' => 'Twitter', 'icon_class' => 'cswi cswi-twitter', 'icon_svg' => 'icon-twitter.svg'],
			#'tumblr'      => ['name' => 'Tumblr', 'icon_class' => 'cswi cswi-tumblr', 'icon_svg' => '.svg'],
			#'vimeo'       => ['name' => 'Vimeo', 'icon_class' => 'cswi cswi-vimeo', 'icon_svg' => '.svg'],
			#'vk'          => ['name' => 'VK', 'icon_class' => 'cswi cswi-vk', 'icon_svg' => '.svg'],
			#'wordpress'   => ['name' => 'WordPress', 'icon_class' => 'cswi cswi-wordpress', 'icon_svg' => '.svg'],
			#'xing'        => ['name' => 'Xing', 'icon_class' => 'cswi cswi-xing', 'icon_svg' => '.svg'],
			#'yelp'        => ['name' => 'Yelp', 'icon_class' => 'cswi cswi-yelp', 'icon_svg' => '.svg'],
			'youtube'   => ['name' => 'YouTube', 'icon_class' => 'cswi cswi-youtube', 'icon_svg' => 'icon-youtube.svg'],
		];
	}
	
}

