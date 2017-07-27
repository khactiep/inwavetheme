<?php
/**
 * inevent functions and definitions
 *
 * @package injob
 */

/* Theme option famework */
require_once get_template_directory().'/framework/theme-option.php';

require_once get_template_directory() . '/framework/option-framework/inof.php';

/* Require helper function */
require_once get_template_directory() . '/framework/inc/helper.php';

/* Require importer function */
require_once get_template_directory() . '/framework/importer/importer.php';

/* Custom nav */
require_once get_template_directory().'/framework/inc/custom-nav.php';

/* Customizer theme */
require_once get_template_directory() . '/framework/inc/customizer.php';

/* Template tags */
require_once get_template_directory() . '/framework/inc/template-tags.php';

/* Require Custom functions that act independently of the theme templates */
require_once get_template_directory() . '/framework/inc/extras.php';

/* Require custom widgets */
require_once get_template_directory() . '/framework/widgets/info-footer.php';
require_once get_template_directory() . '/framework/widgets/subscribe.php';
require_once get_template_directory() . '/framework/widgets/recent-comment.php';
require_once get_template_directory() . '/framework/widgets/recent-post.php';
require_once get_template_directory() . '/framework/widgets/Blog_Follow.php';
require_once get_template_directory() . '/framework/widgets/Info_Author.php';
require_once get_template_directory() . '/framework/widgets/Instagram_Photos.php';
require_once get_template_directory() . '/framework/widgets/Popular_Posts.php';
require_once get_template_directory() . '/framework/widgets/Twitter.php';

/* Require custom shortcode */
require_once get_template_directory() . '/framework/shortcodes/contact.php';

/* Implement the woocommerce template. */
require_once get_template_directory() . '/framework/inc/woocommerce.php';

/* TGM plugin activation. */
require_once get_template_directory() . '/framework/inc/class-tgm-plugin-activation.php';

//framework
require_once get_template_directory().'/framework/theme-plugin-load.php';

require_once get_template_directory().'/framework/theme-function.php';

require_once get_template_directory().'/framework/theme-register.php';

require_once get_template_directory().'/framework/theme-support.php';

require_once get_template_directory().'/framework/theme-style-script.php';

require_once get_template_directory() . '/framework/theme-metabox.php';
register_sidebar(array(
     'name' => 'RIGHT SIDEBAR',
     'id' => 'right_sidebar',
     'description' => 'Show Right Sidebar',
     'before_widget' => '<aside id="%1$s" class="widget %2$s">',
     'after_widget' => '</aside>',
     'before_title' => '<h1 class="widget-title">',
     'after_title' => '</h1>'
));

register_nav_menus(array(
        'footer-menu' => 'Footer Menu'
    )
);

function readmore() {
  return '<br>'.'<a class="readmore" style="text-align: center" href="'. get_permalink( get_the_ID() ) . '">' .'Continue Reading'. '</a>';
}
add_filter( 'excerpt_more', 'readmore' );

function wpb_set_post_views($postID) {
	
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);

    if($count==''){

        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function wpb_track_post_views ($post_id) {
    if ( !is_single() ) return;
    if ( empty ( $post_id) ) {
        global $post;
        $post_id = $post->ID;   
    }
    wpb_set_post_views($post_id);
}
add_action( 'wp_head', 'wpb_track_post_views');

function wpb_get_post_views($postID){
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 View";
    }
    return $count.' Views';
}

add_filter( 'widget_tag_cloud_args', 'change_tag_cloud_font_sizes');

function change_tag_cloud_font_sizes( array $args ) {
    $args['smallest'] = '10';
    $args['largest'] = '10';
    $arg['unit'] = 'pt';

    return $args;
}
function pagination_nav() {
    global $wp_query;

    if ( $wp_query->max_num_pages > 1 ) { ?>
        <nav class="pagination" role="navigation">
            <div class="nav-previous"><?php next_posts_link( 'Older posts &rarr;' ); ?></div>
            <div class="nav-next"><?php previous_posts_link( '&larr; Newer posts' ); ?></div>
        </nav>
    <?php }
}