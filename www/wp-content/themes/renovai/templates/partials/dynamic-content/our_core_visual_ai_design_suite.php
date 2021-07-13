<div id="<?=$sub_id;?>" class="col-12">
	<div class="mb-md-8 mb-3">
		<h2 class="h2 text-center text-md-left"><?=$item_data['title'];?></h2>
	</div>
	<div class="title-right-white mb-10">
		<div class="container">
			<div class="row row-cols-1 row-cols-md-3">
				<?php foreach($item_data['images'] as $image):?>
				<div class="col text-center">
					<p><?=$image['caption'];?></p><img class="img-fluid" src="<?=$image['image'];?>" alt="<?=$image['caption'];?>" title="<?=$image['caption'];?>">
				</div>
				<?php endforeach;?>
			</div>
		</div>
	</div>
</div>
