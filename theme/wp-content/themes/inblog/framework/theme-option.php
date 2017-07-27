<?php

add_action('init', 'inwave_of_options');

if (!function_exists('inwave_of_options')) {
    function inwave_of_options()
    {
        global $wp_registered_sidebars;
        $sidebar_options[] = 'None';
         $sidebars = $wp_registered_sidebars;
        if (is_array($sidebars) && !empty($sidebars)) {
            foreach ($sidebars as $sidebar) {
                $sidebar_options[] = $sidebar['name'];
            }
        }

        //get slug menu in admin
        $menuArr = array();
        $menus = get_terms('nav_menu');
        foreach ( $menus as $menu ) {
            $menuArr[$menu->slug] = $menu->name;
        }

        //Access the WordPress Categories via an Array
        $of_categories = array();
        $of_categories_obj = get_categories('hide_empty=0');
        foreach ($of_categories_obj as $of_cat) {
            $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;
        }

        //Access the WordPress Pages via an Array
        $of_pages = array();
        $of_pages_obj = get_pages('sort_column=post_parent,menu_order');
        foreach ($of_pages_obj as $of_page) {
            $of_pages[$of_page->ID] = $of_page->post_name;
        }

        /*-----------------------------------------------------------------------------------*/
        /* TO DO: Add options/functions that use these */
        /*-----------------------------------------------------------------------------------*/
        $google_fonts = inwave_get_googlefonts(false);

        /*-----------------------------------------------------------------------------------*/
        /* The Options Array */
        /*-----------------------------------------------------------------------------------*/

        // Set the Options Array
        global $inwave_of_options;
        $inwave_of_options = array();

        $sideBars = array();
        foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
            $sideBars[$sidebar['id']] = ucwords( $sidebar['name'] );
        }

        // GENERAL SETTING
        $inwave_of_options[] = array("name" => esc_html__("General setting", 'injob'),
            "type" => "heading"
        );
        $inwave_of_options[] = array("name" => esc_html__("Show demo setting panel", 'injob'),
            "desc" => esc_html__("Check this box to active the setting panel. This panel should be shown only in demo mode", 'injob'),
            "id" => "show_setting_panel",
            "std" => 0,
            "type" => "checkbox");
        $inwave_of_options[] = array("name" => esc_html__("Show page heading", 'injob'),
            "desc" => esc_html__("Check this box to show or hide page heading", 'injob'),
            "id" => "show_page_heading",
            "std" => 1,
            "type" => "checkbox");

        $inwave_of_options[] = array("name" => esc_html__("Show Top 4 Recent Posts", 'injob'),
            "desc" => esc_html__("Check this box to show or hide Top 4 Recent Posts", 'injob'),
            "id" => "show_top4_recent_posts",
            "std" => 1,
            "type" => "checkbox");

        $inwave_of_options[] = array("name" => esc_html__("Show breadcrumbs", 'injob'),
            "desc" => esc_html__("Check to display the breadcrumbs in general. Uncheck to hide them.", 'injob'),
            "id" => "breadcrumbs",
            "std" => 1,
            "type" => "checkbox");
        $inwave_of_options[] = array("name" => esc_html__("Show preload", 'injob'),
            "desc" => esc_html__("Check to display the preload page.", 'injob'),
            "id" => "show_preload",
            "std" => 0,
            "type" => "checkbox");
        $inwave_of_options[] = array("name" => esc_html__("Retina support:", 'injob'),
            "desc" => esc_html__("Each time an image is uploaded, a higher quality version is created and stored with @2x added to the filename in the media upload folder. These @2x images will be loaded with high-resolution screens.", 'injob'),
            "id" => "retina_support",
            "std" => 0,
            "type" => "checkbox");
        
        $inwave_of_options[] = array("name" => esc_html__("Google API", 'injob'),
            "desc" => wp_kses(__('Use for process data from google service. Eg: map, photo, video... To get Google api, you can access via <a href="https://console.developers.google.com/" target="_blank">here</a>.', 'injob'), inwave_allow_tags('a')),
            "id" => "google_api",
            "std" => '',
            "type" => "text");

        $inwave_of_options[] = array(
			"name" => esc_html__("Layout", 'injob'),
            "desc" => esc_html__("Select boxed or wide layout.", 'injob'),
            "id" => "body_layout",
            "std" => "wide",
            "type" => "select",
            "options" => array(
                'boxed' => 'Boxed',
                'wide' => 'Wide',
            ));

        $inwave_of_options[] = array(
			"name" => esc_html__("Sidebar Position", 'injob'),
            "desc" => esc_html__("Select slide bar position", 'injob'),
            "id" => "sidebar_position",
            "std" => "right",
            "type" => "select",
            "options" => array(
                'none' => 'Without Sidebar',
                'right' => 'Right',
                'left' => 'Left',
                'bottom' => 'Bottom'
            ));

        $inwave_of_options[] = array("name" => "Background Image",
            "desc" => esc_html__("Please choose an image or insert an image url to use for the background.", 'injob'),
            "id" => "bg_image",
            "std" => "",
            "mod" => "",
            "type" => "media");

        $inwave_of_options[] = array(
			"name" => esc_html__("Background Image Size", 'injob'),
            "desc" => esc_html__("Select background image size.", 'injob'),
            "id" => "bg_size",
            "std" => 'cover',
            "type" => "select",
            "options" => array('auto' => esc_html__('auto', 'injob'), 'cover' => esc_html__('cover', 'injob'), 'contain' => esc_html__('contain', 'injob')));

        $inwave_of_options[] = array(
			"name" => esc_html__("Background Repeat", 'injob'),
            "desc" => esc_html__("Choose how the background image repeats.", 'injob'),
            "id" => "bg_repeat",
            "std" => "",
            "type" => "select",
            "options" => array('repeat' => esc_html__('repeat', 'injob'), 'repeat-x' => esc_html__('repeat-x', 'injob'), 'repeat-y' => esc_html__('repeat-y', 'injob'), 'no-repeat' => esc_html__('no-repeat', 'injob')));

        $inwave_of_options[] = array("name" => esc_html__("Develop mode", 'injob'),
            "desc" => esc_html__("Check this box to active develop mode. This option should be used only while developing this theme", 'injob'),
            "id" => "develop_mode",
            "std" => 0,
            "type" => "checkbox");

        //TYPO
        $inwave_of_options[] = array(
			"name" => esc_html__("Typography", 'injob'),
            "type" => "heading"
        );
        $inwave_of_options[] = array( "name" => esc_html__("Body Font Family", 'injob'),
            "desc" => esc_html__("Select a font family for body text", 'injob'),
            "id" => "f_body",
            "std" => "Hind",
            "type" => "select",
            "options" => $google_fonts);
        $inwave_of_options[] = array( "name" => esc_html__("Body Font Settings", 'injob'),
            "desc" => esc_html__("Adjust the settings below to load different character sets and types for fonts. More character sets and types equals to slower page load.", 'injob'),
            "id" => "f_body_settings",
            "std" => "300,400,500,600,700,800,900",
            "type" => "text");
        $inwave_of_options[] = array( "name" => esc_html__("Headings Font", 'injob'),
            "desc" => esc_html__("Select a font family for headings", 'injob'),
            "id" => "f_headings",
            "std" => "Poppins",
            "type" => "select",
            "options" => $google_fonts);
        $inwave_of_options[] = array( "name" => esc_html__("Headings Font Settings", 'injob'),
            "desc" => esc_html__("Adjust the settings below to load different character sets and types for fonts. More character sets and types equals to slower page load.", 'injob'),
            "id" => "f_headings_settings",
            "std" => "300,400,500,600,700",
            "type" => "text");
        $inwave_of_options[] = array( "name" => esc_html__("Menu Font", 'injob'),
            "desc" => esc_html__("Select a font family for navigation", 'injob'),
            "id" => "f_nav",
            "std" => "",
            "type" => "select",
            "options" => $google_fonts);
        $inwave_of_options[] = array( "name" => esc_html__("Menu Font Settings", 'injob'),
            "desc" => esc_html__("Adjust the settings below to load different character sets and types for fonts. More character sets and types equals to slower page load.", 'injob'),
            "id" => "f_nav_settings",
            "std" => "",
            "type" => "text");
        $inwave_of_options[] = array( "name" => esc_html__("Default Font Size", 'injob'),
            "desc" => esc_html__("Default is 15px", 'injob'),
            "id" => "f_size",
            "std" => "15px",
            "type" => "text"
        );
        $inwave_of_options[] = array( "name" => esc_html__("Default Font Line Height", 'injob'),
            "desc" => esc_html__("Default is 28px", 'injob'),
            "id" => "f_lineheight",
            "std" => "28px",
            "type" => "text",
        );

        // COLOR PRESETS
        $inwave_of_options[] = array("name" => esc_html__("Color presets", 'injob'),
            "type" => "heading"
        );

        $inwave_of_options[] = array("name" => esc_html__("Primary Color", 'injob'),
            "desc" => esc_html__("Controls several items, ex: link hovers, highlights, and more.", 'injob'),
            "id" => "primary_color",
            "std" => "#2980b9",
            "type" => "color");
        $inwave_of_options[] = array("name" => esc_html__("Background Color", 'injob'),
            "desc" => esc_html__("Select a background color.", 'injob'),
            "id" => "bg_color",
            "std" => "",
            "type" => "color");
        $inwave_of_options[] = array("name" => esc_html__("Content Background Color", 'injob'),
            "desc" => esc_html__("Controls the background color of the main content area.", 'injob'),
            "id" => "content_bg_color",
            "std" => "",
            "type" => "color");
        $inwave_of_options[] = array("name" => esc_html__("Body Text Color", 'injob'),
            "desc" => esc_html__("Controls the text color of body font.", 'injob'),
            "id" => "body_text_color",
            "std" => "#777777",
            "type" => "color");
        $inwave_of_options[] = array("name" => esc_html__("Link Color", 'injob'),
            "desc" => esc_html__("Controls the color of all text links as well as the '>' in certain areas.", 'injob'),
            "id" => "link_color",
            "std" => "",
            "type" => "color");
        $inwave_of_options[] = array("name" => esc_html__("Blockquote Color", 'injob'),
            "desc" => esc_html__("Controls the color of blockquote.", 'injob'),
            "id" => "blockquote_color",
            "std" => "",
            "type" => "color");
        $inwave_of_options[] = array(
			"name" => esc_html__("Color Scheme", 'injob'),
            "desc" => "",
            "id" => "color_pagetitle_breadcrumb",
            "std" => "<h3>".esc_html__('Page Title & Breadcrumb Color', 'injob')."</h3>",
            "icon" => true,
            "position" => "start",
            "type" => "accordion");
        $inwave_of_options[] = array("name" => esc_html__("Page Title Color", 'injob'),
            "desc" => esc_html__("Controls the text color of the page title.", 'injob'),
            "id" => "page_title_color",
            "std" => "",
            "type" => "color");
        $inwave_of_options[] = array("name" => esc_html__("Page Title Background Color", 'injob'),
            "desc" => esc_html__("Controls background color of the page title.", 'injob'),
            "id" => "page_title_bg_color",
            "std" => "",
            "type" => "color");
        $inwave_of_options[] = array("name" => esc_html__("Breadcrumbs Background Color", 'injob'),
            "desc" => esc_html__("Controls the background color of the breadcrumb.", 'injob'),
            "id" => "breadcrumbs_bg_color",
            "std" => "",
            "type" => "color");
        $inwave_of_options[] = array("name" => esc_html__("Breadcrumbs Border Color", 'injob'),
            "desc" => esc_html__("Controls the Border color of the breadcrumb.", 'injob'),
            "id" => "breadcrumbs_bd_color",
            "std" => "",
            "type" => "color");
        $inwave_of_options[] = array("name" => esc_html__("Breadcrumbs Text Color", 'injob'),
            "desc" => esc_html__("Controls the text color of the breadcrumb font.", 'injob'),
            "id" => "breadcrumbs_text_color",
            "std" => "",
            "type" => "color");
        $inwave_of_options[] = array("name" => esc_html__("Breadcrumbs Link Color", 'injob'),
            "desc" => esc_html__("Controls the link color of the breadcrumb font.", 'injob'),
            "id" => "breadcrumbs_link_color",
            "std" => "",
            "type" => "color");
        $inwave_of_options[] = array(
            "position" => "end",
            "type" => "accordion");
        $inwave_of_options[] = array("name" => esc_html__("Color Scheme", 'injob'),
            "desc" => "",
            "id" => "color_scheme_header",
            "std" => "<h3>".esc_html__('Header Color', 'injob')."</h3>",
            "icon" => true,
            "position" => "start",
            "type" => "accordion");
        $inwave_of_options[] = array("name" => esc_html__("Top bar Color", 'injob'),
            "desc" => esc_html__("Select a color for the top bar text.", 'injob'),
            "id" => "top_bar_color",
            "std" => "",
            "type" => "color");
        $inwave_of_options[] = array("name" => esc_html__("Menu Link Color", 'injob'),
            "desc" => esc_html__("Select a color for the header link.", 'injob'),
            "id" => "header_link_color",
            "std" => "",
            "type" => "color");
        $inwave_of_options[] = array("name" => esc_html__("Sub Menu Link Color", 'injob'),
            "desc" => esc_html__("Select a color for the header sub link.", 'injob'),
            "id" => "header_sub_link_color",
            "std" => "",
            "type" => "color");
        $inwave_of_options[] = array("name" => esc_html__("Menu Border Color", 'injob'),
            "desc" => esc_html__("Select a color for the header border.", 'injob'),
            "id" => "header_bd_color",
            "std" => "",
            "type" => "color");

        $inwave_of_options[] = array(
            "position" => "end",
            "type" => "accordion");
        $inwave_of_options[] = array("name" => esc_html__("Color Scheme", 'injob'),
            "desc" => "",
            "id" => "color_scheme_font",
            "std" => "<h3>".esc_html__('Footer Color', 'injob')."</h3>",
            "icon" => true,
            "position" => "start",
            "type" => "accordion");

        $inwave_of_options[] = array("name" => esc_html__("Footer Background Color", 'injob'),
            "desc" => esc_html__("Select a color for the footer background.", 'injob'),
            "id" => "footer_bg_color",
            "std" => "",
            "type" => "color");

        $inwave_of_options[] = array("name" => esc_html__("Footer Border Color", 'injob'),
            "desc" => esc_html__("Select a color for the footer border.", 'injob'),
            "id" => "footer_border_color",
            "std" => "",
            "type" => "color");


        $inwave_of_options[] = array("name" => esc_html__("Footer Headings Color", 'injob'),
            "desc" => esc_html__("Controls the text color of the footer heading font.", 'injob'),
            "id" => "footer_headings_color",
            "std" => "",
            "type" => "color");

        $inwave_of_options[] = array("name" => esc_html__("Footer Font Color", 'injob'),
            "desc" => esc_html__("Controls the text color of the footer font.", 'injob'),
            "id" => "footer_text_color",
            "std" => "#989898",
            "type" => "color");

        $inwave_of_options[] = array("name" => esc_html__("Footer Link Color", 'injob'),
            "desc" => esc_html__("Controls the text color of the footer link font.", 'injob'),
            "id" => "footer_link_color",
            "std" => "#989898",
            "type" => "color");

        $inwave_of_options[] = array(
            "position" => "end",
            "type" => "accordion");
        $inwave_of_options[] = array("name" => esc_html__("Color Scheme", 'injob'),
            "desc" => "",
            "id" => "color_copyright",
            "std" => "<h3>".esc_html__('Copyright Color', 'injob')."</h3>",
            "icon" => true,
            "position" => "start",
            "type" => "accordion");
        $inwave_of_options[] = array("name" => esc_html__("Copyright Background Color", 'injob'),
            "desc" => esc_html__("Controls the background color of the copyright section.", 'injob'),
            "id" => "copyright_bg_color",
            "std" => "",
            "type" => "color");
        $inwave_of_options[] = array("name" => esc_html__("Copyright Text Color", 'injob'),
            "desc" => esc_html__("Controls the text color of the breadcrumb font.", 'injob'),
            "id" => "copyright_text_color",
            "std" => "",
            "type" => "color");
        $inwave_of_options[] = array("name" => esc_html__("Copyright Link Color", 'injob'),
            "desc" => esc_html__("Controls the link color of the breadcrumb font.", 'injob'),
            "id" => "copyright_link_color",
            "std" => "",
            "type" => "color");
        $inwave_of_options[] = array(
            "position" => "end",
            "type" => "accordion");

        //HEADER OPTIONS
        $inwave_of_options[] = array("name" => esc_html__("Header Options", 'injob'),
            "type" => "heading"
        );
        $inwave_of_options[] = array("name" => esc_html__("Header Info", 'injob'),
            "desc" => "",
            "id" => "header_info_content_options",
            "std" => "<h3>".esc_html__('Header Content Options', 'injob')."</h3>",
            "type" => "info");

        $inwave_of_options[] = array("name" => esc_html__("Select a Header Layout", 'injob'),
            "desc" => "",
            "id" => "header_layout",
            "std" => "default",
            "type" => "images",
            "options" => array(
                "default" => get_template_directory_uri() . "/assets/images/header/header-default.jpg",
            ));
        $inwave_of_options[] = array("name" => esc_html__("Sticky Header", 'injob'),
            "desc" => esc_html__("Check to enable a fixed header when scrolling, uncheck to disable.", 'injob'),
            "id" => "header_sticky",
            "std" => '1',
            "type" => "checkbox");        

        $inwave_of_options[] = array(
			"name" => esc_html__("Logo", 'injob'),
            "desc" => esc_html__("Please choose an image file for your logo.", 'injob'),
            "id" => "logo",
            "std" => get_template_directory_uri() . "/assets/images/logo.png",
            "mod" => "",
            "type" => "media");

        $inwave_of_options[] = array(
            "name" => esc_html__("Logo Sticky", 'injob'),
            "desc" => esc_html__("Please choose an image file for your logo sticky.", 'injob'),
            "id" => "logo_sticky",
            "std" => get_template_directory_uri() . "/assets/images/logo.png",
            "mod" => "",
            "type" => "media");

        $inwave_of_options[] = array(
            "name" => esc_html__("Background Header", 'injob'),
            "desc" => esc_html__("Please choose an image file for your background header.", 'injob'),
            "id" => "bg_header",
            "std" => "",
            "mod" => "",
            "type" => "media");

        $inwave_of_options[] = array(
            "name" => esc_html__("Background Header Sticky", 'injob'),
            "desc" => esc_html__("Please choose an image file for your background header sticky.", 'injob'),
            "id" => "bg_header_sticky",
            "std" => get_template_directory_uri() . "/assets/images/bg-header-sticky.png",
            "mod" => "",
            "type" => "media");

        $inwave_of_options[] = array("name" => esc_html__("Show Buy Service button", 'injob'),
            "desc" => esc_html__("Show or hidden Buy Service button in Header.", 'injob'),
            "id" => "show_buy_service",
            "std" => '1',
            "type" => "checkbox");

        $inwave_of_options[] = array(
            "name" => esc_html__("Buy Service button link", 'injob'),
            "desc" => esc_html__("Buy Service button link to show in header using", 'injob'),
            "id"   => "buy_service_link",
            "std"  => "#",
            "type" => "text"
        );

        $inwave_of_options[] = array(
            "name" => esc_html__("Buy Service button text", 'injob'),
            "desc" => esc_html__("Buy Service button text to show in header. Only header layout 2nd", 'injob'),
            "id"   => "buy_service_text",
            "std"  => esc_html__("Buy Service", 'injob'),
            "type" => "text"
        );

        $inwave_of_options[] = array("name" => esc_html__("Show post a job button", 'injob'),
            "desc" => esc_html__("Show or hidden post a job button in Header.", 'injob'),
            "id" => "show_post_a_job",
            "std" => '1',
            "type" => "checkbox");

        $inwave_of_options[] = array(
            "name" => esc_html__("Post a job button link", 'injob'),
            "desc" => esc_html__("Post a job button link to show in header using", 'injob'),
            "id"   => "post_a_job_link",
            "std"  => "#",
            "type" => "text"
        );

        $inwave_of_options[] = array(
            "name" => esc_html__("Post a job button text", 'injob'),
            "desc" => esc_html__("Post a job button text to show in header. Only header layout 2nd", 'injob'),
            "id"   => "post_a_job_text",
            "std"  => esc_html__("Post a job", 'injob'),
            "type" => "text"
        );

        $inwave_of_options[] = array("name" => esc_html__("Header contact", 'injob'),
            "desc" => esc_html__("Enter information contact for default header and header v2.", 'injob'),
            "id" => "header-contact",
            "std" => wp_kses_post(__('<span class="item"><i class="iwj-icon icon-mobile"></i><span class="title">Phone:</span>+123 -777- 456 - 789</span><span class="item"><i class="iwj-icon icon-email"></i><span class="title">Email:</span>Company@gmail.com</span>', 'injob')),
            "mod" => "",
            "type" => "textarea");

        $inwave_of_options[] = array("name" => esc_html__("Show search form button", 'injob'),
            "desc" => esc_html__("Show or hidden search form button in Header.", 'injob'),
            "id" => "show_search_form",
            "std" => '1',
            "type" => "checkbox");

        $inwave_of_options[] = array("name" => esc_html__("Header Info", 'injob'),
            "desc" => "",
            "id" => "header_info_page_title_options",
            "std" => "<h3>".esc_html__("Page Heading Options", 'injob')."</h3>",
            "type" => "info");

        $inwave_of_options[] = array("name" => esc_html__("Page Heading Padding Top", 'injob'),
            "desc" => esc_html__("In pixels, ex: 10px", 'injob'),
            "id" => "page_heading_padding_top",
            "std" => "210px",
            "type" => "text");

        $inwave_of_options[] = array("name" => esc_html__("Page Heading Padding Bottom", 'injob'),
            "desc" => esc_html__("In pixels, ex: 10px", 'injob'),
            "id" => "page_heading_padding_bottom",
            "std" => "50px",
            "type" => "text");

        $inwave_of_options[] = array("name" => esc_html__("Page Heading Background", 'injob'),
            "desc" => esc_html__("Please choose an image or insert an image url to use for the page title background.", 'injob'),
            "id" => "page_title_bg",
            "std" => get_template_directory_uri() . "/assets/images/bg-page-heading.jpg",
            "mod" => "",
            "type" => "media");

        $inwave_of_options[] = array(
			"name" => esc_html__("Background Image Size", 'injob'),
            "desc" => esc_html__("Select Page Title background image size.", 'injob'),
            "id" => "page_title_bg_size",
            "std" => 'cover',
            "type" => "select",
            "options" => array(
				'auto' => esc_html__('auto', 'injob'),
				'cover' => esc_html__('cover', 'injob'),
				'contain' => esc_html__('contain', 'injob')
			)
		);

        $inwave_of_options[] = array("name" => esc_html__("Background Repeat", 'injob'),
            "desc" => esc_html__("Choose how the background image repeats.", 'injob'),
            "id" => "page_title_bg_repeat",
            "std" => "",
            "type" => "select",
            "options" => array('repeat' => esc_html__('repeat', 'injob'), 'repeat-x' => esc_html__('repeat-x', 'injob'), 'repeat-y' => esc_html__('repeat-y', 'injob'), 'no-repeat' => esc_html__('no-repeat', 'injob')));

        // FOOTER OPTIONS
        $inwave_of_options[] = array("name" => esc_html__("Footer options", 'injob'),
            "type" => "heading"
        );
        $inwave_of_options[] = array("name" => esc_html__("Footer style", 'injob'),
            "desc" => "",
            "id" => "footer_option",
            "std" => "default",
            "type" => "images",
            "options" => array(
            "default" => get_template_directory_uri() . "/assets/images/footer/footer-default.jpg",
            ));
        $inwave_of_options[] = array("name" => esc_html__("Footer Default columns", 'injob'),
            "id" => "footer_number_widget",
            "std" => "4",
            "type" => "select",
            "options" => array(
                '4' => '4',
                '3' => '3',
                '2' => '2',
                '1' => '1',
            ));

        $inwave_of_options[] = array("name" => esc_html__("Footer copyright", 'injob'),
            "desc" => esc_html__("Please enter text copyright for footer.", 'injob'),
            "id" => "footer-copyright",
            "std" => wp_kses_post(__("Copyright 2017 © <a href='#'> Medic Center</a>.  All rights reserved. All right reserved. Designed by <a href='#'> WordPress themes - InwaveThemes.</a>", 'injob')),
            "mod" => "",
            "type" => "textarea");

        //CUSTOM SIDEBAR
        $inwave_of_options[] = array("name" => esc_html__("Custom Sidebar", 'injob'),
            "type" => "heading"
        );
        $inwave_of_options[] = array("name" => esc_html__("Custom Sidebar", 'injob'),
            "desc" => esc_html__("Custom sidebar", 'injob'),
            "id" => "custom_sidebar",
            "type" => "addoption",
            'option_label' => esc_html__('Sidebar', 'injob'),
            'add_btn_text' => esc_html__('Add New Sidebar', 'injob')
        );

        // Job OPTIONS
        $inwave_of_options[] = array("name" => esc_html__("Job options", 'injob'),
            "type" => "heading"
        );
        $inwave_of_options[] = array(
            "name" => esc_html__("Sidebar Job Number", 'injob'),
            "id" => "sidebar_job_number",
            "std" => "2",
            "type" => "select",
            "options" => array(
                '1' => '1',
                '2' => '2',
            ));
        $inwave_of_options[] = array(
            "name" => esc_html__("Sidebar Job 1", 'injob'),
            "desc" => esc_html__("Select sidebar job 1", 'injob'),
            "id" => "sidebar_job_1",
            "type" => "select",
            'options' => $sideBars
            );
        $inwave_of_options[] = array(
            'name'    => esc_html__( 'Sidebar Job 2', 'injob' ),
            "desc" => esc_html__("Select sidebar job 2", 'injob'),
            'id'      => 'sidebar_job_2',
            'type'    => 'select',
            'options' => $sideBars,
            );
        $inwave_of_options[] = array(
            "name" => esc_html__("Sidebar Job Position", 'injob'),
            "desc" => esc_html__("Select sidebar job position", 'injob'),
            "id" => "sidebar_job_position",
            "std" => "right",
            "type" => "select",
            "options" => array(
                'none' => 'Without Sidebar',
                'right' => 'Right',
                'left' => 'Left',
            ));
        $inwave_of_options[] = array( "name" => esc_html__("Limit item related job", 'injob'),
            "desc" => esc_html__("Accepts -1 (all) or any positive number.", 'injob'),
            "id" => "limit_item_related",
            "std" => "3",
            "type" => "text"
        );
        $inwave_of_options[] = array("name" => esc_html__("Show Form Find Jobs", 'injob'),
            "desc" => esc_html__("Show form find jobs on jobs page.", 'injob'),
            "id" => "show_find_jobs",
            "std" => 1,
            "type" => "checkbox"
        );
        $inwave_of_options[] = array("name" => esc_html__("Find Jobs Style", 'injob'),
            "desc" => esc_html__("Form find jobs style.", 'injob'),
            "id" => "find_jobs_style",
            "std" => 'style2',
            "type" => "select",
            "options" => array(
                'style1' => esc_html__('Style1', 'injob'),
                'style2' => esc_html__('Style2', 'injob'),
            ));
        $inwave_of_options[] = array("name" => esc_html__("Limit Keyword Form Find Jobs", 'injob'),
            "desc" => esc_html__("Accepts 0 (all) or any positive number.", 'injob'),
            "id" => "limit_keyword_job",
            "std" => "10",
            "type" => "text"
            );

        // SHOP OPTIONS
        $inwave_of_options[] = array("name" => esc_html__("Shop options", 'injob'),
            "type" => "heading");

        $inwave_of_options[] = array("name" => esc_html__("Show Woocommerce Cart Icon in Top Navigation", 'injob'),
            "desc" => esc_html__("Check the box to show the Cart icon & Cart widget, uncheck to disable.", 'injob'),
            "id" => "woocommerce_cart_top_nav",
            "std" => 1,
            "type" => "checkbox");
        $inwave_of_options[] = array("name" => esc_html__("Show Quick View Button", 'injob'),
            "desc" => esc_html__("Check the box to show the quick view button on product image.", 'injob'),
            "id" => "woocommerce_quickview",
            "std" => 1,
            "type" => "checkbox");
        $inwave_of_options[] = array("name" => esc_html__("Quick View Effect", 'injob'),
            "desc" => esc_html__("Select effect of the quick view box.", 'injob'),
            "id" => "woocommerce_quickview_effect",
            "std" => 'fadein',
            "type" => "select",
            "options" => array(
                'fadein' => esc_html__('Fadein', 'injob'),
                'slide' => esc_html__('Slide', 'injob'),
                'newspaper' => esc_html__('Newspaper', 'injob'),
                'fall' => esc_html__('Fall', 'injob'),
                'sidefall' => esc_html__('Side Fall', 'injob'),
                'blur' => esc_html__('Blur', 'injob'),
                'flip' => esc_html__('Flip', 'injob'),
                'sign' => esc_html__('Sign', 'injob'),
                'superscaled' => esc_html__('Super Scaled', 'injob'),
                'slit' => esc_html__('Slit', 'injob'),
                'rotate' => esc_html__('Rotate', 'injob'),
                'letmein' => esc_html__('Letmein', 'injob'),
                'makeway' => esc_html__('Makeway', 'injob'),
                'slip' => esc_html__('Slip', 'injob')
            ));
        $inwave_of_options[] = array("name" => esc_html__("Shop column", 'injob'),
            "desc" => esc_html__("Column in shop page.", 'injob'),
            "id" => "woocommerce_shop_column",
            "std" => '3',
            "type" => "select",
            "options" => array(
                '3' => '3',
                '4' => '4',
            ));
			
        // $inwave_of_options[] = array("name" => esc_html__("Product Listing Layout", 'injob'),
            // "desc" => esc_html__("Select the layout for product listing page. Please logout to clean the old session", 'injob'),
            // "id" => "product_listing_layout",
            // "std" => "wide",
            // "type" => "select",
            // "options" => array(
                // 'grid' => 'Grid',
                // 'row' => 'Row'
        // ));
        $inwave_of_options[] = array("name" => esc_html__("Troubleshooting", 'injob'),
            "desc" => wp_kses(__("Woocommerce jquery cookie fix<br> Read more: <a href='http://docs.woothemes.com/document/jquery-cookie-fails-to-load/'>jquery-cookie-fails-to-load</a>", 'injob'), inwave_allow_tags(array('br', 'a'))),
            "id" => "fix_woo_jquerycookie",
            "std" => 0,
            "type" => "checkbox");
        $inwave_of_options[] = array("name" => esc_html__("Blog", 'injob'),
            "type" => "heading"
        );
        $inwave_of_options[] = array("name" => esc_html__("Blog Listing", 'injob'),
            "desc" => "",
            "id" => "blog_single_post",
            "std" => "<h3>".esc_html__("Blog Listing", 'injob')."</h3>",
            "icon" => true,
            "type" => "info");
        $inwave_of_options[] = array("name" => esc_html__("Post Category Title", 'injob'),
            "desc" => esc_html__("Check the box to display the post category title in each post.", 'injob'),
            "id" => "blog_category_title_listing",
            "std" => 1,
            "type" => "checkbox");
		$inwave_of_options[] = array("name" => esc_html__("Show Post Tags", 'injob'),
            "desc" => esc_html__("Check the box to display blog post tags.", 'injob'),
            "id" => "show_post_tag",
            "std" => 0,
            "type" => "checkbox");
		$inwave_of_options[] = array("name" => esc_html__("Show Post Date", 'injob'),
            "desc" => esc_html__("Check the box to display blog post date.", 'injob'),
            "id" => "show_post_date",
            "std" => 1,
            "type" => "checkbox");
		$inwave_of_options[] = array("name" => esc_html__("Show Post Author", 'injob'),
            "desc" => esc_html__("Check the box to display blog post author.", 'injob'),
            "id" => "show_post_author",
            "std" => 1,
            "type" => "checkbox");
        $inwave_of_options[] = array("name" => esc_html__("Show Post Comment", 'injob'),
            "desc" => esc_html__("Check the box to display blog post comment.", 'injob'),
            "id" => "show_post_comment",
            "std" => 1,
            "type" => "checkbox");
        $inwave_of_options[] = array(
			"name" => esc_html__("Social Sharing Box", 'injob'),
            "desc" => esc_html__("Check the box to display the social sharing box in blog listing", 'injob'),
            "id" => "social_sharing_box_category",
            "std" => 0,
            "type" => "checkbox");

        $inwave_of_options[] = array("name" => esc_html__("Blog Single Post", 'injob'),
            "desc" => "",
            "id" => "blog_single_post",
            "std" => "<h3>".esc_html__("Blog Single Post", 'injob')."</h3>",
            "icon" => true,
            "position" => "start",
            "type" => "accordion");

        $inwave_of_options[] = array("name" => esc_html__("Featured Image on Single Post Page", 'injob'),
            "desc" => esc_html__("Check the box to display featured images on single post pages.", 'injob'),
            "id" => "featured_images_single",
            "std" => 1,
            "type" => "checkbox");

        $inwave_of_options[] = array("name" => esc_html__("Post Title", 'injob'),
            "desc" => esc_html__("Check the box to display the post title that goes below the featured images.", 'injob'),
            "id" => "blog_post_title",
            "std" => 1,
            "type" => "checkbox");

        $inwave_of_options[] = array("name" => esc_html__("Post Category Title", 'injob'),
            "desc" => esc_html__("Check the box to display the post category title that goes below the featured images.", 'injob'),
            "id" => "blog_category_title",
            "std" => 1,
            "type" => "checkbox");

        $inwave_of_options[] = array("name" => esc_html__("Show Author Info", 'injob'),
            "desc" => esc_html__("Check the box to display the author info in the post.", 'injob'),
            "id" => "author_info",
            "std" => 1,
            "type" => "checkbox");

        $inwave_of_options[] = array("name" => esc_html__("Related Posts", 'injob'),
            "desc" => esc_html__("Check the box to display related posts.", 'injob'),
            "id" => "related_posts",
            "std" => 1,
            "type" => "checkbox");
        $inwave_of_options[] = array("name" => esc_html__("Social Sharing Box", 'injob'),
            "desc" => esc_html__("Check the box to display the social sharing box.", 'injob'),
            "id" => "social_sharing_box",
            "std" => 1,
            "type" => "checkbox");
        $inwave_of_options[] = array("name" => esc_html__("Entry footer", 'injob'),
            "desc" => esc_html__("Check the box to display the tags and edit link (admin only).", 'injob'),
            "id" => "entry_footer",
            "std" => 1,
            "type" => "checkbox");
        $inwave_of_options[] = array(
            "position" => "end",
            "type" => "accordion");

        //SOCIAL MEDIA
        $inwave_of_options[] = array("name" => esc_html__("Social Media", 'injob'),
            "type" => "heading"
        );
        $inwave_of_options[] = array("name" => esc_html__("Social Sharing", 'injob'),
            "desc" => "",
            "id" => "social_sharing",
            "std" => "<h3>".esc_html__("Social Sharing", 'injob')."</h3>",
            "type" => "info");
        $inwave_of_options[] = array("name" => esc_html__("Facebook", 'injob'),
            "desc" => esc_html__("Check the box to show the facebook sharing icon in blog, woocommerce and portfolio detail page.", 'injob'),
            "id" => "sharing_facebook",
            "std" => 1,
            "type" => "checkbox");

        $inwave_of_options[] = array("name" => esc_html__("Twitter", 'injob'),
            "desc" => esc_html__("Check the box to show the twitter sharing icon in blog, woocommerce and portfolio detail page.", 'injob'),
            "id" => "sharing_twitter",
            "std" => 1,
            "type" => "checkbox");

        $inwave_of_options[] = array("name" => esc_html__("LinkedIn", 'injob'),
            "desc" => esc_html__("Check the box to show the linkedin sharing icon in blog, woocommerce and portfolio detail page.", 'injob'),
            "id" => "sharing_linkedin",
            "std" => 1,
            "type" => "checkbox");

        $inwave_of_options[] = array("name" => esc_html__("Google Plus", 'injob'),
            "desc" => esc_html__("Check the box to show the g+ sharing icon in blog, woocommerce and portfolio detail page.", 'injob'),
            "id" => "sharing_google",
            "std" => 1,
            "type" => "checkbox");

        $inwave_of_options[] = array("name" => esc_html__("Tumblr", 'injob'),
            "desc" => esc_html__("Check the box to show the tumblr sharing icon in blog, woocommerce and portfolio detail page.", 'injob'),
            "id" => "sharing_tumblr",
            "std" => 1,
            "type" => "checkbox");

        $inwave_of_options[] = array("name" => esc_html__("Pinterest", 'injob'),
            "desc" => esc_html__("Check the box to show the pinterest sharing icon in blog, woocommerce and portfolio detail page.", 'injob'),
            "id" => "sharing_pinterest",
            "std" => 1,
            "type" => "checkbox");

        $inwave_of_options[] = array("name" => esc_html__("Email", 'injob'),
            "desc" => esc_html__("Check the box to show the email sharing icon in blog, woocommerce and portfolio detail page.", 'injob'),
            "id" => "sharing_email",
            "std" => 1,
            "type" => "checkbox");

        $inwave_of_options[] = array(
            "name" => esc_html__("Social Link Configs", 'injob'),
            "desc" => "",
            "id" => "social_link_configs",
            "std" => '<h3>'.esc_html__("Social Link Configs", 'injob').'</h3>',
            "type" => "info",
        );
        $inwave_of_options[] = array("name" => esc_html__("Social links", 'injob'),
            "desc" => wp_kses_post(__("Add new social links. Awesome icon You can get at <a target='_blank' href='https://fortawesome.github.io/Font-Awesome/'>here</a>", 'injob')),
            "id" => "social_links",
            "std" => array(
                array(
                    'order' => 0,
                ),
                array(
                    'title' => __('Facebook', 'injob'),
                    'icon' => 'fa-facebook',
                    'link' => 'http://facebook.com'
                ),
                array(
                    'title' => __('Twitter', 'injob'),
                    'icon' => 'fa-twitter',
                    'link' => 'http://twitter.com'
                ),
                array(
                    'title' => __('Google Plush', 'injob'),
                    'icon' => 'fa-google',
                    'link' => 'http://google-plus.com'
                ),
                array(
                    'title' => __('Pinterest', 'injob'),
                    'icon' => 'fa-pinterest ',
                    'link' => 'http://pinterest.com'
                )
            ),
            "type" => "social_link"
        );

        //Twitter
        $inwave_of_options[] = array("name" => esc_html__("Twitter", 'injob'),
            "type" => "heading"
        );
        $inwave_of_options[] = array(
            "type" => "sinfo",
            "std"=> wp_kses(__('Get them creating your Twitter Application <a href="https://dev.twitter.com/apps" target="_blank">here</a>', 'injob'), inwave_allow_tags('a')));

        $inwave_of_options[] = array( "name" => esc_html__("Consumer Key", 'injob'),
            "id" => "tw_consumer_key",
            "std" => "",
            "type" => "text");
        $inwave_of_options[] = array( "name" => esc_html__("Consumer Secret", 'injob'),
            "id" => "tw_consumer_secret",
            "std" => "",
            "type" => "text");
        $inwave_of_options[] = array( "name" => esc_html__("Access Token", 'injob'),
            "id" => "tw_access_token",
            "std" => "",
            "type" => "text");
        $inwave_of_options[] = array( "name" => esc_html__("Access Token Secret", 'injob'),
            "id" => "tw_access_token_secret",
            "std" => "",
            "type" => "text");
        $inwave_of_options[] = array( "name" => esc_html__("Twitter Username", 'injob'),
            "id" => "tw_username",
            "std" => "",
            "type" => "text");

        // IMPORT EXPORT
        $inwave_of_options[] = array("name" => esc_html__("Import Demo", 'injob'),
            "type" => "heading"
        );
        $inwave_of_options[] = array("name" => esc_html__("Import Demo Content", 'injob'),
            "desc" => wp_kses(__("We recommend you to <a href='https://wordpress.org/plugins/wordpress-reset/' target='_blank'>reset data</a>  & clean wp-content/uploads before import to prevent duplicate content!", 'injob'), inwave_allow_tags('a')),
            "id" => "demo_data",
            "std" => admin_url('themes.php?page=optionsframework') . "&import_data_content=true",
            "btntext" => esc_html__('Import Demo Content', 'injob'),
            "type" => "import_button");

        // BACKUP OPTIONS
        $inwave_of_options[] = array("name" => esc_html__("Backup Options", 'injob'),
            "type" => "heading"
        );
        $inwave_of_options[] = array("name" => esc_html__("Backup and Restore Options", 'injob'),
            "id" => "of_backup",
            "std" => "",
            "type" => "backup",
            "desc" => esc_html__('You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.', 'injob'),
        );

        $inwave_of_options[] = array("name" => esc_html__("Transfer Theme Options Data", 'injob'),
            "id" => "of_transfer",
            "std" => "",
            "type" => "transfer",
            "desc" => esc_html__('You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".', 'injob'),
        );

    }//End function: inwave_of_options()
}//End chack if function exists: inwave_of_options()
?>
