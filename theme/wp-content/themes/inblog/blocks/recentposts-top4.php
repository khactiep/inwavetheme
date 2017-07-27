<?php
/**
 * Created by PhpStorm.
 */
$post_args_my_query = array(
    'post_type'    =>    'post',
    'posts_per_page' => 4,
    'orderby' => 'date'
);
$my_query = new WP_Query( $post_args_my_query );
?>
<?php
$count=0;
$post_id;
if($my_query->have_posts()) 	while ( $my_query->have_posts() ) {
    $my_query->the_post();
    $count++;
    $post_id[$count]= get_the_ID();
}
?>
<div id="sidebar_top">
    <div class="row">
        <div class="col-md-12">
            <div>
                <?php
                $img_src= get_the_post_thumbnail_url($post_id[1]);
                $cat = get_the_category($post_id[1]);
                $cat_id = get_cat_ID($cat[0]->name);
                ?>
                <img src="<?php echo $img_src ?>" style="width: 100%">
                <div class="info_post" style="top: 30%">
                    <a href="<?php echo get_category_link($cat_id); ?>"><div class="cat_box"> <?php echo $cat[0]->name; ?> </div></a><br>
                    <div class="title_recent_post" style="font-size: 35pt;  line-height: 45pt; padding-top: 30px"> <?php echo get_the_title($post_id[1])?> </div>
                    <a href="<?php echo get_the_permalink($post_id[1])?>" title="<?php echo get_the_title($post_id[1])?>"><div class="readmore_box" style="margin-top: 30px"> read more </div></a>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div style="margin-top: 30px">
                <div class="md-item">
                    <?php
                    $img_src= get_the_post_thumbnail_url($post_id[2]);
                    $img_src=inwave_resize($img_src, 570,570, true);
                    $cat = get_the_category($post_id[2]);
                    $cat_id = get_cat_ID($cat[0]->name);
                    ?>
                    <img src="<?php echo $img_src ?>">
                    <div class="info_post" style="top: 40%">
                        <a href="<?php echo get_category_link($cat_id); ?>"><div class="cat_box"> <?php echo $cat[0]->name; ?> </div></a><br>
                        <div class="title_recent_post" style="font-size: 30pt; line-height: 40pt; padding-top: 20px"> <?php echo get_the_title($post_id[2])?> </div>
                        <a href="<?php echo get_the_permalink($post_id[2])?>" title="<?php echo get_the_title($post_id[2])?>"><div class="readmore_box" style="margin-top: 20px"> read more </div></a>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="sm-item">
                <?php
                $img_src= get_the_post_thumbnail_url($post_id[3]);
                $img_src=inwave_resize($img_src, 570,270, true);
                $cat = get_the_category($post_id[3]);
                $cat_id = get_cat_ID($cat[0]->name);
                ?>
                <img src="<?php echo $img_src ?>">
                <div class="info_post" style="top: 30%">
                    <a href="<?php echo get_category_link($cat_id); ?>"><div class="cat_box"> <?php echo $cat[0]->name; ?> </div></a><br>
                    <div class="title_recent_post" style="font-size: 28pt; line-height: 35pt; padding-top: 15px"> <?php echo get_the_title($post_id[3])?> </div>
                    <a href="<?php echo get_the_permalink($post_id[3])?>" title="<?php echo get_the_title($post_id[3])?>"><div class="readmore_box" style="margin-top: 15px"> read more </div></a>
                </div>

            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="sm-item">
                <?php
                $img_src= get_the_post_thumbnail_url($post_id[4]);
                $img_src=inwave_resize($img_src, 570,270, true);
                $cat = get_the_category($post_id[4]);
                $cat_id = get_cat_ID($cat[0]->name);
                ?>
                <img src="<?php echo $img_src ?>">
                <div class="info_post" style="top: 30%">
                    <a href="<?php echo get_category_link($cat_id); ?>"><div class="cat_box"> <?php echo $cat[0]->name; ?> </div></a><br>
                    <div class="title_recent_post" style="font-size: 28pt; line-height: 35pt; padding-top: 15px"> <?php echo get_the_title($post_id[4])?> </div>
                    <a href="<?php echo get_the_permalink($post_id[4])?>" title="<?php echo get_the_title($post_id[4])?>"><div class="readmore_box" style="margin-top: 15px"> read more </div></a>
                </div>

            </div>
        </div>
    </div>
</div>
