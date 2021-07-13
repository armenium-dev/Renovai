<?php
use Digidez\Functions;

$favicons = get_field('favicons', 'option');
/*if(stristr($_SERVER['HTTP_USER_AGENT'], 'Lighthouse') === false){
}else{
	$google['tag_head_code'] = '';
}*/
#Functions::_debug($google);



?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
	    <meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="pingback" href="<?php bloginfo('pingback_url');?>" />
	    <link rel="baseurl" href="<?=site_url();?>">
	    <meta name="HandheldFriendly" content="True" />
	    <meta name="apple-mobile-web-app-capable" content="yes" />
	    <meta name="mobile-web-app-capable" content="yes">
	    <meta name="msapplication-tap-highlight" content="no"/>
	    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
	    <meta name="theme-color" content="#fff">
	    <link rel="icon" type="image/x-icon" href="<?=$favicons['size_256x256'];?>">
	    <link rel="icon" href="<?=$favicons['size_32x32'];?>" sizes="32x32">
	    <link rel="icon" href="<?=$favicons['size_192x192'];?>" sizes="192x192">
	    <link rel="apple-touch-icon-precomposed" href="<?=$favicons['size_180x180'];?>">
	    <meta name="msapplication-TileImage" content="<?=$favicons['size_270x270'];?>">
	    <?php Functions::render_cookiebox(true, false);?>
	    <?php wp_head();?>
    </head>
    <body <?php body_class();?>>
	    <?php Functions::render_header();?>
        <main class="overflow-hidden position-relative">
			
