<h1>Sidebar Options</h1>
<?php settings_errors(  ); ?>
<?php 
    $profile = esc_attr( get_option( 'profile_pic' ) ) ;
    $firstName = esc_html( get_option( 'first_name' ) ) ;
    $lastName = esc_html( get_option( 'last_name' ) ) ;
    $fullName = "$firstName $lastName";
    $description = esc_html( get_option( 'user_description' ) ) ;
?>
<div class="sunset-sidebar-preview">
    <div class="sunset-sidebar">
        <div class="img-container">
        <?php if($profile) { ?>
            <div id="profic-preview" class="propic" style="background-image: url(<?php print $profile; ?>);"></div>
        <?php } ?>
        </div>
        <h1 id="name" class="sunset-username"><?php print $fullName; ?></h1>
        <h2 id="desc" class="sunset-desc"><?php print $description; ?></h2>
        <div class="icons-wrapper">

        </div>
    </div>
</div>

<form action="options.php" method="post" class="sunset-general-form">
    <?php settings_fields( 'sunset-settings-group' ); ?>
    <?php do_settings_sections( 'theme-options' ); ?>
    <?php submit_button(  'Save Changes', 'primary', 'btnSubmit'  ); ?>
</form>