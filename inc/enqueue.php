<?php 

function custom_excerpt_length( $length ) {
   return 25;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 1 );

   function sunset_load_admin_scripts($hook) {
      // echo $hook;
      if('toplevel_page_theme-options' == $hook) { 
         wp_register_style( 'sunset_admin', get_template_directory_uri() . '/css/sunset.admin.css', array(), '1.0.0', 'all' );
         wp_enqueue_style( 'sunset_admin' );

         wp_enqueue_media(  );

         wp_register_script( 'sunset-admin-script', get_template_directory_uri() . '/js/sunset.admin.js', array('jquery'), '1.0.0', true );
         wp_enqueue_script('sunset-admin-script');
      } elseif ('theme-options_page_theme-css-options' == $hook) {
         wp_enqueue_style( 'ace', get_template_directory_uri() . '/css/sunset.ace.css', array(), '1.0.0', 'all' );

         wp_enqueue_script( 'ace', get_template_directory_uri() . '/js/ace/ace.js', array('jquery'), '1.2.1', true );
         wp_enqueue_script( 'ace_mode_js', get_template_directory_uri() . '/js/ace/mode-css.js', array( 'ace_code_highlighter_js' ), '1.2.1', true );
         wp_enqueue_script( 'sunset-custom-css', get_template_directory_uri() . '/js/sunset.customcss.js', array('jquery'), '1.0.0', true );

      } else {
         return;
      }

   }
 add_action( 'admin_enqueue_scripts', 'sunset_load_admin_scripts' );
 
 function sunset_load_wp_scripts() {
   wp_enqueue_script( 'sunsetjs', get_template_directory_uri() . '/js/sunset.js', array('jquery'), '1.0.0', true );   

}
add_action( 'wp_enqueue_scripts', 'sunset_load_wp_scripts' );