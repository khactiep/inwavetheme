<?php
/**
 * The Template for displaying all single posts
 * @package injob
 */

get_header();

$sidebar_position = Inwave_Helper::getPostOption('sidebar_position', 'sidebar_position');
get_template_part('blocks/headerbackground/header', 'small');
?>
    <div class="container">
        <div class="row">
            <div class="col-md-9">
            <div class="page-content">
                <div class="main-content">
                    <div class="blog-content single-content">
                        <?php while (have_posts()) : the_post(); ?>
                            <?php get_template_part('content', 'single'); ?>


                            <?php
                            // If comments are open or we have at least one comment, load up the comment template
                            if (comments_open() || get_comments_number()) :

                                    comments_template();

                            endif;
                            ?>
                        <?php endwhile; // end of the loop. ?>
                    </div>
                </div>
            </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-6" style="margin-top: 50px">
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

<?php get_footer(); ?>