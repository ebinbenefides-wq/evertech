<?php get_header(); ?>

        

        <!-- Blog Standard Start -->
        <div class="section blog-standard-section section-padding-02 mb-4">
            <div class="container">
                <!-- Blog Standard Wrap Start -->
                <div class="blog-standard-wrap">
                    <div class="row">
                        <div class="col-xl-8 col-lg-8">
                            <!-- Blog Post Wrap Start -->
                            <div class="blog-post-wrap">
                                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                                    <!-- Single Blog Start -->
                                    <div class="single-blog-post single-blog">
                                        <div class="blog-image">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php if ( has_post_thumbnail() ) : ?>
                                                    <?php the_post_thumbnail( 'large' ); ?>
                                                <?php else : ?>
                                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/default-cover.jpg" alt="<?php the_title(); ?>">
                                                <?php endif; ?>
                                            </a>
                                            <div class="top-meta">
                                                <span class="date">
                                                    <span><?php echo get_the_date( 'd' ); ?></span><?php echo get_the_date( 'M' ); ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="blog-content">
                                            <div class="blog-meta">
                                                <span class="tag"><i class="far fa-bookmark"></i> <?php the_category( ', ' ); ?></span>
                                                <!--<span><i class="fas fa-user"></i> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a></span>
                                                <span><i class="far fa-comments"></i> <?php comments_number( '0 Comments', '1 Comment', '% Comments' ); ?></span>-->
                                            </div>
                                            <h3 class="title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h3>
                                            <p class="text"><?php echo wp_trim_words( get_the_content(), 20, '...' ); ?></p>
                                            <div class="blog-btn">
                                                <a class="blog-btn-link" href="<?php the_permalink(); ?>">Read Full <i class="fas fa-long-arrow-alt-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Blog End -->
                                <?php endwhile; else : ?>
                                    <p><?php esc_html_e( 'No posts found.' ); ?></p>
                                <?php endif; ?>

                                <!-- Page Pagination Start -->
                                <div class="techwix-pagination">
                                    <ul class="pagination justify-content-center">
                                        <?php
                                        global $wp_query;

                                        // Get total pages
                                        $total_pages = $wp_query->max_num_pages;

                                        if ( $total_pages > 1 ) {
                                            // Get current page
                                            $current_page = max( 1, get_query_var( 'paged' ) );

                                            // Previous Page Link
                                            if ( $current_page > 1 ) {
                                                $prev_page = get_previous_posts_page_link();
                                                echo '<li><a href="' . esc_url( $prev_page ) . '"><i class="fa fa-angle-left"></i></a></li>';
                                            }

                                            // Loop through all pages
                                            for ( $i = 1; $i <= $total_pages; $i++ ) {
                                                if ( $i == $current_page ) {
                                                    // Current page, add active class
                                                    echo '<li><a class="active" href="' . esc_url( get_pagenum_link( $i ) ) . '">' . $i . '</a></li>';
                                                } else {
                                                    // Normal page link
                                                    echo '<li><a href="' . esc_url( get_pagenum_link( $i ) ) . '">' . $i . '</a></li>';
                                                }
                                            }

                                            // Next Page Link
                                            if ( $current_page < $total_pages ) {
                                                $next_page = get_next_posts_page_link();
                                                echo '<li><a href="' . esc_url( $next_page ) . '"><i class="fa fa-angle-right"></i></a></li>';
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>

                                <!-- Page Pagination End -->
                            </div>

                            <!-- Blog Post Wrap Ed -->
                        </div>
                        <?php get_sidebar(); ?>
                    </div>
                </div>
                <!-- Blog Standard Wrap End -->
            </div>
        </div>
        <!-- Blog Standard End -->

        


        <?php get_footer(); ?>

        <!-- back to top start -->
        <div class="progress-wrap">
            <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
            </svg>
        </div>
        <!-- back to top end -->

    </div>

    <!-- JS
    ============================================ -->
    <script src="<?php echo get_template_directory_uri();?>/assets/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="<?php echo get_template_directory_uri();?>/assets/js/vendor/modernizr-3.11.2.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="<?php echo get_template_directory_uri();?>/assets/js/plugins/popper.min.js"></script>
    <script src="<?php echo get_template_directory_uri();?>/assets/js/plugins/bootstrap.min.js"></script>

    <!-- Plugins JS -->
    <script src="<?php echo get_template_directory_uri();?>/assets/js/plugins/swiper-bundle.min.js"></script>
    <script src="<?php echo get_template_directory_uri();?>/assets/js/plugins/aos.js"></script>
    <script src="<?php echo get_template_directory_uri();?>/assets/js/plugins/waypoints.min.js"></script>
    <script src="<?php echo get_template_directory_uri();?>/assets/js/plugins/back-to-top.js"></script>
    <script src="<?php echo get_template_directory_uri();?>/assets/js/plugins/jquery.counterup.min.js"></script>
    <script src="<?php echo get_template_directory_uri();?>/assets/js/plugins/appear.min.js"></script>
    <script src="<?php echo get_template_directory_uri();?>/assets/js/plugins/jquery.magnific-popup.min.js"></script>


    <!--====== Use the minified version files listed below for better performance and remove the files listed above ======-->


    <!-- Main JS -->
    <script src="<?php echo get_template_directory_uri();?>/assets/js/main.js"></script>

</body>

</html>