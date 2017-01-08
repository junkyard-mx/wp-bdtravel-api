<?php
// assets
function enqueue_styles_scripts(){
  /* Enqueue our stylesheet. */
  wp_enqueue_style( 'bd-travel', PLUGIN_URL . '/css/style.css' );
  wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' );

  /* Enqueue our stylesheet. */
  wp_enqueue_script( 'lightslider_js', PLUGIN_URL . '/js/lightslider.js', array('jquery'), true );
  wp_enqueue_script( 'jquery-ui', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js', array( 'jquery' ), true );
  wp_enqueue_script( 'bdtravel-js', PLUGIN_URL . '/js/bdtravel.js', array( 'jquery', 'jquery-ui' ), false );
  wp_enqueue_style( 'lightslider', PLUGIN_URL . '/css/lightslider.css' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_styles_scripts' );