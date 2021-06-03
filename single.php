<?php get_header( ); ?>

    
    <main>
        
        <div class="container">
            <?php 

                if(have_posts(  )) :

                        while(have_posts(  )) : the_post(  );
                        sunset_save_post_views( get_the_ID(  ) );
                            get_template_part( 'template-parts/single', get_post_format(  ) );
                            echo sunset_post_navigation(  );

                            if(comments_open(  )) {
                                comments_template(  );
                            }
                        endwhile;

                endif;

            ?>
        </div>
        <div class="container">
            <a data-page ="<?php echo sunset_check_paged(1); ?>" data-url="<?php echo admin_url( 'admin-ajax.php' ); ?>" class="btn btn-lg btn-default btn-ajax-load">
            <i class="fas fa-sync-alt">&omega;</i>
            <span class="text">Load More</span>
            </a>
        </div>
    </main>

<?php get_footer( ); ?>
