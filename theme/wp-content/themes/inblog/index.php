<?php
/**
 * The template for displaying Category pages
 * @package injob
 */
get_header();?>
        <?php if(isset($inwave_theme_option['show_top4_recent_posts']) && $inwave_theme_option['show_top4_recent_posts']){
            get_template_part('blocks/headerbackground/header', 'big');
        } else {
            get_template_part('blocks/headerbackground/header', 'small');
         }
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

<div class="page-content iw-category blog-list">
    <div class="container">
    <?php if(isset($inwave_theme_option['show_top4_recent_posts']) && $inwave_theme_option['show_top4_recent_posts']){ ?>
        <?php get_template_part('blocks/recentposts', 'top4');?>
    </div>
    <?php } ?>
    <?php if(isset($inwave_theme_option['show_top4_recent_posts']) && $inwave_theme_option['show_top4_recent_posts']) $firstpost_id=$post_id[4]; else $firstpost_id=$post_id[1]+1; ?>
    <div class="container">
    <div class="main-content">
		<div class="row">
			<div class="col-md-9 col-sm-12 col-xs-12">
				<div class="content">
				<?php
				if (have_posts())
                    while (have_posts()) {
                        the_post();
                        if (get_the_ID() < $firstpost_id) {
                            ?>
                                <?php   $cat = get_the_category();
                                        $cat_id = get_cat_ID($cat[0]->name);
                                ?>
                            <div class="cat_post"><a href="<?php echo get_category_link($cat_id); ?>"> <?php echo $cat[0]->name; ?> </a></div>
                            <div class="title_post"><a href="<?php the_permalink();?>"><?php the_title(); ?></a> </div>
                                <div class="date_post"><?php echo get_the_date('F j, Y'); ?></div>

                            <div style="margin-bottom: 40px; margin-top: 60px">
                                <img src="<?php echo get_the_post_thumbnail_url(); ?>" style="width: 100%">
                            </div>
                            <div class="post_content"><?php the_excerpt(); ?></div>
                            <?php get_template_part('blocks/social/social', 'line1');?>
                            <?php
                        }
                    }
                    pagination_nav();
				?>
				</div>
				
			</div>
			<div class="col-md-3 col-sm-6 col-xs-6">
                <div class="sidebar_right">
                    <?php
                    if ( is_active_sidebar('right_sidebar') ) {
                        dynamic_sidebar( 'right_sidebar' );
                    }
                    ?>
                </div>
			</div>
			
		</div>

	</div>
    </div>
</div>

<?php get_footer(); ?>