<?php

/*
 * Inwave_Member List for Visual Composer
 */
if (!class_exists('Inwave_Team')) {

    class Inwave_Team extends Inwave_Shortcode2{

        protected $name = 'inwave_team';
        protected $name2 = 'inwave_member';

        function init_params() {

            return array(
                "name" => __("Team", 'inwavethemes'),
                "base" => $this->name,
                "content_element" => true,
                'category' => 'Custom',
                "description" => __("Add a Team.", "inwavethemes"),
                "as_parent" => array('only' => 'inwave_member'),
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
                    )
                )
            );
        }
        function init_params2() {

            return array(
                "name" => __("Member", 'inwavethemes'),
                "base" => $this->name2,
                "content_element" => true,
                'icon' => 'iw-default',
                'category' => 'Custom',
                "as_child" => array('only' => 'inwave_team'),
                "description" => __("Add a Member.", "inwavethemes"),
                "show_settings_on_create" => true,
                "params" => array(
                    array(
                        'type' => 'attach_image',
                        "heading" => __("Member Image", "inwavethemes"),
                        "param_name" => "image",
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Position", "inwavethemes"),
                        "value" => "",
                        "param_name" => "position"
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Name", "inwavethemes"),
                        "value" => "",
                        "param_name" => "name"
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "value" => "",
                        "description" => __("Write your own CSS and mention the class name here.", "inwavethemes"),
                    )
                )
            );
        }

        // Shortcode handler function for member box slider
        function init_shortcode($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

            $class='';
            extract(shortcode_atts(array(
                "class" => ""
            ), $atts));

            $count = preg_match_all('/\[inwave_member\s+title="([^\"]+)"(.*)\]/Usi', $content, $matches);
            switch($count){
                case 1 :
                    $this->bt_class = 'col-sm-12';
					break;
                case 2 :
                    $this->bt_class = 'col-sm-6';
					break;
                case 3 :
                    $this->bt_class = 'col-sm-4';
					break;
                default :
                    $this->bt_class = 'col-sm-3';
            }
            $output = '<div class="iw-team row">';
            $output .= do_shortcode($content);
            $output .= '</div>';

            return $output;
        }

        // Shortcode handler function member
        function init_shortcode2($atts, $content = null)
        {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name2, $atts ) : $atts;

            $output = $img = $name = $position = $class = $align = $css = $description = $social_links = $style = '';
            extract(shortcode_atts(array(
                'image' => '',
                'name' => '',
                'position' => '',
                'class' => '',
            ), $atts));

            $img_tag = '';
            if ($image) {
                $image = wp_get_attachment_image_src($image, 'large');
                $img_tag .= '<img src="' . $image[0] . '" alt="">';
            }

            $output .= '<div class="iw-member '.$this->bt_class .' ' . $class . ' ">';
            $output .= '<span class="line-1"><span class="line-2"></span></span>';
            $output .= $img_tag;
            $output .= '<div class="member-info">';
            $output .= '<h4 class="member-position">'.$position.'</h4>';
            $output .= '<h3 class="member-name">'.$name.'</h3>';
            $output .= '</div>';
            $output .= '</div>';

            return $output;
        }
    }
}

new Inwave_Team;

if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_Inwave_Team extends WPBakeryShortCodesContainer {
    }
}