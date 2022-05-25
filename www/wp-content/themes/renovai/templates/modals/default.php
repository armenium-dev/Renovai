<?php
switch($params['size']){
	case 1:
		$dialog_class = "modal-sm";
		break;
	case 2:
		$dialog_class = "modal-md";
		break;
	case 3:
		$dialog_class = "modal-lg";
		break;
	case 4:
		$dialog_class = "modal-xl";
		break;
	default:
		$dialog_class = "";
		break;
}
$modal_params = '';
if(isset($params['modal_params'])){
	$a = [];
	foreach($params['modal_params'] as $k => $v){
		$a[] = $k.'="'.$v.'"';
	}
	$modal_params = implode(' ', $a);
}
?>
<div class="modal fade js-modal" id="<?=$params['id'];?>" tabindex="-1" aria-labelledby="<?=$params['id'];?>Label" aria-hidden="true" data-backdrop="static" <?=$modal_params;?>>
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable <?=$dialog_class;?>">
		<div class="modal-content <?=$params['class'];?>">
			<div class="modal-header">
				<h5 class="modal-title" id="<?=$params['id'];?>Label"><?=$params['title'];?></h5>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="tk-aktiv-grotesk-thin"><?=$params['content'];?></div>
				<?=$params['form'];?>
			</div>
			<div class="modal-footer">
				<?php foreach($params['buttons'] as $k => $button):?>
					<?php if($button['display']):?>
					<button type="button" class="<?=$button['class'];?>" <?php if($k == 'cancel'):?>data-bs-dismiss="modal"<?php endif;?>><?=$button['title'];?></button>
					<?php endif;?>
				<?php endforeach;?>
			</div>
		</div>
	</div>
</div>
