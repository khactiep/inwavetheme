<?php
/*
Plugin Name:  Blog_Follow_Widget
Plugin URI: http://BlogFollow.com
Description: To Follow The Blog
Author: Khac Tiep
Version: 1.0
Author URI: http://khactiep.com
*/

class Blog_Follow_Widget extends WP_Widget {

    /**
     * Thiết lập widget: đặt tên, base ID
     */
    function Blog_Follow_Widget() {
        $tpwidget_options = array(
            'classname' => 'Blog_Follow_Widget_class', //ID của widget
            'description' => 'Mô tả của widget'
        );
        $this->WP_Widget('Blog_Follow_Widget_id', 'Blog_Follow Widget', $tpwidget_options);
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

        <div class="follow_me">
            <div class="line"></div>
            <div style="text-align: center">
                <div class="title_sidebar">follow me</div>
            </div>


            <ul>
                <li><a href="http://instagram.com"><i class="fa fa-instagram"></i></a></li>
                <li><a href="http://facebook.com"><i class="fa fa-facebook"></i></a></li>
                <li><a href="http://twitter.com"><i class="fa fa-twitter"></i></a></li>
                <li><a href="http://bloglovin.com"><i class="fa fa-heart"></i></a></li>
                <li><a href="http://pinterest.com"><i class="fa fa-pinterest"></i></a></li>
                <li><a href="http://google.com"><i class="fa fa-google-plus"></i></a></li>
            </ul>


            <img src="http://localhost:8888/khactiep/wp-content/uploads/2017/03/106.png" width="100%" style="margin-top: 20px">
        </div>

        <?php

        echo $after_widget;
    }

}

/*
 * Khởi tạo widget item
 */
add_action( 'widgets_init', 'create_Blog_Follow_Widget' );
function create_Blog_Follow_Widget() {
    register_widget('Blog_Follow_Widget');
}