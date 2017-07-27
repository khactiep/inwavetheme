<?php
/*
 * Inwave_Button for Visual Composer
 */
if (!class_exists('Inwave_Image_Box')) {

    class Inwave_Image_Box extends Inwave_Shortcode{

        protected $name = 'inwave_image_box';

        function init_params() {
            return array(
                'name' => __("Image Box", 'inwavethemes'),
                'description' => __('Add a image box', 'inwavethemes'),
                'base' => $this->name,
                'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
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
                        "type" => "attach_image",
                        "heading" => __("Image", "inwavethemes"),
                        "param_name" => "image",
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Title", "inwavethemes"),
                        "param_name" => "title",
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Sub Title", "inwavethemes"),
                        "param_name" => "sub_title",
                    ),
					array(
                        "type" => "textfield",
                        "heading" => __("Link", "inwavethemes"),
                        "param_name" => "link",
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "inwavethemes")
                    )
                )
            );
        }

        function init_shortcode($atts, $content = null){
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;
            $output = '';
            extract(shortcode_atts(array(
                'style' => '',
                'image' => '',
                'title' => '',
                'sub_title' => '',
                'link' => '',
                'class' => '',
            ), $atts));

            wp_enqueue_style('fancybox');
            wp_enqueue_script('fancybox');

            $class .= ' '.$style;

            $output .= '<div class="iw-image-box '.esc_attr(trim($class)).'">';
                switch($style){
                    case 'style1' :
                    case 'style2' :
                            $img = wp_get_attachment_image_src($image, 'full');
                            $image_url = count($img) ? $img[0] : '';
                            if(function_exists('inwave_resize')){
                                if($style == 'style1'){
                                    $smal_image_url = inwave_resize($image_url, 270, 300, true);
                                }
                                else
                                {
                                    $smal_image_url = inwave_resize($image_url, 570, 630, true);
                                }
                            }
                            else{
                                $smal_image_url = $image_url;
                            }
                            $output .= '<img src="'.esc_url($smal_image_url).'" alt="image">';
                            $output .= '<div class="overlay-box">';
                            $output .= '<span class="line-1"><span class="line-2"></span></span>';
                            $output .= '<div class="image-box-title">';
                            $output .= '<h4>'.$sub_title.'</h4>';
                            $output .= '<h3>'.$title.'</h3>';
                            $output .= '</div>';
                            $output .= '<div class="btn-box">';
                            if($link){
                                $output .= '<a href="'.$link.'"><i class="fa fa-link"></i></a>';
                            }
                            $output .= '<a href="'.esc_url($image_url).'" class="photo-gallery fancybox" data-fancybox-group="photo-gallery"><i class="fa fa-search"></i></a>';
                            $output .= '</div>';
                            $output .= '</div>';

                    break;
                }
            $output .= '</div>';

            return $output;
        }
    }
}

new Inwave_Image_Box;
