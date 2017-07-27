<?php

/*
 * @package Inwave Athlete
 * @version 1.0.0
 * @created Mar 30, 2015
 * @author Inwavethemes
 * @email inwavethemes@gmail.com
 * @website http://inwavethemes.com
 * @support Ticket https://inwave.ticksy.com/
 * @copyright Copyright (c) 2015 Inwavethemes. All rights reserved.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

/**
 * Description of athlete_map
 *
 * @Developer duongca
 */
if (!class_exists('Inwave_Map')) {

    class Inwave_Map extends Inwave_Shortcode{

        protected $name = 'inwave_map';

        function register_scripts()
        {
			$inwave_theme_option = Inwave_Helper::getConfig();
            wp_enqueue_script('google-maps', 'https://maps.googleapis.com/maps/api/js?key='.$inwave_theme_option['google_api'], array('jquery'), INWAVE_COMMON_VERSION);
            //wp_enqueue_script('infobox', 'http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/src/infobox.js', array('jquery'), INWAVE_COMMON_VERSION);
            wp_enqueue_script('iw-map', plugins_url() . '/inwave-common/assets/js/iw-map.js', array('jquery'), INWAVE_COMMON_VERSION);
        }

        function init_params() {
            return array(
                'name' => 'Map',
                'description' => __('Display a Google Map', 'inwavethemes'),
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
                            "Style 1" => "style1",
                        )
                    ),
                    array(
                        "type" => "attach_image",
                        "heading" => __("Marker Icon", "inwavethemes"),
                        "param_name" => "marker_icon",
                    ),
                    array(
                        "type" => "attach_image",
                        "heading" => __("Description Image", "inwavethemes"),
                        "param_name" => "desc_image",
                    ),
                    array(
                        'type' => 'textarea_raw_html',
                        "heading" => __("Description", "inwavethemes"),
                        "holder" => "div",
                        "value" => "JTNDZGl2JTIwY2xhc3MlM0QlMjJtYXAtcm93JTIyJTNFJTBBJTIwJTIwJTIwJTNDaDMlM0UlM0NpJTIwY2xhc3MlM0QlMjJmYSUyMGZhLWxvY2F0aW9uJTIyJTNFJTNDJTJGaSUzRUFkZHJlc3MlM0MlMkZoMyUzRSUwQSUyMCUyMCUyMCUzQ3AlM0VOaWFnYXJhJTIwRmFsbHMlMkMlMjBOWSUyMDE0MzA1MzkwOSUyMFdpdG1lciUyMFJvYWQuJTNDJTJGcCUzRSUwQSUzQyUyRmRpdiUzRSUwQSUzQ2RpdiUyMGNsYXNzJTNEJTIybWFwLXJvdyUyMiUzRSUwQSUyMCUyMCUyMCUzQ2gzJTNFJTNDaSUyMGNsYXNzJTNEJTIyZmElMjBmYS1sb2NhdGlvbiUyMiUzRSUzQyUyRmklM0VFTUFJTCUyRkZBWCUzQyUyRmgzJTNFJTBBJTIwJTIwJTIwJTNDcCUzRWxpZ2h0Ym9vayU0MG1haWwuY29tJTIwMTAwJTIwLSUyMDkwMCUyMC0lMjAyMzM5ODglMjAxMDAlMjAtJTIwMjAwJTIwLSUyMDk5ODg4JTNDJTJGcCUzRSUwQSUzQyUyRmRpdiUzRQ==",
                        "param_name" => "description",
                        "description" => __('Description of map block.', "inwavethemes"),
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Description width", "inwavethemes"),
                        "param_name" => "desc_width",
                        "value" => "220",
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Latitude", "inwavethemes"),
                        "admin_label" => true,
                        "param_name" => "latitude",
                        "value" => "40.6700",
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Longitude", "inwavethemes"),
                        "admin_label" => true,
                        "param_name" => "longitude",
                        "value" => "-73.9400",
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Zoom", "inwavethemes"),
                        "param_name" => "zoom",
                        "value" => "11",
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Map height", "inwavethemes"),
                        "param_name" => "height",
                        "value" => "400",
                        "description"=> __("Example: 400(in px) or 100vh", "inwavethemes"),
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("panBy x", "inwavethemes"),
                        "param_name" => "panby_x",
                        "value" => "",
                        "description"=> __("Changes the center of the map by the given distance in pixels.. Example: 50", "inwavethemes"),
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("panBy y", "inwavethemes"),
                        "param_name" => "panby_y",
                        "value" => "",
                        "description"=> __("Changes the center of the map by the given distance in pixels. Example: 50", "inwavethemes"),
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

        // Shortcode handler function for list Icon
        function init_shortcode($atts, $content=null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

            extract(shortcode_atts(array(
                'style' => '',
                'description' => '',
                'desc_image' => '',
                'desc_width' => '',
                'latitude' => '',
                'longitude' => '',
                'marker_icon' => '',
                'height' => '',
                'panby_x' => '',
                'panby_y' => '',
                'zoom' => '11',
                'class' => ''
            ), $atts));
            $desc_image_url = $icon_url = '';
            if($marker_icon){
                $img = wp_get_attachment_image_src($marker_icon, 'large');
                $icon_url = count($img) ? $img[0] : '';
            }
            if($desc_image){
                $img = wp_get_attachment_image_src($desc_image, 'large');
                $desc_image_url = count($img) ? $img[0] : '';
            }

            if($height){
                if(is_numeric($height)){
                    $height = 'style="height:'.esc_attr($height).'px"';
                }
                else
                {
                    $height = 'style="height:'.esc_attr($height).'"';
                }
            }

            $class .= ' '.$style;

            $output = '';
            $output .= '<div class="iw-map ' . trim($class) . '">';
            $attributes = array();
            $attributes[] = 'data-map_style="' . esc_attr($style) . '"';
            $attributes[] = 'data-marker_icon="' . esc_attr($icon_url) . '"';
            $attributes[] = 'data-lat="' . esc_attr($latitude) . '"';
            $attributes[] = 'data-long="' . esc_attr($longitude) . '"';
            $attributes[] = 'data-zoom="' . esc_attr($zoom) . '"';
            $attributes[] = 'data-panby_x="' . esc_attr($panby_x) . '"';
            $attributes[] = 'data-panby_y="' . esc_attr($panby_y) . '"';
            switch($style){
                case 'style1' :

                    $output .= '<div class="container">';
                    $output .= '<div class="map-description-wrap">';
                    $output .= '<div class="map-description" style="width : '.(int)$desc_width.'px">';
                    if($desc_image_url){
                        $output .= '<img src="'.$desc_image_url.'" alt="">';
                    }
                    $output .= rawurldecode( base64_decode( $description ) );
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $attributes = implode( ' ', $attributes );
                    $output .= '<div class="map-contain" '.$attributes.' >';
                    $output .= '<div class="map-view map-frame" '.$height.'></div>';
                    $output .= '</div>';
                    break;
            }

            $output .= '</div>';

            return $output;
        }
    }
}

new Inwave_Map();
