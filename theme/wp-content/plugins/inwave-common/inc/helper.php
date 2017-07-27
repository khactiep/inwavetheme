<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of functions
 *
 * @developer duongca
 */
if (!function_exists('inwave_get_shortcodes')) {

    function inwave_get_shortcodes() {
        return array(
            'base',//required
            'map',
            'button',
            'heading',
            'info_list',
            //'mailchimp',
            'products',
            'team',
            'testimonials',
            'video',
            'posts',
            'sponsors',
            'funfacts',
            'iwe_events',
            //'text-block',
            'image-box',
            'iw_quote',
            'sermons',
            'post',
            'infunding_listing',
            'tweet',
            'iw_gallery',
            'iwe_events_count_down',
        );
    }
}

if (!function_exists('inwave_add_shortcode_script')) {

    function inwave_add_shortcode_script($scripts) {
        if ($scripts) {
            $theme_info = wp_get_theme();
            foreach ($scripts as $key => $scripts2) {
                foreach ($scripts2 as $key2 => $script) {
                    if ($key == 'scripts') {
                        wp_enqueue_script($key2, $script, array('jquery'), $theme_info->get('Version'));
                    } else {
                        wp_enqueue_style($key2, $script, array(), $theme_info->get('Version'));
                    }
                }
            }
        }
    }

}

if (!function_exists('inwave_get_element_by_tags')) {
    /**
     * Function to get element by tag
     * @param string $tag tag name. Eg: embed, iframe...
     * @param string $content content to find
     * @param int $type type of tag. <br/> 1. [tag_name settings]content[/tag_name]. <br/>2. [tag_name settings]. <br/>3. HTML tags.
     * @return type
     */
    function inwave_get_element_by_tags($tag, $content, $type = 1) {
        if ($type == 1) {
            $pattern = "/\[$tag(.*)\](.*)\[\/$tag\]/Uis";
        } elseif ($type == 2) {
            $pattern = "/\[$tag(.*)\]/Uis";
        } elseif ($type == 3) {
            $pattern = "/\<$tag(.*)\>(.*)\<\/$tag\>/Uis";
        } else {
            $pattern = null;
        }
        $find = null;
        if ($pattern) {
            preg_match($pattern, $content, $matches);
            if ($matches) {
                $find = $matches;
            }
        }
        return $find;
    }
}
