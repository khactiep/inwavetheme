<?php
/**
 * @package injob
 */
$inwave_theme_option = Inwave_Helper::getConfig();
$authordata = Inwave_Helper::getAuthorData();
$show_post_infor = 	(isset($inwave_theme_option['show_post_author']) && $inwave_theme_option['show_post_author'])
				|| 	(isset($inwave_theme_option['blog_category_title_listing']) && $inwave_theme_option['blog_category_title_listing'])
				|| 	(isset($inwave_theme_option['show_post_comment']) && $inwave_theme_option['show_post_comment']);

$post_format = get_post_format();
$contents = get_the_content();
$str_regux = '';
?>
<article id="post-<?php echo esc_attr(get_the_ID()); ?>" <?php post_class(); ?>>
    <div class="post-item fit-video">
		<div class="post-content">
            <div style="text-align: center; margin-bottom: 50px">
                <?php   $cat = get_the_category();
                        $cat_id = get_cat_ID($cat[0]->name);
                ?>
                <div class="cat_post"> <a href="<?php echo get_category_link($cat_id); ?>"> <?php echo $cat[0]->name; ?> </a> </div>
                <div class="title_post"><a href="<?php the_permalink();?>"><?php the_title();?></a></div>
                <div class="">Posted on <?php echo get_the_date('F j, Y');?></div>
            </div>
			<div class="featured-image">
				<?php
				switch ($post_format) {
					case 'video':
						$video = inwave_getElementsByTag('embed', $contents);
						$str_regux = $video[0];
						if ($video) {
							echo apply_filters('the_content', $video[0]);
						}
						break;

					default:
						if ($inwave_theme_option['featured_images_single']) {
                            $img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
                            $img_src = count($img) ? $img[0] : '';
                            echo '<img src="'.$img_src.'" style="width: 100%" alt="">';
						}
						break;
				}
				?>

                <div class="post-title-feature">
                    <?php if (is_sticky()){echo '<span class="feature-post">'.esc_html__('Feature', 'injob').'</span>';} ?>
                </div>
			</div>

                <div class="post-main-info">

                    <div class="post-content-desc <?php echo $inwave_theme_option['social_sharing_box'] ? 'padding-left' : '' ?>">
                        <div class="post-text">
                            <?php echo apply_filters('the_content', str_replace($str_regux, '', get_the_content())); ?>
                        </div>
                            <?php $posttags = get_the_tags();
                            if ($posttags){
                            $firsttag = true; ?>
                            <div class="post-tags">
                                TAGS<br>
                                <?php
                                    foreach ($posttags as $tag) {
                                        $tag_id = $tag->term_id;
                                        if ($firsttag) {?>
                                            <a href="<?php echo get_tag_link($tag_id);?>"> <?php echo $tag->name; ?></a>
                                            <?php $firsttag = false;
                                        } else echo ', ' . '<a href="'.get_tag_link($tag_id).'">'.$tag->name.'</a>';
                                    }?>
                            </div>
                                <?php } ?>
                            <?php get_template_part('blocks/social/social', 'line1');?>
                            <div class="row" style="margin-bottom: 40px">
                                <div class="prev_post col-md-6 col-sm-6 col-xs-6">
                                    <?php $prev_post = get_previous_post(true);
                                    if($prev_post){?>
                                        <div class="prevpost_thumbnail"><?php echo get_the_post_thumbnail($prev_post->ID);?></div>
                                        <div class="prevpost_title">
                                            <?php echo $prev_post->post_title;?><br>
                                            <a href="<?php echo get_permalink($prev_post->ID);?>" style="color: black"><?php echo esc_html('&larr; Previous posts', 'injob');?></a>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="newer_post col-md-6 col-sm-6 col-xs-6">
                                    <?php $next_post = get_next_post();
                                    if($next_post){?>
                                        <div class="nextpost_thumbnail" style="float: right"><?php echo get_the_post_thumbnail($next_post->ID);?></div>
                                        <div class="nextpost_title">
                                            <div style="float: right;"><?php echo $next_post->post_title;?></div><br>
                                            <a href="<?php echo get_permalink($next_post->ID);?>" style="color: black; float: right"><?php echo esc_html('Newer posts &rarr;', 'injob');?></a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php
                            wp_link_pages(array(
                                'before' => '<div class="page-links">' . esc_html__('Pages:', 'injob'),
                                'after' => '</div>',
                            ));
                            ?>
                    </div>
                </div>
        </div>

        <?php if ($inwave_theme_option['related_posts']): ?>
            <?php get_template_part('blocks/related', 'posts'); ?>
        <?php endif ?>

    </div>
</article><!-- #post-## -->