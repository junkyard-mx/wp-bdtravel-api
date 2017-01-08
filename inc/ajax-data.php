<?php
function get_quote_hotels() {
	// Variables from ajax request
	$datafile = $_POST['xml_url'];
	$random_id = $_POST['request_id'];
	
	$xml = bdtravel_get_xml_object( $datafile, 'quote_hotels_' . $random_id );
	
	//Load xml file
	if( ! $xml ) { 
		echo '<script type="text/javascript">console.log("Unable to load XML file")</script>';
	    echo $datafile;
    } else { 
		echo '<script type="text/javascript">console.log("XML file loaded successfully")</script>';  
	}

	//Quote ID
	$quote_id = $xml->QuoteId;

	//Sort by Review->Rating
	$hotels = array();
	foreach( $xml->Hotels->Hotel as $hotel ) {
	    $hotels[] = $hotel;
	};

	//Pagination
 	$startPage = $_POST['page'];
    $perPage = 10;
    $currentRecord = 0;
    $total = count($hotels);


	//get hotel entry
	foreach ( $hotels as $hotel ) {
		$currentRecord += 1;
	    if ( $currentRecord > ( $startPage * $perPage ) && $currentRecord < ( $startPage * $perPage + $perPage ) ) {
	    
		    $counter="<input type='hidden' class='nextpage' value='".($startPage+1)."'><input type='hidden' class='isload' value='true'>";

		    //getting hotel details
			$HName = $hotel[0]->Name;
			$HDescription = $hotel->Description;
			$HImage = $hotel->Image;
			$HCategory = $hotel->CategoryId;
			$HLocation = $hotel->CityName;
			$hotel_id = $hotel->Id;
			$HRating = $hotel->Reviews->Review->Rating;
			$hotel_endpoint = get_page_link( Helper_Functions::get_pages_configuration( 'page_hotel_details' ) );

			//Get room details
			foreach ( $hotel->Rooms->children()  as $room ) {
				if( isset( $room->MealPlans->MealPlan->AverageTotal ) ){
					$tipoHabitacion = $room->Name;
					$planAlimentos = $room->MealPlans->MealPlan->Name;
					$precioPromedio = $room->MealPlans->MealPlan->AverageTotal;
					$precio_sin_promocion = $room->MealPlans->MealPlan->AverageNormal;

				break;
				}
			}
			// include template part
			include PLUGIN_PATH . '/template-parts/content-hotels.php';
				
			if( $currentRecord == $total ){
				echo '<div>Sorry, no more results to display.</div>' ;
			}
		
		}
	}  //ends foreach
} // ends function
// TODO: only run this on hotels page
add_action( 'wp_ajax_get_quote_hotels', 'get_quote_hotels' );
add_action( 'wp_ajax_get_quote_hotels', 'get_quote_hotels' );

function bdtravel_fetch_xml( $url ) {
	$data = false;

	if ( $url ) {

		$response = wp_remote_get( $url, array('timeout' => 15) );

		if ( ! is_wp_error( $response ) ) {
			$data = wp_remote_retrieve_body( $response );
		}

	}

	return $data ? $data : false;
}

function bdtravel_get_xml_object( $url, $name ) {

	if ( false === ( $xml_file = get_transient( $name ) ) ) {

		$xml_file = bdtravel_fetch_xml( $url );

		if ( $xml_file ) {

		  set_transient( $name, $xml_file, HOUR_IN_SECONDS ); // 1 hour

		}

	}
	return $xml_file ? @simplexml_load_string( $xml_file ) : false;
}
