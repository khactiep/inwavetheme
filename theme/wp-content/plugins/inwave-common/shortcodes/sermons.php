<?php

/*
 * Inwave_Sermons for Visual Composer
 */
if (!class_exists('Inwave_Sermons')) {

    class Inwave_Sermons extends Inwave_Shortcode{

        protected $name = 'inwave_sermons';

        function init_params() {

            $_categories = get_categories(array('taxonomy'=>'sermon_cats'));
            $cats = array(array('value' => '*', 'text' => __("All", "inwavethemes") ));
            foreach ($_categories as $cat) {
                $cats[] = array('value' => $cat->term_id, 'text' => $cat->name);
            }

            return array(
                'name' => __("Sermons", 'inwavethemes'),
                'description' => __('Add a Sermon List', 'inwavethemes'),
                'base' => $this->name,
                'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        "heading" => __("Post Ids", "inwavethemes"),
                        "value" => "",
                        "param_name" => "post_ids",
                        "description" => __('Id of posts you want to get. Separated by commas.', "inwavethemes")
                    ),
                    array(
                        "type" => "iw_select",
                        "heading" => __("Post Category", "inwavethemes"),
                        "param_name" => "category",
                        "multiple" => "1",
                        "data" => $cats,
                        "description" => __('Category to get posts.', "inwavethemes")
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Post number", "inwavethemes"),
                        "param_name" => "post_number",
                        "value" => "3",
                        "admin_label" => true,
                        "description" => __('Number of posts to display on box.', "inwavethemes")
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Order By", "inwavethemes"),
                        "param_name" => "order_by",
                        "value" => array(
                            'ID' => 'ID',
                            'Title' => 'title',
                            'Date' => 'date',
                            'Modified' => 'modified',
                            'Ordering' => 'menu_order',
                            'Random' => 'rand'
                        ),
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Order Type", "inwavethemes"),
                        "param_name" => "order_type",
                        "value" => array(
                            'ASC' => 'ASC',
                            'DESC' => 'DESC'
                        ),
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Style", 'inwavethemes'),
                        "admin_label" => true,
                        "param_name" => "style",
                        "value" => array(
                            "Accordion" => "accordion",
                            "Slider"=> "slider",
                            "Grid"=> "grid",
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Color Scheme", 'inwavethemes'),
                        "param_name" => "color_scheme",
                        "value" => array(
                            "Dark Text" => "dark",
                            "Light Text"=> "light",
                        ),
                        "dependency" => array("element"=>"style", "value" => "slider")
                    ),
                    array(
                        "type" => "textfield",
                        "class" => "",
                        "heading" => "Active item",
                        "param_name" => "active_item",
                        "value" => "1",
                        "dependency" => array("element"=>"style", "value" => "accordion")
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

            $output = '';
            extract(shortcode_atts(array(
                'style' => '',
                'color_scheme' => '',
                'post_ids' => '',
                'category' => '',
                'post_number' => '',
                'order_by' => '',
                'order_type' => '',
                'active_item' => '',
                'class' => '',
            ), $atts));

            $args = array();
            $args['post_type'] = 'sermon';
            if ($post_ids) {
                $args['post__in'] = explode(',', $post_ids);
            } elseif($category) {
                $category_arr =  explode(',', $category);
                if(!in_array('*', $category_arr)){
                    $args['tax_query'] = array(
                        array(
                            'taxonomy' => 'sermon_cats',
                            'field' => 'term_id',
                            'terms' => $category_arr,
                        )
                    );
                }
            }
            $search_str = '';
            if(isset($_GET['sermon_search']) && $_GET['sermon_search']){
                $search_str = $args['s'] = esc_sql($_GET['sermon_search']);
            }
            $ordering_str = $order_by.'-'.$order_type;
            if(isset($_GET['sermon_ordering']) && $_GET['sermon_ordering']){
                $ordering_str = $_GET['sermon_ordering'];
            }

            $ordering_arr = explode('-', $ordering_str);
            if(count($ordering_arr) == 2)
            {
                $args['order'] = $ordering_arr[1];
                $args['orderby'] = $ordering_arr[0];
            }
            $args['posts_per_page'] = $post_number;

			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $args['paged'] = $paged;
			
            $query = new WP_Query($args);

            ob_start();

            wp_enqueue_style('fancybox');
            wp_enqueue_script('fancybox');

            $random_id = rand(10, 1000);
            $panel_group_id = 'sermon-group-'.$random_id;

            $class .= ' '.$style;
            switch ($style){
                case 'accordion' :
                    ?>
                    <div class="iw-sermons <?php echo $class; ?> clearfix">
                        <div class="panel-group" id="<?php echo $panel_group_id; ?>">
                            <?php if( $query->have_posts() ) {
                                $i = 1;
                                while ($query->have_posts()) :
                                    $query->the_post();
                                    $post = get_post();

                                    if ( has_excerpt() ) {
                                        $post_content = get_the_excerpt();
                                    } else {
                                        $content_parts = get_extended($post->post_content);
                                        $post_content = $content_parts ? ($content_parts['main'] !== '' ? $content_parts['main'] : wp_trim_words($content_parts['extended'], 30)) : '';
                                    }

                                    //$pastor = get_post_meta($post->ID, 'inwave_pastor', true);
                                    $attach_file = get_post_meta($post->ID, 'inwave_attach_file', true);
                                    $audio_resource = get_post_meta($post->ID, 'inwave_audio_resource', true);
                                    $audio_file = get_post_meta($post->ID, 'inwave_audio_file', true);
                                    $audio_embed = get_post_meta($post->ID, 'inwave_audio_embed', true);
                                    $video_resource = get_post_meta($post->ID, 'inwave_video_resource', true);
                                    $video_file = get_post_meta($post->ID, 'inwave_video_file', true);
                                    $video_embed = get_post_meta($post->ID, 'inwave_video_embed', true);

                                    $id_str = 'sermon-'.$random_id.'-'.get_the_ID();
                                    ?>
                                    <div class="panel <?php echo $active_item == $i ? 'active' : ''; ?>">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#<?php echo $panel_group_id; ?>" href="#<?php echo $id_str; ?>"><span class="icon"><i class="fa fa-microphone"></i></span><span><?php echo esc_html(get_the_title()); ?></span></a>
                                            </h3>
                                        </div>
                                        <div id="<?php echo $id_str; ?>" class="panel-collapse collapse <?php echo $active_item == $i ? 'in' : ''; ?>">
                                            <div class="panel-body">
                                                <div class="sermon-metas clearfix">
                                                    <span class="category"><i class="fa fa-bars"></i><?php echo get_the_term_list($post->ID, 'sermon_cats', __('Category : ')); ?></span>
                                                    <span class="tag"><i class="fa fa-tag"></i><?php echo get_the_term_list($post->ID, 'sermon_tags'); ?></span>
                                                    <span class="pastor"><i class="fa fa-user"></i><?php echo get_the_author_meta('display_name', $post->post_author); ?></span>
                                                </div>
                                                <div class="sermon-content"><?php echo $post_content; ?>..<a class="read-more" href="<?php the_permalink(); ?>"><?php echo esc_html(__('Read detail', 'inwavethemes')) ?></a></div>
                                                <div class="sermon-share-action">
                                                    <div class="sermon-action">
                                                        <?php
                                                        if($audio_resource == 'file_url'){
                                                            if($audio_file) {
                                                                echo '<a href="#" class="action-audio"><i class="fa fa-headphones"></i><audio src="' . esc_url($audio_file) . '"></audio></a>';
                                                            }
                                                        }
                                                        else
                                                        {
                                                            if($audio_embed){
                                                                preg_match('/\s+src=\"([^\"]+)\"/Usi', $audio_embed, $matches);
                                                                if($matches){
                                                                    echo '<a href="'.esc_url($matches[1]).'" class="action-audio fancybox_iframe"><i class="fa fa-headphones"></i></a>';
                                                                }
                                                            }
                                                        }

                                                        if($video_resource == 'file_url'){
                                                            if($video_file) {
                                                                echo '<a href="#sermon-video-'.$post->ID.'" class="action-video fancybox"><i class="fa fa-play-circle"></i></a>';
                                                                echo '<div class="fancybox-hidden" style="display: none">';
                                                                echo '<div id="sermon-video-'.$post->ID.'">';
                                                                echo '<video controls>
                                                                          <source src="'.$video_file.'">
                                                                           '.esc_html__('Your browser does not support the video tag.', 'inwavethemes').'
                                                                    </video> ';
                                                                echo '</div>';
                                                                echo '</div>';
                                                            }
                                                        }
                                                        else
                                                        {
                                                            if($video_embed){
                                                                preg_match('/\s+src=\"([^\"]+)\"/Usi', $video_embed, $matches);
                                                                if($matches){
                                                                    $video_url = $matches[1];
                                                                    echo '<a href="'.esc_url($video_url).'" class="action-video fancybox_iframe"><i class="fa fa-play-circle"></i></a>';
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                        <?php
                                                        if($attach_file){
                                                            echo '<a href="'.esc_url($attach_file).'" class="action-download" target="_blank"><i class="fa fa-download"></i></a>';
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="sermon-share">
                                                        <a href="#"><i class="fa fa-share-alt"></i><?php echo __('Share this sermon', 'inwavethemes');?></a>
                                                    <span class="share-icons">
                                                        <?php echo inwave_social_sharing(get_permalink($post->ID), $content, get_the_title()); ?>
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    $i++;
                                endwhile;
                                wp_reset_postdata();
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    break;
                case 'slider' :
                    $class.= ' slider_'.$color_scheme;
                    $data_plugin_options = array(
                        "autoPlay"=>false,
                        "autoHeight"=>false,
                        "pagination"=>false,
                        "singleItem"=>true,
                        "navigation"=>true,
                        "navigationText" => array("<i class='fa fa-caret-left'></i>", "<i class='fa fa-caret-right'></i>")
                    );
                    ?>
                    <div class="iw-sermons <?php echo $class; ?> clearfix owl-carousel" data-plugin-options='<?php echo esc_attr(json_encode($data_plugin_options)); ?>'>
                        <?php if( $query->have_posts() ) {
                            $i = 1;
                            while ($query->have_posts()) :
                                $query->the_post();
                                $post = get_post();

                                //$pastor = get_post_meta($post->ID, 'inwave_pastor', true);
                                $attach_file = get_post_meta($post->ID, 'inwave_attach_file', true);
                                $audio_resource = get_post_meta($post->ID, 'inwave_audio_resource', true);
                                $audio_file = get_post_meta($post->ID, 'inwave_audio_file', true);
                                $audio_embed = get_post_meta($post->ID, 'inwave_audio_embed', true);
                                $video_resource = get_post_meta($post->ID, 'inwave_video_resource', true);
                                $video_file = get_post_meta($post->ID, 'inwave_video_file', true);
                                $video_embed = get_post_meta($post->ID, 'inwave_video_embed', true);

                                $image_url = get_the_post_thumbnail_url(null, 'full');
                                $image_url = inwave_resize($image_url, 290, 310, true);
                                ?>
                                <div class="sermon-item">
                                    <div class="sermon-info">
                                        <h3><?php echo __("Latest Sermon", "inwavethemes"); ?></h3>
                                        <div class="sermon-title-metas">
                                            <h4 class="sermon-title"><a href="<?php the_permalink(); ?>"><?php echo esc_html(get_the_title()); ?></a></h4>
                                            <div class="sermon-metas clearfix">
                                                <span class="date"><i class="fa fa-calendar-o"></i><?php the_date('j F'); ?></span>
                                                <span class="category"><i class="fa fa-bars"></i><?php echo get_the_term_list($post->ID, 'sermon_cats', __('Category : ')); ?></span>
                                                <span class="pastor"><i class="fa fa-user"></i><?php echo get_the_author_meta('display_name', $post->post_author); ?></span>
                                            </div>
                                        </div>
                                        <div class="sermon-share-action">
                                            <div class="sermon-action">
                                                <?php
                                                if($audio_resource == 'file_url'){
                                                    if($audio_file) {
                                                        echo '<a href="#" class="action-audio"><i class="fa fa-headphones"></i><audio src="' . esc_url($audio_file) . '"></audio></a>';
                                                    }
                                                }
                                                else
                                                {
                                                    if($audio_embed){
                                                        preg_match('/\s+src=\"([^\"]+)\"/Usi', $audio_embed, $matches);
                                                        if($matches){
                                                            echo '<a href="'.esc_url($matches[1]).'" class="action-audio fancybox_iframe"><i class="fa fa-headphones"></i></a>';
                                                        }
                                                    }
                                                }

                                                if($video_resource == 'file_url'){
                                                    if($video_file) {
                                                        echo '<a href="#sermon-video-'.$post->ID.'" class="action-video fancybox"><i class="fa fa-play-circle"></i></a>';
                                                        echo '<div class="fancybox-hidden" style="display: none">';
                                                        echo '<div id="sermon-video-'.$post->ID.'">';
                                                        echo '<video controls>
                                                                      <source src="'.esc_url($video_file).'">
                                                                       '.esc_html__('Your browser does not support the video tag.', 'inwavethemes').'
                                                                        </video> ';
                                                        echo '</div>';
                                                        echo '</div>';
                                                    }
                                                }
                                                else
                                                {
                                                    if($video_embed){
                                                        preg_match('/\s+src=\"([^\"]+)\"/Usi', $video_embed, $matches);
                                                        if($matches){
                                                            $video_url = $matches[1];
                                                            echo '<a href="'.esc_url($video_url).'" class="action-video fancybox_iframe"><i class="fa fa-play-circle"></i></a>';
                                                        }
                                                    }
                                                }
                                                ?>
                                                <?php
                                                if($attach_file){
                                                    echo '<a href="'.esc_url($attach_file).'" class="action-download" target="_blank"><i class="fa fa-download"></i></a>';
                                                }
                                                ?>
                                            </div>
                                            <div class="sermon-share">
                                                <a href="#"><i class="fa fa-share-alt"></i><?php echo __('Share', 'inwavethemes');?></a>
                                                <div class="share-icons">
                                                    <?php echo inwave_social_sharing(get_permalink($post->ID), $content, get_the_title()); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sermon-image">
                                        <img src="<?php echo esc_url($image_url); ?>" alt="">
                                    </div>
                                </div>
                                <?php
                                $i++;
                            endwhile;
                            wp_reset_postdata();
                        }
                        ?>
                    </div>
                    <?php
                    break;
                case 'grid' :
                ?>
                    <div class="iw-sermons <?php echo $class; ?> clearfix">
                        <div class="sermon-header clearfix">
                            <h3><?php echo __("Lightbook Sermon", "inwavethemes"); ?></h3>
                            <form action="<?php echo get_permalink(); ?>" method="get">
                                <select name="sermon_ordering" class="sermon-ordering">
                                    <option value="menu_order-ASC" <?php echo ($ordering_str == 'menu_order-ASC') ? 'selected' : ''; ?>><?php echo __('Order Ascending', 'inwavethemes'); ?></option>
                                    <option value="menu_order-DESC" <?php echo ($ordering_str == 'menu_order-DESC') ? 'selected' : ''; ?>><?php echo __('Order Descending', 'inwavethemes'); ?></option>
                                    <option value="ID-ASC" <?php echo ($ordering_str == 'ID-ASC') ? 'selected' : ''; ?>><?php echo __('ID Ascending', 'inwavethemes'); ?></option>
                                    <option value="ID-DESC" <?php echo ($ordering_str == 'ID-DESC') ? 'selected' : ''; ?>><?php echo __('ID Descending', 'inwavethemes'); ?></option>
                                    <option value="title-ASC" <?php echo ($ordering_str == 'title-ASC') ? 'selected' : ''; ?>><?php echo __('Title Ascending', 'inwavethemes'); ?></option>
                                    <option value="title-DESC" <?php echo ($ordering_str == 'title-DESC') ? 'selected' : ''; ?>><?php echo __('Title Descending', 'inwavethemes'); ?></option>
                                    <option value="date-ASC" <?php echo ($ordering_str == 'date-ASC') ? 'selected' : ''; ?>><?php echo __('Date Ascending', 'inwavethemes'); ?></option>
                                    <option value="date-DESC" <?php echo ($ordering_str == 'date-DESC') ? 'selected' : ''; ?>><?php echo __('Date Descending', 'inwavethemes'); ?></option>
                                </select>
                                <span class="sermon-search">
                                    <input type="text" name="sermon_search" value="<?php echo $search_str; ?>" placeholder="<?php echo __('SEARCH', 'inwavethemes'); ?>">
                                    <i class="fa fa-search"></i>
                                </span>
                            </form>
                        </div>
                        <div class="sermon-items">
                        <div class="sermon-row row">
                        <?php if( $query->have_posts() ) {
                            $i = 1;
                            while ($query->have_posts()) :
                                $query->the_post();
                                $post = get_post();

                                //$pastor = get_post_meta($post->ID, 'inwave_pastor', true);
                                $attach_file = get_post_meta($post->ID, 'inwave_attach_file', true);
                                $audio_resource = get_post_meta($post->ID, 'inwave_audio_resource', true);
                                $audio_file = get_post_meta($post->ID, 'inwave_audio_file', true);
                                $audio_embed = get_post_meta($post->ID, 'inwave_audio_embed', true);
                                $video_resource = get_post_meta($post->ID, 'inwave_video_resource', true);
                                $video_file = get_post_meta($post->ID, 'inwave_video_file', true);
                                $video_embed = get_post_meta($post->ID, 'inwave_video_embed', true);

                                $image_url = get_the_post_thumbnail_url(null, 'full');
                                $image_url = inwave_resize($image_url, 310, 370, true);
                                ?>
                                <div class="sermon-item col-sm-6">
                                    <div class="sermon-wrap clearfix">
                                        <img src="<?php echo $image_url; ?>" alt="">
                                        <div class="iw-item-social-share iw-close">
                                            <a class="click theme-color"><?php echo __('Share', 'inwavethemes');?></a>
                                            <div class="share-icon">
                                                <?php
                                                inwave_social_sharing(get_permalink(), Inwave_Helper::substrword(get_the_excerpt(), 10), get_the_title());
                                                ?>
                                            </div>
                                        </div>
                                        <div class="sermon-info">
                                            <h3 class="sermon-title"><a href="<?php the_permalink(); ?>"><?php echo esc_html(get_the_title()); ?></a></h3>
                                            <div class="sermon-metas clearfix">
                                                <span class="category"><i class="fa fa-bars"></i><?php echo get_the_term_list($post->ID, 'sermon_cats'); ?></span>
                                                <span class="pastor"><i class="fa fa-user"></i><?php echo get_the_author_meta('display_name', $post->post_author); ?></span>
                                            </div>
                                            <div class="sermon-action">
                                                <?php
                                                if($audio_resource == 'file_url'){
                                                    if($audio_file) {
                                                        echo '<a href="#" class="action-audio"><i class="fa fa-headphones"></i><audio src="' . $audio_file . '"></audio></a>';
                                                    }
                                                }
                                                else
                                                {
                                                    if($audio_embed){
                                                        preg_match('/\s+src=\"([^\"]+)\"/Usi', $audio_embed, $matches);
                                                        if($matches){
                                                            echo '<a href="'.$matches[1].'" class="action-audio fancybox_iframe"><i class="fa fa-headphones"></i></a>';
                                                        }
                                                    }
                                                }

                                                if($video_resource == 'file_url'){
                                                    if($video_file) {
                                                        echo '<a href="#sermon-video-'.$post->ID.'" class="action-video fancybox"><i class="fa fa-play-circle"></i></a>';
                                                        echo '<div class="fancybox-hidden" style="display: none">';
                                                        echo '<div id="sermon-video-'.$post->ID.'">';
                                                        echo '<video controls>
                                                                              <source src="'.$video_file.'">
                                                                               Your browser does not support the video tag.
                                                                        </video> ';
                                                        echo '</div>';
                                                        echo '</div>';
                                                    }
                                                }
                                                else
                                                {
                                                    if($video_embed){
                                                        preg_match('/\s+src=\"([^\"]+)\"/Usi', $video_embed, $matches);
                                                        if($matches){
                                                            $video_url = $matches[1];
                                                            echo '<a href="'.$video_url.'" class="action-video fancybox_iframe"><i class="fa fa-play-circle"></i></a>';
                                                        }
                                                    }
                                                }
                                                ?>
                                                <?php
                                                if($attach_file){
                                                    echo '<a href="'.$attach_file.'" class="action-download" target="_blank"><i class="fa fa-download"></i></a>';
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if(($i % 2 == 0) && $query->post_count > $i){
                                    ?>
                                    </div>
                                    <div class="sermon-row row">
                                <?php
                                }
                                $i++;
                            endwhile;
                            wp_reset_postdata();
                        }
                        else{
                            echo '<div class="sermon-empty">'.__('item not found', 'inwavethemes').'</div>';
                        }
                        ?>
                        </div>
                        </div>
                        <?php
                        $total_pages = $query->max_num_pages;
                        if ( $total_pages > 1) {
                        ?>
                        <div class="page-nav">
                            <?php
                            echo paginate_links( apply_filters( 'sermon_pagination_args', array(
                                'base'         => esc_url_raw( str_replace( 999999999, '%#%', get_pagenum_link( 999999999, false ) ) ),
                                'format'       => '',
                                'add_args'     => false,
                                'current'      => max( 1, get_query_var( 'paged' ) ),
                                'total'        => $query->max_num_pages,
                                'prev_text'          => __('<i class="fa fa-angle-left"></i>', 'inwavethemes'),
                                'next_text'          => __('<i class="fa fa-angle-right"></i>', 'inwavethemes'),
                                'type'         => 'list',
                                'end_size'     => 3,
                                'mid_size'     => 3
                            ) ) );
                            ?>
                        </div>
                        <?php } ?>
                    </div>
                    <?php
            }

            $output = ob_get_contents();
            ob_end_clean();

            return $output;
        }
    }
}

new Inwave_Sermons;
