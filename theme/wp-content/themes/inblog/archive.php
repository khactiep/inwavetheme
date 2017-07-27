<?php
/**
 * The template for displaying Category pages
 * @package injob
 */

get_header();

$sidebar_position = Inwave_Helper::getPostOption('sidebar_position', 'sidebar_position');
?>
<div class="page-content iw-category iw-archive blog-list">
    <div class="main-content">
        <div class="container">
            <div class="iw-posts-filter">
                <button class="filter" data-filter=".most-recent">Most recent</button>
                <button class="filter" data-filter=".popular-post">Popular post</button>
                <button class="filter" data-filter=".featured-post">Featured post</button>
                <button class="filter all-posts is-checked" data-filter="*"><?php echo esc_html__('All blog post', 'injob'); ?></button>
            </div>
            <div class="row iw-isotope-main isotope blog-content">
                <?php if ( have_posts() ) : ?>
                    <?php while (have_posts()) : the_post();
                        get_template_part( 'content', get_post_format() );
                    endwhile; // end of the loop. ?>
                <?php else :
                    // If no content, include the "No posts found" template.
                    get_template_part( 'content', 'none' );
                endif;?>
            </div>
            <?php if ( have_posts() ) : ?>
                <?php get_template_part( '/blocks/paging'); ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
