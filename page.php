<?php get_header( ); ?>

    
    <main>
       
        <div class="container sunset-posts-container">
            <?php 

                if(have_posts(  )) :

                        while(have_posts(  )) : the_post(  );
                            get_template_part( 'template-parts/content', 'page' );
                        endwhile;

                    echo '</div>';
                endif;

            ?>
        </div>
    </main>

<?php get_footer( ); ?>
