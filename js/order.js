function displayErrorFields(){
	$('.order_form input[type=text]').each(function(i){
		if($(this).prev().children().text() == "ОШИБКА ВВОДА"){
			$(this).toggleClass('field_error');
		}
	})
}

function sendForm(){
	$('.order_form').live('submit', function(e){
		e.preventDefault();

		$.ajax({
			type: 'POST',
			url: 'http://coffee2go/order',
			data: $('.order_form').serialize(),
			success: function(data){
				$('.order_form_block').replaceWith(data);
				displayErrorFields();

				$.ajax({
	                type: "GET",
	                url: "http://coffee2go/cart",
	                dataFilter: function(server){
	                    return $(server);
	                },
	                success: showCart
            	});
			}
		});
	});
}

function showCart(cart){
            $('.order_list').replaceWith(cart);
            $('.cart_wraper').prepend(cart);
            $('#cartForm').bind('submit', function(e){
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: "http://coffee2go/cart",
                    data: $('#cartForm').serialize(),
                    dataFilter: function(server){
                        return $(server);//.find('.order_list');
                    },
                    success: showCart
                });
            });

            $.ajax({
                type: 'GET',
                url: window.location.href,
                success: function(data){
                    var content = $(data).find('.info_text');
                    $('.info_text').replaceWith(content);
                }
            });

            $('.close_popup_window').on('click', function(e){
                    e.preventDefault();
                    showHideCartBlock();
            });

            refreshCartOnAmountChange();

        };