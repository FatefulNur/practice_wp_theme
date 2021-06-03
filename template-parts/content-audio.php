<article id="post-<?php the_ID(  ); ?>" <?php post_class(  ); ?>>
    <div class="rop">
    <header class="header">
        <?php the_title( '<h3>', '</h3>' ); ?>
        <div class="meta">
            <?php echo sunset_post_meta(); ?>
        </div>
    </header>
    <div class="content">
        <?php 
           echo  sunset_get_embed_media(array('audio', 'iframe'));
        ?>
    </div>
    <footer>
        <?php echo sunset_post_footer(); ?>
    </footer>
    </div>
</article>
