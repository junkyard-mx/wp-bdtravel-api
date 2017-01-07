<?php 
/**
   * Plugin Name: BD Travel Solution API  
   * Description: Este plugin permite cargar contenido turistico como hoteles, vuelos, paquetes, etc. Es alimentado por información de Best Day.
   * Version: 1.0
   * Author: David Leal
   * Author URI: http://www.vexel.mx
   * Author email: contacto@vexel.mx
**/

include "forms.php";

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

// Check if there is not data from search
function check_data(){
  if(!$_POST){
    echo ' <script>
          var post_data = null;
          </script>';
  }

}

// Construct URL to get hotel list
function construct_url_hotels(){
  // Dates
  $sd = explode('/',$_POST['sd']);
  $ed = explode('/',$_POST['ed']);

  $new_sd = $sd[2] . $sd[1] . $sd[0];
  $new_ed = $ed[2] . $ed[1] . $ed[0];

  // Age of kids per room
  list($r1k1a, $r1k2a, $r1k3a) = explode(',', $_POST['ac1']);
  list($r2k1a, $r2k2a, $r2k3a) = explode(',', $_POST['ac2']);
  list($r3k1a, $r3k2a, $r3k3a) = explode(',', $_POST['ac3']);
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
  
  $string .= "&r=" . $_POST['rm'];        //Numero de cuartos
  $string .= "&r1a=" . $_POST['ad1'];       //Adultos en el cuarto 1
  $string .= "&r1k=" . $_POST['ch1'];       //Niños en el cuarto uno
  $string .= "&r1k1a=" .  $r1k1a ;              //Edad de los niños en el cuarto uno 'ac1, 'ac2, 'ac3
  $string .= "&r1k2a=" .  $r1k2a  ;             /**** Siguen cuartos y edades de niños ***/
  $string .= "&r1k3a=" .  $r1k3a  ;
  
  $string .= "&r2a=" . $_POST['ad2'];
  $string .= "&r2k=" . $_POST['ch2'];
  $string .= "&r2k1a=" .  $r2k1a  ;
  $string .= "&r2k2a=" .  $r2k2a  ;
  $string .= "&r2k3a=" .  $r2k3a  ;

  $string .= "&r3a=" . $_POST['ad3'];
  $string .= "&r3k=" . $_POST['ch3']; 
  $string .= "&r3k1a=" .  $r3k1a  ;
  $string .= "&r3k2a=" .  $r3k2a  ;
  $string .= "&r3k3a=" .  $r3k3a  ;

  // $string .= "&r4a=0
  // $string .= "&r4k=0
  // $string .= "&r4k1a=0
  // $string .= "&r4k2a=0
  // $string .= "&r4k3a=0

  // $string .= "&r5a=0
  // $string .= "&r5k=0
  // $string .= "&r5k1a=0
  // $string .= "&r5k2a=0
  // $string .= "&r5k3a=0

  $string .= "&d=" . $_POST['di'];               // Codigo de Destino
  $string .= "&l=esp";              // Lenguaje
  $string .= "&hash=";              // ??

  //Print
  $xmlURL =  $base . $string;
  //$xmlURL = "http://testxml.e-tsw.com/AffiliateService/AffiliateService.svc/restful/GetQuoteHotels?a=AF-ANI&ip=189.217.218.72&c=PE&sd=20150715&ed=20150718&h=&rt=&mp=&r=1&r1a=2&r1k=0&r1k1a=0&r1k2a=0&r1k3a=0&r2a=2&r2k=0&r2k1a=0&r2k2a=0&r2k3a=0&r3a=2&r3k=0&r3k1a=0&r3k2a=0&r3k3a=0&r4a=2&r4k=0&r4k1a=0&r4k2a=0&r4k3a=0&r5a=2&r5k=0&r5k1a=0&r5k2a=0&r5k3a=0&d=2&l=ESP&hash=";
  $xml_url_js = '<script>var xml_url_ajax ="' . $xmlURL . '";</script>';
  echo $xml_url_js;
}
add_action( 'wp_head', 'construct_url_hotels' );

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
//usage
//echo cache_image("http://images.e-tsw.com/_lib/vimages/Cancun/Hotels/Gran-Caribe-Resort-and-Spa/Gallery/Cancun-Gran-Caribe-Real-Asoleadero_xl.jpg");

