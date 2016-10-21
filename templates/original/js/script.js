jQuery.noConflict();
(function($){
  $(document).ready(function(){
    $('.sigProLink,.slimbox').append('<span class="zoom"></span>');
	$('#slider-serv ul:first').bxSlider({
        controls: true,
		auto:true,
		pager:false,
		displaySlideQty:6,
		
		moveSlideQty:1,
		pause:6000});
		
	$('.uk-click').click(function(){
		var index = $(this).attr('rel');
		var href = $('.ari-image-slider.nivoSlider .nivo-imageLink').eq(index).attr('href');
		window.open(href, '_blank');
	});
  });
  $(window).load(function(){
	  $('#slider .nivo-controlNav').hide()
	var i = 0;
    $('#slider .imageslider-item').each(function(){
		$('#slider .nivo-controlNav a[rel="'+i+'"]').html($(this).attr('title'));
		i++;
	});
	$('#slider .nivo-controlNav a:last').after('<div class="clr"></div>');
	$('#slider .nivo-controlNav').hide().show();
  });
})(jQuery);