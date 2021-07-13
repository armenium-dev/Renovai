<?php
use Digidez\Functions;

?>
<?php foreach($items as $item):?>
	<?php
	$description = '';
	foreach($item->cf['candidate_resume'] as $resume)
		$description .= $resume['description'];
	$description = Functions::create_excerpt($description, 130);
	$link = get_permalink($item->ID);?>
	<article id="candidate-<?=$item->ID;?>" class="candidate-item trans_all" data-href="<?=$link;?>">
		<div class="row">
			<div class="col-md-12">
				<?php if(has_post_thumbnail()):?>
					<figure>
						<a href="<?=$link;?>"><?=Functions::get_the_post_thumbnail($item->ID, '200x200', ['alt' => $item->post_title]);?></a>
					</figure>
				<?php endif;?>
				<h3 class="section-title"><a href="<?=$link;?>"><?=$item->post_title;?></a></h3>
				<div class="position"><?=$item->cf['candidate_position'];?></div>
				<div class="meta tk-aktiv-grotesk-thin">
					<div><?=$item->cf['candidate_location'];?></div>
					<div class="base-id">Base ID: <?=$item->cf['candidate_base_id'];?></div>
				</div>
				<div class="resume">
					<div class="info tk-aktiv-grotesk-thin"><?=$description;?></div>
				</div>
				<?php /*
				<div class="skills tk-aktiv-grotesk-thin">
					<a role="button"><?=implode('</a><a role="button">', $item->cf['candidate_skills']);?></a>
				</div>
				*/?>
				<div class="call-btn-row">
					<button type="button" class="button js_ignore_parent_link" data-base_id="<?=$item->cf['candidate_base_id'];?>" data-toggle="modal" data-target="#js_request_resume_<?=$parent_cf['section_talent_vault_main']['section_candidates_request_resume_form'];?>">Request Resume</button>
				</div>
			</div>
		</div>
	</article>
<?php endforeach;?>