//Enqueue scripts
function enqueue_styles_scripts(){
  /* Enqueue our stylesheet. */
  wp_enqueue_style( 'etravelAPI', plugins_url().'/e-travel-api-vxl/css/style.css' );
  wp_enqueue_style( 'font_awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' );
  wp_enqueue_script('jquery3', 'http://code.jquery.com/jquery-1.11.1.min.js');
  
    //Do not call the scroll if this is a detail page
    if ( isset( $_GET["h"] ) ){
      //Detail scripts such as slider
      wp_enqueue_style( 'lightslider', plugins_url().'/e-travel-api-vxl/css/lightslider.css' );
      wp_enqueue_script( 'lightslider_js', plugins_url() . '/e-travel-api-vxl/js/lightslider.js', array('jquery'), true );
      wp_enqueue_script( 'main_js', plugins_url() . '/e-travel-api-vxl/js/main.js', array('jquery'), true );
    } else{
      wp_enqueue_script( 'scroll', plugins_url() . '/e-travel-api-vxl/js/scroll.js', array(), '1.0.0', true );
    }
}
add_action( 'wp_enqueue_scripts', 'enqueue_styles_scripts' );

// Adding [Tags]
function add_container_tag(){
  return '<img id="loading" src="' . plugins_url() . '/e-travel-api-vxl/img/loading.gif"/> 
            <div id="main-container"></div>
          <div id="loading-bottom"><img src="' . plugins_url() . '/e-travel-api-vxl/img/loading-bottom.gif"/> Cargando más resultados</div>';
} 

/******
* * Get hotel details according to the Hotel ID
******/

