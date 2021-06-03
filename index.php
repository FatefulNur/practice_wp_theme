<?php get_header( ); ?>

    
    <main>
        <?php if(is_paged(  )) : ?>
            <div class="container container-load-previous">
                <a data-prev="1" data-page ="<?php echo sunset_check_paged(1); ?>" data-url="<?php echo admin_url( 'admin-ajax.php' ); ?>" class="btn btn-lg btn-default btn-ajax-load">
                <i class="fas fa-sync-alt">&omega;</i>
                <span class="text">Load Previous</span>
                </a>
            </div>
        <?php endif; ?>
        <div class="container sunset-posts-container">
            <?php 

                if(have_posts(  )) :

                    echo '<div class="page-limit" data-page="' . $_SERVER["REQUEST_URI"] .sunset_check_paged(). '">';

                        while(have_posts(  )) : the_post(  );
                            /* $class = 'reveal';
                            set_query_var( 'post-class', $class ); */
                            get_template_part( 'template-parts/content', get_post_format(  ) );
                        endwhile;

                    echo '</div>';
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
