<?php
use Digidez\Functions;
?>
<div class="jobs">
	<?php foreach($items as $item):?>
		<?php
		$postmeta = get_post_meta($item->ID);
		$date = human_time_diff(get_the_time('U', $item->ID), current_time('timestamp')).' ago';
		?>
		<div class="job-item">
			<h2 class="title fw-900"><a href="<?=get_permalink($item->ID);?>"><?=$item->post_title;?></a></h2>
			<div class="info tk-aktiv-grotesk-thin">
				<abbr class="location"><?=$postmeta["bullhorn_job_location"][0];?></abbr>
				<span class="delim">|</span>
				<time class="posted-at"><?=$date;?></time>
			</div>
			<p class="desc">
				<strong>SUMMARY:</strong>
				<span class="tk-aktiv-grotesk-thin"><?=strip_tags(substr($item->post_content, 0, 200));?></span>
			</p>
			<div class="extra-links">
				<a role="button" class="button" href="<?=get_permalink($item->ID);?>">Apply Now</a>
				<a role="button" class="button" href="<?=get_permalink($item->ID);?>">Read More</a>
				<a role="button" tabindex="0" class="share trans_all" data-container="body" data-toggle="popover" data-placement="left" data-html="true" title="Social Share">
					<?=Functions::get_svg_inline(ICONS_DIR.'/icon-share.svg');?>
				</a>
				<?=Functions::get_social_shareing_html($item);?>
			</div>
		</div>
		<div class="separator clearfix"></div>
	<?php endforeach;?>
</div>