<?php 
require "global.php";
$xml_url = construct_url_hotels();
echo '<script>var xml_url_ajax ="';  
echo $xml_url; 
echo '";</script>';
?>

<style type="text/css">
	body{
	background-color: #DCDCDC;
}
</style>

  <link rel="stylesheet" type="text/css" media="all" href="css/style.css">
  <link rel="stylesheet" type="text/css" media="all" href="css/reset.css">
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<!--[if lt IE 9]>
  <script type="text/javascript" src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->


<img id="loading" src='img/loading.gif'>
<!-- Container -->
<div id="main-container">
</div>
 
 <script type="text/javascript">
         <!--
            function getConfirmation(){
               if(post_data == true) { var retVal = confirm("No hay resultados"); }
               if( retVal == true ){
				window.location = "buscador.html";
                  return true;
               }
               else{
                  window.location = "buscador.html";
                  return false;
               }
            }
            getConfirmation();
         //-->
      </script>
<script type="text/javascript" charset="utf-8" src="js/scroll.js"></script>
