<?php
// Shortcodes
add_shortcode( 'bdtravel-hotels', 'hotels_container' );
function hotels_container(){
  return '<img id="loading" src="' . PLUGIN_URL . '/img/loading.gif"/> 
            <div id="main-container"></div>
          <div id="loading-bottom"><img src="' . PLUGIN_URL . '/img/loading-bottom.gif"/> Cargando más resultados</div>';
} 