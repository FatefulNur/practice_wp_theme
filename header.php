<!DOCTYPE html>
<html <?php language_attributes(  ); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php if(is_singular() && pings_open( get_queried_object(  ) )) :  ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php wp_head(  ); ?>
</head>
<body <?php body_class(  ); ?>>
	<div class="sunset-sidebar">
		<div class="sidebar-scroll">
		<?php get_sidebar(  ); ?>
		</div>
	</div>
	<div class="sidebar-overlay"></div>
<div class="container">
<div id="ami-id" style="background-image: url(<?php header_image(  ); ?>);">
	<h4 class="logo">
		<?php if(function_exists('the_custom_logo')) {
			the_custom_logo(  );
		} ?>
	</h4>
 <?php 

wp_nav_menu(
	array(
		'container'  => '',
		'items_wrap' => '%3$s',
		'menu_class'	=> 'menu-item',
		'menu_id'	=> 'menu-mega-menu',
		'theme_location' => 'primary',
		'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'walker' => new Menu_With_Description
	)
);
?>
</div>

