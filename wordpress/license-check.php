<?php
function wpi_check_with_license_server() {
	$license = get_option( 'youroptionfield' );
	
	$api_params = array(
		'slm_action' => 'slm_check',
		'secret_key' => VALIDATION_KEY,
		'license_key' => $license,
	);
		
	// Send query to the license manager server
	$response = wp_remote_get(add_query_arg($api_params, LICENSE_SERVER), array('timeout' => 20, 'sslverify' => false));

	if (is_wp_error($response)){
		echo "Unexpected Error! The query returned with an error.";
	}

	//var_dump($response);//uncomment it if you want to look at the full response

	// License data.
	$license_data = json_decode(wp_remote_retrieve_body($response));

	if( 'success' == $license_data->result ){ //Success was returned for the license activation
		// Mark license as valid
		update_option( 'youroptionfield', 'true');
	} else {
		// Mark license as invalid
		update_option( 'youroptionfield', 'false');
	}

	return;
}