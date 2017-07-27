<?php
/**
 * The default template for displaying content quote
 * @package injob
 */
$authordata = Inwave_Helper::getAuthorData();
$inwave_theme_option = Inwave_Helper::getConfig();
$show_post_infor = inwave_show_post_info();
?>


<div class="iw-posts element-item col-md-4 col-sm-6 col-xs-12">
    <article id="post-<?php echo esc_attr(get_the_ID()); ?>" <?php post_class(); ?>>
        <div class="post-item post-item-quote">
            <div class="post-image">
                <?php
                $img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
                $img_src = count($img) ? $img[0] : '';
                if(!$img_src){
                    $img_src = inwave_get_placeholder_image();
                }
                $img_src = inwave_resize($img_src, 370, 370, true);
                ?>
                <img src="<?php echo $img_src; ?>" alt="">
            </div>
            <div class="post-content">
                <?php if (is_sticky()){echo '<span class="feature-post">'.esc_html__('Feature', 'injob').'</span>';} ?>
                <div class="post-category-date">
                    <?php if(isset($inwave_theme_option['blog_category_title_listing']) && $inwave_theme_option['blog_category_title_listing']): ?>
                        <span class="post-category"><?php the_category(', ') ;?> - </span>
                    <?php endif; ?>
                    <?php if(isset($inwave_theme_option['show_post_date']) && $inwave_theme_option['show_post_date']){ ?>
                        <span class="post-date"><?php echo get_the_date("d. F. Y"); ?></span>
                    <?php } ?>
                </div>
                <div class="post-main-info">
                    <h3 class="post-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title('', ''); ?></a>
                    </h3>
                    <div class="post-quote post-desc">
                        <i class="fa fa-quote-left"></i>
                        <div class="quote-text">
                            <?php
                            $post = get_post();
                            $quote = inwave_getElementsByTag('blockquote', $post->post_content, 3);
                            $text = $quote[2];
                            $text = ltrim($text, '"');
                            $text = rtrim($text, '"');
                            echo wp_trim_words(wp_kses_post($text), 15);
                            ?>
                        </div>
                    </div>
                    <?php if ($show_post_infor){ ?>
                        <div class="post-bottom">
                            <?php if(isset($inwave_theme_option['show_post_author']) && $inwave_theme_option['show_post_author']){ ?>
                                <span class="post-author">
                                <?php echo esc_html__('by', 'injob'); ?> <span><?php echo get_the_author_link(); ?></span>
                            </span>
                            <?php } ?>
                            <?php
                            if(isset($inwave_theme_option['show_post_comment']) && $inwave_theme_option['show_post_comment']){
                                if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
                                    echo '<span class="post-comment-count"> - ';
                                    comments_popup_link(esc_html__('0 comment', 'injob'), esc_html__('1 Comment', 'injob'), esc_html__('% Comments', 'injob'));
                                    echo '</span>';
                                }
                            }
                            ?>
                            <?php echo '<a class="post-read-more theme-color" href="' . esc_url(get_the_permalink()) . '"><i class="iwj-icon icon-right-small"></i>'.esc_html__('Read more', 'injob') .'</a>'; ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php if($inwave_theme_option['social_sharing_box_category']): ?>
                <div class="post-social-share">
                    <?php
                    inwave_social_sharing(get_permalink(), Inwave_Helper::substrword(get_the_excerpt(), 10), get_the_title());
                    ?>
                </div>
            <?php endif; ?>

<!--                    <div class="post-content-desc">-->
<!--                        <div class="post-text">-->
<!--                            --><?php //the_excerpt(); ?>
<!--                        </div>-->
<!--                        --><?php //if (isset($inwave_theme_option['show_post_tag']) && $inwave_theme_option['show_post_tag']): ?>
<!--                                --><?php //inwave_blog_post_tag(); ?>
<!--                            --><?php //endif ?>
<!--                        <div class="post-content-footer">-->
<!--                            --><?php //echo '<a class="more-link" href="' . esc_url(get_the_permalink()) . '">'.esc_html__('Read more', 'injob') .'</a>'; ?>
<!--                            --><?php //if($inwave_theme_option['social_sharing_box_category']): ?>
<!--                                <div class="post-share-buttons-cat">-->
<!--                                    --><?php
//                                    inwave_social_sharing_category_listing(get_permalink(), Inwave_Helper::substrword(get_the_excerpt(), 10), get_the_title());
//                                    ?>
<!--                                </div>-->
<!--                            --><?php //endif; ?>
<!--                        </div>-->
<!--                        --><?php //edit_post_link( esc_html__( 'Edit', 'injob' ), '<span class="edit-link">', '</span>' );?>
<!--                    </div>-->

            <div class="clearfix"></div>

        </div>

    </article><!-- #post-## -->
</div>