<?php

//Hide menus based on user or capability
add_action( 'admin_menu', 'ft_remove_custom_menus', 999 );
function ft_remove_custom_menus () {

	//Remove menus by not allowed user IDs
	$allowed_ids = array(1, 4, 7, 15);
	if( !in_array(get_current_user_id(), $allowed_ids) ) {
		//The user ID is not in the array of IDs, remove menus
		remove_menu_page( 'some-admin-page.php' );
		remove_submenu_page( 'options-general.php', 'certain-plugin-settings' );
	}
	
	//Remove menus by not allowed user capability
	if( !current_user_can('install_themes') ) { 
		//Current user can't install theme, remove other menus too
	}	
	
}

//Remove a submenu
add_action( 'admin_menu', 'ft_control_submenu', 999 );
function ft_control_submenu() {
	
	//remove_submenu_page( $menu_slug, $submenu_slug );
	$page = remove_submenu_page( 'themes.php', 'widgets.php' );
	
	/*
	print_r($page);
	The above will return:
	array(3) { [0]=> string(7) "Widgets" [1]=> string(18) "edit_theme_options" [2]=> string(11) "widgets.php" }
	
	$page[0] is the menu title
	$page[1] is the minimum level or capability required
	$page[2] is the URL to the item's file	
	*/ 
	
	
	//URL => http://fellowtuts.com/wp-admin/admin.php?page=disqus
	remove_submenu_page( 'admin.php', 'disqus' );

	//URL => http://fellowtuts.com/wp-admin/options-general.php?page=tinymce-advanced 
	remove_submenu_page( 'options-general.php', 'tinymce-advanced' );       
	
}

//restrict page access
add_action( 'current_screen', 'tcd_restrict_admin_pages' );
function tcd_restrict_admin_pages() {
	

	// retrieve the current page's ID
	$current_screen_id = get_current_screen()->id;
	// determine which screens are off limits
	$restricted_screens = array(
		'edit',
		'upload',
		'tools',
		'edit-comments',
		'plugins',
		'manage_options'
	);
	
	
	if ( current_user_can( 'publish_posts' ) ) {
		// don't do anything if the user can publish posts
		return;
	}
	// Restrict page access
	foreach ( $restricted_screens as $restricted_screen ) {
		// compare current screen id against each restricted screen
		if ( $current_screen_id === $restricted_screen ) {
			wp_die( __( 'You are not allowed to access this page.', 'tcd' ) );
		}
	}
}