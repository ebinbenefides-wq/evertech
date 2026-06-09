<div class="col-xl-3 col-lg-4">
                            <!-- Blog Sidebar Start -->
                            <div class="blog-sidebar">
                                
                            <!-- Sidebar Widget Start -->
<div class="sidebar-widget sidebar-widget-1">
    <!-- Widget Search Form Start -->
    <form class="search-form" action="<?php echo esc_url(home_url('/')); ?>" method="get">
        <input type="text" name="s" placeholder="Write your keyword..." value="<?php echo get_search_query(); ?>">
        <button type="submit"><i class="fas fa-search"></i></button>
    </form>
    <!-- Widget Search Form End -->
</div>
<!-- Sidebar Widget End -->


                                <!-- Sidebar Widget Start -->
                                <div class="sidebar-widget">
                                    <!-- Widget Title Start -->
                                    <div class="widget-title">
                                        <h3 class="title">Recent Posts</h3>
                                    </div>
                                    <!-- Widget Title End -->

                                    <!-- Widget Recent Post Start -->
                                    <div class="recent-posts">
                                        <ul>
                                            <?php
                                                $recent_posts = new WP_Query( array(
                                                    'posts_per_page' => 5, // Get the latest 5 posts
                                                    'post_status' => 'publish',
                                                    'ignore_sticky_posts' => true
                                                ) );
                                                
                                                if ( $recent_posts->have_posts() ) :
                                                    while ( $recent_posts->have_posts() ) : $recent_posts->the_post(); ?>
                                                        <li>
                                                            <a class="post-link" href="<?php the_permalink(); ?>">
                                                                
                                                                <div class="post-text">
                                                                    <h4 class="title"><?php the_title(); ?></h4>
                                                                    <span class="post-meta"><i class="far fa-calendar-alt"></i> <?php echo get_the_date(); ?></span>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    <?php endwhile;
                                                    wp_reset_postdata();
                                                else : ?>
                                                    <li><?php esc_html_e( 'No recent posts available.' ); ?></li>
                                                <?php endif; ?>
                                        </ul>
                                    </div>
                                    <!-- Widget Recent Post End -->
                                </div>

                                
                                <div class="sidebar-widget">
                                    <!-- Widget Title Start -->
                                    <div class="widget-title">
                                        <h3 class="title">Categories</h3>
                                    </div>
                                    <!-- Widget Title End -->

                                    <!-- Widget Category Start -->
                                    <ul class="category">
                                        <?php
                                        $categories = get_categories( array(
                                            'orderby' => 'name', // Orders categories by name
                                            'order'   => 'ASC', // Ascending order
                                        ) );

                                        foreach ( $categories as $category ) {
                                            // Get category link and post count
                                            $category_link = get_category_link( $category->term_id );
                                            $category_name = esc_html( $category->name );
                                            $category_count = $category->count;
                                            ?>
                                            <li class="cate-item">
                                                <a href="<?php echo esc_url( $category_link ); ?>">
                                                    <i class="flaticon-next"></i> <?php echo $category_name; ?>
                                                    <span class="post-count"><?php echo $category_count; ?></span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                    <!-- Widget Category End -->
                                </div>

                                <!-- Sidebar Widget End -->

                                <!-- Sidebar Widget Start -->
                                <div class="sidebar-widget">
    <!-- Widget Title Start -->
    <div class="widget-title">
        <h3 class="title">Tags</h3>
    </div>
    <!-- Widget Title End -->

    <!-- Widget Tag Start -->
    <ul class="sidebar-tag">
        <?php
        $tags = get_tags( array(
            'orderby' => 'name', // Orders tags by name
            'order'   => 'ASC', // Ascending order
        ) );

        if ( $tags ) {
            foreach ( $tags as $tag ) {
                // Get tag link and name
                $tag_link = get_tag_link( $tag->term_id );
                $tag_name = esc_html( $tag->name );
                ?>
                <li><a href="<?php echo esc_url( $tag_link ); ?>"><?php echo $tag_name; ?></a></li>
                <?php
            }
        } else {
            echo '<li>No tags found</li>';
        }
        ?>
    </ul>
    <!-- Widget Tag End -->
</div>

                                <!-- Sidebar Widget End -->
                            </div>
                            <!-- Blog Sidebar End -->
                        </div>