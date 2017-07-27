<?php

/*
 * Inwave_Info_List for Visual Composer
 */
if (!class_exists('Inwave_Info_List')) {

    class Inwave_Info_List extends Inwave_Shortcode2{

        protected $name = 'inwave_info_list';
        protected $name2 = 'inwave_info_item';
        protected $style;
        protected $count;

        function init_params() {
            return array(
                "name" => __("Info List", 'inwavethemes'),
                "base" => $this->name,
                "content_element" => true,
                'category' => 'Custom',
                'icon' => 'iw-default',
                "description" => __("Add a set of list info and give some custom style.", "inwavethemes"),
                "as_parent" => array('only' => 'inwave_info_item'),
                "show_settings_on_create" => true,
                "js_view" => 'VcColumnView',
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
                "name" => __("Info Item", 'inwavethemes'),
                "base" => $this->name2,
                "class" => "inwave_info_item",
                'icon' => 'iw-default',
                'category' => 'Custom',
                "description" => __("Add a information block and give some custom style.", "inwavethemes"),
                "show_settings_on_create" => true,
                "params" => array(
					array(
                        "type" => "dropdown",
                        "heading" => "Style",
						"admin_label" => true,
                        "param_name" => "style",
                        "value" => array(
                            "Style 1 - Icon Right" => "style1",
                            "Style 2 - Icon Left" => "style2",
                            "Style 3 - Icon Top" => "style3",
                            "Style 4 - Order" => "style4",

                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => "Number column",
                        "param_name" => "number_column",
                        "value" => array(
                            "1" => "1",
                            "2" => "2",
                            "3" => "3",
                            "4" => "4"
                        ),
                        "dependency" => array("element"=>"style", "value" => array("style4"))
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => "Color Scheme",
                        "param_name" => "color_scheme",
                        "value" => array(
                            "Dark Text" => "dark",
                            "White Text" => "white",
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
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Sub Title", "inwavethemes"),
                        "value" => "",
                        "param_name" => "sub_title",
                        "dependency" => array(
                            "element" => "style",
                            "value" => array("style3", "style4")
                        )
                    ),
                    array(
                        "type" => "textarea_html",
						"admin_label" => true,
                        "heading" => "Description",
                        "param_name" => "content",
                        "value" => ""
                    ),
                    array(
                        "type" => "iw_icon",
                        "heading" => __("Select Icon", "inwavethemes"),
                        "param_name" => "icon",
                        "value" => "",
                        "admin_label" => true,
                        "description" => __("Click and select icon of your choice. You can get complete list of available icons here: <a target='_blank' href='http://fortawesome.github.io/Font-Awesome/icons/'>Font-Awesome</a>", "inwavethemes"),
                        "dependency" => array(
                            "element" => "style",
                            "value" => array("style1", "style2", "style3")
                        )
                    ),
                    array(
                        'type' => 'attach_image',
                        "heading" => __("Icon Image", "inwavethemes"),
                        "param_name" => "icon_img",
                        "description" => __("Select icon image instead of font icon above", "inwavethemes"),
                        "dependency" => array(
                            "element" => "style",
                            "value" => array("style1", "style2", "style3")
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Icon Size", "inwavethemes"),
                        "param_name" => "icon_size",
                        "description" => __("Example: 70", "inwavethemes"),
                        "value" => "40",
                        "dependency" => array(
                            "element" => "style",
                            "value" => array("style1", "style2", "style3")
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Link", "inwavethemes"),
                        "param_name" => "link",
                        "value" => ""
                    ),
                    
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "extra_class",
                        "value" => "",
                        "description" => __("Write your own CSS and mention the class name here.", "inwavethemes"),
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
                    )
                )
            );
        }


        // Shortcode handler function for list
        function init_shortcode($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

            $class = $style = '';
            extract(shortcode_atts(array(
                "class" => "",
                "style" => "style1"
            ), $atts));
            $this->style = $style;

            $class .= ' '. $style;

            $output = '<div class="info-list ' . $class . '">';
            $this->count = 0;
            $output .= do_shortcode($content);
            $output .= '</div>';
            return $output;
        }

        // Shortcode handler function for item
        function init_shortcode2($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name2, $atts ) : $atts;

            $output = $style = $number_column = $color_scheme = $icon = $icon_size = $title = $sub_title = $align = $css = $extra_class = $img_tag = '';
            $description = preg_replace('/^\<\/p\>(.*)\<p\>$/Usi','$1',$content);
            extract(shortcode_atts(array(
                'icon' => '',
                'icon_size' => '40',
                'title' => '',
                'sub_title' => '',
                'icon_img' => '',
                'style' => '',
                'number_column' => '3',
                'color_scheme' => 'dark',
                'link' => '',
                'align' => '',
                'css' => '',
                'extra_class' => ''
            ), $atts));
            $class = '';
            $class .= ' '.$style.' '. vc_shortcode_custom_css_class( $css);

            if($color_scheme){
                $class.= ' '.$color_scheme;
            }

            if($align){
                $class.= ' '.$align.'-text';
            }

            if($extra_class){
                $class.= ' '.$extra_class;
            }

            if ($icon_img) {
                $icon_img = wp_get_attachment_image_src($icon_img, 'large');
                $icon_img = $icon_img[0];
                $icon_img = '<img src="' . $icon_img . '" alt="' . $title . '">';
            }

            $this->count++;
            $order = '';
            if ($this->count > 0){
                $order = $this->count;
            }

            switch ($style) {
                case 'style1':
                    $output .= '<div class="info-item ' .$class. '">';
                        if($icon_img){
                            $output .= '<div class="icon">'.$icon_img.'</div>';
                        }else if ($icon) {
                            $output .= '<div class="icon"><i style="font-size:' . $icon_size . 'px" class="' .  $icon . '"></i></div>';
                        }
                        $output .= '<div class="info-item-content">';
                            if ($title) {
                                $output .= '<h4 class="info-item-title">' . $title . '</h4>';
                            }
                            if ($description) {
                                $output .= '<div class="info-item-desc">' . $description . '</div>';
                            }
                        $output .= '</div>';
                        $output .= '<div style="clear: both"></div>';
                    $output .= '</div>';
                    break;

                case 'style2':
                    $output .= '<div class="info-item style1 ' .$class. '">';
                        if($icon_img){
                            $output .= '<div class="icon">'.$icon_img.'</div>';
                        }else if ($icon) {
                            $output .= '<div class="icon"><i style="font-size:' . $icon_size . 'px" class="' .  $icon . '"></i></div>';
                        }
                        $output .= '<div class="info-item-content">';
                            if ($title) {
                                $output .= '<h4 class="info-item-title">' . $title . '</h4>';
                            }
                            if ($description) {
                                $output .= '<div class="info-item-desc">' . $description . '</div>';
                            }
                        $output .= '</div>';
                        $output .= '<div style="clear: both"></div>';
                    $output .= '</div>';
                    break;

                case 'style3':
                    $output .= '<div class="info-item' .$class. '">';
                        if($icon_img){
                            $output .= '<div class="img-wrap" ><span class="iw-line-1"><span class="iw-line-2"></span></span>'.$icon_img.'</div>';
                        }else if ($icon) {
                            $output .= '<div class="icon"><i style="font-size:' . $icon_size . 'px" class="' .  $icon . '"></i></div>';
                        }
                        $output .= '<div class="info-item-content">';
                        if ($sub_title) {
                            $output .= '<span class="info-item-subtitle theme-color">' . $sub_title . '</span>';
                        }
                        if ($title) {
                            $output .= '<h4 class="info-item-title">' . $title . '</h4>';
                        }
                        if ($description) {
                            $output .= '<div class="info-item-desc">' . $description . '</div>';
                        }
                        $output .= '</div>';
                        $output .= '<div style="clear: both"></div>';
                    $output .= '</div>';
                    break;

                case 'style4':
                    $output .= '<div class="col-md-' .$number_column. ' col-sm-6">';
                        $output .= '<div class="info-item' .$class. '">';
                            if($order){
                                $output .= '<div class="item-number" >'.$order.'</div>';
                            }
                            $output .= '<div class="info-item-content">';
                            if ($sub_title) {
                                $output .= '<span class="info-item-subtitle theme-color">' . $sub_title . '</span>';
                            }
                            if ($title) {
                                $output .= '<h4 class="info-item-title">' . $title . '</h4>';
                            }
                            if ($description) {
                                $output .= '<div class="info-item-desc">' . $description . '</div>';
                            }
                            $output .= '</div>';
                        $output .= '</div>';
                    $output .= '</div>';
                    break;
            }
            return $output;
        }
    }
}


new Inwave_Info_List;
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_Inwave_Info_List extends WPBakeryShortCodesContainer {
    }
}
