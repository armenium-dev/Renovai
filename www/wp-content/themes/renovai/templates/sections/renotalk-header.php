<?php
use Digidez\Functions;
use Digidez\Helper;
use Digidez\DataSource;

#$wp_tag_cloud = DataSource::get_tag_cloud();
#Helper::_debug($wp_tag_cloud);
?>
<section id="<?=$section_name;?>-section" class="blog-header-section position-relative">
    <div class="blog-header-container">
        <div class="container">
            <div class="talk-header-content text-center text-md-left">
                <h1 class="h1"><?=$section_data['section_title'];?></h1>
                <p class="d-none d-md-block mb-1"><?=$section_data['section_content'];?></p>
                <p class="d-block d-md-none mb-1"><?=$section_data['section_content_mob'];?></p>
            </div>
        </div>
    </div>
    <img class="blog-header-img renotalk-header-img" src="<?=$section_data['section_image'];?>" alt="header-img">
</section>
