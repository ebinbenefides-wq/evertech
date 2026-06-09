<?php get_header(); ?>


        <!-- Blog Details Start -->
        <div class="section blog-details-section section-padding-02 mb-4">
            <div class="container">
                <!-- Blog Details Wrap Start -->
                <div class="blog-details-wrap">
                    <div class="row">
                        <div class="col-xl-8 col-lg-8">
                            <!-- Blog Details Post Start -->
                            <div class="blog-details-post">
                                <!-- Single Blog Start -->
                                <div class="single-blog-post single-blog">
                                    <!-- Blog Image -->
                                    <div class="blog-image">
                                        <?php if ( has_post_thumbnail() ) : ?>
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail( 'large' ); ?>
                                            </a>
                                            <?php else : ?>
                                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/default-cover.jpg" alt="<?php the_title(); ?>">
                                                <?php endif; ?>
                                        <div class="top-meta">
                                            <span class="date">
                                                <span><?php echo get_the_date( 'd' ); ?></span><?php echo get_the_date( 'M' ); ?>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Blog Content -->
                                    <div class="blog-content">
                                        <div class="blog-meta">
                                            <!-- Category List -->
                                            <span class="tag">
                                                <i class="far fa-bookmark"></i> 
                                                <?php the_category( ' / ' ); ?>
                                            </span>
                                            <!-- Author Info -->
                                           
                                        </div>

                                        <!-- Post Title -->
                                        <h3 class="title"><?php the_title(); ?></h3>

                                        <!-- Post Content -->
                                        <p class="text">
                                            <?php the_content(); ?>
                                        </p>
                                    </div>
                                </div>
                                <!-- Single Blog End -->

                                <!-- Comments Template -->
                                
                            </div>

                            <!-- Blog Details Post End -->
                        </div>
                        <?php get_sidebar(); ?>
                    </div>
                </div>
                <!-- Blog Details Wrap End -->
            </div>
        </div>
        <!-- Blog Details End -->

        


        <?php get_footer(); ?>