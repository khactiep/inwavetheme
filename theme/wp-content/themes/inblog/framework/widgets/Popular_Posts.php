<?php
/*
Plugin Name:  Popular_Posts_Widget
Plugin URI: http://InfoAuhor.com
Description: To dislay the Popular_Posts's information
Popular_Posts: Khac Tiep
Version: 1.0
Popular_Posts URI: http://khactiep.com
*/

class Popular_Posts_Widget extends WP_Widget {

    /**
     * Thiết lập widget: đặt tên, base ID
     */
    function Popular_Posts_Widget() {
        $tpwidget_options = array(
            'classname' => 'Popular_Posts_Widget_class', //ID của widget
            'description' => 'Mô tả của widget'
        );
        $this->WP_Widget('Popular_Posts_Widget_id', 'Popular_Posts Widget', $tpwidget_options);
    }

    /**
     * Tạo form option cho widget
     */
    function form( $instance ) {

        //Biến tạo các giá trị mặc định trong form
        $default = array(
            'title' => 'Tiêu đề widget'
        );

        //Gộp các giá trị trong mảng $default vào biến $instance để nó trở thành các giá trị mặc định
        $instance = wp_parse_args( (array) $instance, $default);

        //Tạo biến riêng cho giá trị mặc định trong mảng $default
        $title = esc_attr( $instance['title'] );

        //Hiển thị form trong option của widget
        echo "<p>Nhập tiêu đề <input type='text' class='widefat' name='".$this->get_field_name('title')."' value='".$title."' /></p>";


    }

    /**
     * save widget form
     */

    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    /**
     * Show widget
     */

    function widget( $args, $instance ) {

        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );

        echo $before_widget;

        //Nội dung widget
        ?>

        <div class="Popular_Posts">
            <div class="line"></div>
            <div style="text-align: center">
                <div class="title_sidebar">Popular Posts</div>
            </div>
            <?php
            $popularpost = new WP_Query( array(
                'posts_per_page' => 5,
                'meta_key' => 'wpb_post_views_count',
                'orderby' => 'meta_value_num'
            ) );

            while ( $popularpost->have_posts() ) : $popularpost->the_post();
                ?>
                <div class=" row list_popular_post">
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        <?php
                        $img_src= get_the_post_thumbnail_url(get_the_ID());
                        $img_src = inwave_resize($img_src, 110, 110, true);
                        ?>
                        <img src="<?php echo $img_src ?>">
                    </div>

                    <div class="col-md-8 col-sm-8 col-xs-8 info_popular_post">
                        <div class="date"><?php echo get_the_date(); ?></div><br>
                        <a href="<?php the_permalink()?>"> <div class="title"><?php the_title();?></div> </a>
                    </div>
                </div>
                <?php
            endwhile;
            ?>

        </div>

        <?php

        echo $after_widget;
    }

}

/*
 * Khởi tạo widget item
 */
add_action( 'widgets_init', 'create_Popular_Posts_Widget' );
function create_Popular_Posts_Widget() {
    register_widget('Popular_Posts_Widget');
}