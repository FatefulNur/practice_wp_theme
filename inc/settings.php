<?php 

function sun_add_admin_page() {
    // admin menu page
    add_menu_page( 'Theme Options Title', 'Theme Options', 'manage_options', 'theme-options', 'theme_option_page', 'dashicons-welcome-add-page', 110 );

    // admin submenu pages
    add_submenu_page( 'theme-options', 'Sidebar Options', 'Sidebar', 'manage_options', 'theme-options', 'theme_option_page' );
    add_submenu_page( 'theme-options', 'Sunset Theme Setup', 'Theme Setup', 'manage_options', 'theme-setup', 'theme_setup_page' );
    add_submenu_page( 'theme-options', 'Sunset Contact Form', 'Contact Form', 'manage_options', 'theme-contact', 'theme_contact_page' );
    add_submenu_page( 'theme-options', 'CSS Options', 'Custom CSS', 'manage_options', 'theme-css-options', 'theme_css_page' );

    // Activate Custom Settings
    add_action( 'admin_init', 'custom_settings' );
}
add_action( 'admin_menu', 'sun_add_admin_page' );
function custom_settings() {
    // Sidebar Options
    register_setting( 'sunset-settings-group', 'profile_pic' );
    register_setting( 'sunset-settings-group', 'first_name' );
    register_setting( 'sunset-settings-group', 'last_name' );
    register_setting( 'sunset-settings-group', 'user_description' );
    register_setting( 'sunset-settings-group', 'twitter_handler', 'sunset_sanitize_twitter_handler' );
    register_setting( 'sunset-settings-group', 'facebook_handler' );
    register_setting( 'sunset-settings-group', 'gplus_handler' );

    add_settings_section( 'sunset-sidebar-options', 'Sidebar Option', 'sunset_sidebar_options', 'theme-options' );

    add_settings_field( 'sidebar-profile-pic', 'Profile Picture', 'sunset_sidebar_profile', 'theme-options', 'sunset-sidebar-options' );
    add_settings_field( 'sidebar-name', 'Full Name', 'sunset_sidebar_name', 'theme-options', 'sunset-sidebar-options' );
    add_settings_field( 'sidebar-description', 'Description', 'sunset_sidebar_description', 'theme-options', 'sunset-sidebar-options' );
    add_settings_field( 'sidebar-twitter', 'Twitter Handler', 'sunset_sidebar_twitter', 'theme-options', 'sunset-sidebar-options' );
    add_settings_field( 'sidebar-facebook', 'Facebook Handler', 'sunset_sidebar_facebook', 'theme-options', 'sunset-sidebar-options' );
    add_settings_field( 'sidebar-gplus', 'Google+ Handler', 'sunset_sidebar_gplus', 'theme-options', 'sunset-sidebar-options' );

    // Theme Setup Options
    register_setting( 'sunset-theme-setup', 'post_formats' );
    register_setting( 'sunset-theme-setup', 'custom_header' );
    register_setting( 'sunset-theme-setup', 'custom_background' );

    add_settings_section( 'sunset-theme-setup-section', 'Theme Setup', 'sunset_theme_setup', 'theme-setup' );

    add_settings_field( 'post-formats', 'Post Formats', 'sunset_post_formats', 'theme-setup', 'sunset-theme-setup-section' );
    add_settings_field( 'custom-header', 'Custom Heder', 'sunset_custom_header', 'theme-setup', 'sunset-theme-setup-section' );
    add_settings_field( 'custom-background', 'Custom Background', 'sunset_custom_background', 'theme-setup', 'sunset-theme-setup-section' );

    // Contact Form Options
    register_setting( 'sunset-contact-options', 'activate_contact' );

    add_settings_section( 'sunset-contact-section', 'Contact Form', 'sunset_contact_section', 'theme-contact' );

    add_settings_field( 'activate-form', 'Activate Contact Form', 'sunset_activate_contact', 'theme-contact', 'sunset-contact-section' );

    // Custom CSS Options
    register_setting( 'sunset-custom-css-options', 'sunset_css', 'esc_textarea' );

    add_settings_section( 'sunset-custom-css-section', 'Custom CSS', 'sunset_custom_css_section', 'theme-css-options' );

    add_settings_field( 'custom-css', 'Insert Your Custom CSS', 'sunset_custom_css_contact', 'theme-css-options', 'sunset-custom-css-section' );
}

