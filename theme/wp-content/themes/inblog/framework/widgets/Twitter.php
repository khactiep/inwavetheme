<?php
/*
Plugin Name:  Twitter_Posts_Widget
Plugin URI: http://InfoAuhor.com
Description: To dislay the Twitter_Posts's information
Twitter_Posts: Khac Tiep
Version: 1.0
Twitter_Posts URI: http://khactiep.com
*/

class Twitter_Posts_Widget extends WP_Widget {

    /**
     * Thiết lập widget: đặt tên, base ID
     */
    function Twitter_Posts_Widget() {
        $tpwidget_options = array(
            'classname' => 'Twitter_Posts_Widget_class', //ID của widget
            'description' => 'Get Posts from a user twitter'
        );
        $this->WP_Widget('Twitter_Posts_Widget_id', 'Twitter_Posts Widget', $tpwidget_options);
    }

    /**
     * Tạo form option cho widget
     */
    function form( $instance ) {

        //Biến tạo các giá trị mặc định trong form
        $default = array(
            'user_name' =>'user name',
            'num' => '3'
        );

        //Gộp các giá trị trong mảng $default vào biến $instance để nó trở thành các giá trị mặc định
        $instance = wp_parse_args( (array) $instance, $default);

        //Tạo biến riêng cho giá trị mặc định trong mảng $default
        $user_name = esc_attr( $instance['user_name'] );
        $num = esc_attr( $instance['num'] );

        //Hiển thị form trong option của widget
        echo "<p>User name: <input type='text' class='widefat' name='".$this->get_field_name('user_name')."' value='".$user_name."' /></p>";
        echo "<p>Num of tweets: <input type='text' class='widefat' name='".$this->get_field_name('num')."' value='".$num."' /></p>";


    }

    /**
     * save widget form
     */

    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;
        $instance['user_name'] = strip_tags($new_instance['user_name']);
        $instance['num'] = strip_tags($new_instance['num']);
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
        $user_name= empty($instance['user_name'])? '' : $instance['user_name'];
        $num= empty($instance['num'])? '' : $instance['num'];

        global $inwave_theme_option;

        $user_name = $user_name ? $user_name : $inwave_theme_option['tw_username'];

        $data_plugin_options = '"navigation":false, "singleItem" : true, "autoPlay":true, "autoPlayTimeout":1000, "pagination":true, "items":1, "itemsDesktop":[1199, 1], "itemsDesktopSmall":[991, 1], "itemsTablet":[767, 1], "itemsTabletSmall":false, "itemsMobile":[479, 1]';

        if(!class_exists('StormTwitter')) {
            $StormTwitter_path = get_template_directory().'/framework/inc/inwave_common/StormTwitter.class.php';
            if (!file_exists($StormTwitter_path)) {
                return __('StormTwitter.class.php is not found. please active inwave-common plugin.', 'inwavethemes');
            } else {
                require_once $StormTwitter_path;
            }
        }

        $st = new StormTwitter(array(
            'key' => $inwave_theme_option['tw_consumer_key'],
            'secret' => $inwave_theme_option['tw_consumer_secret'],
            'token' => $inwave_theme_option['tw_access_token'],
            'token_secret' => $inwave_theme_option['tw_access_token_secret'],
            'cache_expire' => 3600
        ));

        //$tweets = json_decode('[{"created_at":"Fri Jan 08 03:31:14 +0000 2016","id":6.8530271777482e+17,"id_str":"685302717774823424","text":"How 1 to Authenticate Users With Twitter OAuth https:\/\/t.co\/KDLwHe2Uz0","entities":{"hashtags":[],"symbols":[],"user_mentions":[],"urls":[{"url":"https:\/\/t.co\/KDLwHe2Uz0","expanded_url":"http:\/\/nukeviet.vn\/vi\/news\/the-gioi-cong-nghe\/Let-s-Encrypt-da-sang-giai-doan-thu-nghiem-cong-khai-385\/?utm_source=feedburner&utm_medium=twitter&utm_campaign=Feed%3A+nukeviet%2Fnews+%28Tin+t%E1%BB%A9c+NukeViet%29","display_url":"nukeviet.vn\/vi\/news\/the-gi\u2026","indices":[45,68]}]},"truncated":false,"source":"<a href=\"http:\/\/twitter.com\" rel=\"nofollow\">Twitter Web Client<\/a>","in_reply_to_status_id":null,"in_reply_to_status_id_str":null,"in_reply_to_user_id":null,"in_reply_to_user_id_str":null,"in_reply_to_screen_name":null,"user":{"id":3308503320,"id_str":"3308503320"},"geo":null,"coordinates":null,"place":null,"contributors":null,"is_quote_status":false,"retweet_count":0,"favorite_count":0,"favorited":false,"retweeted":false,"possibly_sensitive":false,"lang":"en"},{"created_at":"Fri Jan 08 03:31:14 +0000 2016","id":6.8530271777482e+17,"id_str":"685302717774823424","text":"How to Authenticate Users With Twitter OAuth https:\/\/t.co\/KDLwHe2Uz0","entities":{"hashtags":[],"symbols":[],"user_mentions":[],"urls":[{"url":"https:\/\/t.co\/KDLwHe2Uz0","expanded_url":"http:\/\/nukeviet.vn\/vi\/news\/the-gioi-cong-nghe\/Let-s-Encrypt-da-sang-giai-doan-thu-nghiem-cong-khai-385\/?utm_source=feedburner&utm_medium=twitter&utm_campaign=Feed%3A+nukeviet%2Fnews+%28Tin+t%E1%BB%A9c+NukeViet%29","display_url":"nukeviet.vn\/vi\/news\/the-gi\u2026","indices":[45,68]}]},"truncated":false,"source":"<a href=\"http:\/\/twitter.com\" rel=\"nofollow\">Twitter Web Client<\/a>","in_reply_to_status_id":null,"in_reply_to_status_id_str":null,"in_reply_to_user_id":null,"in_reply_to_user_id_str":null,"in_reply_to_screen_name":null,"user":{"id":3308503320,"id_str":"3308503320"},"geo":null,"coordinates":null,"place":null,"contributors":null,"is_quote_status":false,"retweet_count":0,"favorite_count":0,"favorited":false,"retweeted":false,"possibly_sensitive":false,"lang":"en"}]');

