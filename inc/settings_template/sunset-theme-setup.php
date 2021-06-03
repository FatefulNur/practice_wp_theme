<h1>Sunset Theme Setup</h1>
<?php settings_errors(  ); ?>


<form action="options.php" method="post" class="sunset-general-form">
    <?php settings_fields( 'sunset-theme-setup' ); ?>
    <?php do_settings_sections( 'theme-setup' ); ?>
    <?php submit_button(); ?>
</form>