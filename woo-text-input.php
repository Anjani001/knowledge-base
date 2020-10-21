<?php
function prefix_add_text_input() {
  $args = array(
    'label' => '', // Text in the label in the editor.
    'placeholder' => '', // Give examples or suggestions as placeholder
    'class' => '',
    'style' => '',
    'wrapper_class' => '',
    'value' => '', // if empty, retrieved from post_meta
    'id' => '', // required, will be used as meta_key
    'name' => '', // name will be set automatically from id if empty
    'type' => '',
    'desc_tip' => '',
    'data_type' => '',
    'custom_attributes' => '', // array of attributes you want to pass 
    'description' => ''
  );
  woocommerce_wp_text_input( $args );
}
add_action( 'woocommerce_product_options_pricing', 'prefix_add_text_input' );