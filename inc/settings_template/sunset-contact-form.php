<h1>Sunset Contact Form</h1>
<?php settings_errors(  ); ?>

<p>Use this <b>shortcode</b> to activate the Contact form inside a page or a post</p>
<code>[contacta]</code>

<form action="options.php" method="post" class="sunset-general-form">
    <?php settings_fields( 'sunset-contact-options' ); ?>
    <?php do_settings_sections( 'theme-contact' ); ?>
    <?php submit_button(); ?>
</form>