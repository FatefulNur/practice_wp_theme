<?php 	
	

		add_action( 'wp_enqueue_scripts', function () {
			wp_enqueue_style( 'ami', get_stylesheet_uri(  ) );
		} );
	
		register_nav_menus( array(
			'primary'  => 'Desktop Horizontal Menu'
		)) ;

		add_action( 'after_setup_theme', function () {
			add_theme_support( 'post-thumbnails' );
		});

