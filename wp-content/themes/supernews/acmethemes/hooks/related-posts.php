<?php
/**
 * Display related posts from same category
 *
 * @since supernews 1.0.0
 *
 * @param int $post_id
 * @return void
 *
 */
if ( !function_exists('supernews_related_post_below') ) :

    function supernews_related_post_below( $post_id ) {

        global $supernews_customizer_all_values;
        if( 0 == $supernews_customizer_all_values['supernews-show-related'] ){
            return;
        }
        $categories = get_the_category( $post_id );
        if ($categories) {
            $category_ids = array();
            foreach ($categories as $category) {
                $category_ids[] = $category->term_id;
            }
            ?>
            <h2 class="widget-title">
                <?php esc_html_e('Related posts', 'supernews'); ?>
            </h2>
            <ul class="featured-entries-col featured-related-posts">
                <?php
                $supernews_cat_post_args = array(
                    'category__in' => $category_ids,
                    'post__not_in' => array($post_id),
                    'post_type' => 'post',
                    'posts_per_page'      => 3,
                    'post_status'         => 'publish',
                    'ignore_sticky_posts' => true
                );
                $supernews_featured_query = new WP_Query($supernews_cat_post_args);

                while ( $supernews_featured_query->have_posts() ) : $supernews_featured_query->the_post();
                    $supernews_blog_no_image = '';
                    if( !has_post_thumbnail() ) {
                        $supernews_blog_no_image = 'blog-no-image';
                    }
                    ?>
                    <li class="acme-col-3 <?php echo $supernews_blog_no_image; ?>">
                        <!--post thumbnal options-->
                        <?php
                        if( has_post_thumbnail() ):
                            ?>
                            <div class="post-thumb">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail( 'thumbnail' );?>
                                </a>
                                <?php supernews_list_category(); ?>
                            </div><!-- .post-thumb-->
                            <?php
                            endif;
                        ?>
                        <div class="post-content">
                            <header class="entry-header">
                                <?php the_title( sprintf( '<h4 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' ); ?>
                                <div class="entry-meta">
                                    <?php if ( 'post' === get_post_type() ) : ?>
                                        <?php supernews_posted_on(); ?>
                                    <?php endif; ?>
                                    <?php supernews_entry_footer(); ?>
                                </div><!-- .entry-meta -->
                            </header><!-- .entry-header -->
                            <div class="entry-content">
                                <?php
                                $content = supernews_words_count( get_the_excerpt() );
                                echo '<div class="details">'. esc_html( $content ).'</div>';
                                ?>
                            </div><!-- .entry-content -->
                        </div>
                    </li>
                    <?php
                endwhile;
                wp_reset_query();
                ?>
            </ul>
            <div class="clearfix"></div>
            <?php
        }
    }

endif;

add_action( 'supernews_related_posts', 'supernews_related_post_below', 10, 1 );