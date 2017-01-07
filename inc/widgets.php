<?php

/********
* Register Sidebar
********/
add_action( 'widgets_init', 'etravel_vxl_widgets_init' );
function etravel_vxl_widgets_init() {
    register_sidebar( array(
        'name' => __( 'E-Travel Sidebar', 'theme-slug' ),
        'id' => 'etravel-1',
        'description' => __( 'Los widgets en esta area seran mostrados en la vista de reserva.', 'theme-slug' ),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ) );

    register_widget( 'BDTravelWidget' );

}

// ##### Widget ######
class BDTravelWidget extends WP_Widget {

  function __construct() {
    // Instantiate the parent object
    parent::__construct( false, 'BD Widget' );
  }

  function widget( $args, $instance ) {
    $current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    // Widget output
    if( isset( $_GET['h'] ) ){
      echo '<div class="sidebar-widget book-box">
              <span class="price-from">Desde:</span>
              <span class="price">MXN$ '.round( $_GET['promedio'], 2 ).'</span>
              <span class="price-comment">Precio promedio por noche, Imp. Incluidos.</span>
              <a class="button" href="'.$current_url.'&rates=true">Elegir Habitacion</a>
            </div>';
    } else {
      echo "busqueda";
    }
    
  }

  function update( $new_instance, $old_instance ) {
    // Save widget options
    $instance['title'] = strip_tags($new_instance['title']);
    return $instance;
  }

  function form( $instance ) {
    // Output admin widget options form
  }
}