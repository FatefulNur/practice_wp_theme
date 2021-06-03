<article id="post-<?php the_ID(  ); ?>" <?php post_class(  ); ?>>
    <div class="rop">
    <header class="header">
        <h2><?php echo get_the_content( ); ?></h2>
        <?php the_title( '<h5>', '</h5>' ); ?>
        
    </header>
    
    <footer>
        <?php echo sunset_post_footer(); ?>
    </footer>
    </div>
</article>
