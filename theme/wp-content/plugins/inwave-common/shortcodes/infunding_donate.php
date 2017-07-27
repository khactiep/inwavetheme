<?php
/*
 * Inwave_Event_Listing for Visual Composer
 */
if (!class_exists('Infunding_Donate')) {

    class Infunding_Donate {

        private $params;

        function __construct() {
            $this->initParams();
            add_action('vc_before_init', array($this, 'heading_init'));
            add_shortcode('infunding_donate', array($this, 'infunding_listing_shortcode'));
        }

        function initParams() {
            global $iw_shortcodes;
            $donate_us = get_posts(array('posts_per_page' => -1, 'post_type' => 'infunding'));
            $value = array();
            foreach ($donate_us as $donate) {
                if (isset($value[$donate->post_title])) {
                    $value[$donate->post_title . '(1)'] = $donate->ID;
                } else {
                    $value[$donate->post_title] = $donate->ID;
                }
            }
            $this->params = array(
                'name' => 'Crowdfunding Donate',
                'description' => __('Create a list of events', 'inwavethemes'),
                'base' => 'infunding_donate',
                'category' => 'Custom',
                'icon' => 'iw-default',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Title", "inwavethemes"),
                        "value" => "Donate Us",
                        "param_name" => "title"
                    ),
                    array(
                        'type' => 'textfield',
                        "heading" => __("Sub Title", "inwavethemes"),
                        "value" => "",
                        "param_name" => "sub_title"
                    ),
                    array(
                        "type" => "dropdown",
                        "class" => "",
                        "heading" => "Campaign",
                        "param_name" => "campaign",
                        "value" => $value
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("List Price", "inwavethemes"),
                        "param_name" => "price_list",
                        "value" => '10,20,30,40',
                        "description" => ''
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Payment Method", "inwavethemes"),
                        "param_name" => "payment_method",
                        "value" => array(
                            'Paypal' => 'paypal',
                            'Offline Payment' => 'offline'
                        ),
                        "description" => ''
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Button Text", "inwavethemes"),
                        "param_name" => "button_text",
                        "holder" => "div",
                        "value" => "Paypal"
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "class" => "iw-testimonials-style",
                        "heading" => "Style",
                        "param_name" => "style",
                        "value" => array(
                            "Style 1" => "style1",
                            "Style 2" => "style2",
                            "Style 3" => "style3"
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "class" => "",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "value" => "",
                        "description" => __("Write your own CSS and mention the class name here.", "inwavethemes"),
                    ),
                    array(
                        "type" => "dropdown",
                        "group" => "Style",
                        "class" => "",
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
                        'heading' => __('CSS box', 'js_composer'),
                        'param_name' => 'css',
                        // 'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
                        'group' => __('Design Options', 'js_composer')
                    )
                )
            );
            $iw_shortcodes['infunding_donate'] = $this->params;
        }

        function heading_init() {
            if (function_exists('vc_map')) {
                // Add banner addon
                vc_map($this->params);
            }
        }

        // Shortcode handler function for list Icon
        function infunding_listing_shortcode($atts, $content = null) {
            global $inf_settings;
            $utility = new inFundingUtility();
            $output = $title = $sub_title = $campaign = $price_list = $button_text = $style = $class = $align = $css = '';
            extract(shortcode_atts(array(
                "title" => __('Donate Us', 'inwavethemes'),
                "sub_title" => '',
                "campaign" => "",
                "price_list" => "10,20,30,40",
                "button_text" => "Paypal",
                "payment_method" => "paypal",
                "style" => "style1",
                "align" => "",
                "css" => ""
                            ), $atts));
            $class .= ' ' . $style . ' ' . vc_shortcode_custom_css_class($css);

            if ($align) {
                $class.= ' ' . $align . '-text';
            }
            if (!$campaign) {
                return __('Please select campaign', 'inwavethemes');
            }
            $img = wp_get_attachment_image_src(get_post_thumbnail_id($campaign, 'infunding-large', true));
            $goal = htmlspecialchars(get_post_meta($campaign, 'inf_goal', true));
            $current = htmlspecialchars(get_post_meta($campaign, 'inf_current', true));
            $percent = $current / $goal * 100;
            $amount_list = explode(',', $price_list);
            $p_delay = $percent;
            if ($percent >= 100) {
                $p_delay = 100;
            }

            $payment_page = $inf_settings['general']['inf_payment_page'];
            $link = get_permalink($payment_page) . '?campaign=' . $campaign;
            if (isset($_SESSION['bt_message'])) {
                $output.= $_SESSION['bt_message'];
                unset($_SESSION['bt_message']);
            }
            $output .= '<div class="iw-infunding-donate-us ' . $class . ($style == 'style1' ? ' theme-bg' : '') . '">';
            switch ($style) {
                case 'style1':
                    if ($title) {
                        $output .= '<h3 class="donate-us-title">' . $title . '</h3>';
                    }
                    if ($title) {
                        $output .= '<div class="donate-us-subtitle">' . $sub_title . '</div>';
                    }
                    $output .= '<div class="iw-campaign">';
                    $output .= '<div class="camp-progress-goal"><div class="camp-progress-current" style="width: ' . ($percent > 100 ? 100 : $percent) . '%"></div><div class="camp-funded ' . ($percent > 100 ? 'theme-color' : '') . '" style="left: ' . ($percent > 100 ? 92 : $percent + 1) . '%"> ' . (sprintf(__('%s&percnt;', 'inwavethemes'), $percent)) . '</div></div>';
                    $output .= '<div class="camp-timeremaining-goal"><span class="camp-current" ' . ($percent > 92 ? 'style="right: 0;"' : 'style="left: ' . ($percent - 5) . '%"') . '>$ ' . sprintf(number_format($current, 0, ',', '.')) . '</span><span class="camp-goal" ' . ($percent > 82 ? 'style="position: absolute; top: -42px; right: 0;"' : '') . '>$ ' . sprintf(number_format($goal, 0, ',', '.')) . '</span><div style="clear: both;"></div></div>';
                    $output .= '</div>';
                    $output .= '<div class="donate-us-description">' . sprintf(__('Select a mount or enter the number and click to paypal', 'inwavethemes')) . '</div>';
                    $output .= '<div class="iw-price-list">';
                    foreach ($amount_list as $amount) {
                        $output .= '<div data-price="' . $amount . '" class="price-item theme-color-hover"><span>$ ' . $amount . '</span></div>';
                    }
                    $output .= '<div class="donate-input">';
                    $output .= '<span>$</span>';
                    $output .= '<input type="text" value="100" name="amount"/>';
                    $output .= '</div>';
                    $output .= '<div style="clear: both;"></div>';
                    $output .= '</div>';
                    $output .= '<div class="infunding-paypal"><a data-url="' . $link . '" href="' . $link . '">' . $button_text . '</a></div>';
                    break;

                case 'style2':
                    if ($title) {
                        $output .= '<h3 class="donate-us-title">' . $title . '</h3>';
                    }
                    if ($title) {
                        $output .= '<div class="donate-us-subtitle">' . $sub_title . '</div>';
                    }
                    $output .= '<div class="iw-campaign">';
                    $output .= '<div class="camp-progress-goal"><div class="camp-progress-current theme-bg" style="width: ' . ($percent > 100 ? 100 : $percent) . '%"></div><div class="camp-funded ' . ($percent > 100 ? 'theme-color' : '') . '" style="left: ' . ($percent > 100 ? 92 : $percent + 1) . '%"> ' . (sprintf(__('%s&percnt;', 'inwavethemes'), $percent)) . '</div></div>';
                    $output .= '</div>';
                    $output .= '<div class="donate-us-description">' . sprintf(__('Select a mount or enter the number and click to paypal', 'inwavethemes')) . '</div>';
                    $output .= '<div class="iw-price-list">';
                    foreach ($amount_list as $amount) {
                        $output .= '<div data-price="' . $amount . '" class="price-item theme-color-hover"><span>$ ' . $amount . '</span></div>';
                    }
                    $output .= '<div class="donate-input">';
                    $output .= '<span>$</span>';
                    $output .= '<input type="text" value="100" name="amount"/>';
                    $output .= '</div>';
                    $output .= '<div style="clear: both;"></div>';
                    $output .= '</div>';
                    $output .= '<div class="infunding-paypal"><a class="theme-bg" data-url="' . $link . '" href="' . $link . '">' . $button_text . '</a></div>';
                    break;
//                case 'style3':
//                    $output .= '<div class="block-left col-md-6">';
//                    $output .= '<div class="campaign-image" style="background-image: url(' . $img[0] . '); background-size: cover;"></div>';
//                    $output .= '<div class="iw-campaign-progress">';
//                    $output .= '<div class="campaign-progress">';
//                    $output .= '<div id="campaign-current" style="animation-delay: -' . esc_attr($p_delay) . 's; ' . ($p_delay == 100 ? 'background:#EF9932;' : ($p_delay == 0 ? 'background:#e2e2e2;' : '')) . '" class="circle"></div>';
//                    $output .= '<div id="campaign-progress-percent" class="noselect theme-color">' . esc_attr($percent) . '%</div>';
//                    $output .= '</div>';
//                    $output .= '<div class="camp-timeremaining-goal-current">';
//                    $output .= '<div class="camp-current col-md-6 col-sm-6 col-xs-6"><span class="text">' .__('raised', 'inwavethemes') . '</span><span class="current">$ ' . sprintf(number_format($current, 0, ',', '.')) . '</span></div>';
//                    $output .= '<div class="camp-goal col-md-6 col-sm-6 col-xs-6"><span class="text">' .__('goal', 'inwavethemes') . '</span><span class="goal">$ ' . sprintf(number_format($goal, 0, ',', '.')) . '</span></div>';
//                    $output .= '</div>';
//                    $output .= '</div>';
//                    $output .= '</div>';
//                    $output .= '<div class="block-right col-md-6">';
//                    ob_start();
//                    
                    ?>
                    <!--                    <h3 class="theme-color">Donate Us</h3>
                                        <form action="//<?php echo home_url('infunding-action.php'); ?>" method="post">
                                            <div class="col-md-6">
                                                <input type="text" placeholder="//<?php _e('Your Name', 'inwavethemes'); ?>" name="full_name"/>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" placeholder="//<?php _e('Your Email', 'inwavethemes'); ?>" name="email"/>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" placeholder="//<?php _e('Your Phone', 'inwavethemes'); ?>" name="phone"/>
                                            </div>
                                            <div class="col-md-6">
                                                <select name="amount">
                                                    <option value="">//<?php echo __('Donate Amount', 'inwavethemes'); ?></option>
                                                    //<?php
//                                foreach ($amount_list as $amount) {
//                                    echo '<option value="' . $amount . '">' . $amount . '</option>';
//                                }
//                                
                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-12">
                                                <textarea placeholder="//<?php _e('Your Message', 'inwavethemes'); ?>" name="message"></textarea>
                                                <input type="hidden" value="//<?php echo $payment_method; ?>" name="payment_method"/>
                                                <input type="hidden" value="1" name="quantity"/>
                                                <input type="hidden" value="//<?php echo $campaign; ?>" name="campaign"/>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="hidden" value="infPaymentProcess" name="action"/>
                                                <input type="submit" class="btn-donate theme-bg" value="//<?php echo $button_text; ?>"/>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="reset" class="btn-cancel theme-bg-hover" value="//<?php echo __('Cancel', 'inwavethemes'); ?>"/>
                                            </div>
                                        </form>-->
                    //<?php
//                    $html = ob_get_contents();
//                    ob_end_clean();
//                    $output.=$html;
//                    $output .= '</div>';
//                    break;
                case 'style3':
                    $output .= '<div class="block-left col-md-6 col-xs-12 col-sm-12">';
                    $output .= '<div class="campaign-image" style="background-image: url(' . $img[0] . '); background-size: cover;"></div>';
                    $output .= '<div class="iw-campaign-progress">';
                    $output .= '<div class="campaign-progress">';
                    $output .= '<div class="rd_pie_01 rd_pie_chart">';
                    $output .= '<div class="rd_count_to rd_pc_status">';
                    $output .= '<span class="count_number" data-from="0" data-to="' . $percent . '" data-speed="1000" data-refresh-interval="25">0</span><span>%</span>';
                    $output .= '</div>';
                    $output .= '<div class="rd_pc_track"></div>';
                    $output .= '<div class="rd_pc_track_in"></div>';
                    $output .= '<canvas class="rd_pc_01" width="520" height="400" data-percentage-value="' . ($percent > 100 ? 100 : $percent) . '" data-bar-color="#ffffff" data-bar-alt-color="#ffffff" >Your browser does not support the HTML5 canvas tag.</canvas>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '<div class="camp-timeremaining-goal-current">';
                    $output .= '<div class="row">';
                    $output .= '<div class="camp-current col-md-6 col-sm-6 col-xs-6"><span class="text">' . __('raised', 'inwavethemes') . '</span><span class="current">$ ' . sprintf(number_format($current, 0, ',', '.')) . '</span></div>';
                    $output .= '<div class="camp-goal col-md-6 col-sm-6 col-xs-6"><span class="text">' . __('goal', 'inwavethemes') . '</span><span class="goal">$ ' . sprintf(number_format($goal, 0, ',', '.')) . '</span></div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '<div class="block-right col-md-6 col-xs-12 col-sm-12">';
                    ob_start();
                    ?>
                    <h3 class="theme-color">Donate Us</h3>
                    <form action="<?php echo home_url('infunding-action.php'); ?>" method="post">
                        <div class="col-md-6 col-xs-12 col-sm-12">
                            <input type="text" required="required" placeholder="<?php _e('Your Name*', 'inwavethemes'); ?>" name="full_name"/>
                        </div>
                        <div class="col-md-6 col-xs-12 col-sm-12">
                            <input type="email"  required="required" placeholder="<?php _e('Your Email*', 'inwavethemes'); ?>" name="email"/>
                        </div>
                        <div class="col-md-6 col-xs-12 col-sm-12">
                            <input type="text" required="required" placeholder="<?php _e('Your Phone*', 'inwavethemes'); ?>" name="phone"/>
                        </div>
                        <div class="col-md-6 col-xs-12 col-sm-12">
                            <select name="amount" required="required">
                                <option value=""><?php echo __('Donate Amount*', 'inwavethemes'); ?></option>
                                <?php
                                foreach ($amount_list as $amount) {
                                    echo '<option value="' . $amount . '">' . $amount . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12 col-xs-12 col-sm-12 iw-textarea">
                            <textarea placeholder="<?php _e('Your Message', 'inwavethemes'); ?>" name="message"></textarea>
                            <input type="hidden" value="<?php echo $payment_method; ?>" name="payment_method"/>
                            <input type="hidden" value="1" name="quantity"/>
                            <input type="hidden" value="<?php echo $campaign; ?>" name="campaign"/>
                        </div>
                        <div class="col-md-6 col-xs-12 col-sm-12 donate-btn iw-button-effect">
                            <div class="donate-btn-effect">
                                <input type="hidden" value="infPaymentProcess" name="action"/>
                                <button type="submit" class="btn-donate theme-bg"><span data-hover="<?php echo $button_text; ?>" class="effect"><?php echo $button_text; ?></span></button>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12 col-sm-12">
                            <input type="reset" class="btn-cancel theme-bg-hover" value="<?php echo __('Cancel', 'inwavethemes'); ?>"/>
                        </div>
                    </form>
                    <?php
                    $html = ob_get_contents();
                    ob_end_clean();
                    $output.=$html;
                    $output .= '</div>';
                    break;

                default:
                    break;
            }
            $output .= '</div>';
            return $output;
        }

    }

}

new Infunding_Donate();
if (class_exists('WPBakeryShortCode')) {

    class WPBakeryShortCode_Infunding_Donate extends WPBakeryShortCode {
        
    }

}

