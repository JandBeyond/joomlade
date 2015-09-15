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

    if($('.carousel.news.slide').length)
    {
        $('.carousel').carousel({
            interval: false
        });
    }

    $('#mainnav > ul > li.parent').hover(function(){
        if($(this).find(' > ul > li.module').length)
        {
            var list = $(this).children('ul');
            var module = list.children('li.module');

            if(module.height() > list.height())
            {
                list.height(module.height());
            }
        }
    });
});