// Setting sections
function sunset_sidebar_options() {
    echo 'Customise Your Sidebar Information';
}
function sunset_theme_setup() {
    echo 'Activate and Deactivate specific Theme Support Options';
}
function sunset_contact_section() {
    echo 'Activate and Deactivate the Built-in Contact Form';
}
function sunset_custom_css_section() {
    echo 'Customise with Your Own CSS';
}

// Setting Fields
function sunset_sidebar_profile() {
    $picture = esc_attr( get_option( 'profile_pic' ) ) ;
    if(empty($picture)) {
        echo '<input type="button" class="button" value="Upload Your Profile" id="upload-button" /><input type="hidden" id="profile_pic" name="profile_pic" value=""/>';
    } else {
        echo '<input type="button" class="button" value="Replace Profile Photo" id="upload-button" />  <input type="button" class="button" value="Remove" id="remove-button" /><input type="hidden" id="profile_pic" name="profile_pic" value="'.$picture.'"/>';
    }
}
function sunset_sidebar_name() {
    $firstName = esc_attr( get_option( 'first_name' ) ) ;
    $lastName = esc_attr( get_option( 'last_name' ) ) ;
    echo '<input type="text" id="first-name" name="first_name" value="'.$firstName.'" placeholder="First Name" />
          <input type="text" id="last-name" name="last_name" value="'.$lastName.'" placeholder="Last Name" />
        ';
}
function sunset_sidebar_description() {
    $description = esc_attr( get_option( 'user_description' ) ) ;
    echo '<textarea type="text" id="describe" name="user_description" placeholder="Add Description" cols="52" rows="5">'.$description.'</textarea><p class="description">Write Something Smart</p>';
}
function sunset_sidebar_twitter() {
    $twitter = esc_attr( get_option( 'twitter_handler' ) ) ;
    echo '<input type="text" name="twitter_handler" value="'.$twitter.'" placeholder="Twitter Handler" /><p class="description">Input your Twiiter username without the @ character</p>';
}
function sunset_sidebar_facebook() {
    $facebook = esc_attr( get_option( 'facebook_handler' ) ) ;
    echo '<input type="text" name="facebook_handler" value="'.$facebook.'" placeholder="Facebook Handler" />';
}
function sunset_sidebar_gplus() {
    $gplus = esc_attr( get_option( 'gplus_handler' ) ) ;
    echo '<input type="text" name="gplus_handler" value="'.$gplus.'" placeholder="Google+ Handler" />';
}
function sunset_post_formats() {
    $options = get_option( 'post_formats' );
    $formats = array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat');
    $output = '';
    foreach($formats as $format) {
        $checked = (isset($options[$format])) == 1 ?  'checked' : '';
        $output .= '<label><input type="checkbox" id="'.$format.'" name="post_formats['.$format.']" value="1" '.$checked.' />'.$format.'</label><br/>';
    }
    echo $output;
}
function sunset_custom_header() {
    $options = get_option( 'custom_header' );
    $checked = (@$options == 1) ?  'checked' : '';
    echo '<label><input type="checkbox" id="custom_header" name="custom_header" value="1" '.$checked.' /> Activate Custom Header</label>';
}
function sunset_custom_background() {
    $options = get_option( 'custom_background' );
    $checked = (@$options == 1) ?  'checked' : '';
    echo '<label><input type="checkbox" id="custom_background" name="custom_background" value="1" '.$checked.' /> Activate Custom Background</label>';
}
function sunset_activate_contact() {
    $options = get_option( 'activate_contact' );
    $checked = (@$options == 1) ?  'checked' : '';
    echo '<input type="checkbox" id="activate_contact" name="activate_contact" value="1" '.$checked.' />';
}
function sunset_custom_css_contact() {
    $css = get_option( 'sunset_css' );
    $css = empty($css) ? '/* Sunset Theme Custom CSS */' : $css;
    echo '<div id="customCss">' . $css . '</div><textarea id="sunset_css" name="sunset_css" style="display: none;">' . $css . '</textarea>';
}


// Sanitization Settings
// always return sanitize function , never echo it
function sunset_sanitize_twitter_handler($input) {
    $output = sanitize_text_field( $input );
    $output = str_replace('@', '', $output);
    return $output;
}

// menu & submenus callback
function theme_option_page() {
    require_once(get_template_directory(  ).'/inc/settings_template/admin.php');
}
function theme_css_page() {
    require_once(get_template_directory(  ) . '/inc/settings_template/sunset-custom-css.php');
}
function theme_setup_page() {
    require_once(get_template_directory(  ) . '/inc/settings_template/sunset-theme-setup.php');
}
function theme_contact_page() {
    require_once(get_template_directory(  ) . '/inc/settings_template/sunset-contact-form.php');
}