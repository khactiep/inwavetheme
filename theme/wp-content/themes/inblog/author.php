<?php
/**
 * The template for displaying Author archive pages
 * @package injob
 */

get_header();
$sidebar_position = Inwave_Helper::getPostOption('sidebar_position', 'sidebar_position');
get_template_part('blocks/headerbackground/header', 'small');
?>

    <?php rewind_posts(); ?>
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <?php if ( have_posts() ) :
                        while (have_posts()) :
                                the_post();
                               $cat = get_the_category();
                               $cat_id = get_cat_ID($cat[0]->name);
                            ?>
                            <div style="text-align: center;">
                                <div class="cat_post"><a href="<?php echo get_category_link($cat_id); ?>"> <?php echo $cat[0]->name; ?> </a></div>
                                <div class="title_post"> <a href="<?php the_permalink();?>"> <?php the_title();?> </a> </div>
                                <div class="date_post"><?php echo get_the_date('F j,Y');?></div>
                            </div>

                            <div style="margin-bottom: 40px; margin-top: 60px">
                                <img src="<?php echo get_the_post_thumbnail_url();?>" style="width: 100%">
                                <!--<?php the_post_thumbnail('content_image'); ?>-->
                            </div>
                            <div class="post_content"><?php the_excerpt(); ?></div>
                            <?php
                            get_template_part('blocks/social/social', 'line1');
                        endwhile;
                        pagination_nav();// end of the loop. ?>
                    <?php else :
                        // If no content, include the "No posts found" template.
                        get_template_part( 'content', 'none' );
                    endif;?>
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