function get_hotel_details(){
  $datafile = "http://testxml.e-tsw.com/AffiliateService/AffiliateService.svc/restful/GetHotelInformation?a=AF-ANI&ip=201.141.78.72&c=PE&l=ESP&h=".$_GET['h']."&hash=";
  //Load xml file
  if( ! $xml = simplexml_load_file($datafile) ) { 
          echo '<script type="text/javascript">console.log("GetHotelInformation - Unable to load XML file ")</script>'; 
  } else { 
          echo '<script type="text/javascript">console.log("GetHotelInformation - XML file loaded successfully")</script>';  
  } 


  $detail = '<div id="main-container">';

    
  foreach ($xml->Hotel as $key => $item) {
    $hotel_name = $item->Name;
    $hotel_city = $item->DestinationPath;
    $hotel_city_name = $item->Address->City->Name;
    $hotel_description = $item->Description;
    $check_in = $item->CheckIn;
    $check_out = $item->CheckOut;
    $total_rooms = $item->TotalRooms;
    //var_dump($item);
  }

    $detail .= '<h1 class="hotel-name">'.$hotel_name.' en '.$hotel_city.'</h1><br>';
    $detail .= '<span class="location"><i class="fa fa-location-arrow"> </i> '.$hotel_city_name.'</span>';
    $detail .= '
    <div class="divider"></div><br>
     <!-- Slider Begins -->';

    //Starting slide
    $detail .= '
    <!-- Slides Container -->
      <div class="clearfix" style="max-width:400px; max-height:300px;">
                <ul id="image-gallery" class="gallery list-unstyled cS-hidden">';
    //Hotel gallery
      foreach ($xml->Hotel->Galleries->Image as $gallery) {
          //var_dump($gallery);
          $image_description = $gallery->Description;
          $image = $gallery->URL;
          $image_url = str_replace('//images', 'http://images', $image);
          //$img_xl = str_replace('.jpg', '_xl.jpg', $image_url);
          $img_m = str_replace('.jpg', '_m.jpg', $image_url);
          //$size_xl = getimagesize($img_xl);        

          //Show the HD image if it exists
            // if ($size_xl !== false) {
            //     $image_url = $img_xl;
            // }
    $detail .= ' 
          <li data-thumb="'.$img_m.'">
              <img width="400px" src="'.$image_url.'" /> 
          </li>';
      } //Ends gallery foreach

    $detail .= '</ul></div>'; //End of the slide out foreach

    //Hotel Description
    $detail .= '<div class="more-hotel-details">';
    $detail .= '<h2>Acerca del Hotel</h2>';
    $detail .= '<p>'.$hotel_description.'</p>';
    $detail.='
    <div class="hotel-details">
      <ul class="list-descripcion">
          <li class="main-li">
            <h4>Habitaciones</h4>
            <div class="content room-list">
              <ul>
                  <li>
                    <h4>Llegada</h4>
                    <br><p>'.$check_in.'</p>
                  <li>
                  <li>
                    <h4>Salida</h4>
                    <br><p>'.$check_out.'</p>
                  <li>
                  <li>
                    <h4>Total de Habitaciones</h4>
                    <br><p>'.$total_rooms.'</p>
                  <li>
              </ul>
            </div>
          </li>
          
          <!-- TODO: agregar logica para mostrar o no -->
          <li class="main-li">
            <h4>Todo Incluido</h4>
            <div class="content">
              <h4>¿Que incluye?</h4>
              <div class="separador"></div>
              
              <b>Alimentos y Bebidas</b>
              <p>'.$item->AllInclusive->MealsDescription.'</p>
              <p>'.$item->AllInclusive->BeverageDescription.'</p>
              
              <b>Actividades</b>
              <p>'.$item->AllInclusive->ActivitiesDescription.'<p>
              
              <b>Entretenimiento</b>
              <p>'.$item->AllInclusive->EntertainmentDescription.'<p>
              
              <b>Servicios</b>
              <p>'.$item->AllInclusive->ServicesDescription.'<p>
              
              <b>Limitaciones</b>
              <p>'.$item->AllInclusive->Limitations.'<p>

            </div>
          </li>';

    //List of services
    $detail .= '<li class="main-li">
            <h4>Servicios</h4>
            <div class="content">
              <ul class="list-services">';
      
      //Services
      foreach ($xml->Hotel->Services->Service as $service) {
        $service_id = $service->Id;
        $service_extracharge = $service->ExtraCharge;
        $service_name = $service->Name;
        $detail .= '<li class="'.$service_id.'">'.$service_name.'</li>';
      }         
                  
    
    $detail .= '</ul>
            </div>
          </li>';

    //List of facilities
    $detail .= '<li class="main-li">
            <h4>Instalaciones</h4>
            <div class="content">
              <ul class="list-services">';
            
            //Facilities
            foreach ($xml->Hotel->Facilities->Comfort as $comfort) {
              $comfort_id = $comfort->Id;
              $comfort_extracharge = $comfort->ExtraCharge;
              $comfort_name = $comfort->Name;
                $detail .= '<li class="'.$comfort_id.'">'.$comfort_name.'</li>';
            }
    $detail .= '</ul>
            </div>
          </li>';

          //List of Activities
    $detail .= '<li class="main-li">
            <h4>Actividades</h4>
            <div class="content">
              <ul class="list-services">';
            
            //Activities
            foreach ($xml->Hotel->Activities->Activity as $activity) {
              $activity_id = $activity->Id;
              $activity_extracharge = $activity->ExtraCharge;
              $activity_name = $activity->Name;
                $detail .= '<li class="'.$activity_id.'">'.$activity_name.'</li>';
            }
    $detail .= '</ul>
            </div>
          </li>';
          
    $detail .= '<li class="main-li">
            <h4>Restaurantes</h4>
            <div class="content restaurants">
              <ul>';
            
            //Restaurants
            foreach ($xml->Hotel->Restaurants->Restaurant as $restaurant) {
              $restaurant_name = $restaurant->Name;
              $restaurant_description = $restaurant->Description;
              $restaurant_schedule = $restaurant->Schedule;
              
                $detail .= '
                
                <li class="restaurant">

                  <h5>'.$restaurant_name.'</h5>
                                  <p>'.$restaurant_description.'</p>
                                  <span class="schedule"><b>Horarios</b></span>
                                  <p>'.$restaurant_schedule.'</li>';
            }
    $detail .= '</ul>
            </div>
          </li>';

     $detail .= '<li class="main-li">
            <h4>Bares</h4>
            <div class="content restaurants">
              <ul>';
            
            //Restaurants
            foreach ($xml->Hotel->Bars->Bar as $bar) {
              $bar_name = $bar->Name;
              $bar_description = $bar->Description;
              $bar_schedule = $bar->Schedule;
              
                $detail .= '
                
                <li class="restaurant">

                  <h5>'.$bar_name.'</h5>
                                  <p>'.$bar_description.'</p>
                                  <span class="schedule"><b>Horarios</b></span>
                                  <p>'.$bar_schedule.'</li>';
            }
    $detail .= '</ul>
            </div>
          </li>';

    $detail .= '</div>'; //End of div.more-details

 //Ends main foreach
  return $detail;
} //End of get_hotel_details

