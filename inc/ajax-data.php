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
foreach($xml->Hotels->Hotel as $hotel) {
    $hotels[] = $hotel;
};

// usort ($hotels, function($a, $b) {
//     return strcmp($b->Reviews->Review->Rating, $a->Reviews->Review->Rating);
// });

	//Pagination
 	$startPage = $_POST['page'];
    $perPage = 10;
    $currentRecord = 0;
    $total = count($hotels);


//get hotel entry
foreach ($hotels as $hotel) {
	 $currentRecord += 1;
    if($currentRecord > ($startPage * $perPage) && $currentRecord < ($startPage * $perPage + $perPage)){
    
    $counter="<input type='hidden' class='nextpage' value='".($startPage+1)."'><input type='hidden' class='isload' value='true'>";

    //getting hotel details
	$HName = $hotel[0]->Name;
	$HDescription = $hotel->Description;
	$HImage = $hotel->Image;
	$HCategory = $hotel->CategoryId;
	$HLocation = $hotel->CityName;
	$HId = $hotel->Id;
	$HRating = $hotel->Reviews->Review->Rating;

		//Get habitations details
		foreach ($hotel->Rooms->children()  as $room ) {
			if(isset($room->MealPlans->MealPlan->AverageTotal)){
				$tipoHabitacion = $room->Name;
				$planAlimentos = $room->MealPlans->MealPlan->Name;
				$precioPromedio = $room->MealPlans->MealPlan->AverageTotal;
				$precio_sin_promocion = $room->MealPlans->MealPlan->AverageNormal;

			break;
			}
				// //Get habitation -> Mealplans details
				// foreach ($room->MealPlans->children() as $roomDetail) {
				// 	//echo $roomDetail->Name.' '.$roomDetail->AverageGrossTotal.'<br>';
				// }
		}
?>
	<div class="content-summary" id="<?php echo $HId ?>">
		<div class="left-info">
			<div class="hotel-image"><a href="<?php echo $url_params. '&promedio='.$precioPromedio.'&h=' . $HId; ?>"><img src="<? echo $HImage ?>" /></a></div>
			<h2 class="hotel-name"><a href="<?php echo $url_params. '&promedio='.$precioPromedio.'&h=' . $HId; ?>"> <?php echo $HName ?> </a></h2>
			<div class="category stars <?php echo $HCategory ?>"></div>
			<div class="rating"><i class="fa fa-comment-o"></i> <?php echo $HRating ?><span class="rating-small">/5 de Calificación</span></div>
			<ul class="more-details">
				<li class="location"><i class="fa fa-location-arrow"></i> <?php echo $HLocation ?></li>
				<!-- <li><?php echo $tipoHabitacion ?></li> -->
				<li class="plan-alimentos"><?php echo $planAlimentos ?></li>
			</ul>
		</div>
		<div class="right-info">
			<div class="normal-price"><span style="font-size:9px;">MXN$</span> <?php echo round($precio_sin_promocion, 2) ?></div>
			<div class="price"><span style="font-size:14px;">MXN$</span> <?php echo round($precioPromedio, 2) ?></div>
			<p>Precio por Noche</p>
			<p>Impuestos incluidos</p>
			<a href="<?php echo $url_params. '&promedio='.$precioPromedio.'&h=' . $HId; ?>">
				<div class="bd-button">Reservar</div>
			</a>
		</div>	
		<? echo $counter; ?>
	</div>
	<div class="divider"></div>
	<? if( $currentRecord == $total){echo '<div>Sorry, no more results to display.</div>' ;} ?>
	
<?php
}}  //ends foreach
} // end function
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
