<?php

/*
 * Inwave_Info_Item for Visual Composer
 */
if (!class_exists('Inwave_Info_Item')) {

    class Inwave_Info_Item extends Inwave_Shortcode{

        protected $name = 'inwave_info_item';
        protected $style;

        function init_params(){
            return array(
                "name" => __("Info Item", 'inwavethemes'),
                "base" => $this->name,
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
                            "Style 1 - Normal" => "style1",
                            "Style 2 - Icon Left" => "style2",
                            "Style 3 - Icon Left 2" => "style3",
							"Style 4 - Line through icon" => "style4",
							"Style 5 - Icon image left" => "style5",
                            "Style 6 - Style with image icon" => "style6",
                            
                        )
                    ),
					array(
                        "type" => "iwevent_preview_image",
                        "heading" => __("Preview Style", "inwavethemes"),
                        "param_name" => "preview_style1",
                        "value" => get_template_directory_uri() . '/assets/images/shortcodes/info-item-1.jpg',
                        "dependency" => array('element' => 'style', 'value' => 'style1')
                    ),
					array(
                        "type" => "iwevent_preview_image",
                        "heading" => __("Preview Style", "inwavethemes"),
                        "param_name" => "preview_style2",
                        "value" => get_template_directory_uri() . '/assets/images/shortcodes/info-item-2.jpg',
                        "dependency" => array('element' => 'style', 'value' => 'style2')
                    ),
					array(
                        "type" => "iwevent_preview_image",
                        "heading" => __("Preview Style", "inwavethemes"),
                        "param_name" => "preview_style3",
                        "value" => get_template_directory_uri() . '/assets/images/shortcodes/info-item-3.jpg',
                        "dependency" => array('element' => 'style', 'value' => 'style3')
                    ),
					array(
                        "type" => "iwevent_preview_image",
                        "heading" => __("Preview Style", "inwavethemes"),
                        "param_name" => "preview_style4",
                        "value" => get_template_directory_uri() . '/assets/images/shortcodes/info-item-4.jpg',
                        "dependency" => array('element' => 'style', 'value' => 'style4')
                    ),
					array(
                        "type" => "iwevent_preview_image",
                        "heading" => __("Preview Style", "inwavethemes"),
                        "param_name" => "preview_style5",
                        "value" => get_template_directory_uri() . '/assets/images/shortcodes/info-item-5.jpg',
                        "dependency" => array('element' => 'style', 'value' => 'style5')
                    ),
					array(
                        "type" => "iwevent_preview_image",
                        "heading" => __("Preview Style", "inwavethemes"),
                        "param_name" => "preview_style6",
                        "value" => get_template_directory_uri() . '/assets/images/shortcodes/info-item-6.jpg',
                        "dependency" => array('element' => 'style', 'value' => 'style6')
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Title", "inwavethemes"),
                        "value" => "This is title",
                        "param_name" => "title"
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
                    ),
                    array(
                        'type' => 'attach_image',
                        "heading" => __("Icon Image", "inwavethemes"),
                        "param_name" => "img",
                        "description" => __("Icon Image", "inwavethemes"),
						"dependency" => array(
							'element' => 'style', 
							'value' => array('style5', 'style6')
						)
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Icon Size", "inwavethemes"),
                        "param_name" => "icon_size",
                        "description" => __("Example: 70", "inwavethemes"),
                        "value" => "70"
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

        // Shortcode handler function for item
        function init_shortcode($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

            $output = $style = $icon = $icon_size = $title = $align = $css = $extra_class = $img_tag = '';
            $description = preg_replace('/^\<\/p\>(.*)\<p\>$/Usi','$1',$content);
            extract(shortcode_atts(array(
                'icon' => '',
                'icon_size' => '70',
                'title' => '',
                'img' => '',
                'style' => '',
                'link' => '',
                'align' => '',
                'css' => '',
                'extra_class' => ''
            ), $atts));

            $class = ' '.$style.' '. vc_shortcode_custom_css_class( $css);

            if($align){
                $class.= ' '.$align.'-text';
            }

            if($extra_class){
                $class.= ' '.$extra_class;
            }

            if ($img) {
                $img = wp_get_attachment_image_src($img, 'large');
                $img = $img[0];
                $size = '';
                if ($icon_size) {
                    $size = 'style="width:' . $icon_size . 'px!important;"';
                }
                $img_tag .= '<img src="' . $img . '" alt="' . $title . '">';
            }
            switch ($style) {
                case 'style1':
                    $output .= '<div class="info-item ' . $class . '">';
                    if ($icon) {
                        $output .= '<div class="icon"><i style="font-size:' . $icon_size . 'px" class="theme-color ' .  $icon . '"></i></div>';
                    }
                    $output .= '<div class="info-item-content">';
                    if ($title) {
                        if($link){
                            $output .= '<h4 class="theme-color info-item-title"><a href="' . $link . '">' . $title . '</a></h4>';
                        }
                        else{
                            $output .= '<h4 class="theme-color info-item-title">' . $title . '</h4>';
                        }
                    }
                    $output .= '<div class="info-item-desc">' . $description . '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
				break;
                case 'style2':
                    $output .= '<div class="info-item ' . $class . '">';
                    $output .= '<div class="info-item-content">';
                    $output .= '<div class="info-top">';
                    if ($icon) {
                        if($link){
                            $output .= '<div class="icon ' . $class . '" style="font-size:'.$icon_size.'px"><a href="' . $link . '"><i class="theme-color ' .  $icon . '"></i></a></div>';
                        }else{
                            $output .= '<div class="icon ' . $class . '" style="font-size:'.$icon_size.'px"><i class="theme-color ' .  $icon . '"></i></div>';
                        }
                    }
                    if ($title) {
                        if($link){
                            $output .= '<h4 class="theme-color info-item-title"><a href="' . $link . '">' . $title . '</a></h4>';
                        }
                        else{
                            $output .= '<h4 class="theme-color info-item-title">' . $title . '</h4>';
                        }
                    }
                    $output .= '<div style="clear: both"></div>';
                    $output .= '</div>';
                    $output .= '<div class="info-item-desc">' . $description . '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
				break;
				
				case 'style3':
					$output .= '<div class="info-item ' . $class . '">';
					if ($icon) {
						$output .= '<div class="icon theme-color" style="font-size:'.$icon_size.'px"><i class="' .  $icon . '"></i></div>';
					}
					$output .= '<div class="info-item-content">';
					if ($title) {
						if($link){
							$output .= '<h4 class="info-item-title"><a href="' . $link . '">' . $title . '</a></h4>';
						}
						else{
							$output .= '<h4 class="info-item-title">' . $title . '</h4>';
						}
					}
					$output .= '<div class="info-item-desc">' . $description . '</div>';
						
					$output .= '</div>';
					$output .= '<div style="clear: both"></div>';
					$output .= '</div>';
                break;

                case 'style4':
                    $output .= '<div class="info-item ' . $class . '">';
                    if ($icon) {
                        if($link) {
                            $output .= '<div class="icon"><a href="' . $link . '"><i style="font-size:' . $icon_size . 'px" class="theme-color ' . $icon . '"></i></a></div>';
                        }else{
                            $output .= '<div class="icon"><i style="font-size:'.$icon_size.'px" class="' . $icon . '"></i></div>';
                        }
                    }
                    $output .= '<div class="info-item-content">';
                    if ($title) {
                        if($link) {
                            $output .= '<h4 class="info-item-title theme-color"><a href="' . $link . '">' . $title . '</a></h4>';
                        }else{
                            $output .= '<h4 class="info-item-title theme-color">' . $title . '</h4>';
                        }
                    }
                    $output .= '<div class="info-item-desc">' . $description . '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
				break;
				
				case 'style5':
					$output .= '<div class="info-item'.$class.'">';
                    if ($img) {
                        $output .= '<div class="info-item-icon">'.$img_tag.'</div>';
                    }
                    $output .= '<div class="info-item-body">';
                    if ($title) {
                        if($link) {
                            $output .= '<h3 class="info-item-title"><a href="'.$link.'">'.$title.'</a></h3>';
                        } else {
                            $output .= '<h3 class="info-item-title">'.$title.'</h3>';
                        }
                    }
                    $output .= '<div class="info-item-desc">' . $description . '</div>';
                    $output .= '</div>';
                    $output .= '<div style="clear:both;"></div></div>';
                break;
				
				case 'style6':
					$output .= '<div class="info-item'.$class.'">';
                    if ($img) {
                        $output .= '<div class="info-item-icon">'.$img_tag.'</div>';
                    }
                    $output .= '<div class="info-item-body">';
                    if ($title) {
                        if($link) {
                            $output .= '<h3 class="info-item-title"><a href="'.$link.'">'.$title.'</a></h3>';
                        } else {
                            $output .= '<h3 class="info-item-title">'.$title.'</h3>';
                        }
                    }
                    $output .= '<div class="info-item-desc">' . $description . '</div>';
                    $output .= '</div>';
                    $output .= '<div style="clear:both;"></div></div>';
                break;

                default:
                    $output .= '<div class="info-item style2">';
                    $output .= '<div class="info-item-content">';
                    $output .= '<div class="info-top">';
                    if ($icon) {
                        if($link){
                            $output .= '<div class="icon ' . $class . '" style="font-size:'.$icon_size.'px"><a href="' . $link . '"><i class="theme-color ' .  $icon . '"></i></a></div>';
                        }else{
                            $output .= '<div class="icon ' . $class . '" style="font-size:'.$icon_size.'px"><i class="theme-color ' .  $icon . '"></i></div>';
                        }
                    }
                    if ($title) {
                        if($link){
                            $output .= '<h4 class="theme-color info-item-title"><a href="' . $link . '">' . $title . '</a></h4>';
                        }
                        else{
                            $output .= '<h4 class="theme-color info-item-title">' . $title . '</h4>';
                        }
                    }
                    $output .= '<div style="clear: both"></div>';
                    $output .= '</div>';
                    $output .= '<div class="info-item-desc">' . $description . '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    break;
            }
            return $output;
        }
    }
}


new Inwave_Info_Item;
if (class_exists('WPBakeryShortCodesContainer')) {
    class WPBakeryShortCode_Inwave_Info_Item extends WPBakeryShortCodesContainer {
    }
}
