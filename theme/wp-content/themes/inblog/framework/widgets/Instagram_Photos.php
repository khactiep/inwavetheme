<?php
/*
Plugin Name:  Instagram_Photo_Widget
Plugin URI: http://InfoAuhor.com
Description: To dislay the Instagram_Photo's information
Instagram_Photo: Khac Tiep
Version: 1.0
Instagram_Photo URI: http://khactiep.com
*/

class Instagram_Photo_Widget extends WP_Widget {

    /**
     * Thiết lập widget: đặt tên, base ID
     */
    function Instagram_Photo_Widget() {
        $tpwidget_options = array(
            'classname' => 'Instagram_Photo_Widget_class', //ID của widget
            'description' => 'Mô tả của widget'
        );
        $this->WP_Widget('Instagram_Photo_Widget_id', 'Instagram_Photo Widget', $tpwidget_options);
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

        <div class="Instagram_Photo" style="margin-top: 30px">
            <div class="line"></div>
            <div style="text-align: center">
                <div class="title_sidebar"><?php echo esc_html__('Instagram','injob');?></div>
            </div>
            <?php echo do_shortcode('[instagram-feed num=5 cols=3 showfollow=false showheader=false showbutton=false]'); ?>
        </div>

        <?php

        echo $after_widget;
    }

}

/*
 * Khởi tạo widget item
 */
add_action( 'widgets_init', 'create_Instagram_Photo_Widget' );
function create_Instagram_Photo_Widget() {
    register_widget('Instagram_Photo_Widget');
}