<?php
/*
 * Inwave_Product_List for Visual Composer
 */
if (!class_exists('Inwave_Products')) {

    class Inwave_Products extends Inwave_Shortcode{

        protected $name = 'inwave_products';

        function get_categories(&$categories, $parent, $level) {

            $args = array(
                'taxonomy'     => 'product_cat',
                //'orderby'      => 'name',
                'show_count'   => 0,
                'pad_counts'   => 0,
                'hierarchical' => 1,
                'title_li'     => '',
                'hide_empty'   => 0,
                'parent' => $parent
            );

            $all_categories = get_categories( $args );
            //$categories = get_categories($arg);
            if($all_categories){
                foreach ($all_categories as $cat) {
                    $categories[str_repeat('— ', $level).$cat->name] = $cat->term_id;
                    $this->get_categories($categories, $cat->term_id, ($level + 1));
                }
            }
        }

        function init_params() {

            $categories = array();
            $categories[__("All", "inwavethemes")] = '';
            $this->get_categories($categories, 0, 0);
            return array(
                'name' => __('Woocommerce Products', 'inwavethemes'),
                'description' => __('Add list of products', 'inwavethemes'),
                'base' => $this->name,
                'icon' => 'iw-default',
                'category' => 'Custom',
                'params' => array(
                    array(
                        "type" => "dropdown",
                        "heading" => "Style",
                        "param_name" => "style",
                        "value" => array(
                            "Style 1 - Slider" => "style1",
                            "Style 2 - Slider V2" => "style2",
                        )
                    ),
                    array(
                        'type' => 'textfield',
                        "holder" => "div",
                        "heading" => __("Title", "inwavethemes"),
                        "value" => "Enter title",
                        "param_name" => "title"
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Display", "inwavethemes"),
                        "param_name" => "display",
                        "value" => array(
                            __("All", "inwavethemes") => "",
                            __("Recent Products", "inwavethemes") => "recent",
                            __("Featured Products", "inwavethemes") => "featured",
                            __("Top rated Products", "inwavethemes") => "top_rated",
                            __("Products on sale", "inwavethemes") => "on_sale",
                            __("Best selling products", "inwavethemes") => "best_sale"
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Product Category", "inwavethemes"),
                        "param_name" => "category",
                        "value" => $categories
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Sub categories", "inwavethemes"),
                        "param_name" => "sub_categories",
                        "value" => array(
                            __("No", "inwavethemes") => "0",
                            __("Yes", "inwavethemes") => "1",
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Order By", "inwavethemes"),
                        "param_name" => "order_by",
                        "value" => array(
                            __("Date", "inwavethemes") => "date",
                            __("Title", "inwavethemes") => "title",
                            __("Product ID", "inwavethemes") => "ID",
                            __("Name", "inwavethemes") => "name",
                            __("Price", "inwavethemes") => "price",
                            __("Sales", "inwavethemes") => "sales",
                            __("Random", "inwavethemes") => "rand",
                        )
                    ),
                    array(
                        "type" => "dropdown",
                        "heading" => __("Order Direction", "inwavethemes"),
                        "param_name" => "order_dir",
                        "value" => array(
                            __("Descending", "inwavethemes") => "desc",
                            __("Ascending", "inwavethemes") => "asc"
                        )
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Number of products", "inwavethemes"),
                        "param_name" => "limit",
                        "value" => 3
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Extra Class", "inwavethemes"),
                        "param_name" => "class",
                        "description" => __('If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', "inwavethemes")
                    )
                )
            );
        }

        // Shortcode handler function for list products woocommerce
        function init_shortcode($atts, $content = null) {
            $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( $this->name, $atts ) : $atts;
            global $woocommerce, $yith_wcwl;
            $output = $title = $limit = $function = $category = $order_by = $order_dir = $class = $style = '';
            extract(shortcode_atts(array(
                'title' => '',
                'limit' => '',
                'display' => '',
                'category' => '',
                'sub_categories' => '',
                'order_by' => '',
                'order_dir' => '',
                'class' => '',
                'style' => ''
             ), $atts));

            $args = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'posts_per_page' => $limit,
                'orderby' => $order_by,
                'order' => $order_dir,
            );
            switch ($display) {
                case 'recent':
                    $args['meta_query'] = WC()->query->get_meta_query();
                    break;
                case 'featured':
                    $args['meta_query'] = array(
                        array(
                            'key' => '_visibility',
                            'value' => array('catalog', 'visible'),
                            'compare' => 'IN'
                        ),
                        array(
                            'key' => '_featured',
                            'value' => 'yes'
                        )
                    );
                    break;
                case 'top_rated':
                    add_filter('posts_clauses', array(WC()->query, 'order_by_rating_post_clauses'));
                    $args['meta_query'] = WC()->query->get_meta_query();
                    break;
                case 'on_sale':
                    $product_ids_on_sale = wc_get_product_ids_on_sale();
                    $args['meta_query'] = array();
                    $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
                    $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
                    $args['post__in'] = $product_ids_on_sale;
                    break;
                case 'best_sale':
                    $args['meta_key'] = 'total_sales';
                    $args['orderby'] = 'meta_value_num';
                    $args['meta_query'] = array(
                        array(
                            'key' => '_visibility',
                            'value' => array('catalog', 'visible'),
                            'compare' => 'IN'
                        )
                    );
                    break;
            }
            if ($category) {
                $categories = array('' => $category);
                if($sub_categories){
                    $this->get_categories($categories, $category, 0);
                }
                $categories = array_values($categories);
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'product_cat',
                        'terms' => $categories,
                        'field' => 'term_id',
                        'operator' => 'IN'
                    )
                );
            }
            $query = new WP_Query($args);
            ob_start();
            switch ($style) {
                case 'style1':
                    ?>
                    <div class="iw-products style1">
                        <?php if($title){ ?>
                            <h3><?php echo $title; ?></h3>
                        <?php } ?>
                        <div class="product-carousel owl-carousel" data-plugin-options='{"autoPlay":false,"autoHeight":false,"singleItem":true,"navigation":false}'>
                            <?php
                            if ($query->have_posts()):
                                while ($query->have_posts()) : $query->the_post();
                                    $product = wc_get_product();
                                    $rating_count = $product->get_rating_count();
                                    $average      = $product->get_average_rating();
                                    ?>
                                    <div class="product-item woocommerce clearfix">
                                        <?php $img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full'); ?>
                                        <div class="product-image"><img src="<?php echo $img[0]; ?>" alt=""></div>
                                        <div class="product-content clearfix">
                                            <h3 class="product-title"><a href="<?php the_permalink(); ?>"><?php echo esc_html(get_the_title()); ?></a></h3>
                                            <div class="product-cat-rate">
                                                <?php echo wp_kses_post(wc_get_product_category_list($product->get_id(), ', ', '<div class="cat-list">', '</div>' )); ?>
                                                <?php if ( $rating_count > 0 ) : ?>
                                                    <div class="rating-box">
                                                        <div class="woocommerce-product-rating">
                                                            <div class="star-rating" title="<?php printf( esc_html__( 'Rated %s out of 5', 'woocommerce' ), $average ); ?>">
                                                            <span style="width:<?php echo ( ( $average / 5 ) * 100 ); ?>%">
                                                                <strong class="rating"><?php echo esc_html( $average ); ?></strong> <?php printf( esc_html__( 'out of %s5%s', 'woocommerce' ), '<span>', '</span>' ); ?>
                                                                <?php printf( _n( 'based on %s customer rating', 'based on %s customer ratings', $rating_count, 'woocommerce' ), '<span class="rating">' . $rating_count . '</span>' ); ?>
                                                            </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <div style="clear:both;"></div>
                                            </div>
                                            <div class="price-box">
                                                <?php echo wp_kses_post($product->get_price_html()); ?>
                                            </div>
                                        </div>
                                        <div class="product-btn">
                                            <?php
                                                $p_class = implode( ' ', array_filter( array(
                                                    'cart',
                                                    'product_type_' . $product->product_type,
                                                    $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                                                    $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : ''
                                                )));

                                                echo apply_filters( 'woocommerce_loop_add_to_cart_link',
                                                sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</a>',
                                                    esc_url( $product->add_to_cart_url() ),
                                                    esc_attr( isset( $quantity ) ? $quantity : 1 ),
                                                    esc_attr( $product->get_id() ),
                                                    esc_attr( $product->get_sku() ),
                                                    esc_attr($p_class),
                                                    '<i class="fa fa-cart-plus"></i>'.__('Cart', 'inwavethemes')
                                                ));
                                            ?>
                                            <?php
                                            if (defined( 'YITH_WCWL' ) ) {
                                                $link_classes = get_option( 'yith_wcwl_use_button' ) == 'yes' ? 'class="like add_to_wishlist single_add_to_wishlist button alt"' : 'class="like add_to_wishlist"';
                                                ?>
                                                <a href="<?php echo esc_url( add_query_arg( 'add_to_wishlist', $product->get_id() ) )?>" rel="nofollow" data-product-id="<?php echo $product->get_id() ?>" data-product-type="<?php echo $product->product_type?>" <?php echo $link_classes ?> >
                                                    <i class="fa <?php echo $yith_wcwl->is_product_in_wishlist($product->get_id()) ? 'fa-check' : 'fa-heart'; ?>"></i><?php echo __('Like', 'inwavethemes'); ?>
                                                </a>
                                                <img src="<?php echo esc_url( YITH_WCWL_URL . 'assets/images/wpspin_light.gif' ) ?>" class="ajax-loading" alt="loading" width="16" height="16" style="visibility:hidden" />
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                endwhile;
                                wp_reset_postdata();
                            endif;
                            ?>
                        </div>
                    </div>
                    <?php
                    break;
                case 'style2':
                    ?>
                    <div class="iw-products style2">
                        <?php if($title){ ?>
                            <h3 class="title-block"><?php echo $title; ?></h3>
                        <?php } ?>
                        <div class="product-carousel owl-carousel" data-plugin-options='{"autoPlay":false,"autoHeight":false,"singleItem":true,"navigation":true, "pagination":false}'>
                            <?php
                            if ($query->have_posts()):
                                while ($query->have_posts()) : $query->the_post();
                                    $product = wc_get_product();
                                    $rating_count = $product->get_rating_count();
                                    $average      = $product->get_average_rating();
                                    ?>
                                    <div class="product-item woocommerce clearfix">
                                        <?php $img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full'); ?>
                                        <div class="col-md-6 col-sm-6 product-image-wrap">
                                            <div class="img"><img src="<?php echo $img[0]; ?>" alt=""></div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 item-info-wrap">
                                            <div class="product-content clearfix">
                                                <h3 class="product-title"><a href="<?php the_permalink(); ?>"><?php echo esc_html(get_the_title()); ?></a></h3>
                                                <div class="product-cat-rate">
                                                    <?php if ( $rating_count > 0 ) : ?>
                                                        <div class="rating-box">
                                                            <span class="rating-title"><?php echo __( 'Christian Book', 'woocommerce' ) ?></span>
                                                            <div class="woocommerce-product-rating">
                                                                <div class="star-rating theme-color" title="<?php printf( esc_html__( 'Rated %s out of 5', 'woocommerce' ), $average ); ?>">
                                                        <span style="width:<?php echo ( ( $average / 5 ) * 100 ); ?>%">
                                                            <strong class="rating"><?php echo esc_html( $average ); ?></strong> <?php printf( esc_html__( 'out of %s5%s', 'woocommerce' ), '<span>', '</span>' ); ?>
                                                            <?php printf( _n( 'based on %s customer rating', 'based on %s customer ratings', $rating_count, 'woocommerce' ), '<span class="rating">' . $rating_count . '</span>' ); ?>
                                                        </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div style="clear:both;"></div>
                                                </div>
                                                <div class="price-box theme-color">
                                                    <?php echo wp_kses_post($product->get_price_html()); ?>
                                                </div>
                                            </div>
                                            <div class="product-btn">
                                                <?php
                                                $p_class = implode( ' ', array_filter( array(
                                                    'cart',
                                                    'product_type_' . $product->product_type,
                                                    $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                                                    $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : ''
                                                )));

                                                echo apply_filters( 'woocommerce_loop_add_to_cart_link',
                                                    sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</a>',
                                                        esc_url( $product->add_to_cart_url() ),
                                                        esc_attr( isset( $quantity ) ? $quantity : 1 ),
                                                        esc_attr( $product->get_id() ),
                                                        esc_attr( $product->get_sku() ),
                                                        esc_attr($p_class),
                                                        '<i class="fa fa-cart-plus"></i>'.__('Cart', 'inwavethemes')
                                                    ));
                                                ?>
                                                <?php
                                                if (defined( 'YITH_WCWL' ) ) {
                                                    $link_classes = get_option( 'yith_wcwl_use_button' ) == 'yes' ? 'class="like add_to_wishlist single_add_to_wishlist button alt"' : 'class="like add_to_wishlist"';
                                                    ?>
                                                    <a href="<?php echo esc_url( add_query_arg( 'add_to_wishlist', $product->get_id() ) )?>" rel="nofollow" data-product-id="<?php echo $product->get_id() ?>" data-product-type="<?php echo $product->product_type?>" <?php echo $link_classes ?> >
                                                        <i class="fa <?php echo $yith_wcwl->is_product_in_wishlist($product->get_id()) ? 'fa-check' : 'fa-heart'; ?>"></i><?php echo __('Like', 'inwavethemes'); ?>
                                                    </a>
                                                    <img src="<?php echo esc_url( YITH_WCWL_URL . 'assets/images/wpspin_light.gif' ) ?>" class="ajax-loading" alt="loading" width="16" height="16" style="visibility:hidden" />
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                endwhile;
                                wp_reset_postdata();
                            endif;
                            ?>
                        </div>
                    </div>
                    <?php
                    break;
            }
            $output .= ob_get_contents();
            ob_end_clean();

            return $output;
        }
    }
}

new Inwave_Products;
