<?php 	
require_once(get_template_directory(  ).'/inc/theme-setup.php');
require_once(get_template_directory(  ).'/inc/class-nav_walker.php');
require_once(get_template_directory(  ).'/inc/settings.php');
require_once(get_template_directory(  ).'/inc/enqueue.php');
require_once(get_template_directory(  ).'/inc/theme-support.php');
require_once(get_template_directory(  ).'/inc/custom-posttype.php');
require_once(get_template_directory(  ).'/inc/ajax.php');
require_once(get_template_directory(  ).'/inc/shortcode.php');
require_once(get_template_directory(  ).'/inc/widget.php');

 
add_filter('the_content', 'do_shortcode');
add_filter('the_excerpt', 'do_shortcode');
add_filter('widget_text', 'do_shortcode');


// MEGA MENU CUSTOM FIELDS SECTION

// Create fields
function fields_list() {
	return array(
		// menu-item-megamenu
		'megamenu' => 'Activate MegaMenu',
		'column-divider' => 'Column Divider',
		'divider' => 'Inline Divider',
		'fea-img' => 'Featured Image',
		'desc' => 'Description'
	);
}
// Setup fields
function megamenu_fields($id, $item, $depth, $args) {
	$fields = fields_list();
	foreach($fields as $_key => $label) :
		$key = sprintf('menu-item-%s', $_key);
		$id = sprintf('edit-%s-%s', $key, $item->ID);
		$class = sprintf('field-%s', $_key);
		$name = sprintf('%s[%s]', $key, $item->ID);
		$value = get_post_meta( $item->ID, $key, true );
	?>

		<p class="description description-wide <?php echo esc_attr( $class ); ?>">
			<label for="<?php echo esc_attr( $id ); ?>">
				<input type="checkbox" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>" value="1" <?php  echo ($value == 1) ? 'checked="checked"' : ''; ?>  <?php /* checked( $value, true );  */?>>
				<?php echo esc_html($label); ?>
			</label>
		</p>

	<?php

	endforeach;
}
add_action( 'wp_nav_menu_item_custom_fields', 'megamenu_fields', 10, 4 );


// Show columns
function megamenu_columns( $columns ) {
	$fields = fields_list();

	$columns = array_merge($columns, $fields);

	return $columns;
}
add_filter( 'manage_nav-menus_columns', 'megamenu_columns', 99 );

// Save/Update fields
function megamenu_save($menu_id, $menu_item_db_id, $menu_item_args) {
	if(defined('DOING_AJAX') && DOING_AJAX) {
		return;
	}
	check_admin_referer( 'update-nav_menu', 'update-nav-menu-nonce' );
	$fields = fields_list();
	foreach($fields as $_key => $label) :
		$key = sprintf('menu-item-%s', $_key);

		// Sanitize
		if(!empty($_POST[$key][$menu_item_db_id])) {
			$value = $_POST[$key][$menu_item_db_id];
		} else {
			$value = null;
		}

		// Save or Update
		if(!is_null($value)) {
			update_post_meta( $menu_item_db_id, $key, $value );
		} else {
			delete_post_meta( $menu_item_db_id, $key );
		}
	endforeach;
}
add_action( 'wp_update_nav_menu_item', 'megamenu_save', 10, 3 );

// Update the admin walker nav
function megamenu_walkernav($walker) {
	$walker = 'MegaMenu_Walker_Edit';
	if(!class_exists($walker)) {
		require_once get_template_directory(  ) . '/inc/walker-nav-menu-edit.php';
	}
	return $walker;
}
// add_filter( 'wp_edit_nav_menu_walker', 'megamenu_walkernav', 99 );
