<?php 
    $class = get_query_var( 'post-class' );
?>
<article id="post-<?php the_ID(  ); ?>" <?php post_class( $class ); ?>>
    <div class="rop">
    <header class="header">
    <div class="sunset_attch">
    <div class="image-st" style="background-image: url(<?php echo sunset_get_attachment(  ); ?>)">
            </div>
    </div>
        <div class="meta">
            <?php echo sunset_post_meta(); ?>
        </div>
    </header>
    <div class="content">
        
        <div class="excerpt">
            <?php echo the_content(); ?>
        </div>
    </div>
    <footer>
        <?php echo sunset_post_footer(); ?>
    </footer>
    </div>
</article>
