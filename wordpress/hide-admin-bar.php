<?php
/**
 * Disables the #wpadmin bar for users without "edit_posts" permissions.
 */
 function prefix_hide_admin_bar() {
	if ( ! current_user_can( 'edit_posts' ) ) {
		add_filter( 'show_admin_bar', '__return_false' );
	}
}
add_action( 'after_setup_theme', 'prefix_hide_admin_bar' );