
 // //Slider
 jQuery(document).ready(function($) {
    $('#image-gallery').lightSlider({
        gallery:true,
        item:1,
        thumbItem:5,
        slideMargin: 0,
        speed:500,
        auto:true,
        loop:true,
        pause: 4000,
        currentPagerPosition: 'right',
        onSliderLoad: function() {
            $('#image-gallery').removeClass('cS-hidden');
        }  
    });

    //Remove empty <li>
    $('ul li:empty').remove();
});

function randomID() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < 10; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}



 jQuery(document).ready(function($){

    // ajax url
    var ajax_arry=[];
    var ajax_index =0;
    var sctp = 100;
    var xml_url_ajax = $('input#bd-ajax-url').val();
    
    $('#loading').show();
    var random_id_post = randomID();

    $.ajax({
        url: 'http://travelhub.dev:8888/wp-admin/admin-ajax.php',
        type:"POST",
        data: {
            'action' : 'get_quote_hotels',
            'page' : 0,
            'xml_url' : xml_url_ajax,
            'request_id' : random_id_post
        },
        success: function(response){
            $('#loading').hide();
            $('#main-container').html(response);
        },
        error: function(errorThrown){
            console.log(errorThrown);
        }
    });

    $(window).scroll(function(){

    var height = $('#main-container').height();
    var scroll_top = $(this).scrollTop();
    
    if( ajax_arry.length > 0 ){
        $('#loading').hide();

        for(var i=0;i<ajax_arry.length;i++){
            ajax_arry[i].abort();
        }
    }

    var page = $('.content-summary').find('.nextpage').val();
    var isload = $('.content-summary').find('.isload').val();
    var containerHeight =  $("#main-container").css('height');


    if ( ( ( $(window).scrollTop() + window.innerHeight ) >= $(document).height() - 700 ) && isload === 'true' ) {
        $('#loading-bottom').show();
        var ajaxreq = $.ajax({
            url: 'http://travelhub.dev:8888/wp-admin/admin-ajax.php',
            type:"POST",
            data: {
                'action' : 'get_quote_hotels',
                'page' : page,
                'xml_url' : xml_url_ajax,
                'request_id' : random_id_post
            },
            success: function(response){
                $('#main-container').find('.nextpage').remove();
                $('#main-container').find('.isload').remove();
                $('#loading-bottom').hide();
                $('#main-container').append( response );
            },
            error: function(error, jqXHR){
                console.log(error, jqXHR);
            }
        });
        ajax_arry[ajax_index++]= ajaxreq;
    }

    return false;

    if( $( window ).scrollTop() == $(window).height() ) { }
    });

    /** date picker **/
    $( function() {
    var dateFormat = "mm/dd/yy",
      from = $( "#startDate" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 1
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#endDate" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
        // get date
        function getDate( element ) {
          var date;
          try {
            date = $.datepicker.parseDate( dateFormat, element.value );
          } catch( error ) {
            date = null;
          }
     
          return date;
        }
    });

    // Hotels and destinations auto complete
    $( function() {
        $( "#destination" ).autocomplete({
            source: function( request, response ) {
                $.ajax( {
                    url: "http://ajax.e-tsw.com/searchservices/getSearchJson.aspx",
                    dataType: "jsonp",
                    jsonpCallback: "BDHotels",
                    data: {
                        Lenguaje: "ESP",
                        ItemTypes: "H:10,D:10,C:10",
                        Oder: "H,D,C",
                        Filters: "",
                        PalabraBuscada: request.term
                    },
                    success: function( data ) {
                        response( $.map( data.results, function( item ) {
                            return {
                                label: item.Label,
                                Type: item.Type,
                                ID: item.TypeID
                            }
                        }));
                    }
                } );
            },
            minLength: 2,
            select: function( event, ui ) {
                $( '#did' ).val( ui.item.ID );
                $( '#dtype' ).val( ui.item.Type );
            }
        } );

        // On search form submit
        $( "#hotels-search-box" ).submit(function( event ) {
            event.preventDefault();
            if ( 'H' === $( "#dtype" ).val() ) {
                // go to hotel details
                var hotelEndpoint = $('#hotel-details-url').val();
                $('#hotels-search-box').attr( 'action', hotelEndpoint );
                $('#hotels-search-box')[0].submit();
            } else {
                // go to hotels list
                var hotelDetailsEndpoint = $('#hotels-url').val();
                $('#hotels-search-box').attr( 'action', hotelDetailsEndpoint );
                $('#hotels-search-box')[0].submit();
            }
        });

    } );

}); // end of file
      