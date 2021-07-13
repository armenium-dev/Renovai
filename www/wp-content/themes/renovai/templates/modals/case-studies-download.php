<?php
use Digidez\Functions;

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
<div class="modal fade" id="<?=$params['id'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" <?=$modal_params;?>>
	<div class="modal-dialog modal-dialog-centered <?=$dialog_class;?>">
		<div class="modal-content <?=$params['class'];?>">
			<div class="modal-header">
				<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="text-center">
					<img src="<?=$params['image'];?>" alt="" title="">
					<h3 class="mt-5 mb-5"><?=$params['content'];?></h3>
					<img src="<?=$params['logo'];?>" alt="" title="" class="my-5">
				</div>
			</div>
		</div>
	</div>
</div>
