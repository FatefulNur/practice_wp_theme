<article id="post-<?php the_ID(  ); ?>" <?php post_class( 'sunset-post-image' ); ?>>
    
        <header class="image-st" style="background-image: url(<?php echo sunset_get_attachment(); ?>)">
        </header>
        <?php the_title( '<h3>', '</h3>' ); ?>
        <div class="meta">
            <?php echo sunset_post_meta(); ?>
        </div>
        <div class="excerpt">
            <?php echo wpautop(get_the_excerpt(  )); ?>
        </div>
    <footer>
        <?php echo sunset_post_footer(); ?>
    </footer>
</article>
