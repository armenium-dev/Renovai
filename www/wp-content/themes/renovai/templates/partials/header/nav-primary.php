<?php
use Digidez\Functions;
use Digidez\Theme;
use Digidez\Helper;

$menu = Theme::get_menu_tree('primary');
#Helper::_debug($menu); exit;
?>
<nav class="navbar navbar-expand-md headerNavBar p-0">
	<a class="header-logo p-mobile" href="<?=site_url('/');?>" title="<?=get_bloginfo('title');?>"></a>
	<button class="p-mobile navbar-toggler collapsed" type="button" data--toggle="collapse" data-trigger="js_action_click" data-action="toggle_mobile_nav" data-target=".headerNavBar" data-nav-target=".headerNav" aria-controls="headerNavBar" aria-expanded="false"><span></span><span></span><span></span></button>
	<div class="collapse navbar-collapse headerNav">
		<?php if(!empty($menu)):?>
			<ul class="navbar-nav header-nav text-md-left justify-content-start">
				<?php foreach($menu as $k => $level_1_item):?>
					<?php
					$is_button = false;
					$has_dropdown = false;
					$level_1_item_a_class = $level_1_item_li_class = [];
					
					$level_1_item_a_class[] = empty($level_1_item['classes']) ? 'nav-link' : $level_1_item['classes'];
					$level_1_item_li_class[] = 'nav-item';
					
					$data_atts = [];
					
					if(strstr($level_1_item['classes'], 'btn-light') !== false){
						$is_button = true;
						$level_1_item_li_class[] = 'btn-static';
						$level_1_item_li_class[] = 'mr-0';
						$level_1_item_li_class[] = 'pr-0';
						
						$data_atts[] = [
							'trigger' => 'js_action_click',
							'action' => 'save_to_storage',
							'referer' => get_permalink(get_queried_object()),
						];
					}
					if(strstr($level_1_item['classes'], 'btn-secondary') !== false){
						$is_button = true;
						$level_1_item_li_class[] = 'btn-fixed';
						$level_1_item_li_class[] = 'mr-0';
						$level_1_item_li_class[] = 'pr-0';
						
						$data_atts[] = [
							'trigger' => 'js_action_click',
							'action' => 'save_to_storage',
							'referer' => get_permalink(get_queried_object()),
						];
					}
					if(strstr($level_1_item['classes'], 'btn-primary') !== false){
						$is_button = true;
						$level_1_item_li_class[] = 'mr-0';
						$level_1_item_li_class[] = 'pr-0';
						$level_1_item_li_class[] = 'd-md-none';
						$level_1_item_li_class[] = 'mt-3';
						
						$data_atts[] = [
							'trigger' => 'js_action_click',
							'action' => 'save_to_storage',
							'referer' => get_permalink(get_queried_object()),
						];
					}
					$data_anchore = Functions::create_button_data_attributes($data_atts);
					if(isset($level_1_item['items']) && count($level_1_item['items']) > 0){
						$has_dropdown = true;
						$level_1_item_a_class[] = 'dropdown-toggle';
						$level_1_item_li_class[] = 'dropdown';
					}
					$level_1_item_a_class[] = $level_1_item['active_class'];
					$level_1_item_li_class[] = $level_1_item['active_class'];
					
					$level_1_item_a_class = implode(' ', $level_1_item_a_class);
					$level_1_item_li_class = implode(' ', $level_1_item_li_class);
					?>
					<li id="dropdown_<?=$k;?>" class="<?=$level_1_item_li_class;?>">
						<a class="<?=$level_1_item_a_class;?>" <?=$data_anchore;?> href="<?=$level_1_item['url'];?>" target="<?=$level_1_item['target'];?>">
							<span><?=$level_1_item['name'];?></span>
						</a>
						<?php if(!$is_button && $has_dropdown):?>
						<span class="caret" <?php if(!$is_button && $has_dropdown):?>data-trigger="js_action_click" data-action="toggle_submenu" data-target="#dropdown_<?=$k;?>"<?php endif;?>>
							<svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 8L0.803849 0.799999L11.1962 0.8L6 8Z" fill="#0D0D30"/></svg>
						</span>
						<?php endif;?>
		
						<?php if($has_dropdown):?>
							<div class="dropdown-menu">
								<?php foreach($level_1_item['items'] as $k2 => $level_2_item):?>
								
									<?php if(isset($level_2_item['items']) && count($level_2_item['items']) > 0):?>
										<div id="dropdown_<?=$k2;?>" class="dropdown-item">
											<a href="<?=$level_2_item['url'];?>" class="submenu-label">
												<span><?=$level_2_item['name'];?></span>
											</a>
											<span class="caret" data-trigger="js_action_click" data-action="toggle_submenu" data-target="#dropdown_<?=$k2;?>">
												<svg width="12" height="8" viewBox="0 0 12 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 8L0.803849 0.799999L11.1962 0.8L6 8Z" fill="#0D0D30"/></svg>
											</span>
											<div class="dropdown-wrap">
												<div class="dropdown-submenu">
													<?php foreach($level_2_item['items'] as $k3 => $level_3_item):?>
														<a href="<?=$level_3_item['url'];?>" class="dropdown-item dropdown-item-mobile <?=$level_3_item['classes'];?>"><?=$level_3_item['name'];?></a>
													<?php endforeach;?>
												</div>
											</div>
										</div>
									<?php else:?>
										<a href="<?=$level_2_item['url'];?>" class="dropdown-item <?=$level_2_item['classes'];?> <?php #=$level_2_item['active_class'];?>"><?=$level_2_item['name'];?></a>
									<?php endif;?>
								
								<?php endforeach;?>
							</div>
						<?php endif;?>
		
					</li>
				<?php endforeach;?>
				<?php do_action('add_logout_item');?>
			</ul>
		<?php endif;?>
	</div>
</nav>