        $options = explode(",",$options);
        $tweets = $st->getTweets($user_name, $num);
        if($tweets){
            if (is_array($tweets) && isset($tweets['error'])) {
                if (is_array($tweets) && isset($tweets['error'][0]) && isset($tweets['error'][0]['message'])) {
                    $last_error = $tweets['error'][0]['message'];
                } else {
                    $last_error = $tweets['error'];
                }

                return $last_error;
            } else {
                $output .= '<div class="iw-tweet clearfix '.$class.'">';
                $output .= '<div class="tweet-content">';
                $output .= "<div class='owl-carousel' data-plugin-options='{" .$data_plugin_options. "}'>";
                foreach ($tweets as $key=>$tweet){
                    $tweet = (array)$tweet;
                    $output .= '<div class="'.($key == 0 ? 'active' : '').'">';
                    $output .= '<span class="tweet-icon"><i class="fa fa-twitter"></i></span><br>';
                    $output .= '<a href="http://twitter.com/'.$inwave_theme_option['tw_username'].'" class="twitter-author">@'.$tweet['display_name'].'</a>';
                    $msg = $tweet['text'];
                    if(in_array('encode_utf8', $options)) $msg = utf8_encode($msg);
                    if (in_array('hyperlinks', $options)) {
                        // match protocol://address/path/file.extension?some=variable&another=asf%
                        $msg = preg_replace('/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"$1\" class=\"twitter-link\">$1</a>", $msg);
                        // match www.something.domain/path/file.extension?some=variable&another=asf%
                        $msg = preg_replace('/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"http://$1\" class=\"twitter-link\">$1</a>", $msg);
                        // match name@address
                        $msg = preg_replace('/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i',"<a href=\"mailto://$1\" class=\"twitter-link\">$1</a>", $msg);
                        //NEW mach #trendingtopics
                        //$msg = preg_replace('/#([\w\pL-.,:>]+)/iu', '<a href="http://twitter.com/#!/search/\1" class="twitter-link">#\1</a>', $msg);
                        //NEWER mach #trendingtopics
                        $msg = preg_replace('/(^|\s)#(\w*[a-zA-Z_]+\w*)/', '\1<a href="http://twitter.com/#!/search/%23\2" class="twitter-link" target="_blank">#\2</a>', $msg);
                    }
                    if (in_array('twitter_users', $options))  {
                        $msg = preg_replace('/([\.|\,|\:|\¡|\¿|\>|\{|\(]?)@{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/$2\" class=\"twitter-user\">@$2</a>$3 ", $msg);
                    }

                    $output .= '<div class="twitter-message">'.$msg.'</div>';

                    $time = strtotime($tweet['created_at']);
                    $h_time = ( ( abs( time() - $time) ) < 86400 ) ? sprintf( __('%s ago'), human_time_diff( $time )) : date(__('Y/m/d'), $time);
                    $output .= '<span class="twitter-timestamp">'.$h_time.'</span>';
                    $output .= '</div>';
                    /* $link = 'http://twitter.com/#!/'.$options['username'].'/status/'.$message->id_str;*/
                }
                $output .= '</div>';
                $output .= '</div>';
                //$output .= '<a class="twitter-follow" href="https://twitter.com/intent/follow?original_referer='.urlencode($_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]).'®ion=follow_link&screen_name='.$inwave_theme_option['tw_username'].'&tw_p=followbutton&variant=2.0"><i class="fa fa-twitter"></i>'.__('Follow Us').'</a>';
                ob_start();
                echo $output
                ?>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                <?php
                $output = ob_get_contents();
                ob_end_clean();
                $output .= '</div>';
            }
        }

        echo (string)$output;

        echo $after_widget;
    }

}

/*
 * Khởi tạo widget item
 */
add_action( 'widgets_init', 'create_Twitter_Posts_Widget' );
function create_Twitter_Posts_Widget() {
    register_widget('Twitter_Posts_Widget');
}