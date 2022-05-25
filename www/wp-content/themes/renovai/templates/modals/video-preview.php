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
			<button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">&times;</button>
			<video id=""
			       src=""
			       crossorigin="anonymous"
			       poster=""
			       aria-label="Video"
			       controlslist="nodownload"
			       controls="controls"
			       playsinline="playsinline"
			       preload="metadata"
			       autoplay="autoplay"
			       type="video/mp4"
			       x-webkit-airplay="allow"
			></video>
		</div>
	</div>
</div>
