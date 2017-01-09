<?php 
/**
   * Plugin Name: BD Travel Solution API  
   * Description: Este plugin permite cargar contenido turistico como hoteles, vuelos, paquetes, etc. Es alimentado por información de Best Day.
   * Version: 1.0
   * Author: David Leal
   * Author URI: http://www.vexel.mx
   * Author email: contacto@vexel.mx
**/
define( PLUGIN_PATH, dirname( __FILE__) );
define( PLUGIN_URL, plugins_url() . '/wp-bdtravel-api' );

require_once( PLUGIN_PATH . '/inc/assets.php' );
require_once( PLUGIN_PATH . '/inc/ajax-data.php' );
require_once( PLUGIN_PATH . '/inc/shortcodes.php' );
require_once( PLUGIN_PATH . '/inc/widgets.php' );

require_once( PLUGIN_PATH . '/inc/fieldmanager/class-bdtravel-fm-submenu.php' );
require_once( PLUGIN_PATH . '/inc/class-helper-functions.php' );

// Function to get the client ip address
function get_client_ip_server() {
    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
 
    return $ipaddress;
}


// Construct URL to get hotel list
function construct_url_hotels(){
  // Dates
  $sd = explode('/',$_GET['sd']);
  $ed = explode('/',$_GET['ed']);

  $new_sd = $sd[2] . $sd[1] . $sd[0];
  $new_ed = $ed[2] . $ed[1] . $ed[0];

  // Age of kids per room
  list($r1k1a, $r1k2a, $r1k3a) = explode(',', $_GET['ac1']);
  list($r2k1a, $r2k2a, $r2k3a) = explode(',', $_GET['ac2']);
  list($r3k1a, $r3k2a, $r3k3a) = explode(',', $_GET['ac3']);
  if(empty($r1k1a)){$r1k1a = 0;}
  if(empty($r1k2a)){$r1k2a = 0;}
  if(empty($r1k3a)){$r1k3a = 0;}
  if(empty($r2k1a)){$r2k1a = 0;}
  if(empty($r2k2a)){$r2k2a = 0;}
  if(empty($r2k3a)){$r2k3a = 0;}
  if(empty($r3k1a)){$r3k1a = 0;}
  if(empty($r3k2a)){$r3k2a = 0;}
  if(empty($r3k3a)){$r3k3a = 0;}

  $base = "http://testxml.e-tsw.com/AffiliateService/AffiliateService.svc/restful/GetQuoteHotels";
  $string = "?a=AF-ANI";              // User ID
  $string .= "&ip=192.168.1.0" .  $ipaddress;   //IP usuario
  $string .= "&c=" . "pe";            //Moneda
  $string .= "&sd=" . $new_sd;          //Fecha de inicio
  $string .= "&ed=" . $new_ed;          // Fecha de termino
  $string .= "&h=";                 //ID del hotel
  $string .= "&rt=";                //Room code
  $string .= "&mp=";                //Meal plan code
  
  $string .= "&r=" . $_GET['rm'];        //Numero de cuartos
  $string .= "&r1a=" . $_GET['ad1'];       //Adultos en el cuarto 1
  $string .= "&r1k=" . $_GET['ch1'];       //Niños en el cuarto uno
  $string .= "&r1k1a=" .  $r1k1a ;              //Edad de los niños en el cuarto uno 'ac1, 'ac2, 'ac3
  $string .= "&r1k2a=" .  $r1k2a  ;             /**** Siguen cuartos y edades de niños ***/
  $string .= "&r1k3a=" .  $r1k3a  ;
  
  $string .= "&r2a=" . $_GET['ad2'];
  $string .= "&r2k=" . $_GET['ch2'];
  $string .= "&r2k1a=" .  $r2k1a  ;
  $string .= "&r2k2a=" .  $r2k2a  ;
  $string .= "&r2k3a=" .  $r2k3a  ;

  $string .= "&r3a=" . $_GET['ad3'];
  $string .= "&r3k=" . $_GET['ch3']; 
  $string .= "&r3k1a=" .  $r3k1a  ;
  $string .= "&r3k2a=" .  $r3k2a  ;
  $string .= "&r3k3a=" .  $r3k3a  ;

  $string .= "&d=" . $_GET['di'];               // Codigo de Destino
  $string .= "&l=esp";              // Lenguaje
  $string .= "&hash=";              // ??

  //Print
  // $xmlURL =  $base . $string;
  $xmlURL = "http://testxml.e-tsw.com/AffiliateService/AffiliateService.svc/restful/GetQuoteHotels?a=AF-ANI&ip=189.217.218.72&c=PE&sd=20170715&ed=20170718&h=&rt=&mp=&r=1&r1a=2&r1k=0&r1k1a=0&r1k2a=0&r1k3a=0&r2a=2&r2k=0&r2k1a=0&r2k2a=0&r2k3a=0&r3a=2&r3k=0&r3k1a=0&r3k2a=0&r3k3a=0&r4a=2&r4k=0&r4k1a=0&r4k2a=0&r4k3a=0&r5a=2&r5k=0&r5k1a=0&r5k2a=0&r5k3a=0&d=2&l=ESP&hash=0";
  $xml_url_js = '<input id="bd-ajax-url" type="hidden" value="' . $xmlURL . '" />';
  echo $xml_url_js;
}
add_action( 'wp_head', 'construct_url_hotels' );

// Print hotels endpoints
function print_pages_endpoints() {
  $hotels_endpoint = get_page_link( Helper_Functions::get_pages_configuration( 'page_hotels' ) );
  $hotel_details_endpoint = get_page_link( Helper_Functions::get_pages_configuration( 'page_hotel_details' ) );
  if( false !== $hotels_endpoint && false !== $hotel_details_endpoint ) {
    echo '<input type="hidden" id="hotels-url" value="' . $hotels_endpoint . '" />';
    echo '<input type="hidden" id="hotel-details-url" value="' . $hotel_details_endpoint . '" />';
  }

}
add_action( 'wp_head', 'print_pages_endpoints' );


//Cache images
function cache_image($image_url){
  //replace with your cache directory
  $image_path = 'temp/';

  //get the name of the file
  $exploded_image_url = explode("/",$image_url);
  $image_filename = end($exploded_image_url);
  $exploded_image_filename = explode(".",$image_filename);
  $extension = end($exploded_image_filename);

  //make sure its an image
  if($extension=="gif"||$extension=="jpg"||$extension=="png"){
    //get the remote image
    $image_to_fetch = file_get_contents($image_url);

    //save it
    $local_image_file  = fopen($image_path.$image_filename, 'w+');
    chmod($image_path.$image_filename,0755);
    fwrite($local_image_file, $image_to_fetch);
    fclose($local_image_file);  
  }
  return $image_path.$image_filename;
}