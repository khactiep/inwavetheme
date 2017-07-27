<?php
/*
 * @package inChurch
 * @version 1.0.0
 * @created Jun 8, 2015
 * @author Inwavethemes
 * @email inwavethemes@gmail.com
 * @website http://inwavethemes.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 Inwavethemes. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */


/**
 * Description of iw_gallery
 *
 * @developer hientran
 */
if (!class_exists('Inwave_Gallery_Slider')) {

    class Inwave_Gallery_Slider extends Inwave_Shortcode2{

        protected $name = 'inwave_gallery_slider';
        protected $name2 = 'inwave_gallery_item';
        protected $count;
        protected $style;
        protected $thumbs = array();

        function init_params() {
            return array(
                "name" => __("Gallery Slider", 'inwavethemes'),
                "base" => $this->name,
                "content_element" => true,
                'category' => 'Custom',
                "description" => __("Add a set of list item.", "inwavethemes"),
                "as_parent" => array('only' => 'inwave_gallery_item'),
                "show_settings_on_create" => true,
                "js_view" => 'VcColumnView',
                'icon' => 'iw-default',
                "params" => array(
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "value" => "",
                        "description" => __("Write your own CSS and mention the class name here.", "inwavethemes"),
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "heading" => "Style",
                        "param_name" => "style",
                        "value" => array(
                            "Style 1" => "style1",
                        )
                    )
                )
            );
        }

        function init_params2(){
            return array(
                "name" => __("Gallery Slider Item", 'inwavethemes'),
                "base" => $this->name2,
                "class" => "inwave_gallery_item",
                'icon' => 'iw-default',
                'category' => 'Custom',
                "description" => __("Add a information block and give some custom style.", "inwavethemes"),
                "as_child" => array('only' => 'inwave_gallery_slider'),
                "show_settings_on_create" => true,
                "params" => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Title", "inwavethemes"),
                        "value" => "",
                        "param_name" => "title"
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Description", "inwavethemes"),
                        "value" => "",
                        "param_name" => "description"
                    ),
                    array(
                        'type' => 'attach_image',
                        "heading" => __("Image", "inwavethemes"),
                        "param_name" => "img"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "inwavethemes")
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "heading" => "Style",
                        "param_name" => "style",
                        "value" => array(
                            "Style 1" => "style1",
                        )
                    ),
                )
            );
        }

        // Shortcode handler function for list
        function init_shortcode($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

            $output = '';

            extract(shortcode_atts(array(
                "class" => "",
                "style" => "style1"
            ), $atts));

            $class .= ' '.$style;

            $output .= '<div class="iw-gallery">';
                $output .= '<div class="slider">';
                    $output .= '<div class="iw-slider flexslider ' . trim($class) . '">';
                        $output .= '<ul class="slides">';
                            $output .= do_shortcode($content);
                        $output .= '</ul>';
                    $output .= '</div>';
                $output .= '</div>';
                $output .= '<div class="iw-carousel flexslider">';
                    $output .= '<ul class="slides">';
                        if($this->thumbs){
                            foreach($this->thumbs as $thumb){
                                $output .= '<li>';
                                $output .= $thumb;
                                $output .= '</li>';
                            }
                        }
                    $output .= '</ul>';
                $output .= '</div>';
            $output .= '</div>';

            return $output;
        }

        // Shortcode handler function for item
        function init_shortcode2($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name2, $atts ) : $atts;

            $output = $img = $title = $description = $class = $style = '';
            extract(shortcode_atts(array(
                'img' => '',
                'title' => '',
                'description' => '',
                'class' => '',
                'style' => 'style1'
            ), $atts));

            $class .= ' '.$style;

            $img_tag = '';
            if ($img) {
                $img = wp_get_attachment_image_src($img, 'large');
                $img = $img[0];
                $img_tag .= '<img src="' . $img . '" alt="' .$title. '">';
            }

            $this->thumbs[] = $img_tag;
            switch ($style) {
                case 'style1':
                    $output .= '<li>';
                        $output .= '<div class="slider-info">';
                            if ($img_tag){
                                $output .= $img_tag;
                            }
                            $output .= '<div class="slider-info-inner">';
                            if ($title){
                                $output .= '<div class="item-title">' . $title . '</div>';
                            }
                            if ($description){
                                $output .= '<div class="item-description theme-color">' . $description . '</div>';
                            }
                            $output .= '</div>';
                        $output .= '</div>';
                    $output .= '</li>';
                break;
            }

            return $output;
        }
    }
}

new Inwave_Gallery_Slider();
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_Inwave_Gallery_Slider extends WPBakeryShortCodesContainer {
    }
}