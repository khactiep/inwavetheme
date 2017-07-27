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
if (!class_exists('Inwave_Post')) {

    class Inwave_Post extends Inwave_Shortcode{

        protected $name = 'inwave_post';

        function init_params() {
            $_categories = get_categories();
            $cats = array(__("All", "inwavethemes") => '');
            foreach ($_categories as $cat) {
                $cats[$cat->name] = $cat->term_id;
            }

            return array(
                'name' => __('Single Post', 'inwavethemes'),
                'description' => __('Display a post ', 'inwavethemes'),
                'base' => $this->name,
                'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
                    array(
                        "type" => "textfield",
                        "heading" => __("Post ID", "inwavethemes"),
                        "param_name" => "post_id",
                        "description" => __('Enter post id', "inwavethemes")
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Style", 'inwavethemes'),
                        "admin_label" => true,
                        "param_name" => "style",
                        "value" => array(
                            "Style 1 - Normal Size" => "style1",
                            "Style 2 - Large Size" => "style2",
                        )
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

            extract(shortcode_atts(array(
                'post_id' => '',
                'style' => '',
                'class' => ''
            ), $atts));
            $class .= ' '.$style;
            $output = '<div class="iw-single-post '.esc_attr($class).'">';
                if($post_id){
                    $post = get_post($post_id);
                    if($post){
                        $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
                        $image_url = $image[0];

                        if($style == 'style1'){
                            $image_url = inwave_resize($image_url, 270, 430, true);
                        }
                        else
                        {
                            $image_url = inwave_resize($image_url, 570, 430, true);
                        }
                        if($image_url) {
                            $output .= '<img src="'.$image_url.'" alt="">';
                        }
                        $output .= '<div class="date-box"><div class="date-1">'.get_the_date('d', $post).'</div><div class="date-2">'.get_the_date('F y', $post).'</div></div>';
                        $output .= '<div class="post-info">';
                        $output .= '<h3><a href="'.get_permalink($post->ID).'">'.get_the_title($post->ID).'</a></h3>';
                            $output .= '<div class="post-metas">';
                                $output .= get_the_category_list(',', '', $post->ID).', ';
                                $output .= __('Posted by', 'inwavethemes').' ';
                                $output .= '<a href="'.get_author_posts_url( $post->post_author).'">'.get_the_author_meta('display_name', $post->post_author).'</a>';
                            $output .= '</div>';
                        $output .= '</div>';
                    }
                    else
                    {
                        $output .= __('Post is not not existed', 'inwavethemes');
                    }
                }
                else
                {
                    $output .= __('Please enter post id', 'inwavethemes');
                }
            $output .= '</div>';

            return $output;
        }
    }
}

new Inwave_Post();