<?php
/**
 * The template for displaying pages
 * @package injob
 */
get_header();

$sidebar_position = Inwave_Helper::getPostOption('sidebar_position', 'sidebar_position');
$sidebar_name = Inwave_Helper::getPostOption('sidebar_name');
get_template_part('blocks/headerbackground/header', 'small');
?>

<div class="contents-main" id="contents-main">
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="page-title">
                <?php the_title(); ?>
            </div>
            <div class="featured-image">
                <?php
                    $img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
                    $img_src = count($img) ? $img[0] : '';
                    echo '<img src="'.$img_src.'" style="width: 100%" alt="">';
                ?>
            </div>
            <?php while (have_posts()) : the_post(); ?>
                    <div class="page-content">
                        <?php get_template_part('content', 'page'); ?>
                    </div>
                <?php
                // If comments are open or we have at least one comment, load up the comment template
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
                ?>
            <?php endwhile; // end of the loop. ?>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-6">
            <div class="sidebar_right">
                <?php
                if ( is_active_sidebar('right_sidebar') ) {
                    dynamic_sidebar( 'right_sidebar' );
                }
                ?>
            </div>
        </div>
    </div>
</div>
</div>
<?php get_footer(); ?>
