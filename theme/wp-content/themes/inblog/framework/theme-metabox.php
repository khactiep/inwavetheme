<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category ARIVA
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/webdevstudios/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'inwave_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function inwave_metaboxes( array $meta_boxes ) {

    // Start with an underscore to hide fields from custom fields list
    $prefix = 'inwave_';

    $sideBars = array();
    foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
        $sideBars[$sidebar['id']] = ucwords( $sidebar['name'] );
    }

    $menuArr = array();
    $menuArr[''] = 'Default';
    $menus = get_terms('nav_menu');
    foreach ( $menus as $menu ) {
        $menuArr[$menu->slug] = $menu->name;
    }

    /**
     * Metabox to be displayed on a single page ID
     */

    $meta_boxes['page_metas'] = array(
        'id'         => 'page_metas',
        'title'      => esc_html__( 'Page Options', 'injob' ),
        'pages'      => array( 'page', 'post' ), // Post type
        'context'    => 'side',
        'priority'   => 'low',
        'show_names' => true, // Show field names on the left
        'fields'     => array(
            array(
                'name'    => esc_html__('Main Color', 'injob'),
                'id'      => $prefix . 'main_color',
                'type'    => 'colorpicker',
                'default' => '',
            ),
            array(
                'name'    => esc_html__('Background Color Page', 'injob'),
                'id'      => $prefix . 'background_color_page',
                'type'    => 'colorpicker',
                'default' => '',
            ),
            array(
                'name'    => esc_html__('Select Revolution  Slider', 'injob'),
                'id'      => $prefix . 'slider',
                'type'    => 'select',
                'options' => Inwave_Helper::getRevoSlider(),
                'default' => '',
            ),
            array(
                'name'    => esc_html__( 'Show preload', 'injob' ),
                'id'      => $prefix . 'show_preload',
                'type'    => 'select',
                'options' => array(
                    '' => esc_html__( 'Default', 'injob' ),
                    'yes'   => esc_html__( 'Yes', 'injob' ),
                    'no'     => esc_html__( 'No', 'injob' ),
                ),
            ),
            array(
                'name' => esc_html__( 'Extra class', 'injob' ),
                'desc' => esc_html__( 'Add extra class for page content', 'injob' ),
                'default' => '',
                'id' => $prefix . 'page_class',
                'type' => 'text',
            ),
            array(
                'name' => esc_html__( 'Header Options', 'injob' ),
                'id'   => $prefix . 'header_options_title',
                'type' => 'title',
            ),
            array(
                'name'    => esc_html__( 'Header style', 'injob' ),
                'id'      => $prefix . 'header_option',
                'type'    => 'select',
                'options' => array(
					'' => esc_html__( 'Default', 'injob' ),
					'none'   => esc_html__( 'None', 'injob' ),
					'default'   => esc_html__( 'Header Style 1', 'injob' ),
                ),
            ),
            array(
                'name'    => esc_html__( 'Sticky Header', 'injob' ),
                'id'      => $prefix . 'header_sticky',
                'type'    => 'select',
                'options' => array(
                    '' => esc_html__( 'Default', 'injob' ),
                    'yes'   => esc_html__( 'Yes', 'injob' ),
                    'no'     => esc_html__( 'No', 'injob' ),
                ),
            ),
            array(
                'name'    => esc_html__( 'Show Make Appointment in Header Style 1', 'injob' ),
                'id'      => $prefix . 'show_make_appointment',
                'type'    => 'select',
                'options' => array(
                    '' => esc_html__( 'Default', 'injob' ),
                    'yes'   => esc_html__( 'Yes', 'injob' ),
                    'no'     => esc_html__( 'No', 'injob' ),
                ),
            ),
            array(
                'name' => esc_html__( 'Change logo', 'injob' ),
                'id'   => $prefix . 'logo',
                'type' => 'file',
            ),
            array(
                'name' => esc_html__( 'Change logo sticky', 'injob' ),
                'id'   => $prefix . 'logo_sticky',
                'type' => 'file',
            ),
            array(
                'name' => esc_html__( 'Page Heading Options', 'injob' ),
                'id'   => $prefix . 'page_heading_options_title',
                'type' => 'title',
            ),
            array(
                'name'    => esc_html__( 'Show page heading', 'injob' ),
                'id'      => $prefix . 'show_pageheading',
                'type'    => 'select',
                'options' => array(
                    '' => esc_html__( 'Default', 'injob' ),
                    'yes'   => esc_html__( 'Yes', 'injob' ),
                    'no'     => esc_html__( 'No', 'injob' ),
                ),
            ),
            array(
                'name' => esc_html__( 'Page heading background', 'injob' ),
                'id'   => $prefix . 'pageheading_bg',
                'type' => 'file',
            ),
            array(
                'name'    => esc_html__( 'Show page breadcrumb', 'injob' ),
                'id'      => $prefix . 'breadcrumbs',
                'type'    => 'select',
                'options' => array(
                    '' => esc_html__( 'Default', 'injob' ),
                    'yes'   => esc_html__( 'Yes', 'injob' ),
                    'no'     => esc_html__( 'No', 'injob' ),
                ),
            ),
            array(
                'name' => esc_html__( 'Sidebar Options', 'injob' ),
                'id'   => $prefix . 'sidebar_options_title',
                'type' => 'title',
            ),
            array(
                'name'    => esc_html__( 'Sidebar Position', 'injob' ),
                'id'      => $prefix . 'sidebar_position',
                'type'    => 'select',
                'options' => array(
                    '' => esc_html__( 'Default', 'injob' ),
                    'none'   => esc_html__( 'Without Sidebar', 'injob' ),
                    'right'     => esc_html__( 'Right', 'injob' ),
                    'left'     => esc_html__( 'Left', 'injob' ),
                    'bottom'     => esc_html__( 'Bottom', 'injob' ),
                ),
            ),
            array(
                'name'    => esc_html__( 'Sidebar', 'injob' ),
                'id'      => $prefix . 'sidebar_name',
                'type'    => 'select',
                'options' => $sideBars,
            ),
            array(
                'name'    => esc_html__( 'Sidebar 1', 'injob' ),
                'id'      => $prefix . 'sidebar_name_1',
                'type'    => 'select',
                'options' => $sideBars,
            ),
            array(
                'name'    => esc_html__( 'Sidebar 2', 'injob' ),
                'id'      => $prefix . 'sidebar_name_2',
                'type'    => 'select',
                'options' => $sideBars,
            ),
            array(
                'name'    => esc_html__( 'Primary Menu', 'injob' ),
                'id'      => $prefix . 'primary_menu',
                'type'    => 'select',
                'options' => $menuArr,
            ),
            array(
                'name' => esc_html__( 'Footer Options', 'injob' ),
                'id'   => $prefix . 'footer_options_title',
                'type' => 'title',
            ),
            array(
                'name'    => esc_html__( 'Footer style', 'injob' ),
                'id'      => $prefix . 'footer_option',
                'type'    => 'select',
                'options' => array(
                ''        => esc_html__( 'Default', 'injob' ),
                'default' => esc_html__( 'Footer version 1', 'injob' ),
                ),
            ),
            array(
                'name'    => esc_html__('Footer Background Color', 'injob'),
                'id'      => $prefix . 'footer_bg_color',
                'type'    => 'colorpicker',
                'default' => '',
            ),
            array(
                'name'    => esc_html__('Copyright Background Color', 'injob'),
                'id'      => $prefix . 'copyright_bg_color',
                'type'    => 'colorpicker',
                'default' => '',
            ),
        )
    );

    return $meta_boxes;
}