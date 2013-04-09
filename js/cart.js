var url = '';

function changeGoodWord(count){
            var cnt = count;
            cnt = cnt.toString();
            var lastIndex = cnt.length;
            var firstIndex = lastIndex-2;

            var res = cnt.slice(firstIndex, lastIndex);
            res =  res*1;
            if(res > 10 && res < 21){
                $('.small_cart_word').text("товаров");
            }
            else{
                if(res > 9){
                    res = res.toString();
                    res = res.slice(1, 2);
                    res = res*1;
                }
                switch (res){
                    case 1: $('.small_cart_word').text("товар");
                        break;
                    case 2: 
                    case 3: 
                    case 4: $('.small_cart_word').text("товара"); 
                        break;
                    default: $('.small_cart_word').text("товаров");
                        break;
                }
            }
        };
function changeCatalogCount(){
            var cnt = $('#products_list .product').length;
            cnt = cnt.toString();
            var lastIndex = cnt.length;
            var firstIndex = lastIndex-2;

            $('.catalog_amount').html($('#products_list .product').length);

            var res = cnt.slice(firstIndex, lastIndex);
            res =  res*1;
            if(res > 10 && res < 21){
                $('.catalog_word').text("товаров");
            }
            else{
                if(res > 9){
                    res = res.toString();
                    res = res.slice(1, 2);
                    res = res*1;
                }
                switch (res){
                    case 1: $('.catalog_word').text("товар");
                        break;
                    case 2: 
                    case 3: 
                    case 4: $('.catalog_word').text("товара"); 
                        break;
                    default: $('.catalog_word').text("товаров");
                        break;
                }
            }
        };

