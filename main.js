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
                    sessionStorage.setItem("bokaDatum", $('.bokarad td.datum input').attr('value'));
                    sessionStorage.setItem("bokaTur", $('.bokarad td.tur input').attr('value'));
                    }else if($('.bokarad').hasClass('selected')){
                    $('.bokarad').removeClass('selected');
                    sessionStorage.clear();
                    }
                                });

            /*  $(".next, .prev").on("click submit", function(event) {
                var form =  sessionStorage.getItem('form');
                console.log(form);
                var data = new Array();
                if (form !== null){
                    for (i = 0; i < sessionStorage.length; i++) {
                     data.push(sessionStorage.getItem(sessionStorage.key(i)));
                    };

                    $.ajax({
                   type: "POST",
                   url: "turer.php",
                    data: {calinfo:JSON.stringify(data)},
                    success: function () {
                        console.log(data)
                    }
                    });


};

            });*/           $('div#calendar ul li:not(.greyed)').on("click", function(event) {
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
                if(sessionStorage.getItem('bokadatum') !== null && sessionStorage.getItem('bokatur') !== null){
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

        /*
            $("#calendarform, .date, .next, .prev").on("click submit", function(event) {
  console.log($(this));
                      event.preventDefault();



                      var $form = $( this ),
                          url = $form.attr( 'action' );


                      var posting = $.post( url, { date: $(this).val()});


                       // if (($(this).attr('id')) !== 'calendarform'){
                        console.log($(this));
                        var $link = $( this ),
                      url = $link.attr( 'href');

                   //  posting.done(function( data ) {

                    var data = new Array();

                        for (i = 0; i < sessionStorage.length; i++) {
                         data.push(sessionStorage.getItem(sessionStorage.key(i)));
                        };

                        if(sessionStorage.getItem('selected1') !== null &&
                           sessionStorage.getItem('selected2') !== null){
                        $.ajax({
                       type: "POST",
                       url: url,
                        data: {calinfo:JSON.stringify(data[0], data[1])},
                        success: function () {
                            console.log(data);

                        }
                        });
                        };

                        window.location = url;

                     // });
           // }
            });*/

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
