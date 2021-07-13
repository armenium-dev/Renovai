<?php

$logos = get_field('logos', 'option');
$small_logo = $logos['small_logo'];
$logos_title = $logos['logos_title'];
$big_logo = $logos['big_logo'];
?>

<a class="header-logo" href="<?=site_url('/');?>" title="<?=$logos_title;?>"></a>
