<article id="post-<?php the_ID(  ); ?>" <?php post_class(  ); ?>>
    <div class="rop">
    <header class="header">
    <?php $link = sunset_grab_url(); ?>
        <?php the_title( '<h3><a href="'. $link .'">', '</a></h3>' ); ?>
        
    </header>
    
    <footer>
        <?php echo sunset_post_footer(); ?>
    </footer>
    </div>
</article>
