<?php
	/**
	 * Example code for tutorial post on custom meta boxes:
	 * https://wptheming.com/2010/08/custom-metabox-for-post-type/
	 */
	
	/**
	 * Registers the event post type.
	 */
	function wpt_event_post_type() {
		
		$labels = array(
				'name'               => __( 'Events' ),
				'singular_name'      => __( 'Event' ),
				'add_new'            => __( 'Add New Event' ),
				'add_new_item'       => __( 'Add New Event' ),
				'edit_item'          => __( 'Edit Event' ),
				'new_item'           => __( 'Add New Event' ),
				'view_item'          => __( 'View Event' ),
				'search_items'       => __( 'Search Event' ),
				'not_found'          => __( 'No events found' ),
				'not_found_in_trash' => __( 'No events found in trash' )
		);
		
		$supports = array(
				'title',
				'editor',
				'thumbnail',
				'comments',
				'revisions',
		);
		
		$args = array(
				'labels'               => $labels,
				'supports'             => $supports,
				'public'               => true,
				'capability_type'      => 'post',
				'rewrite'              => array( 'slug' => 'events' ),
				'has_archive'          => true,
				'menu_position'        => 30,
				'menu_icon'            => 'dashicons-calendar-alt',
				'register_meta_box_cb' => 'wpt_add_event_metaboxes',
		);
		
		register_post_type( 'events', $args );
		
	}
	add_action( 'init', 'wpt_event_post_type' );
	
	/**
	 * Adds a metabox to the right side of the screen under the “Publish” box
	 */
	function wpt_add_event_metaboxes() {
		add_meta_box(
				'wpt_events_location',
				'Event Location',
				'wpt_events_location',
				'events',
				'side',
				'default'
		);
	}
	
	/**
	 * If you wanted to have two sets of metaboxes.
	 */
	function add_events_metaboxes_v2() {
		
		add_meta_box(
				'wpt_events_date',
				'Event Date',
				'wpt_events_date',
				'events',
				'side',
				'default'
		);
		
		add_meta_box(
				'wpt_events_location',
				'Event Location',
				'wpt_events_location',
				'events',
				'normal',
				'high'
		);
		
	}
	
	/**
	 * Output the HTML for the metabox.
	 */
	function wpt_events_location() {
		global $post;
		
		// Nonce field to validate form request came from current site
		wp_nonce_field( basename( __FILE__ ), 'event_fields' );
		
		// Get the location data if it's already been entered
		$location = get_post_meta( $post->ID, 'location', true );
		
		// Output the field
		echo '<input type="text" name="location" value="' . esc_textarea( $location )  . '" class="widefat">';
		
	}
	
	/**
	 * Save the metabox data
	 */
	function wpt_save_events_meta( $post_id, $post ) {
		
		// Return if the user doesn't have edit permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
		
		// Verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times.
		if ( ! isset( $_POST['location'] ) || ! wp_verify_nonce( $_POST['event_fields'], basename(__FILE__) ) ) {
			return $post_id;
		}
		
		// Now that we're authenticated, time to save the data.
		// This sanitizes the data from the field and saves it into an array $events_meta.
		$events_meta['location'] = esc_textarea( $_POST['location'] );
		
		// Cycle through the $events_meta array.
		// Note, in this example we just have one item, but this is helpful if you have multiple.
		foreach ( $events_meta as $key => $value ) :
			
			// Don't store custom data twice
			if ( 'revision' === $post->post_type ) {
				return;
			}
			
			if ( get_post_meta( $post_id, $key, false ) ) {
				// If the custom field already has a value, update it.
				update_post_meta( $post_id, $key, $value );
			} else {
				// If the custom field doesn't have a value, add it.
				add_post_meta( $post_id, $key, $value);
			}
			
			if ( ! $value ) {
				// Delete the meta key if there's no value
				delete_post_meta( $post_id, $key );
			}
		
		endforeach;
		
	}
	add_action( 'save_post', 'wpt_save_events_meta', 1, 2 );
