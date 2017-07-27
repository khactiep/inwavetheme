<?php
$theme_menu = Inwave_Helper::getPostOption('primary_menu');
if(!$theme_menu){
    $locations = get_nav_menu_locations();
    $menu_id = isset($locations[ 'primary' ]) ? $locations[ 'primary' ] : '' ;
    $nav_menu = wp_get_nav_menu_object($menu_id);
}else{
    $nav_menu = wp_get_nav_menu_object($theme_menu);
}
?>
<nav class="st-menu">
	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span style="background-color: white" class="icon-bar"></span>
        <span style="background-color: white" class="icon-bar"></span>
        <span style="background-color: white" class="icon-bar"></span>
    </button>
	<div class="collapse navbar-collapse" id="myNavbar">
    <?php
    wp_nav_menu(array(
        "container"             => "",
        'menu'                  => $theme_menu,
        'theme_location'        => 'primary',
        "menu_class"            => "canvas-menu",
        "walker"                => new Inwave_Nav_Walker_Mobile(),
        "hidden_number"         => true
    ));
    ?>
	</div>
</nav>

