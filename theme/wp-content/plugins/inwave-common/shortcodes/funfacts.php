<?php
/*
 * Inwave_Button for Visual Composer
 */
if (!class_exists('Inwave_Funfacts')) {

    class Inwave_Funfacts extends Inwave_Shortcode2{

        protected $name = 'inwave_funfacts';
        protected $name2 = 'inwave_funfact';

        function init_params() {
            return array(
                "name" => __("Funfacts", 'inwavethemes'),
                "base" => $this->name,
                "content_element" => true,
                'category' => 'Custom',
                "description" => __("Add a set of list item.", "inwavethemes"),
                "as_parent" => array('only' => 'inwave_funfact'),
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
                )
            );
        }

        function init_params2() {
            return array(
                'name' => __("Funfact", 'inwavethemes'),
                'description' => __('Insert a funfact style', 'inwavethemes'),
                'base' => $this->name2,
                'icon' => 'iw-default',
                'category' => 'Custom',
                "as_child" => array('only' => 'inwave_funfacts'),
                "show_settings_on_create" => true,
                'params' => array(
                    array(
                        "type" => "textfield",
                        "admin_label" => true,
                        "heading" => __("Number",'inwavethemes'),
                        "param_name" => "number",
                        "value" => __("7854",'inwavethemes'),
                        "description" => __("Add number funfact on for element",'inwavethemes')
                    ),
                    array(
                        "type" => "textfield",
                        "admin_label" => true,
                        "heading" => __("title",'inwavethemes'),
                        "param_name" => "title",
                        "value" => __("Data Transferred",'inwavethemes'),
                        "description" => __("Add title Funfacr for element",'inwavethemes')
                    ),
                    array(
                        "type" => "attach_image",
                        "heading" => __("Image", "inwavethemes"),
                        "param_name" => "image",
                    ),
                    array(
                        "type" => "textfield",
                        "admin_label" => true,
                        "heading" => __("Prefix",'inwavethemes'),
                        "param_name" => "prefix",
                        "value" => '',
                        "description" => __("Add prefix funfact for element",'inwavethemes')
                    ),
                    array(
                        "type" => "textfield",
                        "admin_label" => true,
                        "heading" => __("Suffix",'inwavethemes'),
                        "param_name" => "suffix",
                        "value" => '',
                        "description" => __("Add suffix funfact for element",'inwavethemes')
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Speed",'inwavethemes'),
                        "param_name" => "speed",
                        "value" => '1000',
                        "description" => __("Set speed funfact for element",'inwavethemes')
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __( 'Add comma?', 'js_composer' ),
                        'param_name' => 'add_comma',
                    ),
                )
            );
        }

        function init_shortcode($atts, $content = null){
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;
            $output = '';
            extract( shortcode_atts(
                array(
                    // alway
                    'class' => '',
                ), $atts ));

            $count = preg_match_all('/\[inwave_funfact(.*)\]/Usi', $content, $matches);
            $this->width = 0;
            if($count){
                $this->width = 100/$count;
            }
            $output .= '<div class="iw-funfacts clearfix">';
            $output .= '<div class="container">';
            $output .= do_shortcode($content);
            $output .= '</div>';
            $output .= '</div>';

            return $output;
        }
        function init_shortcode2($atts, $content = null){
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name2, $atts ) : $atts;
            $el_class = $html = '';
            extract( shortcode_atts(
                array(
                    // alway
                    'el_class' => '',
                    'image' => '',
                    'number' => '',
                    'title' => '',
                    'prefix' => '',
                    'suffix' => '',
                    'speed' => '',
                    'add_comma' => '',
                ), $atts ));

            wp_enqueue_script('jquery-countTo');

            $img = wp_get_attachment_image_src($image, 'full');

            $funfact_settings = array();
            $funfact_settings['to'] = $number;
            $funfact_settings['speed'] = (int)$speed;
            $funfact_settings['add_comma'] = $add_comma ? true : false;
            $html .='<div class="iw-funfact" data-settings="'.esc_attr(json_encode($funfact_settings)).'" style="width : '.$this->width.'%">
                        <div class="funfact-wrap clearfix">
                        <div class="funfact-info">
                            <div class="funfact-number-wrap">';
                                if($prefix != ''){
                                    $html .='<span class="funfact-prefix">'.$prefix.'</span>';
                                }
                                $html .='<span data-number="'.esc_attr($number).'" class="funfact-number">'.$number.'</span>';
                                if($suffix !=''){
                                    $html .='<span class="funfact-suffix">'.$suffix.'</span>';
                                }
                                $html .='
                            </div>
                            <h3 class="funfact-title">'.$title.'</h3>
                        </div>
					<div class="funfact-image"><img src="'.(isset($img[0]) ? $img[0] : '').'" alt=""></div>
			    </div></div>';

            return $html;
        }
    }
}

new Inwave_Funfacts();
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_Inwave_Funfacts extends WPBakeryShortCodesContainer {
    }
}