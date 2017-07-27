<?php

/*
 * Inwave_Heading for Visual Composer
 */
if (!class_exists('Inwave_Heading')) {

    class Inwave_Heading extends Inwave_Shortcode{

        protected $name = 'inwave_heading';

        function init_params() {
            $google_fonts = function_exists('inwave_get_googlefonts') ? inwave_get_googlefonts() : array();
            $font_weight = function_exists('inwave_get_fonts_weight') ? inwave_get_fonts_weight() : array();
            return array(
                'name' => __("Heading", 'inwavethemes'),
                'description' => __('Add a heading & some information', 'inwavethemes'),
                'base' => $this->name,
                'category' => 'Custom',
                'icon' => 'iw-default',
                'params' => array(
                    array(
                        "type" => "dropdown",
                        "admin_label" => true,
                        "heading" => "Style",
                        "param_name" => "style",
                        "value" => array(
                            "Style 1 - Normal" => "style1",
                            "Style 2 - Underline" => "style2",
                            "Style 3 - Left icon" => "style3",
                            "Style 4 - Center icon" => "style4",
                        )
                    ),
                    array(
                        'type' => 'textfield',
                        "heading" => __("Sub2 Title", "inwavethemes"),
                        "value" => "",
                        "param_name" => "sub2_title"
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "span",
                        "heading" => __("Title", "inwavethemes"),
                        "description" => __("You can add |TEXT_EXAMPLE| to specify strong words, <br />{TEXT_EXAMPLE} to specify colorful words, <br />'///' to insert line break tag (br)", "inwavethemes"),
                        "value" => "",
                        "param_name" => "title",
                    ),
                    array(
                        'type' => 'textarea',
                        "holder" => "div",
                        "heading" => __("Sub Title", "inwavethemes"),
                        "value" => "",
                        "param_name" => "sub_title",
                        "dependency" => array(
                            "element" => "style",
                            "value" => array("style1", "style2", "style4")
                        )
                    ),
                    array(
                        "type" => "attach_image",
                        "heading" => __("Image", "inwavethemes"),
                        "param_name" => "icon",
                        "description" => __('Icon for heading.', "inwavethemes"),
                        "dependency" => array(
                            "element" => "style",
                            "value" => array("style2", "style3", "style4")
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => "Color Scheme",
                        "param_name" => "color_scheme",
                        "value" => array(
                            "Dark Text" => "dark",
                            "Light Text" => "light",
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => "Text align",
                        "param_name" => "align",
                        "value" => array(
                            "Default" => "",
                            "Left" => "left",
                            "Right" => "right",
                            "Center" => "center"
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "inwavethemes")
                    ),

                    //title style
                    array(
                        "type" => "colorpicker",
                        "heading" => __("Title Color", "inwavethemes"),
                        "group" => "Title Style",
                        "param_name" => "color_title",
                        "description" => __('Color for Title', "inwavethemes"),
                        "value" => "",
                    ),
                    array(
                        'type' => 'textfield',
                        "group" => "Title Style",
                        "heading" => __("Title Font Size", "inwavethemes"),
                        "value" => "",
                        "description" => __('Custom font-size title', "inwavethemes"),
                        "param_name" => "font_size_title",
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Title Font Family", "inwavethemes"),
                        "group" => "Title Style",
                        "param_name" => "font_family_title",
                        "description" => __('Font family of Title', "inwavethemes"),
                        "value" => $google_fonts,
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Title Style",
                        "heading" => __("Load Font Family from google", "inwavethemes"),
                        "param_name" => "load_font_title",
                        "value" => array(
                            __('No', "inwavethemes") => '',
                            __('Yes', "inwavethemes") => '1',
                        ),
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Title Style",
                        "heading" => __("Title Font Weight", "inwavethemes"),
                        "param_name" => "font_weight_title",
                        "description" => __('Font weight of Title', "inwavethemes"),
                        "value" => $font_weight,
                    ),
                    array(
                        "type" => "textfield",
                        "group" => "Title Style",
                        "heading" => __("Title Line Height", "inwavethemes"),
                        "param_name" => "line_height_title",
                        "description" => __('Line height of Title', "inwavethemes"),
                        "value" => "",
                    ),

                    //subtitle style
                    array(
                        "type" => "colorpicker",
                        "heading" => __("Sub Title Color", "inwavethemes"),
                        "group" => "Sub Title Style",
                        "param_name" => "color_sub_title",
                        "description" => __('Color for Sub Title', "inwavethemes"),
                        "value" => "",
                    ),
                    array(
                        'type' => 'textfield',
                        "group" => "Sub Title Style",
                        "heading" => __(" Sub Title Font Size", "inwavethemes"),
                        "value" => "",
                        "description" => __('Custom font-size title', "inwavethemes"),
                        "param_name" => "font_size_sub_title",
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Sub Title Font Family", "inwavethemes"),
                        "group" => "Sub Title Style",
                        "param_name" => "font_family_sub_title",
                        "description" => __('Font family of Sub Title', "inwavethemes"),
                        "value" => $google_fonts,
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Sub Title Style",
                        "heading" => __("Load Font Family from google", "inwavethemes"),
                        "param_name" => "load_font_sub_title",
                        "value" => array(
                            __('No', "inwavethemes") => '',
                            __('Yes', "inwavethemes") => '1',
                        ),
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Sub Title Style",
                        "heading" => __("Sub Title Font Weight", "inwavethemes"),
                        "param_name" => "font_weight_sub_title",
                        "description" => __('Font weight of Sub Title', "inwavethemes"),
                        "value" => $font_weight,
                    ),
                    array(
                        "type" => "textfield",
                        "group" => "Sub Title Style",
                        "heading" => __("Sub Title Line Height", "inwavethemes"),
                        "param_name" => "line_height_sub_title",
                        "description" => __('Line height of Sub Title', "inwavethemes"),
                        "value" => "",
                    ),
                    array(
                        "type" => "textfield",
                        "group" => "Sub Title Style",
                        "heading" => __("Margin top", "inwavethemes"),
                        "param_name" => "margin_top_sub_title",
                        "description" => __('Margin top of Sub Title', "inwavethemes"),
                        "value" => "",
                    ),

                    //sub2title style
                    array(
                        "type" => "colorpicker",
                        "heading" => __("Sub2 Title Color", "inwavethemes"),
                        "group" => "Sub2 Title Style",
                        "param_name" => "color_sub2_title",
                        "description" => __('Color for Sub2 Title', "inwavethemes"),
                        "value" => "",
                        "dependency" => array(
                            "element" => "style",
                            "value" => array("style1", "style2", "style3")
                        )
                    ),
                    array(
                        'type' => 'textfield',
                        "group" => "Sub2 Title Style",
                        "heading" => __(" Sub2 Title Font Size", "inwavethemes"),
                        "value" => "",
                        "description" => __('Custom font-size title', "inwavethemes"),
                        "param_name" => "font_size_sub2_title",
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Sub2 Title Font Family", "inwavethemes"),
                        "group" => "Sub2 Title Style",
                        "param_name" => "font_family_sub2_title",
                        "description" => __('Font family of Sub2 Title', "inwavethemes"),
                        "value" => $google_fonts,
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Sub2 Title Style",
                        "heading" => __("Load Font Family from google", "inwavethemes"),
                        "param_name" => "load_font_sub2_title",
                        "value" => array(
                            __('No', "inwavethemes") => '',
                            __('Yes', "inwavethemes") => '1',
                        ),
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Sub2 Title Style",
                        "heading" => __("Sub2 Title Font Weight", "inwavethemes"),
                        "param_name" => "font_weight_sub2_title",
                        "description" => __('Font weight of Sub2 Title', "inwavethemes"),
                        "value" => $font_weight,
                    ),
                    array(
                        "type" => "textfield",
                        "group" => "Sub2 Title Style",
                        "heading" => __("Sub2 Title Line Height", "inwavethemes"),
                        "param_name" => "line_height_sub2_title",
                        "description" => __('Line height of Sub2 Title', "inwavethemes"),
                        "value" => "",
                    ),
                    array(
                        "type" => "textfield",
                        "group" => "Sub2 Title Style",
                        "heading" => __("Margin bottom", "inwavethemes"),
                        "param_name" => "margin_bottom_sub2_title",
                        "description" => __('Margin bottom of Sub2 Title', "inwavethemes"),
                        "value" => "",
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Sub2 Title Style",
                        "heading" => __("background Color", "inwavethemes"),
                        "param_name" => "background_color_sub2_title",
                        "value" => array(
                            __('No', "inwavethemes") => '',
                            __('Yes', "inwavethemes") => '1',
                        ),
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

        // Shortcode handler function for list Icon
        function init_shortcode($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

            $output = '';
            $content = preg_replace('/^\<\/p\>(.*)\<p\>$/Usi','$1',$content);
            extract(shortcode_atts(array(
                'title' => '',
                'sub_title' => '',
                'sub2_title' => '',
                'icon' => '',
                'align' => '',
                'color_scheme' => '',
                'style' => 'style1',

                'color_title' => '',
                'font_size_title' => '',
                'font_family_title' => '',
                'load_font_title' => '',
                'font_weight_title' => '',
                'line_height_title' => '',

                'color_sub_title' => '',
                'font_size_sub_title' => '',
                'font_family_sub_title' => '',
                'load_font_sub_title' => '',
                'font_weight_sub_title' => '',
                'line_height_sub_title' => '',
                'margin_top_sub_title' => '',

                'color_sub2_title' => '',
                'font_size_sub2_title' => '',
                'font_family_sub2_title' => '',
                'load_font_sub2_title' => '',
                'font_weight_sub2_title' => '',
                'line_height_sub2_title' => '',
                'margin_bottom_sub2_title' => '',
                'background_color_sub2_title' => '',

                'css' => '',
                'class' => ''
            ), $atts));

            $class .= ' '.$style.' '.$color_scheme.' '. vc_shortcode_custom_css_class( $css);
            if($align){
                $class.= ' text-'.$align;
            }
            if($background_color_sub2_title){
                $class .= ' sub2-background-color';
            }

            //title
            $title_style = array();
            if($color_title){
                $title_style[] = 'color: '.esc_attr($color_title);
            }
            if($font_size_title){
                $title_style[] = 'font-size: '.esc_attr($font_size_title);
            }
            if($font_family_title){
                if($load_font_title && !isset(Inwave_Shortcode::$loadfonts[$font_family_title.$font_weight_title])){
                    $font_url = "http" . ((is_ssl()) ? 's' : '') . "://fonts.googleapis.com/css?family={$font_family_title}";
                    wp_enqueue_style('google-font-'.strtolower(str_replace(" ", "-", $font_family_title.$font_weight_title)), $font_url);
                    Inwave_Shortcode::$loadfonts[$font_family_title.$font_weight_title] = true;
                }
                $title_style[] = 'font-family: '.esc_attr($font_family_title);
            }
            if($font_weight_title){
                $title_style[] = 'font-weight: '.esc_attr($font_weight_title);
            }
            if($line_height_title){
                $title_style[] = 'line-height: '.esc_attr($line_height_title);
            }

            //subtitle
            $sub_title_style = array();
            if($color_sub_title){
                $sub_title_style[] = 'color: '.esc_attr($color_sub_title);
            }
            if($font_size_sub_title){
                $sub_title_style[] = 'font-size: '.esc_attr($font_size_sub_title);
            }
            if($font_family_sub_title){
                if($load_font_sub_title && !isset(Inwave_Shortcode::$loadfonts[$font_family_sub_title.$font_weight_sub_title])){
                    $font_url = "http" . ((is_ssl()) ? 's' : '') . "://fonts.googleapis.com/css?family={$font_family_sub_title}";
                    wp_enqueue_style('google-font-'.strtolower(str_replace(" ", "-", $font_family_sub_title.$font_weight_sub_title)), $font_url);
                    Inwave_Shortcode::$loadfonts[$font_family_sub_title.$font_weight_sub_title] = true;
                }
                $sub_title_style[] = 'font-family: '.esc_attr($font_family_sub_title);
            }
            if($font_weight_sub_title){
                $sub_title_style[] = 'font-weight: '.esc_attr($font_weight_sub_title);
            }
            if($line_height_sub_title){
                $sub_title_style[] = 'line-height: '.esc_attr($line_height_sub_title);
            }
            if($margin_top_sub_title){
                $sub_title_style[] = 'margin-top: '.esc_attr($margin_top_sub_title);
            }

            //sub2title
            $sub2_title_style = array();
            if($color_sub2_title){
                $sub2_title_style[] = 'color: '.esc_attr($color_sub2_title);
            }
            if($font_size_sub2_title){
                $sub2_title_style[] = 'font-size: '.esc_attr($font_size_sub2_title);
            }
            if($font_family_sub2_title){
                if($load_font_sub2_title && !isset(Inwave_Shortcode::$loadfonts[$font_family_sub2_title.$font_weight_sub2_title])){
                    $font_url = "http" . ((is_ssl()) ? 's' : '') . "://fonts.googleapis.com/css?family={$font_family_sub2_title}";
                    wp_enqueue_style('google-font-'.strtolower(str_replace(" ", "-", $font_family_sub2_title.$font_weight_sub2_title)), $font_url);
                    Inwave_Shortcode::$loadfonts[$font_family_sub2_title.$font_weight_sub2_title] = true;
                }
                $sub2_title_style[] = 'font-family: '.esc_attr($font_family_sub2_title);
            }
            if($font_weight_sub2_title){
                $sub2_title_style[] = 'font-weight: '.esc_attr($font_weight_sub2_title);
            }
            if($line_height_sub2_title){
                $sub2_title_style[] = 'line-height: '.esc_attr($line_height_sub2_title);
            }
            if($margin_bottom_sub2_title){
                $sub2_title_style[] = 'margin-bottom: '.esc_attr($margin_bottom_sub2_title);
            }

            $title= preg_replace('/\|(.*)\|/isU','<strong>$1</strong>',$title);
            $title= preg_replace('/\{(.*)\}/isU','<span class="theme-color">$1</span>',$title);
            $title= preg_replace('/\/\/\//i', '<br />', $title);

            $sub_title= preg_replace('/\|(.*)\|/isU','<strong>$1</strong>',$sub_title);
            $sub_title= preg_replace('/\{(.*)\}/isU','<span class="theme-color">$1</span>',$sub_title);
            $sub_title= preg_replace('/\/\/\//i', '<br />', $sub_title);

            $sub2_title= preg_replace('/\|(.*)\|/isU','<strong>$1</strong>',$sub2_title);
            $sub2_title= preg_replace('/\{(.*)\}/isU','<span class="theme-color">$1</span>',$sub2_title);
            $sub2_title= preg_replace('/\/\/\//i', '<br />', $sub2_title);

            switch ($style) {
                // Normal style
                case 'style1':
                    $output .= '<div class="iw-heading ' . $class . '">';
                    if ($sub2_title) {
                        $sub2_class = 'heading-sub2-title';
                        $sub2_class .= $background_color_sub2_title ? ' theme-bg' : '';
                        $output .= '<div class="'.$sub2_class.'" style="'.implode("; ",$sub2_title_style).'">' . $sub2_title . '</div>';
                    }
                    $output .= '<h3 class="heading-title" style="'.implode("; ",$title_style).'">' . $title . '</h3>';
                    if ($sub_title) {
                        $output .= '<div class="heading-sub-title" style="'.implode("; ",$sub_title_style).'">' . $sub_title . '</div>';
                    }
                    $output .= '</div>';
                    break;

                case 'style2':
                    $output .= '<div class="iw-heading ' . $class . '">';
                    if($icon){
                        $img = wp_get_attachment_image_src($icon, 'full');
                        $image_url = count($img) ? $img[0] : '';
                        $output .= '<img class="heading-icon" src="'.esc_url($image_url).'" alt="">';
                    }
                    if ($sub2_title) {
                        $sub2_class = 'heading-sub2-title';
                        $sub2_class .= $background_color_sub2_title ? ' theme-bg' : '';
                        $output .= '<div class="'.$sub2_class.'" style="'.implode("; ",$sub2_title_style).'">' . $sub2_title . '</div>';
                    }
                    $output .= '<h3 class="heading-title" style="'.implode("; ",$title_style).'">' . $title . '</h3>';
                    $output .= '<span class="line"></span>';
                    if ($sub_title) {
                        $output .= '<div class="heading-sub-title" style="'.implode("; ",$sub_title_style).'">' . $sub_title . '</div>';
                    }
                    $output .= '</div>';
                break;

                case 'style3':
                    $output .= '<div class="iw-heading ' . $class . '">';
                        if($icon){
                            $img = wp_get_attachment_image_src($icon, 'full');
                            $image_url = count($img) ? $img[0] : '';
                            $output .= '<img class="heading-icon" src="'.esc_url($image_url).'" alt="">';
                        }
                        $output .= '<div class="heading-main">';
                            if ($sub2_title) {
                                $sub2_class = 'heading-sub2-title';
                                $sub2_class .= $background_color_sub2_title ? ' theme-bg' : '';
                                $output .= '<div class="'.$sub2_class.'" style="'.implode("; ",$sub2_title_style).'">' . $sub2_title . '</div>';
                            }
                            $output .= '<h3 class="heading-title" style="'.implode("; ",$title_style).'">' . $title . '</h3>';
                            $output .= '<span class="line"></span>';
                            if ($sub_title) {
                                $output .= '<div class="heading-sub-title" style="'.implode("; ",$sub_title_style).'">' . $sub_title . '</div>';
                            }
                        $output .= '</div>';
                    $output .= '</div>';
                break;

                case 'style4':
                    $output .= '<div class="iw-heading ' . $class . ' row">';
                        $output .= '<div class="col-md-5 col-sm-5 col-xs-12"><h3 class="heading-title" style="'.implode("; ",$title_style).'">' . $title . '</h3></div>';
                        if($icon){
                            $output .= '<div class="col-md-2 col-sm-2 col-xs-12">';
                            $img = wp_get_attachment_image_src($icon, 'full');
                            $image_url = count($img) ? $img[0] : '';
                            $output .= '<img class="heading-icon" src="'.esc_url($image_url).'" alt="">';
                            $output .= '</div>';
                        }
                        if ($sub_title) {
                            $output .= '<div class="col-md-5 col-sm-5 col-xs-12 heading-sub-title"><span>' . $sub_title . '</span></div>';
                        }
                    $output .= '</div>';
                break;
            }
            return $output;
        }
    }
}

new Inwave_Heading;
