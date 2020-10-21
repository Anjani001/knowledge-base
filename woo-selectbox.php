// Display select Fields
add_action( 'woocommerce_product_options_general_product_data', 'prefix_add_selectbox');
function prefix_add_selectbox() {
	global $woocommerce, $post;
	$args = array(
			'id' => 'my_new_select', // required. The meta_key ID for the stored value
			'wrapper_class' => '', // a custom wrapper class if needed
			'desc_tip' => true, // makes your description show up with a "?" symbol and as a tooltip
			'description' => __('My awesome select box', 'your_text_domain'),
			'label' => __( 'My New Select', 'your_text_domain' ),
			'options' => array(
					'value1' => __( 'Text 1', 'your_text_domain' ),
					'value2' => __( 'Text 2', 'your_text_domain' )
			)
	);
	woocommerce_wp_select( $args );
}