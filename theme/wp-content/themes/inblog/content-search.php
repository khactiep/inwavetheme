<?php
/**
 * The template part for displaying results in search pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package injob
 */
$inwave_theme_option = Inwave_Helper::getConfig();
?>


<article id="post-<?php echo esc_attr(get_the_ID());?>" style="margin-bottom: 30px" <?php post_class(); ?>>
    <div class="row">
        <div class="col-sm-4 col-md-4 search_thumbnail"><?php the_post_thumbnail();?></div>
        <header class="col-sm-8 col-md-8 entry-header">
            <?php the_title( sprintf( '<h3><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>


            <div class="entry-meta">
                <?php
                    $author_id = get_the_author_meta('ID');
                    echo 'Posted on '.get_the_date().' by <a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a>';
                ?>
            </div><!-- .entry-meta -->

            <div class="entry-summary">
                <?php the_excerpt(); ?>
            </div><!-- .entry-summary -->
        </header><!-- .entry-header -->
    </div>

	<div class="clearfix"></div>
    <?php if (isset($inwave_theme_option['show_post_tag']) && $inwave_theme_option['show_post_tag']): ?>
        <footer class="entry-footer">
            <?php inwave_blog_post_tag(); ?>
        </footer><!-- .entry-footer -->
    <?php endif ?>

</article><!-- #post-## -->
