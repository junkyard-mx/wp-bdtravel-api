 var ajax_arry=[];
 var ajax_index =0;
 var sctp = 100;
 var xml_url_ajax_clean = encodeURIComponent(xml_url_ajax);

 //Generate Random ID
 function randomID()
{
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < 10; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}


 jQuery(function($){
   $('#loading').show();
   var random_id_post = randomID();
   
 $.ajax({
	     url:"/wp-content/plugins/e-travel-api-vxl/data.php",
                  type:"POST",
                  data:"page=0&xml_url=" + xml_url_ajax_clean + "&request_id=" + random_id_post,
        cache: false,
        success: function(response){
		   $('#loading').hide();
		  $('#main-container').html(response);
		   
		}
		
	   });

	$(window).scroll(function(){
       
	   var height = $('#main-container').height();
	   var scroll_top = $(this).scrollTop();
	   if(ajax_arry.length>0){
	   $('#loading').hide();
	   for(var i=0;i<ajax_arry.length;i++){
	     ajax_arry[i].abort();
	   }
	}
	   var page = $('.content-summary').find('.nextpage').val();

	   var isload = $('.content-summary').find('.isload').val();
	   var containerHeight =  $("#main-container").css('height');

	   	//alert(document.documentElement.clientHeight);

	     if (( ( $(window).scrollTop() + window.innerHeight ) >= $(document).height() - 700 ) && isload=='true'){
		 $('#loading-bottom').show();
	  	 var ajaxreq = $.ajax({
	     url:"/wp-content/plugins/e-travel-api-vxl/data.php",
                  type:"POST",
                  data:"page=" + page + "&xml_url=" + xml_url_ajax_clean + "&request_id=" + random_id_post,
        cache: false,
        success: function(response){
		   $('#main-container').find('.nextpage').remove();
		   $('#main-container').find('.isload').remove();
		   $('#loading-bottom').hide();
		   
		  $('#main-container').append(response);
		 
		}
		
	   });
	   ajax_arry[ajax_index++]= ajaxreq;
	   
	   }
	return false;

 if($(window).scrollTop() == $(window).height()) {
   }
	});

});

//Update URL when scroll
// $(function () {
//     var currentHash = "#first"
//     $(document).scroll(function () {
//         $('.content-summary').each(function () {
//             var top = window.pageYOffset;
//             var distance = top - $(this).offset().top;
//             var hash = $(this).attr('id');

//             if (distance < 30 && distance > -30 && currentHash != hash) {
//             	window.location.hash = hash;
//                 //alert(hash);
//                 currentHash = hash;
//             }
//         });
//     });
// });
	  