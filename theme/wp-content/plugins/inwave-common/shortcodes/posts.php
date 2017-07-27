<?php
/*
 * @package Inwave Athlete
 * @version 1.0.0
 * @created Mar 27, 2015
 * @author Inwavethemes
 * @email inwavethemes@gmail.com
 * @website http://inwavethemes.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 Inwavethemes. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

/**
 * Description of wp_posts
 *
 * @Developer duongca
 */
if (!class_exists('Inwave_Posts')) {

    class Inwave_Posts extends Inwave_Shortcode{

        protected $name = 'inwave_posts';

        function init_params() {
            $_categories = get_categories();
            $cats = array(__("All", "inwavethemes") => '');
            foreach ($_categories as $cat) {
                $cats[$cat->name] = $cat->term_id;
            }

            return array(
                'name' => __('Posts', 'inwavethemes'),
                'description' => __('Display a list of posts ', 'inwavethemes'),
                'base' => $this->name,
                'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
                    /*array(
                        "type" => "dropdown",
                        "admin_label" => true,
                        "heading" => __("Style", "inwavethemes"),
                        "param_name" => "style",
                        "value" => array(
                            'Style 1' => 'style1',
                            'Style 2' => 'style2',
                        )
                    ),*/
                    /*array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Title", "inwavethemes"),
                        "value" => "",
                        "param_name" => "title",
                        "description" => __('Title of wp_posts block.', "inwavethemes")
                    ),*/
                    array(
                        'type' => 'textfield',
                        "heading" => __("Post Ids", "inwavethemes"),
                        "value" => "",
                        "param_name" => "post_ids",
                        "description" => __('Id of posts you want to get. Separated by commas.', "inwavethemes")
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Post Category", "inwavethemes"),
                        "param_name" => "category",
                        "value" => $cats,
                        "description" => __('Category to get posts.', "inwavethemes")
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Post number", "inwavethemes"),
                        "param_name" => "post_number",
                        "value" => "3",
						"admin_label" => true,
                        "description" => __('Number of posts to display on box.', "inwavethemes")
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Order By", "inwavethemes"),
                        "param_name" => "order_by",
                        "value" => array(
                            'ID' => 'ID',
                            'Title' => 'title',
                            'Date' => 'date',
                            'Modified' => 'modified',
                            'Ordering' => 'menu_order',
                            'Random' => 'rand'
                        ),
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Order Type", "inwavethemes"),
                        "param_name" => "order_type",
                        "value" => array(
                            'ASC' => 'ASC',
                            'DESC' => 'DESC'
                        ),
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Description Word Limit", "inwavethemes"),
                        "param_name" => "description_limit",
                        "value" => "30",
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Show date", "inwavethemes"),
                        "param_name" => "show_date",
                        "value" => array(
                            'Yes' => '1',
                            'No' => '0'
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Show category", "inwavethemes"),
                        "param_name" => "show_category",
                        "value" => array(
                            'Yes' => '1',
                            'No' => '0'
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Show Author", "inwavethemes"),
                        "param_name" => "show_author",
                        "value" => array(
                            'Yes' => '1',
                            'No' => '0'
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Show post type icon", "inwavethemes"),
                        "param_name" => "show_post_type",
                        "value" => array(
                            'Yes' => '1',
                            'No' => '0'
                        )
                    ),
                    /*array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "heading" => __("Show description", "inwavethemes"),
                        "param_name" => "show_desc",
                        "value" => array(
                            'Yes' => '1',
                            'No' => '0'
                        ),
                        "dependency" => array(
                            "element" => "style",
                            "value"=> array("style3")
                        )
                    ),*/
                    array(
                        "type" => "dropdown",
                        "heading" => __("Show comment count", "inwavethemes"),
                        "param_name" => "show_comment_count",
                        "value" => array(
                            'No' => '0',
                            'Yes' => '1'
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Show tag", "inwavethemes"),
                        "param_name" => "show_tag",
                        "value" => array(
                            'No' => '0',
                            'Yes' => '1'
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "heading" => __("Show read-more", "inwavethemes"),
                        "param_name" => "show_readmore",
                        "value" => array(
                            'Yes' => '1',
                            'No' => '0'
                        ),
                        "dependency" => array(
                            "element" => "style",
                            "value"=> "style3"
                        ),
                    ),
                    /*array(
                        'type' => 'textfield',
                        "heading" => __("Read More Text", "inwavethemes"),
                        "value" => "",
                        "param_name" => "readmore_text",
                        "dependency" => array(
                            "element" => "style",
                            "value"=> "1"
                        )
                    ),*/
                    /*array(
                        "type" => "textfield",
                        "group" => "Style",
                        "heading" => __("Columns Desktop", "inwavethemes"),
                        "description" => __("Number of columns on Desktop devices", "inwavethemes"),
                        "param_name" => "items_desktop",
                        "value" => '4',
                        "dependency" => array(
                            "element" => "style",
                            "value"=> array("style1", "style2")
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "group" => "Style",
                        "heading" => __("Columns Small Desktop", "inwavethemes"),
                        "description" => __("Number of columns on Small Desktop devices", "inwavethemes"),
                        "param_name" => "items_desktopsmall",
                        "value" => '3',
                        "dependency" => array(
                            "element" => "style",
                            "value"=> array("style1", "style2")
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "group" => "Style",
                        "heading" => __("Columns Tablet", "inwavethemes"),
                        "description" => __("Number of columns on Tablet devices", "inwavethemes"),
                        "param_name" => "items_tablet",
                        "value" => '2',
                        "dependency" => array(
                            "element" => "style",
                            "value"=> array("style1", "style2")
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "group" => "Style",
                        "heading" => __("Columns Mobile", "inwavethemes"),
                        "description" => __("Number of columns on Mobile Desktop devices", "inwavethemes"),
                        "param_name" => "items_mobile",
                        "value" => '1',
                        "dependency" => array(
                            "element" => "style",
                            "value"=> array("style1", "style2")
                        )
                    ),*/
					array(
						"type" => "textfield",
						"heading" => __("Link for load more", "inwavethemes"),
						"param_name" => "load_more_link",
						"value" => '',
						"dependency" => array('element' => 'style', 'value' => 'style5')
					),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "inwavethemes")
                    ),
                )
            );
        }

        // Shortcode handler function for list Icon
        function init_shortcode($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;
            $output = $title = $post_ids = $category = $items_desktop = $items_desktopsmall = $items_tablet = $items_mobile = $description_limit = $post_number = $order_by = $order_type = $style = $show_date = $show_category = $show_author = $show_thumbnail = $show_desc = $show_comment_count = $show_tag = $show_readmore = $show_post_type = $read_more_text = $load_more_link = $class = '';
            extract(shortcode_atts(array(
                'title' => '',
                'post_ids' => '',
                'category' => '',
                /*'items_desktop' => 4,
                'items_desktopsmall' => 3,
                'items_tablet' => 2,
                'items_mobile' => 1,*/
                'description_limit' => 15,
                'post_number' => 3,
                'order_by' => 'ID',
                'order_type' => 'DESC',
                'style' => 'style1',
                'show_date' => '1',
                'show_category' => '1',
                'show_author' => '1',
                /*'show_thumbnail' => '1',*/
                /*'show_desc' => '1',*/
                'show_comment_count' => '1',
                'show_tag' => '1',
                'show_readmore' => '1',
                'show_post_type' => '1',
                /*'read_more_text' => 'more',*/
				'load_more_link'	=> '',
                'class' => ''
                            ), $atts));

            $args = array();
            if ($post_ids) {
                $args['post__in'] = explode(',', $post_ids);
            } else {
                if ($category) {
                    $args['category__in'] = $category;
                }
            }
            $args['posts_per_page'] = $post_number;
            $args['order'] = $order_type;
            $args['orderby'] = $order_by;
            $query = new WP_Query($args);
            $class .= ' ' . $style;
            ob_start();
            switch ($style) {
                default:
                case 'style1':
                wp_enqueue_script('slick');
                wp_enqueue_style('slick');
                wp_enqueue_style('slick-theme');
					?>
					<div class="iw-posts <?php echo $class ?>">
                        <div class="iw-posts-list">
						<?php
                        $i = 0;
						while ($query->have_posts()) :
                        $query->the_post();
                        $i++;
						$post_format = get_post_format();
                            $icon_post_type = '';
                            switch ($post_format) {
                                case 'video':
                                    $icon_post_type = 'fa fa-play';
                                    break;
                                case 'gallery':
                                    $icon_post_type = 'fa fa-th-large';
                                    break;
                                case 'image':
                                    $icon_post_type = 'fa fa-image';
                                    break;
                                case 'quote':
                                    $icon_post_type = 'fa fa-quote-left';
                                    break;
                                case 'link':
                                    $icon_post_type = 'fa fa-link';
                                    break;
                            }
							?>
							<div class="post-item col-md-4" data-number="<?php echo $i; ?>">
								<div class="post-item-inner">
										<div class="post-thumbnail featured-image">
											<?php
                                            $post = get_post();
											$contents = $post->post_content;
											switch ($post_format) {
												case 'video':
													$video = inwave_get_elements_by_tag('embed', $contents);
													if (count($video)) {
                                                        //$video_url = $video[2];
														echo apply_filters('the_content', $video[0]);
													}
                                                    else{
                                                        $img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
                                                        echo '<img src="'.$img[0].'" alt="">';
                                                    }
                                                    break;
												default :
                                                    $img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
                                                    ?>
                                                    <img src="<?php echo $img[0]; ?>" alt="">
                                                    <?php
                                            }
                                        ?>
									    </div>
                                        <div class="post-content">
                                            <?php if ($show_date || $show_category || $show_author || $show_comment_count || $show_tag){ ?>
                                            <div class="post-meta">
                                                <ul >
                                                    <?php if ($show_date): ?>
                                                        <li>
                                                            <div class="post-date theme-bg">
                                                                <div class="day"><?php printf(__('%s'), get_the_date('j')) ?></div>
                                                                <div class="month-year"><?php printf(__('%s'), get_the_date("F 'y")) ?></div>
                                                            </div>

                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if ($show_author): ?>
                                                        <li>
                                                            <div class="author"><?php echo esc_html__('Post by ', 'inwavethemes'); ?><span class="theme-color"><?php echo get_the_author_link(); ?></span></div>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if($show_category) { ?>
                                                        <li>
                                                            <div class="category"><span><?php the_category(', '); ?></span></div>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if($show_comment_count) { ?>
                                                        <li>
                                                            <span><a href="<?php comments_link(); ?>"><?php comments_number( __('0 Comments','inwavethemes'), __('1 Comment','inwavethemes'), __('% Comments','inwavethemes') ); ?></a></span>
                                                        </li>
                                                    <?php } ?>
                                                    <?php if($show_tag) { ?>
                                                        <li>
                                                            <span><span><?php echo esc_html__('Tags:', 'inwavethemes'); ?></span><?php echo get_the_tag_list(); ?></span>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                            <?php } ?>
                                            <div class="post-info">
                                                <div class="post-title">
                                                    <a href="<?php echo get_permalink(); ?>"><?php the_title() ?></a>
                                                </div>
                                                <div class="post-content">
                                                    <p><?php echo Inwave_Helper::substrword(get_the_excerpt(), $description_limit); ?></p>
                                                </div>
                                            </div>
										</div>
									</div>
								</div>
								<?php
							endwhile;
							wp_reset_postdata();
							?>		
                        </div>
					</div>
				<?php
                break;

			}
            $html = ob_get_contents();
            ob_end_clean();

            return $html;
        }
    }
}

new Inwave_Posts();