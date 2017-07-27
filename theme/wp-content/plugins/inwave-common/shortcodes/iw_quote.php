<?php

/*
 * Inwave_Heading for Visual Composer
 */
if (!class_exists('Inwave_Quote')) {

    class Inwave_Quote extends Inwave_Shortcode{

        protected $name = 'inwave_quote';

        function init_params() {
            $google_fonts = function_exists('inwave_get_googlefonts') ? inwave_get_googlefonts() : array();
            $font_weight = function_exists('inwave_get_fonts_weight') ? inwave_get_fonts_weight() : array();
            return array(
                'name' => __("Quote", 'inwavethemes'),
                'description' => __('Add a quote & some information', 'inwavethemes'),
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
                            "Style 2 - Image Left" => "style2",
                            "Style 3 " => "style3",
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Insert Border", "inwavethemes"),
                        "description" => __('Insert border for Style 2.', "inwavethemes"),
                        "param_name" => "insert_border",
                        "value" => array(
                            "No Border" => "",
                            "Insert Border" => "insert-border",
                            "dependency" => array('element' => 'style', 'value' => 'style2')
                        )
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
                        "heading" => __("Quote Author", "inwavethemes"),
                        "description" => "",
                        "value" => "",
                        "param_name" => "author",
                    ),
                    array(
                        'type' => 'textarea',
                        "heading" => __("Quote", "inwavethemes"),
                        "description" => __("You can add |TEXT_EXAMPLE| to specify strong words, {TEXT_EXAMPLE} to specify colorful words", "inwavethemes"),
                        "value" => "",
                        "param_name" => "quote",
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "span",
                        "heading" => __("Bible Name ", "inwavethemes"),
                        "description" => __("You can add {TEXT_EXAMPLE} to specify colorful words", "inwavethemes"),
                        "value" => "",
                        "param_name" => "bible_name",
                    ),
                    array(
                        "type" => "attach_image",
                        "heading" => __("Image", "inwavethemes"),
                        "param_name" => "image",
                        "description" => __('Icon for heading.', "inwavethemes"),
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

            $output = $author = $quote = $bible_name = $image = $align = $style = $insert_border = $color_scheme = $css = $class = '';
            $content = preg_replace('/^\<\/p\>(.*)\<p\>$/Usi','$1',$content);
            extract(shortcode_atts(array(
                'author' => '',
                'quote' => '',
                'image' => '',
                'bible_name' => '',
                'align' => '',
                'style' => 'style1',
                'insert_border' => '',
                'color_scheme' => 'white',
                'css' => '',
                'class' => ''
            ), $atts));

            $class = '';
            $class .= ' '.$style.' '. vc_shortcode_custom_css_class( $css);

            if($align){
                $class.= ' text-'.$align;
            }

            if($color_scheme){
                $class.= ' color-'.$color_scheme;
            }

            if($insert_border){
                $class.= ' '.$insert_border;
            }

            if ($image) {
                $image = wp_get_attachment_image_src($image, 'large');
                $image = $image[0];
                $image = '<img src="' . $image . '" alt="' . $author . '">';
            }

            $quote = preg_replace('/\|(.*)\|/isU','<strong>$1</strong>',$quote);
            $quote = preg_replace('/\{(.*)\}/isU','<span class="theme-color">$1</span>',$quote);

            $bible_name = preg_replace('/\{(.*)\}/isU','<span class="bible-name">$1</span>',$bible_name);

            switch ($style) {
                // Normal style
                case 'style1':
                    $output .= '<div class="info-quote' .$class. '">';
                    if($image){
                        $output .= '<div class="quote-image">'.$image.'</div>';
                    }
                    $output .= '<div class="quote-content">';
                    $output .= '<h4 class="quote-author"><span class="author">'. ($author ? $author.': ' : '') . '</span><span class="quote">' . $quote . '</span></h4>';
                    if($bible_name){
                        $output .= '<div class="taken-from">' .$bible_name. '</div>';
                    }
                    $output .= '</div>';
                    $output .= '<div style="clear: both"></div>';
                    $output .= '</div>';
                    break;
                case 'style2':
                    $output .= '<div class="info-quote' .$class. '">';
                    if($image){
                        $output .= '<div class="quote-image">'.$image.'</div>';
                    }
                    $output .= '<div class="quote-content">';
                    if ($author || $quote) {
                        $output .= '<h4 class="quote-author"><span class="author">' . ($author ? $author.': ' : '') . '</span> <span class="quote theme-color">' . $quote . '</span></h4>';
                    }
                    if($bible_name){
                        $output .= '<div class="taken-from">' .$bible_name. '</div>';
                    }
                    $output .= '</div>';
                    $output .= '<div style="clear: both"></div>';
                    $output .= '</div>';
                break;
                case 'style3':
                    $output .= '<div class="info-quote' .$class. '">';
                        $output .= '<div class="quote-content">';
                            $output .= '<div class="icon-quote"><i class="fa fa-quote-left"></i></div>';
                            if ($quote) {
                                $output .= '<span class="quote-content">' . $quote . '</span>';
                            }
                            if ($author) {
                                $output .= '<h4 class="quote-author"><i class="fa fa-user theme-color"></i>' .__("By", "inwavethemes"). ' ' . $author . '</h4>';
                            }
                        $output .= '</div>';
                    $output .= '</div>';
                break;
            }
            return $output;
        }
    }
}

new Inwave_Quote;
