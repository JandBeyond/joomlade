/*
* joomla.de template js 
*/

jQuery( document ).ready(function( $ ) {
    $('#navtoggler').click(function() { $('body').toggleClass('shownav') });

    $(window).resize(function(){
        if($(window).width() >= 768)
        {
            $('body').removeClass('shownav');
        }
    });
});