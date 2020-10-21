<?php
function prefix_add_checkbox() {
  $args = array(
    'label' => '', // Text in the editor label
    'class' => '',
    'style' => '',
    'wrapper_class' => '', // custom CSS class for styling
    'value' => '', // meta_value where the id serves as meta_key
    'id' => '', // required, it's the meta_key for storing the value (is checked or not)
    'name' => '', 
    'cbvalue' => '', // "value" attribute for the checkbox
    'desc_tip' => '', // true or false, show description directly or as tooltip
    'custom_attributes' => '', // array of attributes 
    'description' => '' // provide something useful here
  );
  woocommerce_wp_checkbox( $args );
}

add_action( 'woocommerce_product_options_tax', 'prefix_add_checkbox' );