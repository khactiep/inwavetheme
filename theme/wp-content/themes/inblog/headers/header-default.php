<?php
$inwave_theme_option = Inwave_Helper::getConfig();
$header_sticky = Inwave_Helper::getPostOption('header_sticky', 'header_sticky');
$show_buy_service = Inwave_Helper::getPostOption('show_buy_service', 'show_buy_service');
$show_post_a_job = Inwave_Helper::getPostOption('show_post_a_job', 'show_post_a_job');
$show_search_form = Inwave_Helper::getPostOption('show_search_form', 'show_search_form');
$logo = Inwave_Helper::getPostOption('logo', 'logo');
$logo_sticky = Inwave_Helper::getPostOption('logo_sticky', 'logo_sticky');
$show_page_heading = Inwave_Helper::getPostOption('show_pageheading', 'show_page_heading');

$header_class = '';
if(!is_page_template( 'page-templates/home-page.php' ) && !is_singular('post') && $show_page_heading == 'no') {
    $header_class = ' no-page-heading';
}

?>
<div class="header header-default header-style-default <?php if ($header_sticky && $header_sticky != 'no') { echo 'header-sticky';} echo esc_attr($header_class); ?> ">  
                <div class="top-bar-right">
                    <div class="social-header">
						<span><?php echo inwave_get_social_link(); ?></span>
                    </div>
                </div>
</div>

<!--End Header-->