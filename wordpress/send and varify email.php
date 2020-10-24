<?php
add_action( 'user_register', 'my_registration', 10, 2 );
function my_registration( $user_id ) {
	// get user data
	$user_info = get_userdata($user_id);
	// create md5 code to verify later
	$code = md5(time());
	// make it into a code to send it to user via email
	$string = array('id'=>$user_id, 'code'=>$code);
	
	$encoded_string = base64_encode( serialize($string));
	// create the activation code and activation status
	update_user_meta($user_id, 'account_activated', 0);
	update_user_meta($user_id, 'activation_code', $code);
	// create the url
	$url_full = get_site_url(). '/my-account/?act=' . $encoded_string;
	// basically we will edit here to make this nicer
	$html = '<a href="'.$url_full.'">'.$url_full.'</a>';
	// send an email out to user
	$headers = array('Content-Type: text/html; charset=UTF-8');
	
	$sent_message = wp_mail( $user_info->user_email, __('Email Subject','user varification') , $html, $headers);
	if ( $sent_message ) {
		echo 'The test message was sent. Check your email inbox.';
	} else {
		echo 'The message was not sent!';
	}
	die;
}

add_action( 'init', 'verify_user_code' );
function verify_user_code(){
	if(isset($_GET['act'])){
		
		$data = unserialize(base64_decode($_GET['act']));
		$code = get_user_meta($data['id'], 'activation_code', true);
		
		// verify whether the code given is the same as ours
		if(($code == $data['code']) && ($code != '')){
			// update the user meta
			update_user_meta($data['id'], 'account_activated', 1);
			
			if ( ! delete_user_meta($data['id'], 'activation_code') ) {
				//echo "Ooops! Error while deleting this information!";
			}
			wc_add_notice( __( '<strong>Success:</strong> Your account has been activated! ', 'text-domain' )  );
		}
	}
}
	
add_filter( 'wp_authenticate_user', 'check_status' );
function check_status( WP_User $user ) {
	$status = get_user_meta( $user->ID, 'account_activated' );
	if (( 1 !== (int) $status ) && (current_user_can( 'publish_posts' ))) {
		$message = wc_add_notice( __( '<strong>Error:</strong> user_not_verified', 'text-domain' )  );
		return new WP_Error( $message );
	}
	return $user;
}
	
