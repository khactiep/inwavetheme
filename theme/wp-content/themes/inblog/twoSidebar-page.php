<?php
/**
 * The template for displaying pages
 * @package injob
 */
get_header();

$sidebar_name_1 = Inwave_Helper::getPostOption('sidebar_name_1');
$sidebar_name_2 = Inwave_Helper::getPostOption('sidebar_name_2');
?>
<div class="contents-main" id="contents-main">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-3 iw-sidebar iw-sidebar-1 <?php echo esc_attr($sidebar_name_1); ?>">
                <?php get_sidebar($sidebar_name_1); ?>
            </div>
            <div class="col-md-6 col-sm-6">
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('content', 'page'); ?>
                    <?php
                    // If comments are open or we have at least one comment, load up the comment template
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                    ?>
                <?php endwhile; // end of the loop. ?>
            </div>
            <div class="col-md-3 col-sm-3 iw-sidebar iw-sidebar-2 <?php echo esc_attr($sidebar_name_2); ?>">
                <?php get_sidebar($sidebar_name_2); ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
