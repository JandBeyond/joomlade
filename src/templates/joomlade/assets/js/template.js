/*
* joomla.de template js 
*/

jQuery( document ).ready(function( $ ) {
    $('#navtoggler').click(function() { $('body').toggleClass('shownav') });
	
	$('#myCarouselblogcarousel').carousel({
		interval: 10000
	})

	$('.carouselbloginner .item').each(function(){
		var next = $(this).next();
		if (!next.length) {
			next = $(this).siblings(':first');
		}
		next.children(':first-child').clone().appendTo($(this));

		if (next.next().length>0) {
			next.next().children(':first-child').clone().appendTo($(this));
		}
		else {
			$(this).siblings(':first').children(':first-child').clone().appendTo($(this));
		}
	});

});