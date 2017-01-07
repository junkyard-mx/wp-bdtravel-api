<?php
/* Global functions of plugin by David Leal */

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
check_data();

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
	$string = "?a=AF-ANI"; 							// User ID
	$string .= "&ip=192.168.1.0" .  $ipaddress; 	//IP usuario
	$string .= "&c=" . "pe";		 				//Moneda
	$string .= "&sd=" . $new_sd; 					//Fecha de inicio
	$string .= "&ed=" . $new_ed; 					// Fecha de termino
	$string .= "&h="; 								//ID del hotel
	$string .= "&rt=";								//Room code
	$string .= "&mp=";								//Meal plan code
	
	$string .= "&r=" . $_POST['rm'];				//Numero de cuartos
	$string .= "&r1a=" . $_POST['ad1'];				//Adultos en el cuarto 1
	$string .= "&r1k=" . $_POST['ch1'];				//Niños en el cuarto uno
	$string .= "&r1k1a=" .  $r1k1a ; 							//Edad de los niños en el cuarto uno 'ac1, 'ac2, 'ac3
	$string .= "&r1k2a=" .  $r1k2a  ;							/**** Siguen cuartos y edades de niños ***/
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

	$string .= "&d=" . $_POST['di']; ;								// Codigo de Destino
	$string .= "&l=esp"; 							// Lenguaje
	$string .= "&hash=";							// ??

	//Print
	$xmlURL =  $base . $string;
	return $xmlURL;
}

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
?>