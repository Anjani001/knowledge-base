<?php

get_bloginfo( 'version' );

global $wp_version;
if ( version_compare( $wp_version, '4.3', '>=' ) ) {
	// WordPress version is greater than 4.3
}

if ( function_exists( 'has_post_format' ) ) {
	//  3.1 specific code
}

/*
 * Compares the version of WordPress running to the $version specified.
 *
 * @param string $operator
 * @param string $version
 * @returns boolean
 */
function is_version( $operator = '>', $version = '4.0' ) {
	global $wp_version;
	return version_compare( $wp_version, $version, $operator );
}