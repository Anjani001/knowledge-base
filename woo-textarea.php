<?php
function prefix_add_textarea() {

  $args = array(
    'label' => '', // Text in the label in the editor view
    'placeholder' => '', // Give advice or examples as placeholder
    'class' => '',
    'style' => '',
    'wrapper_class' => '',
    'value' => '', // if empty, will be loaded as meta_value for the meta_key with the given id
    'id' => '', // required, serves as meta_key for this field
    'name' => '', // name will be set automatically from the id if left empty
    'rows' => '',
    'cols' => '',
    'desc_tip' => '',
    'custom_attributes' => '', // array of attributes you can pass
    'description' => ''
  );
  woocommerce_wp_textarea_input( $args );
}

add_action( 'woocommerce_product_options_pricing', 'prefix_add_textarea' );