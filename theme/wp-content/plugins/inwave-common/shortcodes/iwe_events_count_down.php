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
 * Description of iwe_count_down
 *
 * @developer duongca
 */
if (!class_exists('Inwave_Event_Count_Down')) {

    class Inwave_Event_Count_Down extends Inwave_Shortcode{

        protected $name = 'iwe_count_down';

        function init_params() {
           return array(
                'name' => __('Event Count Down', 'inwavethemes'),
                'description' => __('Add a event speaker block', 'inwavethemes'),
                'base' => $this->name,
                'category' => 'Custom',
                'icon' => 'iw-default',
                'params' => array(
                    array(
                        "type" => "dropdown",
                        "heading" => "Style",
                        "admin_label"=> true,
                        "param_name" => "style",
                        "value" => array(
                            "Style 1" => "style1",
                        )
                    ),
                    array(
                        "type" => "iwevent_event",
                        "heading" => "Event",
                        "admin_label"=> true,
                        "param_name" => "event",
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Button Text", "inwavethemes"),
                        "param_name" => "button_text",
                        "holder" => "div",
                        "value"=>""
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Button Link", "inwavethemes"),
                        "param_name" => "button_link",
                        "value"=>"#"
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
            $output = $event = $button_text = $button_link = $class = $css = $style = '';
            extract(shortcode_atts(array(
                "event" => "",
                "button_text" => "",
                "button_link" => "",
                "style" => "style1",
                "description" => "",
                "css" => "",
                "class" => ""
            ), $atts));

            if (!class_exists('iwEventUtility')) {
                return __('Please active Inwave Event plugin', 'inwavethemes');
            }
            
            $class .= ' '.$style.' '. vc_shortcode_custom_css_class( $css);

            wp_enqueue_script('jquery-countdown');

            $utility = new iwEventUtility();

            if (!$event) {
                return __('Please select event', 'inwavethemes');
            }
            $eventInfo = $utility->getEventInfo($event);
            $date = time();
            $event_start = wp_kses_post($utility->getLocalDate('Y-m-d', $eventInfo->event_start));
            $event_start_date = wp_kses_post($utility->getLocalDate('l Y/m/d', $eventInfo->event_start));
            $event_start_time = wp_kses_post($utility->getLocalDate('H-i-s', $eventInfo->event_start));
            $event_start_day = strtotime($event_start);
            $event_end = strtotime(wp_kses_post($utility->getLocalDate('Y-m-d', $eventInfo->event_end)));
            $title = get_the_title($event);
            $url = get_permalink($event);
            $status_event = '';
            if($date < $event_start_day) {
                $status_event = __('Upcoming Events', 'inwavethemes');
            }
            elseif($date > $event_end) {
                $status_event = __('Ended Events', 'inwavethemes');
            }
            else {
                $status_event = __('Incoming Events', 'inwavethemes');
            }

            $time_text = '';
            if(!empty($eventInfo->day['times'])){
                    if(!empty($eventInfo->day['times'])){
                        foreach($eventInfo->day['times'] as $t){
                            $time_text = $t['time'];
                            break;
                        }
                    }
            }
            $extract_date = $extract_time = array('', '' ,'');
            if($event_start){
                $extract_date = explode("-", $event_start);
                $extract_time = explode("-", $event_start_time);
            }
            ob_start();


            switch ($style) {
                case 'style1':
                    $output .= '<div class="iwe-countdown' . $class . '">';
                        $output .= '<div class="iw-line"><span class="iw-line-1"><span class="iw-line-2"></span></span></div>';
                        $output .= '<div class="event-info">';
                            $output .= '<div class="status-event theme-bg">' .$status_event. '</div>';
                            $output .= '<div class="event-title"><h3><a href="' .$url. '">' .$title. '</a></h3></div>';
                            $output .= '<div class="time-address">
                                <ul>
                                    <li>
                                        <span class="time"><i class="fa fa-clock-o"></i>' .$event_start_date. '' .($eventInfo->day['times'] ? ', '.esc_html($time_text) : ''). '</span>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-map-marker"></i>' .esc_attr($eventInfo->address). '</a>
                                    </li>'
                                    .($eventInfo->speakers[0]?'<li>
                                        <span><i class="fa fa-user"></i>' .__('BY PASTOR ', 'inwavethemes'). '' .$eventInfo->speakers[0]->getName(). '</span>
                                    </li>':'').
                                '</ul>
                            </div>';
                        $output .= '</div>';
                            $output .= '<div class="shape_content">';
                                $output .= '<div class="iwe-share-icon"><span>' .__('Share On: ', 'inwavethemes'). '</span>' .inwave_social_sharing(get_permalink($event), Inwave_Helper::substrword(get_the_excerpt($event), 10), get_the_title($event), '', true). '</div>';
                                if (!empty($event_start)) {
                                    $output .= '<div class="inwave-countdown" data-countdown="'.esc_attr($extract_date[0].'/'.$extract_date[1].'/'.$extract_date[2].' '.$extract_time[0].':'.$extract_time[1].':'.$extract_time[2]).'">
                                    <div class="date-countdown day-count">
                                        <div class="border">
                                            <span class="day date"></span>
                                            <span class="day-label date-label theme-color">DAYS</span>
                                        </div>
                                    </div>
                                    <div class="date-countdown hour-count">
                                        <div class="border">
                                            <span class="hour date"></span>
                                            <span class="hour-label date-label theme-color">HOURS</span>
                                        </div>
                                    </div>
                                    <div class="date-countdown minute-count">
                                        <div class="border">
                                            <span class="minute date"></span>
                                            <span class="minute-label date-label theme-color">MINS</span>
                                        </div>
                                    </div>
                                    <div class="date-countdown second-count">
                                        <div class="border">
                                            <span class="second date"></span>
                                            <span class="second-label date-label theme-color">SECS</span>
                                        </div>
                                    </div>
                                    '.($button_text ? '<div class="date-countdown iwe-button theme-bg"><a class="theme-bg" href="' .$button_link. '">' .$button_text. '</a></div>' : '').'
                                </div>';
                                }
                        $output .= '</div>';
                        $output .= '<div style="clear: both"></div>';
                    $output .= '</div>';
                    break;
            }
            return $output;
        }
    }
}

new Inwave_Event_Count_Down();