// **** Ends of Hotel Detail ***//


//If it is a detail section, set the shortcode as hotel detail, if not, set it as search results
if ( isset( $_GET["h"] ) && !isset( $_GET['rates'] ) ){
  //If you click in an hotel details you will get this function
  add_shortcode( 'etravel-container', 'get_hotel_details' );
}elseif ( isset( $_GET['rates'] )  ){
  //If you navigate to the rates, you will run this function
  add_shortcode( 'etravel-container', 'get_hotel_rates' );
}else {
  //else you will get the search box
  add_shortcode( 'etravel-container', 'add_container_tag' );
}

/***
* Hotel Rates
** Building the URL to GetQuoteHotelRate and show rates and rooms.
*/
function get_hotel_rates(){
  $url_parameters = str_replace("&h=&", "", $_SERVER['QUERY_STRING']);
  $xml_rates = "http://testxml.e-tsw.com/AffiliateService/AffiliateService.svc/restful/GetQuoteHotelRate?" . $url_parameters;
echo $xml_rates;
  //Load xml file for GetQuoteHotelRate
  if( ! $xml_feed_rates = simplexml_load_file($xml_rates) ) { 
          echo '<script type="text/javascript">console.log("GetQuoteHotelRate - Unable to load XML file ")</script>'; 
      } else { 
          echo '<script type="text/javascript">console.log("GetQuoteHotelRate - XML file loaded successfully")</script>';  
  }



  //var_dump($xml_feed_rates->Hotel->Rooms);
  $rates = "";
  $rates .= '<div class="rates-container">';
      foreach ($xml_feed_rates->Hotel->Rooms->Room as $key => $value) {
        //Room values
        $room_name = $value->Name;
        $room_image = 'http:'.$value->Image;

        $rates .= '<div class="room">';
        $rates .= '<h3>'.$room_name.'</h3>';
        $rates .= '<div class="room-image">';
        //if ( getimagesize( $room_image )){
          $rates .= '<img src="'.$room_image.'" width="180px" />';
        // } else {
        //   $rates .= '';
        // }
        $rates .= '</div>';
        $rates .= '<div class="room-details">';
        $rates .= '<p style="font-size:10px;">' . $value->Description . '</p>';
            //Mealplans for each room
            foreach ($xml_feed_rates->Hotel->Rooms->Room->MealPlans->MealPlan as $key => $meal_plan) {
              # code...
              $rates .= '<h4>' . $meal_plan->Name . '</h4>';
            }

        $rates .= '</div>';
        $rates .= '</div>';
      }
  $rates .= '</div>';
  return $rates;
}

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

?>
