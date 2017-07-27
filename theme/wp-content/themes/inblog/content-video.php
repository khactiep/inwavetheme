<?php
/**
 * The default template for displaying content video
 * @package injob
 */
$authordata = Inwave_Helper::getAuthorData();
$inwave_theme_option = Inwave_Helper::getConfig();
$show_post_infor = 	(isset($inwave_theme_option['show_post_author']) && $inwave_theme_option['show_post_author'])
				|| 	(isset($inwave_theme_option['blog_category_title_listing']) && $inwave_theme_option['blog_category_title_listing'])
				|| 	(isset($inwave_theme_option['show_post_comment']) && $inwave_theme_option['show_post_comment']);
?>

<div class="iw-posts element-item col-md-4 col-sm-6 col-xs-12">
    <article id="post-<?php echo esc_attr(get_the_ID()); ?>" <?php post_class(); ?>>
        <div class="post-item fit-video">
            <div class="featured-image">
                <?php
                $img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
                $img_src = count($img) ? $img[0] : '';
                if(!$img_src){
                    $img_src = inwave_get_placeholder_image();
                }
                $img_src = inwave_resize($img_src, 370, 370, true);
                ?>
                <img src="<?php echo $img_src; ?>" alt="">
                <a href="<?php the_permalink(); ?>" class="button-detail"><i class="fa fa-play"></i></a>
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