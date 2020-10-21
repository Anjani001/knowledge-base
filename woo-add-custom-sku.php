<?php

function jk_add_custom_sku() {
  $args = array(
    'label' => __( 'Custom SKU', 'woocommerce' ),
    'placeholder' => __( 'Enter custom SKU here', 'woocommerce' ),
    'id' => 'jk_sku',
    'desc_tip' => true,
    'description' => __( 'This SKU is for internal use only.', 'woocommerce' ),
  );
  woocommerce_wp_text_input( $args );
}
add_action( 'woocommerce_product_options_sku', 'jk_add_custom_sku' );

function jk_save_custom_meta( $post_id ) {
  // grab the SKU value
  $sku = isset( $_POST[ 'jk_sku' ] ) ? sanitize_text_field( $_POST[ 'jk_sku' ] ) : '';
  
  // grab the product
  $product = wc_get_product( $post_id );
  
  // save the custom SKU meta field
  $product->update_meta_data( 'jk_sku', $sku );
  $product->save();
}

add_action( 'woocommerce_process_product_meta', 'jk_save_custom_meta' );