<?php

namespace Digidez;

use WP_Widget;
use WP_Customize_Manager;

class Nav_Menu extends WP_Widget{
	
	public function __construct(){
		$widget_ops = array(
			'description'                 => __('Add a navigation menu to your sidebar.'),
			'customize_selective_refresh' => true,
		);
		parent::__construct('digidez_nav_menu', __('Theme Nav Menu'), $widget_ops);
	}
	
	public function widget($args, $instance){
		
		// Get menu.
		$nav_menu = !empty($instance['nav_menu']) ? wp_get_nav_menu_object($instance['nav_menu']) : false;
		
		if(!$nav_menu){
			return;
		}
		
		$menu = Theme::get_menu_tree(null, $nav_menu->term_id);
		
		$title = !empty($instance['title']) ? $instance['title'] : '';
		
		echo $args['before_widget'];
		
		if($title){
			echo $args['before_title'].$title.$args['after_title'];
		}
		
		if(!empty($menu)){
			foreach($menu as $k => $level_1_item){
				$level_1_item_a_class = [];
				$level_1_item_a_class[] = 'text-white';
				$level_1_item_a_class[] = $level_1_item['active_class'];
				$level_1_item_a_class = implode(' ', $level_1_item_a_class);
				
				if($level_1_item['url'] == '#'){
					echo '<p><b>'.$level_1_item['name'].'</b></p>';
				}else{
					echo '<p><b><a class="'.$level_1_item_a_class.'" href="'.$level_1_item['url'].'" target="'.$level_1_item['target'].'">'.$level_1_item['name'].'</a></b></p>';
				}
				
				if(isset($level_1_item['items']) && count($level_1_item['items']) > 0){
					foreach($level_1_item['items'] as $level_2_item){
						$level_2_item_a_class = [];
						$level_2_item_a_class[] = 'text-white';
						$level_2_item_a_class[] = 'd-inline-block';
						$level_2_item_a_class[] = $level_2_item['active_class'];
						$level_2_item_a_class = implode(' ', $level_2_item_a_class);
						
						echo '<div class="mb-2"><a class="'.$level_2_item_a_class.'" href="'.$level_2_item['url'].'" target="'.$level_2_item['target'].'">'.$level_2_item['name'].'</a></div>';
					}
				}
			}
		}
		
		echo $args['after_widget'];
	}
	
	public function update($new_instance, $old_instance){
		$instance = array();
		if(!empty($new_instance['title'])){
			$instance['title'] = sanitize_text_field($new_instance['title']);
		}
		if(!empty($new_instance['nav_menu'])){
			$instance['nav_menu'] = (int)$new_instance['nav_menu'];
		}
		
		return $instance;
	}
	
	public function form($instance){
		global $wp_customize;
		$title    = isset($instance['title']) ? $instance['title'] : '';
		$nav_menu = isset($instance['nav_menu']) ? $instance['nav_menu'] : '';
		
		// Get menus.
		$menus = wp_get_nav_menus();
		
		$empty_menus_style     = '';
		$not_empty_menus_style = '';
		if(empty($menus)){
			$empty_menus_style = ' style="display:none" ';
		}else{
			$not_empty_menus_style = ' style="display:none" ';
		}
		
		$nav_menu_style = '';
		if(!$nav_menu){
			$nav_menu_style = 'display: none;';
		}
		
		// If no menus exists, direct the user to go and create some.
		?>
		<p class="nav-menu-widget-no-menus-message" <?php echo $not_empty_menus_style; ?>>
			<?php
			if($wp_customize instanceof WP_Customize_Manager){
				$url = 'javascript: wp.customize.panel( "nav_menus" ).focus();';
			}else{
				$url = admin_url('nav-menus.php');
			}
			
			/* translators: %s: URL to create a new menu. */
			printf(__('No menus have been created yet. <a href="%s">Create some</a>.'), esc_attr($url));
			?>
		</p>
		<div class="nav-menu-widget-form-controls" <?php echo $empty_menus_style; ?>>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>"/>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('nav_menu'); ?>"><?php _e('Select Menu:'); ?></label>
				<select id="<?php echo $this->get_field_id('nav_menu'); ?>" name="<?php echo $this->get_field_name('nav_menu'); ?>">
					<option value="0"><?php _e('&mdash; Select &mdash;'); ?></option>
					<?php foreach($menus as $menu) : ?>
						<option value="<?php echo esc_attr($menu->term_id); ?>" <?php selected($nav_menu, $menu->term_id); ?>>
							<?php echo esc_html($menu->name); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</p>
			<?php if($wp_customize instanceof WP_Customize_Manager) : ?>
				<p class="edit-selected-nav-menu" style="<?php echo $nav_menu_style; ?>">
					<button type="button" class="button"><?php _e('Edit Menu'); ?></button>
				</p>
			<?php endif; ?>
		</div>
		<?php
	}
}
