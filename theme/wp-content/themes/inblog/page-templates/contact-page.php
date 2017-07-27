<?php
/**
 * Template Name: Contact Page
 * This is the template that is used for Contact Page
 */

get_header();
?>
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="contact-page-content">
                            <?php get_template_part('content', 'page'); ?>
                        </div>
                    <?php endwhile; // end of the loop. ?>
<?php get_footer(); ?>