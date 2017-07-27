<?php

/*
 * Inwave_Event_Listing for Visual Composer
 */
if (!class_exists('InFunding_Listing')) {

    class InFunding_Listing extends Inwave_Shortcode{

        protected $name = 'infunding_listing';

        function getCampaignCategories() {
            global $wpdb;
            $categories = $wpdb->get_results('SELECT a.name, a.term_id FROM ' . $wpdb->prefix . 'terms AS a INNER JOIN ' . $wpdb->prefix . 'term_taxonomy AS b ON a.term_id = b.term_id WHERE b.taxonomy=\'infunding_category\'');
            $newCategories = array();
            $newCategories[__("All", "inwavethemes")] = '0';
            foreach ($categories as $cat) {
                $newCategories[$cat->name] = $cat->term_id;
            }
            return $newCategories;
        }

        function init_params() {

            return array(
                'name' => __('Crowdfunding Listing', 'inwavethemes'),
                'description' => __('Create a list of events', 'inwavethemes'),
                'base' => $this->name,
                'category' => 'Custom',
                'icon' => 'iw-default',
                'params' => array(
					array(
                        "type" => "dropdown",
                    //	"group" => "layout",
                        "class" => "",
						"admin_label" => true,
                        "heading" => "Style",
                        "param_name" => "style",
                        "value" => array(
                            "Style 1 - Default" => "style1",
                            "Style 2 - Row" => "style2",
							"Style 3 - Listing" => "style3",
                            "Accordion" => "accordion"
                        )
                    ),
					array(
                        'type' => 'textfield',
                        "heading" => __("Title", "inwavethemes"),
                        "value" => "",
                        "param_name" => "title_heading",
						"dependency" => array('element' => 'style', 'value' => 'style3')
                    ),
                    array(
                        "type" => "dropdown",
                        "class" => "",
                        'multiple' => 'true',
                        "heading" => "Campaign Category",
                        "admin_label" => true,
                        "param_name" => "category",
                        "value" => $this->getCampaignCategories()
                    ),
                    array(
                        'type' => 'textfield',
                        "heading" => __("Campaign Ids", "inwavethemes"),
                        "value" => "",
                        "param_name" => "ids",
                        "description" => __('Id of posts you want to get. Separated by commas. IF this value is set, data is result value only', "inwavethemes")
                    ),
                    array(
                        "type" => "dropdown",
                        "class" => "",
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
                        "class" => "",
                        "heading" => "Order Direction",
                        "param_name" => "order_dir",
                        "value" => array(
                            "Descending" => "desc",
                            "Ascending" => "asc"
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Number of campaign per page", "inwavethemes"),
                        "param_name" => "limit",
                        "value" => 12
                    ),
                    array(
                        "type" => "dropdown",
                        "class" => "",
                        "heading" => "Show description",
                        "param_name" => "show_des",
                        "value" => array(
                            "Yes" => "1",
                            "No" => "0"
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "class" => "",
                        "heading" => "Number of description words",
                        "param_name" => "desc_text_limit",
                        "value" => '20'
                    ),
                    array(
                        "type" => "textfield",
                        "group" => "layout",
                        "class" => "",
                        "heading" => "Active item",
                        "param_name" => "active_item",
                        "value" => "1",
                        "dependency" => array("element"=>"style", "value" => "accordion")
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "layout",
                        "class" => "",
                        "heading" => "Show page list",
                        "param_name" => "show_page_list",
                        "value" => array(
                            "Yes" => "1",
                        ),
                        "dependency" => array("element"=>"style", "value" => array("style3"))

                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "layout",
                        "class" => "",
                        "heading" => "Show Time Icon",
                        "param_name" => "show_time_icon",
                        "value" => array(
                            "Yes" => "1",
                            "No" => "0"
                        ),
                        "dependency" => array("element"=>"style", "value" => array("style3"))
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "layout",
                        "class" => "",
                        "heading" => "Show Date",
                        "param_name" => "show_date",
                        "value" => array(
                            "Yes" => "1",
                            "No" => "0"
                        ),
                        "dependency" => array("element"=>"style", "value" => array("style3"))
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "layout",
                        "class" => "",
                        "heading" => "Show Location",
                        "param_name" => "show_location",
                        "value" => array(
                            "Yes" => "1",
                            "No" => "0"
                        ),
                        "dependency" => array("element"=>"style", "value" => array("style3"))
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "layout",
                        "class" => "",
                        "heading" => "Number of column",
                        "param_name" => "number_column",
                        "value" => array(
                            "1" => "1",
                            "2" => "2",
                            "3" => "3",
                            "4" => "4"
                        ),
                        "dependency" => array("element"=>"style", "value" => array("style1","style3"))
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "layout",
                        "class" => "",
                        "heading" => "Show filter bar",
                        "param_name" => "show_filter_bar",
                        "description" => __('Only available on default style', 'inwavethemes'),
                        "value" => array(
                            "Yes" => "1",
                            "No" => "0"
                        ),
                        "dependency" => array("element"=>"style", "value" => array("style3"))
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "layout",
                        "class" => "",
                        "heading" => "Show Icon Action",
                        "param_name" => "show_icon_action",
                        "description" => __('Only available on default style', 'inwavethemes'),
                        "value" => array(
                            "Yes" => "1",
                            "No" => "0"
                        ),
                        "dependency" => array("element"=>"style", "value" => array("style3"))
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "layout",
                        "class" => "",
                        "heading" => "Show Campaign Progress",
                        "param_name" => "show_progress",
                        "description" => '',
                        "value" => array(
                            "Yes" => "1",
                            "No" => "0"
                        ),
                        "dependency" => array("element"=>"style", "value" => array("style3"))
                    ),
                    array(
                        "type" => "textfield",
                        "group" => "layout",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "inwavethemes")
                    )
                )
            );
        }

        // Shortcode handler function for list Icon
        function init_shortcode($atts, $content = null) {
            extract(shortcode_atts(array(
                "category" => "0",
				"title_heading" => "",
                "ids" => '',
                "order_by" => "date",
                "order_dir" => "desc",
                "limit" => 12,
                "show_des" => '1',
                "desc_text_limit" => 20,
                "style" => 'style1',
                "active_item" => 'style1',
                "show_page_list" => '1',
                "show_time_icon" => '1',
                "show_date" => '1',
                "show_location" => '1',
                "number_column" => '3',
                "show_filter_bar" => '1',
                "show_icon_action" => '1',
                "show_progress" => '1',
                "class" => ""
                            ), $atts));

            if($style != 'style3'){
                $show_page_list = 0;
                $show_filter_bar = 0;
            }

            ob_start();
            $class = $class.' '.$style;
            echo do_shortcode('[infunding_list category="'.$category.'" title_heading="'.$title_heading.'" ids="'.$ids.'" order_by="'.$order_by.'" order_dir="'.$order_dir.'" limit="'.$limit.'" show_des="'.$show_des.'" desc_text_limit="'.$desc_text_limit.'" style="'.$style.'" active_item="'.$active_item.'" show_page_list="'.$show_page_list.'" show_time_icon="'.$show_time_icon.'" show_date="'.$show_date.'" show_location="'.$show_location.'" number_column="'.$number_column.'" show_filter_bar="'.$show_filter_bar.'" show_icon_action="'.$show_icon_action.'" class="'.$class.'" show_progress="'.$show_progress.'"]');
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }
    }

}

new InFunding_Listing();