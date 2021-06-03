<?php 

class Sunset_Profile_Widget extends WP_Widget {
    // setup widget name, description, etc...
    public function __construct()
    {
        $widget_ops = array(
            'classname' => 'sunset-profile-widget',
            'description' => 'Custom sunset profile widget'
        );
        parent::__construct('sunset_profile', 'Sunset Profile', $widget_ops);
    }

    // back-end display widget
    public function form($instance)
    {
        echo '<p><strong>No option for this widget</strong></p><p><a href="admin.php?page=theme-options">Click Here</a> for setup option</p>';
    }

    // front-end display of widget
    public function widget($args, $instance)
    {
        $profile = esc_attr( get_option( 'profile_pic' ) ) ;
        $firstName = esc_html( get_option( 'first_name' ) ) ;
        $lastName = esc_html( get_option( 'last_name' ) ) ;
        $fullName = "$firstName $lastName";
        $description = esc_html( get_option( 'user_description' ) ) ;

        echo $args['before_widget']; ?>

        <div class="img-container">
        <?php if($profile) { ?>
            <div id="profic-preview" class="propic" style="background-image: url(<?php print $profile; ?>);"></div>
        <?php } ?>
        </div>
        <h1 id="name" class="sunset-username"><?php print $fullName; ?></h1>
        <h2 id="desc" class="sunset-desc"><?php print $description; ?></h2>
        <div class="icons-wrapper">

        </div>

        <?php
        
        echo $args['after_widget'];
    }
}
add_action('widgets_init', function() {
    register_widget( 'Sunset_Profile_Widget' );
} );

/* Edit default wordpress widget */
function sunset_tag_cloud_font_change( $args ) {
    $args['smallest'] = 8;
    $args['largest'] = 9;

    return $args;
}
add_filter('widget_tag_cloud_args', 'sunset_tag_cloud_font_change');

function sunset_list_categories_output_change( $links ) {
	
	$links = str_replace('</a> (', '</a> <span>', $links);
	$links = str_replace(')', '</span>', $links);
	
	return $links;
	
}
add_filter( 'wp_list_categories', 'sunset_list_categories_output_change' );

/* Save post views */
function sunset_save_post_views($postID) {
    $metaKey = 'sunset_post_views';
    $views = get_post_meta( $postID, $metaKey, true );
    $count = (empty($views) ? 0 : $views);
    $count++;

    update_post_meta( $postID, $metaKey, $count );
    echo '<h1>' . $views . '</h1>';
}
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );

/* Popular posts widgets */
class Sunset_Popular_Post_Widget extends WP_Widget {

    // setup widget name, description, etc...
    public function __construct()
    {
        $widget_ops = array(
            'classname' => 'sunset-popular-posts-widget',
            'description' => 'Popular Post Widget'
        );
        parent::__construct('sunset_popular_widget', 'Sunset Popular post', $widget_ops);
    }

    public function form($instance)
    {
        $title = ( !empty($instance['title']) ? $instance['title'] : 'Popular Posts' );
        $total = ( !empty($instance['total']) ? absint($instance['total']) : 4 ); 

        $output = '<p>';
        $output .= '<label for="' . esc_attr($this->get_field_id('title')) . '">Title: </label>';
        $output .= '<input type="text" class="widefat" id="' . esc_attr($this->get_field_id('title')) . '" name="' . esc_attr($this->get_field_name('title')) . '" value="' . esc_attr( $title ) . '">';
        $output .= '</p>';
        $output .= '<p>';
        $output .= '<label for="' . esc_attr($this->get_field_id('total')) . '">Number of Posts: </label>';
        $output .= '<input type="number" class="widefat" id="' . esc_attr($this->get_field_id('total')) . '" name="' . esc_attr($this->get_field_name('total')) . '" value="' . esc_attr( $total ) . '">';
        $output .= '</p>';
        echo $output;
    }

    // update
    public function update( $new_instance, $old_instance )
    {
        $instance = array();
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['total'] = ( !empty( $new_instance['total'] ) ) ? absint(strip_tags( $new_instance['total'] )) : 0;

        return $instance;
    }

    // front-end display of widget
    public function widget($args , $instance)
    {
        $total = absint( $instance['total'] );
        $post_args = array(
            'post_type' => 'post',
            'posts_per_page' => $total,
            'meta_key'  => 'sunset_post_views',
            'orderby'   => 'meta_value_num',
            'order' => 'DESC'
        );
        $posts_query = new WP_Query($post_args);

        echo $args['before_widget']; 
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];

        }
        if($posts_query->have_posts(  )) : 
            echo '<ul>';
                while( $posts_query->have_posts(  ) ) : $posts_query->the_post();
                    echo '<li><a href="'. get_permalink(  ) .'">' . get_the_title(  ) . '</a></li>';
                    // echo '<div class="row"><div class="col-xs-12">'. sunset_post_footer( true ) .'</div></div>';
                endwhile;
            echo '</ul>';
        endif;
        echo $args['after_widget']; 
    }
}
add_action( 'widgets_init', function(){
    register_widget( 'Sunset_Popular_Post_Widget' );
} );