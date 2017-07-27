<?php
    /*
     * Register post type sermon
    */
    function inwave_post_type_sermon()
    {

        $labels = array(
            'name' 					=> __('Sermon', 'bolder'),
            'singular_name' 		=> __('Sermon', 'bolder'),
            'add_new' 				=> __('Add New', 'bolder'),
            'all_items' 			=> __('All Sermons', 'bolder'),
            'add_new_item' 			=> __('Add New Sermon', 'bolder'),
            'edit_item' 			=> __('Edit Sermon', 'bolder'),
            'new_item' 				=> __('New Sermon', 'bolder'),
            'view_item' 			=> __('View Sermon', 'bolder'),
            'search_items' 			=> __('Search Sermon', 'bolder'),
            'not_found' 			=> __('No Sermon Found', 'bolder'),
            'not_found_in_trash' 	=> __('No Sermon Found in Trash', 'bolder'),
            'parent_item_colon' 	=> '',
        );

        global $inwave_theme_option;

        $args = array(
            'labels' 			=> $labels,
            'public' 			=> true,
            'show_ui' 			=> true,
            'capability_type' 	=> 'post',
            'taxonomies'        => array( 'sermon_cats', ),
            'hierarchical' 		=> false,
            'rewrite' 			=> array('slug' => (isset($inwave_theme_option['sermon_slug']) && $inwave_theme_option['sermon_slug']) ? $inwave_theme_option['sermon_slug'] : 'sermon', 'with_front' => true),
            'query_var' 		=> true,
            'show_in_nav_menus' => true,
            'has_archive'          => true,
            'menu_icon' 		=> 'dashicons-list-view',
            'supports' 			=> array('title', 'thumbnail', 'excerpt', 'editor', 'author','tags', 'comments'),
        );

        register_post_type( 'sermon' , $args );
        register_taxonomy('sermon_cats',
            array('sermon'),
            array(
                'hierarchical' 		=> true,
                'public'            => true,
                'label' 			=> 'Sermon Categories',
                'show_admin_column'	=>'true',
                'singular_label' 	=> 'Category', 
                'query_var' 		=> true,
                'rewrite'           => array(
                    'slug'                       => 'sermon-category',
                    'with_front'                 => true,
                    'hierarchical'               => false,
                ),
            )
        );
        register_taxonomy('sermon_tags',
            array('sermon'),
            array(
                'hierarchical' 		=> false,
                'public'            => true,
                'label' 			=> 'Sermon Tags',
                'show_admin_column'	=>'true',
                'singular_label' 	=> 'Tag',
                'query_var' 		=> true,
                'rewrite'           => array(
                    'slug'                       => 'sermon-tag',
                    'with_front'                 => true,
                    'hierarchical'               => false,
                ),
            )
        );
    }

    add_action('init', 'inwave_post_type_sermon');
?>