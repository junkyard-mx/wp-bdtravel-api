<?php
// Shortcodes
add_shortcode( 'bdtravel-hotels', 'hotels_container' );
function hotels_container(){
  return '<img id="loading" src="' . PLUGIN_URL . '/img/loading.gif"/> 
            <div id="main-container"></div>
          <div id="loading-bottom"><img src="' . PLUGIN_URL . '/img/loading-bottom.gif"/> Cargando más resultados</div>';
} 

add_shortcode( 'bdtravel-hotel-details', 'get_hotel_details' );

function get_hotel_details(){
  $datafile = "http://testxml.e-tsw.com/AffiliateService/AffiliateService.svc/restful/GetHotelInformation?a=AF-ANI&ip=201.141.78.72&c=PE&l=ESP&h=".$_GET['h']."&hash=";
  //Load xml file
  if( ! $xml = simplexml_load_file($datafile) ) { 
          echo '<script type="text/javascript">console.log("GetHotelInformation - Unable to load XML file ")</script>'; 
  } else { 
          echo '<script type="text/javascript">console.log("GetHotelInformation - XML file loaded successfully")</script>';  
  } 


  $detail = '<div id="main-container-2">';

    
  foreach ( $xml->Hotel as $key => $item ) {
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