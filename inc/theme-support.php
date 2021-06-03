<?php 

add_action( 'wp_head', 'display_custom_css' );
 
function display_custom_css() {

    $custom_css = get_option( 'sunset_css' );
    if ( ! empty( $custom_css ) ) { ?>
    <style type="text/css">
        <?php
        echo '/* Custom CSS */' . "\n";
        echo $custom_css . "\n";
        ?>
    </style>
        <?php
    }
}

$options = get_option( 'post_formats' );
$formats = array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat');
$output = array();
foreach($formats as $format) {
    $output[] = (isset($options[$format])) == 1 ?  $format : '';
    if(!empty($options[$format])) {
        add_theme_support( 'post-formats',  $output);
    }
}
$header = get_option( 'custom_header' );
$background = get_option( 'custom_background' );
if($header == 1) {
    add_theme_support( 'custom-header' );
}
if($background == 1) {
    add_theme_support( 'custom-background' );
}

// Sidebar Register
function sunset_sidebar_init() {
    register_sidebar( array(
        'name'          => __( 'Sunset Sidebar', 'textdomain' ),
        'id'            => 'sunset-sidebar',
        'description'   => __( 'Right Sidebar', 'textdomain' ),
        'before_widget' => '<section id="%1$s" class="sunset-widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="sunset-widgettitle">',
        'after_title'   => '</h2>',
    ) );
}
add_action('widgets_init', 'sunset_sidebar_init');


// custom function
function sunset_post_meta() {
    $posted_on = human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) );

    $categories = get_the_category();
    $sepator = ', ';
    $output = '';
    $i = 1;
    if(!empty($categories)) {
        foreach ($categories as $category) {
            if($i > 1) :  $output .= $sepator;  endif;
            $output .= '<a href="'. esc_url( get_category_link( $category->term_id ) ) .'">'.esc_html__( $category->name ).'</a>';
            $i++;
        }
    }

    return '<span class="posted-on"> <a href="'.esc_url( get_permalink(  ) ).'">'. $posted_on .'</a> ago</span> / <span class="posted-in">'. $output .'</span>';
}
function sunset_post_footer($onlyComments = false) {
    global $post;
    $comment_num = get_comments_number( $post->ID );
    $comment = '';
    if(  comments_open( )) {
        if($comment_num == 0) {
            $comment = 'No Comments' ;
        } elseif($comment_num > 1) {
            $comment = $comment_num .  'Comments' ;
        } else {
            $comment = '1 Comment' ;
        }
        $comment = '<a href="'. get_comment_link( $post->ID ) .'">'.$comment .'</a>' ;
    } else {
        $comment = 'Comments are closed';
    }
    if ($onlyComments) {
		return $comment;
	}
    return 
    '<div class="rop">
        <div class="col-6">
            '. get_the_tag_list( '<span>', ' ', '</span>' ) .'
        </div>
        <div class="col-6">
            '. $comment .'
        </div>
    </div>';
}
function sunset_get_attachment() {
    $output = '';
        if(has_post_thumbnail(  )) :
            $output = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID(  )) );
        else:
            $attachments = get_posts( array(
                'post_type'      => 'attachment',
                'numberposts' => 1,
                'post_mime_type' => 'image',
                'post_parent' => 97,
                'cache_results'  => false,
                'update_post_meta_cache' => false,
                'update_post_term_cache' => false
            ) );
            
           if($attachments) :
                foreach($attachments as $attachment) :
                        $output = $attachment->guid;
                endforeach;
                // $output = $attachments;
                // echo '<pre>';
                // var_dump($attachments);
                // echo '</pre>';
            endif;
            wp_reset_postdata(  );
        endif; 
    
   return $output;
}
function sunset_get_embed_media($type=array()) {
    $content = do_shortcode( apply_filters( 'the_content', get_the_content( ) ) );
            $embed = get_media_embedded_in_content( $content, $type );
            return str_replace('?visual=true', '?visual=false', $embed[0]);
}
function sunset_grab_url() {
    if(!preg_match('/<a\s[^>]*?href=[\'"](.+?)[\'"]/i', get_the_content(), $link )) {
        return false;
    }
    return esc_url_raw( $link[1] );
}

function sunset_grab_current_uri() {
    $http = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
    $referer = $http . $_SERVER['HTTP_HOST'];
    $archive_url =  $referer . $_SERVER["REQUEST_URI"];

    return $archive_url;
}

function sunset_post_navigation() {
    $nav = '<div class="row">';

    $prev = get_previous_post_link( '<div class="post-link-nav">%link</div>', '%title' );
    $nav .= '<div class="col-xs-12 col-sm-6">'. $prev .'</div>';
    $next = get_next_post_link( '<div class="post-link-nav">%link</div>', '%title' );
    $nav .= '<div class="col-xs-12 col-sm-6">'. $next .'</div>';

    $nav .= '</div>';
    return $nav;
}

function sunset_share_this( $content ) {
    if(is_single(  )) {

        $content .= '<div class="sunset-share">';
    
        $title = get_the_title();
        $permalink = get_permalink();
        $twitterHandler = get_option( 'twitter_handler' ) ? '&amp;via='. esc_attr(get_option( 'twitter_handler' )) : '';
    
        $twitter = 'https://twitter.com/intent/tweet?text='. $title .'&amp;url='. $permalink . $twitterHandler;
        $facebook = 'https://facebook.com/sharer.php?u=' . $permalink;
        $google = 'https://plus.google.com/share?url='. $permalink;
                
        $content .= "<ul>
                <li><a href=' $facebook; '>facebook</a></li>
                <li><a href='  $twitter; '>twit</a></li>
                <li><a href='  $google; '>plus</a></li>
            </ul>
        </div>";
        return $content;

    } else {
        return $content;
    }
}
add_filter('the_content', 'sunset_share_this');



// php mailer mailtrap

function mailtrap($phpmailer) {
    $phpmailer->isSMTP();
    $phpmailer->Host = 'smtp.mailtrap.io';
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 2525;
    $phpmailer->Username = 'a34619580f7600';
    $phpmailer->Password = '07efb77c0eb44c';
  }
  
  add_action('phpmailer_init', 'mailtrap');