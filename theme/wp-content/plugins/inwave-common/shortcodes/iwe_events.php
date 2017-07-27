<?php

/*
 * Inwave_Event_Listing for Visual Composer
 */
if (!class_exists('Inwave_Events')) {

    class Inwave_Events extends Inwave_Shortcode{

        protected $name = 'iwe_events';

        function getIweCategories() {
            global $wpdb;
            $categories = $wpdb->get_results('SELECT a.name, a.term_id FROM ' . $wpdb->prefix . 'terms AS a INNER JOIN ' . $wpdb->prefix . 'term_taxonomy AS b ON a.term_id = b.term_id WHERE b.taxonomy=\'iwevent_category\'');
            $newCategories = array();
            $newCategories[__("All", "inwavethemes")] = '0';
            foreach ($categories as $cat) {
                $newCategories[$cat->name] = $cat->term_id;
            }
            return $newCategories;
        }
        function getIweLocations() {
            global $wpdb;
            $categories = $wpdb->get_results('SELECT a.name, a.term_id FROM ' . $wpdb->prefix . 'terms AS a INNER JOIN ' . $wpdb->prefix . 'term_taxonomy AS b ON a.term_id = b.term_id WHERE b.taxonomy=\'iwevent_location\'');
            $newCategories = array();
            $newCategories[__("Select a location", "inwavethemes")] = '';
            foreach ($categories as $cat) {
                $newCategories[$cat->name] = $cat->term_id;
            }
            return $newCategories;
        }

        function init_params() {

            return array(
                'name' => __('Events', 'inwavethemes'),
                'description' => __('Create a list of events', 'inwavethemes'),
                'base' => $this->name,
                'category' => 'Custom',
                'icon' => 'iw-default',
                'params' => array(
                    array(
                        "type" => "dropdown",
                        "heading" => "Event Category",
                        "admin_label" => true,
                        "param_name" => "category",
                        "value" => $this->getIweCategories()
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Event Ids", "inwavethemes"),
                        "param_name" => "ids",
                        "value" => ""
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => "Event Location",
                        "param_name" => "location",
                        "value" => $this->getIweLocations()
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => "Order By",
                        "param_name" => "order_by",
                        "value" => array(
                            "Date" => "date",
                            "Title" => "title",
                            "Event ID" => "ID",
                            "Name" => "name",
                            "menu_order" => "Ordering",
                            "Random" => "rand"
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => "Order Direction",
                        "param_name" => "order_dir",
                        "value" => array(
                            "Descending" => "desc",
                            "Ascending" => "asc"
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Number of event per page", "inwavethemes"),
                        "param_name" => "limit",
                        "value" => 12
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => "Show description",
                        "param_name" => "show_des",
                        "value" => array(
                            "Yes" => "1",
                            "No" => "0"
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => "Number of description text",
                        "param_name" => "desc_text_limit",
                        "value" => '20'
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "heading" => "Style",
                        "admin_label" => true,
                        "param_name" => "style",
                        "value" => array(
                            "Events" => "events",
                            "Grid Block" => "grid_block",
                            "List Block" => "list_block",
                            "Accordion" => "accordion",
                        )
                    ),
                    array(
                        'type' => 'textfield',
                        "group" => "Style",
                        "holder" => "span",
                        "heading" => __("Title Event", "inwavethemes"),
                        "description" => "",
                        "value" => "",
                        "param_name" => "title_event",
                        "dependency" => array("element"=>"style", "value" => array("events"))
                    ),
                    array(
                        'type' => 'textfield',
                        "group" => "Style",
                        "holder" => "span",
                        "heading" => __("Sub Title Event", "inwavethemes"),
                        "description" => "",
                        "value" => "",
                        "param_name" => "sub_title_event",
                        "dependency" => array("element"=>"style", "value" => array("events"))
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Color Scheme", 'inwavethemes'),
                        "group" => "Style",
                        "param_name" => "color_scheme",
                        "value" => array(
                            "Dark Text" => "dark",
                            "Light Text"=> "light",
                        ),
                        "dependency" => array("element"=>"style", "value" => "accordion")
                    ),
                    array(
                        "type" => "textfield",
                        "group" => "Style",
                        "class" => "",
                        "heading" => "Active item",
                        "param_name" => "active_item",
                        "value" => "1",
                        "dependency" => array("element"=>"style", "value" => "accordion")
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "heading" => "Show Page List",
                        "param_name" => "show_page_list",
                        "value" => array(
                            "Yes" => "1",
                            "No" => "0"
                        ),
                        "dependency" => array("element"=>"style", "value" => array("events", "list"))
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "heading" => "Show Date",
                        "param_name" => "show_date",
                        "value" => array(
                            "Yes" => "1",
                            "No" => "0"
                        ),
                        "dependency" => array("element"=>"style", "value" => array("events", "list"))
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "heading" => "Show Location",
                        "param_name" => "show_location",
                        "value" => array(
                            "Yes" => "1",
                            "No" => "0"
                        ),
                        "dependency" => array("element"=>"style", "value" => array("events", "list"))
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "heading" => "Show Action Icon",
                        "param_name" => "show_icon_action",
                        "value" => array(
                            "Yes" => "1",
                            "No" => "0"
                        ),
                        "dependency" => array("element"=>"style", "value" => array("events", "list"))
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "heading" => "Number column",
                        "param_name" => "number_column",
                        "value" => array(
                            "1" => "1",
                            "2" => "2",
                            "3" => "3",
                            "4" => "4"
                        ),
                        "dependency" => array("element"=>"style", "value" => array("events", "list", "grid_block"))
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "heading" => "Show filter bar",
                        "param_name" => "show_filter_bar",
                        "value" => array(
                            "No" => "0",
                            "Yes" => "1",
                        ),
                        "dependency" => array("element"=>"style", "value" => array("events", "list"))
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
        function init_shortcode($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;

            extract(shortcode_atts(array(
                "category" => "0",
                "ids" => '',
                "location" => "",
                "order_by" => "date",
                "order_dir" => "desc",
                "limit" => 12,
                "show_des" => '1',
                "desc_text_limit" => 20,
                "style" => 'events',
                "color_scheme" => '',
                "active_item" => '',
                "show_page_list" => '1',
                "show_date" => '1',
                "show_location" => '1',
                "show_icon_action" => '1',
                "number_column" => '3',
                "show_filter_bar" => '0',
                "title_event" => '',
                "sub_title_event" => '',
                "class" => ""
            ), $atts));

            if (!class_exists('iwEventUtility')) {
                return __('Please active Inwave Event plugin', 'inwavethemes');
            }

            $utility = new iwEventUtility();
            if($style != 'list' && $style != 'events'){
                $show_page_list = 0;
                $show_filter_bar = 0;
            }

            $class = $class.' '.$style;

            return do_shortcode('[iwe_list_page category="' . $category . '" ids="'.$ids.'" location="'.$location.'" order_by="' . $order_by . '" order_dir="' . $order_dir . '" limit="' . $limit . '" show_des="' . $show_des . '" desc_text_limit="' . $desc_text_limit . '" style="'.$style.'" color_scheme="'.$color_scheme.'" active_item="'.$active_item.'" show_page_list="' . $show_page_list . '" show_date="' . $show_date . '" show_location="' . $show_location . '" show_icon_action="' . $show_icon_action . '" number_column="' . $number_column . '" show_filter_bar="' . $show_filter_bar . '" title_event="' . $title_event . '" " sub_title_event="' . $sub_title_event . '" class="' . $class . '"]');

        }
    }
}

new Inwave_Events();
