<article id="post-<?php the_ID(  ); ?>" <?php post_class(  ); ?>>
    <div class="rop">
    <header class="header">
        <?php the_title( '<h3>', '</h3>' ); ?>
        <div class="meta">
            <?php echo sunset_post_meta(); ?>
        </div>
    </header>
    <div class="content">
        <?php if(sunset_get_attachment(  )) : ?>
            
            <div class="image-st" style="background-image: url(<?php echo sunset_get_attachment(  ); ?>)">
            </div>
        <?php endif; ?>
        <div class="excerpt">
            <?php echo wpautop(get_the_excerpt(  )); ?>
        </div>
        <div class="button-container">
            <a href="<?php the_permalink(  ); ?>"><?php _e( 'Read More' ); ?></a>
        </div>
        <?php comments_template(  ); ?>
    </div>
    <footer>
        <?php echo sunset_post_footer(); ?>
    </footer>
    </div>
</article>
