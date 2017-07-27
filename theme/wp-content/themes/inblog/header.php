<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package injob
 */
$header_layout = Inwave_Helper::getPostOption('header_option' , 'header_layout');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php esc_attr(bloginfo('charset')); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" />
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php esc_url(bloginfo('pingback_url')); ?>">
    <?php wp_head(); ?>
</head>
<body id="page-top" <?php body_class(); ?>>
<header style="position: relative">
    <div class="container">
        <div class="right-menu">
            <?php
            $show_search_form = Inwave_Helper::getPostOption('show_search_form', 'show_search_form');
            if($show_search_form == 'yes' || $show_search_form == '1') { ?>

                <span class="search-button" onclick="search()"><i class="fa fa-search"></i></span>
                <span id="close_search" onclick="close_search()"><i class="fa fa-close"></i></span>
                <script>
                    function search(){
                        document.getElementById("search-bar").style.display="block";
                        document.getElementById("close_search").style.display="block";
                    }
                    function close_search(){
                        document.getElementById("search-bar").style.display="none";
                        document.getElementById("close_search").style.display="none";
                        document.getElementById("search-bar").style.width="40%";
                    }
                </script>
            <?php }
            $header_layout = Inwave_Helper::getPostOption('header_option' , 'header_layout');
            if(!$header_layout){
                $header_layout = 'default';
            }

            if($header_layout != 'none'){
                get_template_part('headers/header', $header_layout);
            }?>

            <form class="search-form-header" method="get" action="<?php echo esc_url( home_url( '/' ) )?>">
                     <span class="search-wrap">
						<input type="search" onclick="change_width_search()" title="<?php echo esc_attr_x( 'Search for:', 'label','inmedical' ) ?>" value="<?php echo get_search_query() ?>" name="s" placeholder="<?php echo esc_attr_x( 'Enter your key words...', 'placeholder','inmedical' );?>" id="search-bar">
                    </span>
            </form>
            <script>
                function change_width_search(){
                    document.getElementById("search-bar").style.width="100%";
                }
            </script>
        </div>
			<?php
				get_template_part('blocks/canvas', 'menu');
			?>
    </div>
</header>
