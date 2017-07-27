<?php
/**
 * The default template for displaying content gallery
 * @package injob
 */
 
$authordata = Inwave_Helper::getAuthorData();
$inwave_theme_option = Inwave_Helper::getConfig();

$showContent = false;
if (is_single() || !get_post_gallery()) {
    $showContent = true;
}
$show_post_infor = 	(isset($inwave_theme_option['show_post_author']) && $inwave_theme_option['show_post_author'])
				|| 	(isset($inwave_theme_option['blog_category_title_listing']) && $inwave_theme_option['blog_category_title_listing'])
				|| 	(isset($inwave_theme_option['show_post_comment']) && $inwave_theme_option['show_post_comment']);
?>

<div class="iw-posts element-item col-md-4 col-sm-6 col-xs-12">
    <article id="post-<?php echo esc_attr(get_the_ID()); ?>" <?php post_class(); ?>>
        <div class="post-item post-gallery">
            <div class="post-image">
                <?php if (!$showContent) :
                    $post = get_post();
                    $gallery = get_post_gallery_images( get_the_ID());
                ?>
                    <div id="ei-slider" class="ei-slider">
                        <ul class="ei-slider-large">
                            <?php foreach($gallery as $gallery_url) {

                                $gallery_url = inwave_resize($gallery_url, 370, 370, true);
                                echo '
                                        <li>
                                            <a href="'.get_the_permalink().'"><img class="srch-photo" src="'.$gallery_url.'" alt=""></a>
                                        </li>';
                            } ?>
                        </ul>
                        <ul class="ei-slider-thumbs">
                            <li class="ei-slider-element"></li>
                            <?php foreach($gallery as $gallery_url) {
                                echo '
                                        <li>
                                            <img class="srch-photo" src="'.$gallery_url.'" alt="">
                                        </li>';
                            } ?>
                        </ul><!-- ei-slider-thumbs -->
                    </div>
                <?php endif; ?>
            </div>
            <?php if($inwave_theme_option['social_sharing_box_category']): ?>
                <div class="post-social-share">
                    <?php
                    inwave_social_sharing(get_permalink(), Inwave_Helper::substrword(get_the_excerpt(), 10), get_the_title());
                    ?>
                </div>
            <?php endif; ?>
            <?php if (is_sticky()){echo '<span class="feature-post">'.esc_html__('Feature', 'injob').'</span>';} ?>
        </div>

    </article><!-- #post-## -->
</div>
