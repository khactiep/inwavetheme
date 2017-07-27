<?php
/*
Plugin Name: Contact shortcode
Plugin URI:
Description: Contact shortcode
Version: 1.2
Author: Mr.KhacTiep
Author URI:
License: GPL2
 */

function Contact_shortcode_function(){
    get_template_part('blocks/headerbackground/header', 'big');
    ?>
    <div class="container" style="padding: 0 100px">
        <div id="sidebar_top">
            <img src="http://localhost:8888/khactiep/wp-content/uploads/2017/03/106.png" width="100%">
        </div>
        <div style="text-align: center; color: black; margin-top: 30px;">
            <div class="contact-title">Contact me</div>
            <?php
                echo esc_html__('the content');
                get_template_part('blocks/social/social', 'line2');
            ?>
        </div>
        <div class="form-contact">
            <?php echo do_shortcode('[contact-form-7 id="300" title="Inwave_Contactform"]');?>
        </div>
    </div>
<?php }
add_shortcode( 'Contact_shortcode', 'Contact_shortcode_function' );
?>