(function ($) {
	"use strict";
	$(function () {


		function highlightDate(date){
			var dates = new Array() ;
			var i = 0;

			//console.log(date) ;

			$('div#better_calendar_events .event_date_start').each(function(){

				dates[$(this).attr('data-date')] = $(this).attr('data-date');
				i++;
				
			});

			if((date.getMonth() + 1) < 10){
				var search = (date.getDate()) + "/" + "0" + (date.getMonth() + 1) + "/" + date.getFullYear();
			}
			else{
				var search = (date.getDate()) + "/" + (date.getMonth() + 1) + "/" + date.getFullYear();
			}

			var Highlight = dates[search];

            if (dates[search]) {

                return [true, "highlight", Highlight];

            }

            else {

                return [false, '', ''];

            }

		}

		$('#better_calendar').datepicker({
			dateFormat: "dd/mm/yy",
			firstDay: 1,
			minDate: 0,
			beforeShowDay: highlightDate,
			onSelect: selectEvent
		}) ;

		function selectEvent(date){

			var selector = "div#better_calendar_events div.event." + date.replace(/\//g, '-') ;

			//Hide all rows desc
			$('div#better_calendar_events div.event').hide() ;
			$('div#better_calendar_events div.event').removeClass('show') ;


			if($(selector).hasClass('show')){
				
				//Hide event description
				$(selector).hide('slow').removeClass('show') ;

			}
			else{
			//console.log($(selector).css('display'));

				//Hide event description
				$(selector).show('slow').addClass('show') ;
			}

		}
	});
}(jQuery));