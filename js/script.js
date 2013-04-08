$(document).ready(function(){
	var mgBaseDir = $('.mgBaseDir').text();
	//Показать форму закрытия заказов
	$('.close-order').click(function(){
            $('.reason-text').val('');
            $('strong[class=orderId]').text($(this).attr('id'));
            $('span[class=orderDate]').text($(this).attr('date'));
	});

	//Инициализация fancybox
    $(".close-order, a.fancy-modal").fancybox({
	'overlayShow'   :   false
	});


	//при наведении на фото, появляется лупа для увеличения
	$('a.fancy-modal').hover(
        function () {
            $('.zoom').stop().fadeTo(200,1.0);

        },
        function () {
             $('.zoom').stop().fadeTo(200,0.0);
        }
    );


	//Закрытие заказа из личного кабинета
	$('.close-order-btn').click(function(){
		var id = $('strong[name=orderId]').text();
		var comm = $('.reason-text').val();
		  $.ajax({
			type:"POST",
			url: "personal",
			data: {
				delOK:"OK",
				delID: id,
				comment: comm
			},
			cache: false,
			dataType: 'json',
			success: function(response){
				if(response.msg){
					$('a[name=next]').click();
					$('.order-history#'+id+' .order-number .order-status strong').text(response.orderStatus);
					$('.order-history#'+id+' .order-settings').text('Заказ закрыт или в работе');
				}else{
					$('a[name=error]').click();
				}
			}
		  });
		});


	//Количество товаров
	$('.amount_change .up').click(function(){
	    var obj = $(this).parents('.cart_form').find('.amount_input');
		var i = obj.val();
		i++;
		obj.val(i);
		return false;
	});
	$('.amount_change .down').click(function(){
		var obj = $(this).parents('.cart_form').find('.amount_input');
		var i = obj.val();
		i--;
		if(i<=0){
		i=1;
		}
		obj.val(i)
		return false;
		});

	//Показать суб меню при клике
	$("ul.cat-list li:has(ul)").addClass("active-menu");
	$("ul.sub-cat-list li:has(ul)").addClass("active-menu");

	//Показать маленькую корзину
	$('.cart').hover(function(event){
		event.stopPropagation();
		if($('.small-cart-table tbody tr').length > 0){
		  $('.small-cart').slideDown();
		};

	},
	function(){
		 $('.small-cart').slideUp();
	});

	//Клик вне области закрывает корзину
	$(document).click(function(e){
		if ($(e.target).parents().filter('.small-cart:visible').length != 1) {
			$('.small-cart').slideUp();
		}
	});

	//Большой слайдер
	 $("#slides").slides({
        generateNextPrev: false,
		play: 5000,
		slideSpeed: 1000,
		hoverPause: false,
		effect: 'fade',
		prev: 'prev',
		next: 'next'
      });

	  // Обработка ввода поисковой фразы в поле поиска
      $('body').on('keyup', 'input[name=search]', function(){

         var text = $(this).val();
         if(text.length>=2) {
            $.ajax({
				type: "POST",
				url: "ajax",
				data: {
				  action: "getSearchData", // название действия в пользовательском класса Ajaxuser
				  actionerClass: "Ajaxuser", // ajaxuser.php - в папке шаблона
				  search:text
				},
				dataType: "json",
				cache: false,
				success: function(data){
				   var html = '<ul class="fast-result-list">';
				   function buildElements(element, index, array) {
					 html += '<li> <div class="fast-result-img"><img src="'+mgBaseDir+'/uploads/'+element.image_url+'" alt="'+element.title+'"/></div><a href="'+mgBaseDir+'/'+(element.category_url?element.category_url:'vse')+'/'+element.product_url+'">'+element.title+'</a><span>'+element.price+ ' руб.</span></li>';
				   };

				   if('success' == data.status){
					 console.log(data.item.items.catalogItems)
					 data.item.items.catalogItems.forEach(buildElements);
					 html += '</ul>';
					 $('.fastResult').html(html);
					 $('.fastResult').show();
				   }
				}
			  });
         }
      });


	 // Заполнение корзины аяксом
     $('body').on('click', '.addToCart', function(){
		var itemId = $(this).data('item-id');
		var count = $(this).parents('.buy-block').find('.amount_input').val();

		  $.ajax({
			type: "POST",
			url: "ajax",
			data: {
			  action: "updateCart", // название действия в пользовательском класса Ajaxuser
			  actionerClass: "Ajaxuser", // ajaxuser.php - в папке шаблона
			  itemId:itemId,
			  count:count
			},
			dataType: "json",
			cache: false,
			success: function(response){

			  if('success' == response.status){
				dataSmalCart = '';
				response.data.dataCart.forEach(printSmalCartData);

				$('.small-cart-table').html(dataSmalCart);
				$('.total .total-sum span').text(response.data.cart_price_wc);
				$('.cart-qty .pricesht').text(response.data.cart_price);
				$('.cart-qty .countsht').text(response.data.cart_count);
			  }
			}
		  });

		 return false;
      });

	  // Исключение ввода в поле выбора количесва не допустимых значений
      $('body').on('keyup', '.amount_input', function(){

		  if(isNaN($(this).val()) || $(this).val()<=0 ){
		    $(this).val('1');
		  }
	  });

	 // Удаление вещи из корзины аяксом
     $('body').on('click', '.deleteItemFromCart', function(){
		var $this = $(this);
		var itemId = $this.data('delete-item-id');

		  $.ajax({
			type: "POST",
			url: "ajax",
			data: {
			  action: "delFromCart", // название действия в пользовательском класса Ajaxuser
			  actionerClass: "Ajaxuser", // ajaxuser.php - в папке шаблона
			  itemId: itemId,
			},
			dataType: "json",
			cache: false,
			success: function(response){
			 // console.log(response.data.cart_price);
			  if('success' == response.status){
          $this.parents('tr').remove();
          $('.total .total-sum span').text(response.data.cart_price_wc);
          response.data.cart_price = response.data.cart_price?response.data.cart_price:0;
          response.data.cart_count = response.data.cart_count?response.data.cart_count:0;
          $('.cart-qty .pricesht').text(response.data.cart_price);
          $('.cart-qty .countsht').text(response.data.cart_count);

          if($('.small-cart-table tbody tr').length == 0){
          $('.small-cart').hide();
          };
			  }
			}
		  });

		 return false;
      });

	  // строит содержимое маленькой корзины в  выпадащем блоке
	  function printSmalCartData(element, index, array){
	  		dataSmalCart +='<tr>\
				<td class="small-cart-img">\
					<a href="'+mgBaseDir+'/'+(element.category_url?element.category_url:'vse')+'/'+element.product_url+'"><img src="'+mgBaseDir+'/uploads/'+element.image_url+'" alt="'+element.title+'" alt="" /></a>\
				</td>\
				<td class="small-cart-name">\
					<ul class="small-cart-list">\
						<li><a href="'+mgBaseDir+'/'+(element.category_url?element.category_url:'vse')+'/'+element.product_url+'">'+element.title+'</a></li>\
						<li class="qty">x'+element.countInCart+' <span>'+element.priceInCart+'</span></li>\
					</ul>\
				</td>\
				<td class="small-cart-remove"><a href="#" class="deleteItemFromCart" title="Удалить" data-delete-item-id='+element.id+'>&#215;</a></td>\
			</tr>';
	  }


	  $(".addToCart, .product-buy").click(function(){
			$(this).closest('.product-wrapper, .product-details-block').find('.product-image a img, .product-details-image > a > img').effect("transfer", { to: $(".cart"), className: "transfer_class" }, 500);
			$('.transfer_class').html($(this).closest('.product-wrapper, .product-details-block').find('.product-image, .product-details-image').html());
			$('.transfer_class').find('img').css({'height': '100%', "opacity": 0.5});
		});

});