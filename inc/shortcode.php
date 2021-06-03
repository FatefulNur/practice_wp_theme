<?php 



add_shortcode( 'tooltip', 'sunset_tooltip' );
function sunset_tooptip( $atts = array() , $content = null ) {
    $atts = shortcode_atts( array(
        'placement' => 'top',
        'title' => ''
    ), $atts, 'tooptip' );
    return 'hellow';
}

function sunset_contact_form( $atts = array() , $content = null) {
    $atts = shortcode_atts( array(
        
    ), $atts, 'contact_form' );

    ob_start();
        include_once('settings_template/contact-form.php');
    return ob_get_clean();

}
add_shortcode( 'contact_form', 'sunset_contact_form' );