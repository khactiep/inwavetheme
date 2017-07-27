<?php
/**
 * The template for displaying Category pages
 * @package injob
 */
get_header();

$sidebar_position = Inwave_Helper::getPostOption('sidebar_position', 'sidebar_position');
get_template_part('blocks/headerbackground/header', 'small');
?>
<div class="page-content">
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="<?php echo esc_attr(inwave_get_classes('container', $sidebar_position))?> search-content">
                    <?php if ( have_posts() ) : ?>
                        <?php /* Start the Loop */ ?>
						<div class="search-results">
                        <?php while ( have_posts() ) : the_post(); ?>
                            <?php
                            /**
                             * Run the loop for the search to output the results.
                             * If you want to overload this in a child theme then include a file
                             * called content-search.php and that will be used instead.
                             */
                            get_template_part( 'content', 'search' );
                            ?>
                        <?php endwhile; ?>
						</div>
                        <?php pagination_nav(); ?>
                    <?php else : ?>
                        <?php get_template_part( 'content', 'none' ); ?>
                    <?php endif; ?>
                    </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>
