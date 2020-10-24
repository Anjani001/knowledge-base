<?php
function prefix_add_radio_buttons() {
  $args = array(
    'label' => '', // Text in the label in the editor
    'class' => 'prefix_radio', // custom class
    'style' => '', 
    'wrapper_class' => '', // custom wrapper class
    'value' => '', // if empty, retrieved from meta_value where id is the meta_key
    'id' => '', // required, will be used as meta_key for this field
    'name' => 'my_radio_buttons', // required if you want only one option to be selected at a time
    'options' => array( // options for radio inputs, array
      'value1' => __( 'Option 1', 'your_text_domain' ),
      'value2' => __( 'Option 2', 'your_text_domain' )
    ), 
    'desc_tip' => '', // true or false. Controls whether your description is shown directly or as tooltip
    'description' => '' // provide a useful description
  );
  woocommerce_wp_radio( $args );
}

add_action( 'woocommerce_product_options_tax', 'prefix_add_radio_buttons' );