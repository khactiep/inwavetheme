<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package injob
 */

$footer_layout = Inwave_Helper::getPostOption('footer_option', 'footer_option');
$footer_layout = $footer_layout ? $footer_layout : 'default';
$inwave_theme_option = Inwave_Helper::getConfig();
?>
<div class="line"></div>
<div class="text_follow_insta">Follow Instagram</div>
<div id="sidebar_bottom">
    <?php
        echo do_shortcode('[instagram-feed num=5 cols=5 showfollow=false showheader=false showbutton=false imagepadding=0]');
    ?>
</div>
    <?php
        get_template_part('blocks/social', 'footer');
    ?>
<div class="footer_bottom">
	
	<?php 
		get_template_part('blocks/menu', 'footer');
		get_template_part('footer/footer', $footer_layout);
	?>
</div>

</div><!--end .content-wrapper -->
<?php wp_footer(); ?>
</body>
</html>
