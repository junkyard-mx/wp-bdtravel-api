 // //Slider
 var $ = jQuery.noConflict();
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