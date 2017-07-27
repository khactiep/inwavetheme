<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package injob
 */
get_header();
get_template_part('blocks/headerbackground/header', 'small'); ?>
<div class="page-content page-content-404">
    <div class="container">
        <div class="error-404 not-found">
			<div class="text"> 404 Not Found !!</div>
            <div class="text_label_404"><?php esc_html_e("We're sorry, but the page you were looking for doesn't exist.", "injob"); ?></div>
        </div>
        <?php get_search_form(); ?>
        <!-- .error-404 -->
    </div>
</div><!-- .page-content -->
<?php get_footer(); ?>
