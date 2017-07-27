<?php
/*
Plugin Name:  Info_Author_Widget
Plugin URI: http://InfoAuhor.com
Description: To dislay the Author's information
Author: Khac Tiep
Version: 1.0
Author URI: http://khactiep.com
*/

class Author_Widget extends WP_Widget {

    /**
     * Thiết lập widget: đặt tên, base ID
     */
    function Author_Widget() {
        $tpwidget_options = array(
            'classname' => 'Author_Widget_class', //ID của widget
            'description' => 'Mô tả của widget'
        );
        $this->WP_Widget('Author_Widget_id', 'Info_Author Widget', $tpwidget_options);
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
        <div class="about_me">
            <div class="line"></div>
            <div style="text-align: center">
                <div class="title_sidebar">About me</div>
            </div>
            <div style="text-align:center">
                <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ));?>" target="_blank"><?php echo '<div class="author_avatar">'.get_avatar(get_the_author_meta('ID'),160).'</div>';?></a>
                <div style="font-family: Karla; font-size: 11pt; color: black"> <?php echo get_the_author_meta( 'description' ); ?></div>
            </div>
        </div>
        <?php
        echo $after_widget;
    }

}

/*
 * Khởi tạo widget item
 */
add_action( 'widgets_init', 'create_Author_Widget' );
function create_Author_Widget() {
    register_widget('Author_Widget');
}