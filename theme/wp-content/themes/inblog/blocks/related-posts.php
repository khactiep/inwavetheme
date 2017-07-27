<?php
$post = get_post();
$tags = wp_get_post_tags($post->ID);
if ($tags) {
$tag_ids = array();
foreach ($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
$args = array(
	'tag__in' => $tag_ids,
	'post__not_in' => array($post->ID),
	'posts_per_page' => 3, // Number of related posts to display.
	'ignore_sticky_posts' => 1
);

$my_query = new wp_query($args);
if($my_query->have_posts()){
$authordata = Inwave_Helper::getAuthorData();
?>
<div class="related-posts">
        <?php
        $tag = get_the_tags();
                    $firsttag = $tag[0]->term_id;
                    $arg = array(
                        'tag__in' => array($firsttag),
                        'post__not_in' => array($post->ID),
                        'posts_per_page' => 3,
                        'caller_get_posts' => 1
                    );
                    $my_query = new WP_query($arg);
                    if ($my_query->have_posts()) {?>
                        <div class="row">
                            <div style="text-align: center; color: black">RELATED POSTS</div>
                            <?php while ($my_query->have_posts()) { ?>
                            <?php $my_query->the_post(); ?>
                            <div class="col-md-4 col-xs-12 col-sm-4">
                                <div class="related-post" style="background-image: url(<?php the_post_thumbnail_url();?>); background-size: cover">
                                    <?php
                                    echo '<div class="date_box">'.get_the_date().'</div><br>';
                                    echo '<a href="'.get_the_permalink().'"><div class="title-related-post">'.get_the_title().'</div></a>';
                                ?>
                                </div>
                            </div>
                            <?php }?>
                        </div>
                    <?php }?>
</div>
<?php }
} ?>