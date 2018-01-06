var jQuery_1_8_2 = $.noConflict();
(function ($, undefined) {
	$(function () {
		var form = $('#login-form');



		if (form.length > 0) {
			form.validate({
				errorPlacement: function (error, element) {
					error.insertAfter(element.parent());
				},
				onkeyup: false,
				errorClass: "err",
				wrapper: "em"
			});
		}

		var groups = $('.group', form).filter(function(){
			return !$(this).hasClass('submit');
		}).click(function(){
			$(groups).removeClass('active');
			$(this).addClass('active');
		});
		$('#name').trigger('click').trigger('focus');


                                $('div#calendar ul li').on('click', function(){
                    if(!$('div#calendar ul li').hasClass('selected1') && sessionStorage.getItem('selected1') === null){
                    $(this).addClass('selected1');
                                //    console.log(this);
                                  //  console.log($(this).attr('id'));
                    sessionStorage.setItem("selected1", $(this).attr('id'));
                    sessionStorage.setItem("NextNamn",document.getElementById('Namn').value);

                    console.log(sessionStorage.getItem("NextNamn"));

                 sessionStorage.setItem("NextFordon",document.getElementById('FordonNamn').value);
                    $('div#calendar ul li.selected1').prevAll('div#calendar ul li').addClass('greyed');
                    $('div#calendar ul li.selected1').nextAll('div#calendar ul li').addClass('normal');
                    }else if($('div#calendar ul li').hasClass('selected1')){
                       // console.log(sessionStorage.getItem('selected1'));
                  //      $('div#calendar ul li').on('click', function(){
                            $('div#calendar ul li').removeClass('selected2');
                    $(this).removeClass('selected1');
                    $(this).addClass('selected2');

                    sessionStorage.setItem("selected2", $(this).attr('id'));

                     $('div#calendar ul li.selected2').prevAll('div#calendar ul li.normal').addClass('blued');
                    //sessionStorage.clear();

                //    });
                    }else if(sessionStorage.getItem('selected1') !== null){
                            $('div#calendar ul li').removeClass('selected2');
console.log(sessionStorage.getItem('selected1'));
                    $(this).removeClass('selected1');
                    $(this).addClass('selected2');
                   sessionStorage.setItem("selected2", $(this).attr('id'));
                        //console.log(sessionStorage.getItem('selected2'));
                     $('div#calendar ul li.selected2').prevAll('div#calendar ul li').addClass('blued');

                    }
                                });

                          $('.bokarad').on('click', function(){
                    if(!$('.bokarad').hasClass('selected') && sessionStorage.getItem('selected') === null){
                    $(this).addClass('selected');
                                console.log(this);
                                  //  console.log($(this).attr('id'));
                    sessionStorage.setItem("bokaDatum", $(
											'.bokarad.selected td.fordon.datum input').attr('value'));
											console.log(sessionStorage.getItem('bokaDatum'));
                    sessionStorage.setItem("turId",
										$('.bokarad.selected td.fordon.tur input[name=TurID]').attr('value'));
										sessionStorage.setItem("regNr",
										$('.bokarad.selected td.fordon.tur input[name=RegNummer]').attr('value'));
										//sessionStorage.setItem("bokaRegNr", $('.bokarad td.regNr input').attr('value'));
                    }else if($('.bokarad').hasClass('selected')){
                    $('.bokarad').removeClass('selected');
                    sessionStorage.clear();
                    }
                                });

											$('.oversiktrad').on('click', function(){
			                    if(!$('.oversiktrad').hasClass('selected') && sessionStorage.getItem('selected') === null){
			                    $(this).addClass('selected');
			                                console.log(this);
																			$('.turNamn').text(
																				$('.oversiktrad.selected td.fordon.tur input[name=TurNamn]').attr('value'));

																					var kundNamn = $('.oversiktrad.selected td.fordon.tur input[name=KundNamn]').attr('value');

																						var orderId = $('.oversiktrad.selected td.fordon.tur input[name=OrderID]').attr('value');

																					$('.tbody').append(
																						'<tr> <td>'+kundNamn+'</td> <td>'+orderId+'</td> <td><a href="http://expabtrans.local/boka.php?ac=redigera&amp;OrderID='+orderId+'" id="tablebutton">Ändra</a></td><td><a href="#" id="tablebutton">Ta bort</a></td></tr>');

			                    }else if($('.oversiktrad').hasClass('selected')){
			                    $('.oversiktrad').removeClass('selected');
													$('.tbody tr').remove();
			                    sessionStorage.clear();
			                    }
			                                });
 $('div#calendar ul li:not(.greyed)').on("click", function(event) {
                        console.log($(this));
                      event.preventDefault();

                          var data = new Array();

                        for (i = 0; i < sessionStorage.length; i++) {
                         data.push(sessionStorage.getItem(sessionStorage.key(i)));
                        };

                       for (var i=data.length-1; i>=0; i--) {
    if (data[i].includes('php')) {
        data.splice(i, 1);
        // break;       //<-- Uncomment  if only the first term has to be removed
    }
};
                if(sessionStorage.getItem('selected1') !== null){
                        $.ajax({
                       type: "POST",
                       url: "turer.php",
                        data: {calinfo:JSON.stringify(data)},
                        success: function () {
                            console.log(data);

                        }
                        });
                }

            });

    $('.bokarad').on("click", function(event) {
                        console.log($(this));
                      event.preventDefault();

                          var data = new Array();

                        for (i = 0; i < sessionStorage.length; i++) {
                         data.push(sessionStorage.getItem(sessionStorage.key(i)));
                        };

                       for (var i=data.length-1; i>=0; i--) {
    if (data[i].includes('php') || data[i].includes('undefined')) {
        data.splice(i, 1);
        // break;       //<-- Uncomment  if only the first term has to be removed
    }
};
                if(sessionStorage.getItem('bokaDatum') !== null
								&& sessionStorage.getItem('turId') !== null
							&& sessionStorage.getItem('regNr') !== null){
                        $.ajax({
                       type: "POST",
                       url: "boka.php",
                        data: {TurFordonInfo:JSON.stringify(data)},
                        success: function () {
                            console.log(data);

                        }
                        });
                        };
            });


window.onload = function(){
       console.log(sessionStorage.getItem("url2"));
        var prev = window.location.href.substr(window.location.href.indexOf(".")+6);

    console.log(prev);
    if ((window.location.href === sessionStorage.getItem("url1") ||
       prev === sessionStorage.getItem("url2") || (window.location.href.indexOf('spara') > -1) || (window.location.href.indexOf('redigera') > -1)) || window.location.href.indexOf('turer') <= -1){
        console.log('true');
         sessionStorage.clear();
        sessionStorage.setItem("url1", window.location.href);
        sessionStorage.setItem("url2", $(".prev").attr("href"));
    }else{
        console.log('false');
        sessionStorage.setItem("url1", window.location.href);
        sessionStorage.setItem("url2", $(".prev").attr("href"));
    }
      }

});
})(jQuery_1_8_2);
