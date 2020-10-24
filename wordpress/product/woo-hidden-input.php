<?php
function prefix_add_hidden_input() {
  $args = array(
    'value' => '', // meta_value, meta_key is the id
    'class' => '',
    'id' => '' // required, makes the meta_key for storing the value
  );
  woocommerce_wp_hidden_input( $args );
}

add_action( 'woocommerce_product_options_tax', 'prefix_add_hidden_input' );