$(function(){
        changeCatalogCount();

        // Показываем форму заказа и корзину при нажатии на кнопку "Показать корзину"
        $('.showCart').live('click', function(e){
            e.preventDefault();

            $.ajax({
                type: "GET",
                url: url + "/cart",
                dataFilter: function(server){
                    return $(server);
                },
                success: showCart
            });

            $.ajax({
                type: "GET",
                url: url + "/order",
                success: showOrderForm
            });

            $('.close_popup_window').live('click', function(e){
                    e.preventDefault();
                    showHideCartBlock();
            });

            showHideCartBlock();

        });

        function showCart(cart){
            $('.order_list').replaceWith(cart);
            $('.cart_wraper').prepend(cart);
            $('#cartForm').bind('submit', function(e){
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: url + "/cart",
                    data: $('#cartForm').serialize(),
                    dataFilter: function(server){
                        return $(server);//.find('.order_list');
                    },
                    success: showCart
                });
            });

            /*$.ajax({
                type: 'GET',
                url: window.location.href,
                success: function(data){
                    var content = $(data).find('.info_text');
                    $('.info_text').replaceWith(content);
                }
            });*/

            changeGoodWord($('.small_cart_amount').html());

            $('.close_popup_window').on('click', function(e){
                    showHideCartBlock();
                    return false
            });

            refreshCartOnAmountChange();

            var spinner = $('.amount_input').each(function(){
                        $(this).spinner();
                    })

                    $('.ui-spinner-button').on('click', function(e){
                        if($(this).parent().children('.amount_input').attr('value') < '1'){
                            e.preventDefault();
                            $(this).parent().children('.amount_input').attr('value', '1');
                            return;
                        }

                        $.ajax({
                            type: 'POST',
                            url: url + '/cart',
                            data: $(this).parent().parent().serialize(),
                            dataType: 'html',
                            error: function(){alert('ERROR')},
                            success: function(data){
                                $('header .orange').html($(data).find("header .orange").html());
                                $('.sum_cart_price .orange').html($(data).find('.sum_cart_price .orange').html());
                                $('.small_cart_amount').html($(data).find('header .orange').html());
                                $('.small_cart_price').html('');
                                $('.small_cart_price').html($(data).find('.sum_cart_price .orange').html());
                                changeGoodWord($(data).find('header .orange').html());
                                $('.close_popup_window').live('click', function(e){
                                    e.preventDefault();
                                    showHideCartBlock();
                                });
                            }
                        });
                    });

        };

        function showOrderForm(form){
            $('.order_form_block').remove();
            $('.cart_wraper').append(form);
            $('#submitOrder').bind('submit', function(e){
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: url + "/order",
                    data: $('#submitOrder').serialize(),
                    success: showOrderForm
                });
            });

            sendForm();

            changeGoodWord($('header .orange').html());
        }


        // Добавляем товар в корзину из каталога
        $('.adv_buy_button').on('click', function(e){
            e.preventDefault();

            $.ajax({
                type: 'GET',
                url: $(this).attr('href'),
                success: function(data){
                    if($('#cart_block.full').css('display') == 'none'){
                        $('#cart_block.empty').css('display', 'none');
                        $('#cart_block.full').css('display', 'block');
                    }

                    var amount = $(data).find('header .orange').html();
                    var sum = $(data).find('.sum_cart_price .orange').html();

                    var content = '<span class="green_color"><span class="small_cart_amount">' + amount + '</span> <span class="small_cart_word">товаров</span></span> на <span class="small_cart_price">' +  sum + "</span>";
                    $('.info_text').empty().append(content);
                    changeGoodWord($('.small_cart_amount').html());
                }
            });
        });


        // Закрываем окно корзины и формы заказа
        $('.close_popup_window').on('click', function(e){
            e.preventDefault();
            showHideCartBlock();
            e.doNotPreventDefault();
        });

        function showHideCartBlock(){
            if($('.cart_wraper_fade').css('display') == 'none'){
                var winWidth = $(document).width();
                var winHeight = $(document).height();

                $('.cart_wraper_fade').show();
                $('.cart_wraper_fade').css('width', winWidth + 'px');
                $('.cart_wraper_fade').css('height', winHeight + 'px');

                // Закрываем окно корзины и формы заказа
                $('.close_popup_window').live('click', function(e){
                    e.preventDefault();
                    showHideCartBlock();
                    e.doNotPreventDefault();
                });
            }
            else{
                $('.cart_wraper_fade').hide();
            }

            changeGoodWord($('.small_cart_amount').html());
        }


        // Обновляем значения малой корзины при изминении кол-ва товаров
        function refreshCartOnAmountChange(){
     
            // Удаляем товар из корзины + обновляем значения
            $('.delete_item_from_cart').on('click', function(e){
                e.preventDefault();

                var inputName = $(this).prev().children().find('.amount_input').attr('name');
                inputName = inputName.replace('item', 'del');
                $(this).prev().children().find('.amount_input').attr('name', inputName);

                $.ajax({
                    type: 'POST',
                    url: url + "/cart",
                    data: $(this).prev().children().serialize(),
                    success: function(data){
                        if($(data).find('header  .orange').html() == 0){
                            $.ajax({
                                type: 'GET',
                                url: url + "/cart",
                                beforeSend: function(){
                                    $('.order_list').empty();
                                },
                                success: function(data){
                                    $('.order_list').replaceWith(data);
                                    $('#cart_block.full').css('display', 'none');
                                    $('#cart_block.empty').css('display', 'block');
                                    showHideCartBlock();
                                }
                            });
                        }
                        else{
                            $('header .orange').replaceWith($(data).find('header  .orange'));
                            $('.sum_cart_price .orange').replaceWith($(data).find('.sum_cart_price .orange'));
                            changeGoodWord($('header .orange').html());
                            $('.small_cart_amount').html($(data).find('header  .orange').html());
                            $('.small_cart_price').html($(data).find('.sum_cart_price  .orange').html());
                        }
                    }
                })

                $(this).parent().remove();
            })
        }


        // Отображаем ошибку при введении некорректной информации
        function displayErrorFields(){
            $('input[type=text]').each(function(i){
                if($(this).prev().children().text() == "*ОШИБКА ВВОДА"){
                    $(this).toggleClass('field_error');
                }
            })
        }


        // Отправляем форму заказа
        function sendForm(){
            $('.order_form').live('submit', function(e){
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: url + '/order',
                    data: $('.order_form').serialize(),
                    success: function(data){
                        if($(data).find('form').hasClass('order_form')){
                            $('.order_form_block').replaceWith(data);
                            displayErrorFields();
                        }
                        else{
                            showThankMsg(data);
                            $('#cart_block.full').css('display', 'none');
                            $('#cart_block.empty').css('display', 'block');
                        }
                    }
                });

                $('.close_popup_window').live('click', function(e){
                    e.preventDefault();
                    showHideCartBlock();
                });
            });
        }

        // Очищаем окно и выводим сообщение успешной покупки

        function showThankMsg(data){
            $('.order_list').remove();
            $('.order_form_block').remove();
            $('.cart_wraper').append(data);

            $('.close_popup_window').live('click', function(e){
                e.preventDefault();
                showHideCartBlock();
            });
        }

        $('.small_cart_wraper').hover(function(){
            if($('.small_cart_list').attr('data-opened') == 'false'){
                smallCartOperations();
                setTimeout(function(){$('.small_cart_list').attr('data-opened', 'true')}, 200);
                $('.sc-wraper').css('display', 'block');
                $('.triangle').css('display', 'block');
                    $('.small_cart_list').slideDown({
                        duration: '400'
                    });
            }
        }, function(){
                if($('.small_cart_list').attr('data-opened') == 'true'){
                    setTimeout(function(){$('.small_cart_list').attr('data-opened', 'false')}, 400);
                    $('.small_cart_list').slideUp({
                        duration: '400'
                    });
                    setTimeout(function(){$('.triangle').css('display', 'none')}, 390);
                    setTimeout(function(){$('.sc-wraper').css('display', 'none')}, 390);
                }
        });

        $('.showSmallCart').on('click', function(e){
            e.preventDefault();
            if($('.sc-wraper').css('display') == 'none'){
                smallCartOperations();
                $('.sc-wraper').css('display', 'block');
                $('.triangle').css('display', 'block');
                $('.small_cart_list').slideDown();
            }
            else{
                $('.small_cart_list').slideUp();
                setTimeout(function(){$('.triangle').css('display', 'none')}, 390);
                setTimeout(function(){$('.sc-wraper').css('display', 'none')}, 390);
            }
        })



        // Обработка действий в малой корзине
        function smallCartOperations(){
            $.ajax({
                type: 'GET',
                url: url + '/cart',
                data: 'json=true',
                dataType: 'json',
                success: function(data){
                    var result = data['data']['productPositions'];

                    $('.small_cart_list').empty();
                    $('.small_cart_list').append('<h3>В корзине <span class="orange">' + data['data']['total']['cart_count'] + '</span> <span class="small_cart_word">товаров</span></h3>');
                    $('.small_cart_list').append('<div class="scroll-block"><ul class="small_cart_products_list">');
                    for(var i = 0; i < result.length; i++){
                        var item = '';
                        item += '<li>';
                            item += '<img src= ' + url + '"/uploads/' + result[i]['image_url'] + '"" alt="' + result[i]['title'] + '" />';
                            item += '<div class="cart_item_info">';
                                item += '<p class="cart_item_title">'+ result[i]['title']+'</p>';
                                item += '<p class="cart_item_code">Код товара: ' + result[i]['code'] + '</p>';
                                item += '<p class="cart_item_price">' + result[i]['price'] + ' грн</p>';
                            item += '</div>';
                            item += '<div class="cart_item_count">';
                                item += '<form id="cart_from_item_' + result[i]['id'] + '">';
                                    item += '<input id="spinner" type="text" class="small_amount_input" name="item_' + result[i]['id'] + '" value="'+ data['data']['total']['dataCart'][i]['countInCart'] + '" />';
                                    item += '<input type="hidden" name="refresh" value="Пересчитать" />';
                                    item += '<input type="hidden" name="json" value="true" />';
                                item += '</form>';
                            item += '</div>';
                            item += '<a href="" class="small_delete_item_from_cart">&nbsp;</a>';
                        item += '</li>';

                        $('.small_cart_products_list').append(item);
                    }
                    $('.small_cart_list').append("<ul></div><p class='sum_cart_price'>Общая сумма: <span class='orange'>" + data['data']['total']['cart_price'] + " грн</span></p>");
                    $('.small_cart_list').append("<a href='#' class='order enter-btn showCart'>Оформить заказ</a>");

                    changeGoodWord(data['data']['total']['cart_count']);


                    var spinner = $('.small_amount_input').each(function(){
                        $(this).spinner();
                    })

                    jQuery('.scroll-block').jScrollPane();

                    $('.ui-spinner-button').on('click', function(e){
                        if($(this).parent().children('.small_amount_input').attr('value') < '1'){
                            e.preventDefault();
                            $(this).parent().children('.small_amount_input').attr('value', '1');
                            return false;
                        }

                        $.ajax({
                            type: 'POST',
                            url: url + '/cart',
                            data: $(this).parent().parent().serialize(),
                            dataType: 'html',
                            error: function(){alert('ERROR')},
                            success: function(data){
                                data = $.parseJSON(data);
                                $('.small_cart_list h3 .orange').html(data["cart_count"]);
                                $('.small_cart_amount').html(data["cart_count"]);
                                $('.sum_cart_price .orange').html(data['cart_price'] + ' грн');
                                $('.small_cart_price').html('');
                                $('.small_cart_price').html(data['cart_price'] + ' грн');
                                changeGoodWord(data["cart_count"]);
                            }
                        });
                    });

                    $('.small_delete_item_from_cart').on('click', function(e){
                        e.preventDefault();

                        var inputName = $(this).prev().children().find('.small_amount_input').attr('name');
                        inputName = inputName.replace('item', 'del');
                        $(this).prev().children().find('.small_amount_input').attr('name', inputName);

                        $.ajax({
                            type: 'POST',
                            url: url + '/cart',
                            data: $(this).prev().children().serialize(),
                            dataType: 'html',
                            error: function(){alert('ERROR')},
                            success: function(data){
                                data = $.parseJSON(data);
                                if(data["cart_count"] == 0){
                                    $('#cart_block.full').css('display', 'none');
                                    $('#cart_block.empty').css('display', 'block');
                                }

                                $('.small_cart_list h3 .orange').html(data["cart_count"]);
                                $('.small_cart_amount').html(data["cart_count"]);
                                $('.sum_cart_price .orange').html(data['cart_price'] + ' грн');
                                $('.small_cart_price').html('');
                                $('.small_cart_price').html(data['cart_price'] + ' грн');
                                changeGoodWord(data["cart_count"]);
                            }
                        });

                        $(this).parent().remove();
                    });

                }
            });
        }

        // Обработка нажатия кнопки купить на странице продукта

        $('.buy_button_pr').on('click', function(e){
            e.preventDefault();

            $.ajax({
                type: 'GET',
                url: $(this).attr('href'),
                success: function(data){
                    if($('#cart_block.full').css('display') == 'none'){
                        $('#cart_block.empty').css('display', 'none');
                        $('#cart_block.full').css('display', 'block');
                    }

                    var amount = $(data).find('header .orange').html();
                    var sum = $(data).find('.sum_cart_price .orange').html();

                    var content = '<span class="green_color"><span class="small_cart_amount">' + amount + '</span> <span class="small_cart_word">товаров</span></span> на <span class="small_cart_price">' +  sum + "</span>";
                    $('.info_text').empty().append(content);
                    changeGoodWord($('.small_cart_amount').html());
                }
            });

            $.ajax({
                type: "GET",
                url: url + "/cart",
                dataFilter: function(server){
                    return $(server);
                },
                success: showCart
            });

            $.ajax({
                type: "GET",
                url: url + "/order",
                success: showOrderForm
            });

            $('.close_popup_window').on('click', function(e){
                    e.preventDefault();
                    showHideCartBlock();
            });

            showHideCartBlock();
        })

});