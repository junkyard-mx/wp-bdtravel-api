
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

});
      