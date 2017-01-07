<?php
// assets
function enqueue_styles_scripts(){
  /* Enqueue our stylesheet. */
  wp_enqueue_style( 'bd-travel', PLUGIN_URL . '/css/style.css' );
  wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' );

  /* Enqueue our stylesheet. */
  wp_enqueue_style( 'searchbox', PLUGIN_URL . '/css/resbox.css' );
  // wp_enqueue_script( 'etravel', PLUGIN_URL . '/js/etravel.js', false );   
  wp_enqueue_script( 'lightslider_js', PLUGIN_URL . '/js/lightslider.js', array('jquery'), true );
  wp_enqueue_script( 'bdtravel-js', PLUGIN_URL . '/js/bdtravel.js', array('jquery'), false );
  wp_enqueue_style( 'lightslider', PLUGIN_URL . '/css/lightslider.css' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_styles_scripts' );