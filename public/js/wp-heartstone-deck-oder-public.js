(function ( $ ) {
	"use strict";
	$(document).mousemove(function(event) {
        $('#hover-card').css('top', event.pageY - 50);
		$('#hover-card').css('left', event.clientX  + 50);
    });

	$(document).ready(function() {
		$('.card-frame').hover(
			function() {
				var art_id = $(this).attr('dbfid');
				var art_url = 'https://art.hearthstonejson.com/v1/render/latest/enUS/256x/' + art_id + '.png';
			 	$('#hover-card').attr("src", art_url);
				$('#hover-card').css('display', 'block');
				if($('.primary').length){
					$('.primary').css('position', 'initial');
				}
				

			}, function() {
				$('#hover-card').css('display', 'none');
				if($('.primary').length){
					$('.primary').css('position', '');
				}
				
			});

			$('.btn-deck-copy').click(function() {
				var deckstring = $(this).attr('data-deck-copy');
				var $temp = $("<input>");
				$("body").append($temp);
				$temp.val(deckstring).select();
				document.execCommand("copy");
				$temp.remove();
				$(this).html('Copied!');
			});

	});
}(jQuery));