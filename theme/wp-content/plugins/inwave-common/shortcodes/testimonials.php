<?php

/*
 * @package inChurch
 * @version 1.0.0
 * @created May 5, 2015
 * @author Inwavethemes
 * @email inwavethemes@gmail.com
 * @website http://inwavethemes.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 Inwavethemes. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

/**
 * Description of testimonials
 *
 * @developer duongca
 */
if (!class_exists('Inwave_Testimonials')) {

    class Inwave_Testimonials extends Inwave_Shortcode2{

        protected $name = 'inwave_testimonials';
        protected $name2 = 'inwave_testimonial_item';
        protected $testimonials;
        protected $testimonial_item;
        protected $style;

        function init_params()
        {
            return array(
                "name" => __("Testimonials", 'inwavethemes'),
                "base" => $this->name,
                "content_element" => true,
                'category' => 'Custom',
                'icon' => 'iw-default',
                "description" => __("Add a set of testimonial and give some custom style.", "inwavethemes"),
                "as_parent" => array('only' => $this->name2),
                "show_settings_on_create" => true,
                "js_view" => 'VcColumnView',
                "params" => array(
                    array(
                        "type" => "dropdown",
                        "class" => "iw-testimonials-style",
                        "heading" => "Style",
                        "param_name" => "style",
                        "value" => array(
                            "Style 1 - Position next to avatar clickable" => "style1",
                            /*"Style 2 - Avatar at bottom" => "style2",*/
                            "Style 3 - One Page Education" => "style3",
                        )
                    ),
					array(
                        "type" => "iwevent_preview_image",
                        "heading" => __("Preview Style", "inwavethemes"),
                        "param_name" => "preview_style1",
                        "value" => get_template_directory_uri() . '/assets/images/shortcodes/testimonials-style1.jpg',
                        "dependency" => array('element' => 'style', 'value' => 'style1')
                    ),
					array(
                        "type" => "iwevent_preview_image",
                        "heading" => __("Preview Style", "inwavethemes"),
                        "param_name" => "preview_style3",
                        "value" => get_template_directory_uri() . '/assets/images/shortcodes/testimonials-style3.jpg',
                        "dependency" => array('element' => 'style', 'value' => 'style3')
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "value" => "",
                        "description" => __("Write your own CSS and mention the class name here.", "inwavethemes"),
                    ),
                )
            );
        }

        function init_params2() {
            return array(
                "name" => __("Testimonial Item", 'inwavethemes'),
                "base" => $this->name2,
                "class" => "inwave_testimonial_item",
                'icon' => 'iw-default',
                'category' => 'Custom',
//                "as_child" => array('only' => $this->name),
                "description" => __("Add a list of testimonials with some content and give some custom style.", "inwavethemes"),
                "show_settings_on_create" => true,
                "params" => array(
                    array(
                        "type" => "dropdown",
                        "heading" => "Style",
                        "admin_label" => true,
                        "param_name" => "style",
                        "value" => array(
                            "Style 1" => "style1",
                        )
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Title", "inwavethemes"),
                        "value" => "This is title",
                        "param_name" => "title"
                    ),
                    array(
                        'type' => 'textarea_html',
                        /*"holder" => "div",*/
                        "heading" => __("Description", "inwavethemes"),
                        "value" => "",
                        "param_name" => "content"
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Signature", "inwavethemes"),
                        "value" => "",
                        "param_name" => "signature"
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Name", "inwavethemes"),
                        "value" => "This is Name",
                        "param_name" => "name"
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Position", "inwavethemes"),
                        "value" => "",
                        "param_name" => "position",
                    ),
                    array(
                        "type" => "attach_image",
                        "heading" => __("Client Image", "inwavethemes"),
                        "param_name" => "image",
                        "value" => "",
                    ),
                    array(
                        'type' => 'textfield',
                        "heading" => __("Link", "inwavethemes"),
                        "value" => "",
                        "param_name" => "link",
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "heading" => __("Text align", "inwavethemes"),
                        "param_name" => "align",
                        "value" => array(
                            "Default" => "",
                            "Left" => "left",
                            "Right" => "right",
                            "Center" => "center"
                        )
                    ),
                    array(
                        'type' => 'css_editor',
                        'heading' => __( 'CSS box', 'js_composer' ),
                        'param_name' => 'css',
                        // 'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
                        'group' => __( 'Design Options', 'js_composer' )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "extra_class",
                        "value" => "",
                        "description" => __("Write your own CSS and mention the class name here.", "inwavethemes"),
                    )
                )
            );
        }

        // Shortcode handler function for list
        function init_shortcode($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

            $output = $class = $style = '';
            //$id = 'iwt-' . rand(10000, 99999);
            extract(shortcode_atts(array(
                "class" => "",
                "style" => "style1",
            ), $atts));

            $this->style = $style;

            $matches = array();
            //$count = preg_match_all('/\[inwave_testimonial_item(?:\s+layout="([^\"]*)"){0,1}(?:\s+title="([^\"]*)"){0,1}(?:\s+name="([^\"]*)"){0,1}(?:\s+date="([^\"]*)"){0,1}(?:\s+position="([^\"]*)"){0,1}(?:\s+image="([^\"]*)"){0,1}(?:\s+rate="([^\"]*)"){0,1}(?:\s+testimonial_text="([^\"]*)"){0,1}(?:\s+class="([^\"]*)"){0,1}\]/i', $content, $matches);
            $count = preg_match_all( '/inwave_testimonial_item([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
            if ($count) {
                switch ($style){
                    case 'style1':
                        $output .= '<div class="iw-testimonals style1 ' . $class . '">';
                        $output.= '<div class="testi-owl-maincontent">';
                        $output .= do_shortcode($content);
                        $items = array();
                        foreach ($matches[1] as $value) {
                            $items[] = shortcode_parse_atts( $value[0] );
                        }
                        $output.= '</div>';
                        $output.= '<div class="testi-owl-clientinfo">';
                        foreach ($items as $key => $item) {
                            $image = $item['image'];
                            if ($image) {
                                $img = wp_get_attachment_image_src($image);
                                $image = '<img class="grayscale" src="' . $img[0] . '" alt=""/>';
                            }
                            $output.= '<div data-item-active="' . $key . '" class="iw-testimonial-client-item ' . ($key == 0 ? 'active' : '') . '">';
                            $output.= '<div class="testi-image">' . $image . '</div>';
                            $output.= '</div>';
                        }
                        $output.= '</div>';
                        $output .= '</div>';
                        break;
                    case 'style2':
                        $output .= '<div class="iw-testimonals style2 ' . $class . '">';
                        $output.= '<div class="testi-owl-maincontent">';
                        $items = array();

                        foreach ($matches[1] as $value) {
                            $items[] = shortcode_parse_atts( $value[0] );
                        }
                        foreach ($items as $key => $item) {
                            $text = html_entity_decode($item['testimonial_text']);
                            $name = html_entity_decode($item['name']);
                            $position = html_entity_decode($item['position']);
                            $image = $item['image'];
                            if ($image) {
                                $img = wp_get_attachment_image_src($image);
                                $image = '<img class="grayscale" src="' . $img[0] . '" alt=""/>';
                            }
                            $output.= '<div class="iw-testimonial-item ' . ($key == 0 ? 'active' : '') . '">';
                            $output.= '<div class="testi-content">' . $text . '</div>';
                            $output.= '<div class="testi-client-name">' . $name . '</div>';
                            $output.= '<div class="testi-client-position">' . $position . '</div>';
                            if ($image) {
                                $output.= '<div class="testi-image">' . $image . '</div>';
                            }
                            $output.= '</div>';
                        }
                        $output.= '</div>';
                        $output .= '</div>';
                        break;
                    case 'style3':
                        $output .= '<div class="iw-testimonals style3 ' . $class . '">';
                        $output.= '<div class="testi-owl-maincontent">';
                        $output .= do_shortcode($content);
                        $output.= '</div>';
                        $output .= '</div>';
                        break;
                }
            }

            $output .= '<div style="clear:both;"></div>';
            $output .= '<script type="text/javascript">';
            $output .= '(function ($) {';
            $output .= '$(document).ready(function () {';
            $output .= '$(".iw-testimonals").iwCarousel();';
            $output .= '});';
            $output .= '})(jQuery);';
            $output .= '</script>';

            return $output;
        }

        // Shortcode handler function for item
        function init_shortcode2($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name2, $atts ) : $atts;

            $output = $title = $name = $position = $signature = $image = $link = $style = $align = $css = $extra_class = '';
            extract(shortcode_atts(array(
                'style' => '',
                'title' => '',
                'signature' => '',
                'name' => '',
                'position' => '',
                'image' => '',
                'link' => '',
                'align' => '',
                'css' => '',
                'extra_class' => ''
            ), $atts));

            $class = '';
            $class .= ' '.$style.' '. vc_shortcode_custom_css_class( $css);

            if($align){
                $class.= ' '.$align.'-text';
            }

            if($extra_class){
                $class .= ' '. $extra_class;
            }

            switch ($style) {
                case 'style1':
                    $output.= '<div class="iw-testimonial-item' .$class. '">';
                        if($title){
                            $output.= '<h3 class="testi-client-title">' . $title . '</h3>';
                        }
                        if($content){
                            $output.= '<div class="testi-content"><p>' . $content . '</p></div>';;
                        }
                        if($signature){
                            $output.= '<span class="testi-client-signature">' . $signature . '</span>';
                        }
                        $output.= '<div class="testi-name-position">';
                            if($name){
                                $output.= '<a class="testi-client-name" href="' .esc_url($link). '">' . $name . '</a>';
                            }
                            if($position){
                                $output.= '<span class="testi-client-position"> - ' . $position . '</span>';
                            }
                        $output.= '</div>';
                    $output.= '</div>';
                    break;
            }

            return $output;
        }
    }
}

new Inwave_Testimonials;
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_Inwave_Testimonials extends WPBakeryShortCodesContainer {}
}
