<?php mgTitle($data['titeCategory']); ?>
<pre>
<?php //print_r($data); ?>
</pre>
<!-- Верстка каталога -->
<?php  if(empty($data['searchData'])): ?>
<section id="sidebar">
                <div class="breadcrumps"><a href="<?php echo SITE; ?>">Главная</a> &rsaquo; <a href="<?php echo SITE . URL::getClearUri () ; ?>"><?php echo $data['titeCategory']; ?></a></div>
                
                <nav class="cat-menu">
                    <ul>
                    <?php foreach($data['catList'] as $menuItem): ?>
                        <?php if($menuItem['url']): ?>
                        <li class="<?php echo $menuItem['url']; ?>"><a href="<?php echo SITE . '/' . $menuItem['url']; ?>"><?php echo $menuItem['title']; ?></a></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </ul>
                </nav>

                <?php if($data['catList']['isMother']): ?>
                <div id="filters">
                    <header id="filters_header"><h2>Фильтры товаров</h2></header>
                    <form id="filter_form">
                        <fieldset>
                            <legend>Цена</legend>
                            <div id="minPrice"></div>
                            <div id="maxPrice"></div>
                            <div id="slider"></div>
                            <label for="minCost"><span class="price_label">От</span></label>
                            <input type="text" name="minCost" id="minCost" value="<?php echo $data['fullInfo']['minPrice']; ?>" />
                            <label for="maxCost" id="maxCost_label"><span class="price_label">до</span></label>
                            <input type="text" name="maxCost" id="maxCost" value="<?php echo $data['fullInfo']['maxPrice']; ?>" />
                        </fieldset>
                        
                        <?php foreach($data['filters'] as $filterGroup): ?>
                        <fieldset>
                            <legend><?php echo $filterGroup['name']; ?>:</legend>
                                <?php foreach($filterGroup['data'] as $property): ?>
                                    <input type="checkbox" class="filter_checkbox" name="<?php echo $filterGroup['id']; ?>" value="<?php echo $property; ?>" />
                                    <label><?php echo $property; ?></label>
                                <?php endforeach; ?>
                        </fieldset>
                        <?php endforeach; ?>
                    </form>
                    
                </div>
                <?php else: ?>
                <div class="help-filters">
                    <p>Выберите категорию товаров для возможности отбора товаров по характеристикам!</p>
                </div>
                <?php endif;?>
            </section>

            <section id="catalog">
                <header><h2><?php echo $data['titeCategory']; ?></h2></header>
                <div id="info_bar">
                    <p><span class="green_text"><span class="catalog_amount"></span></span> <span class="catalog_word"></span> отобразить по </p><ul class="select_item_cnt"><li id='main_li'>12</li><div class="showHelper"></div><ul class="list_item_cnt"><li><a href="#?cnt=12">12</a></li><li><a href="#?cnt=24">24</a></li><li><a href="#?cnt=48">48</a></li><li><a href="#?cnt=all">Все</a></li></ul></ul><p> на cтранице</p>
                    <p class="info_bar_right_part">Сортировать по: <a href="" class="active sort alphabet">алфавиту</a> <a href="" class="sort price">цене</a></p>
                </div>
                <div id="products_list">


<?php

foreach($data['items'] as $item){
  if(0 == $i % 3) :
?>
<?php endif; ?>

					<div class="product">
                        <div>
                            <a href="<?php echo $item['category_url'] . '/' . $item['url']; ?>"><img src="<?php echo SITE; ?>/uploads/<?php echo $item['image_url']; ?>" alt="<?php echo $item['title']; ?>" /></a>
                            <h4><a href="<?php echo $item['category_url'] . '/' . $item['url']; ?>"><?php echo $item['title']; ?> <?php echo $data['fullInfo'][$item['title']]['Вес']['value']; ?>&nbsp;</a></h4>
                            <ul>
                                <li><span class="descr"><?php echo $data['fullInfo'][$item['title']][1]['name']; ?>:</span> <?php echo $data['fullInfo'][$item['title']][1]['value']; ?></li>
                                <li><span class="descr"><?php echo $data['fullInfo'][$item['title']][2]['name']; ?>:</span> <?php echo $data['fullInfo'][$item['title']][2]['value']; ?></li>
                            </ul>
                            <p><?php echo $item['price']; ?> грн</p>
                            <a href="<?php echo SITE;?>/catalog?inCartProductId=<?php echo $item['id'];?>" class="adv_buy_button">Купить</a>
                        </div>
                    </div>
	
<?php
  $i++;
}
?>
            <div class="clear"></div>
            </div>
            <div class="pag-wraper">
				<nav id="pagination">
                </nav>
            </div>
            </section>
<!-- / Верстка каталога -->

<!-- Верстка поиска -->
<?php else: ?>
<?php mgTitle('Поиск'); ?>

<section class="search_result">
                <header><h2>Поиск "<span class="orange_text"><?php echo $data['searchData']['keyword'] ?></span>"</h2></header>
                <div id="info_bar">
                    <p><span class="green_text"><span class="catalog_amount"></span></span> <span class="catalog_word"></span> отобразить по </p><ul class="select_item_cnt"><li id='main_li'>12</li><div class="showHelper"></div><ul class="list_item_cnt"><li><a href="#?cnt=12">12</a></li><li><a href="#?cnt=24">24</a></li><li><a href="#?cnt=48">48</a></li><li><a href="#?cnt=all">Все</a></li></ul></ul><p> на cтранице</p>
                    <p class="info_bar_right_part">Сортировать по: <a href="" class="active sort alphabet">алфавиту</a> <a href="" class="sort price">цене</a></p>
                </div>
                <div id="products_list">
  <?php
  foreach($data['items'] as $item){
    if(0 == $i % 3) :
  ?>

  <?php endif; ?>

		<div class="product">
                        <div>
                            <img src="<?php echo SITE; ?>/uploads/<?php echo $item['image_url']; ?>" />
                            <h4><a href="<?php echo $item['category_url'] . '/' . $item['url']; ?>"><?php echo $item['title']; ?></a></h4>
                            <ul>
                                <li><span class="descr"><?php echo $data['fullInfo'][$item['title']][1]['name']; ?>:</span> <?php echo $data['fullInfo'][$item['title']][1]['value']; ?></li>
                                <li><span class="descr"><?php echo $data['fullInfo'][$item['title']][2]['name']; ?>:</span> <?php echo $data['fullInfo'][$item['title']][2]['value']; ?></li>
                            </ul>
                            <p><?php echo $item['price']; ?> грн</p>
                                <a href="<?php echo SITE;?>/catalog?inCartProductId=<?php echo $item['id'];?>" class="adv_buy_button">Купить</a>
                        </div>
                    </div>
	
  <?php
    $i++;
  }
  ?>
  <div class="clear"></div>
</div>  
            <div class="pag-wraper">
				<nav id="pagination">

                    <?php
					  endif;
					?>
                </nav>
            </div>
               </section>
<!-- / Верстка поиска -->

<script type="text/javascript">

    function pagination(){
                var amount = $('#main_li').text();
                var itemsCount = $('#products_list .product').length;
                $('.product').css('visibility', 'visible');

                if(amount < itemsCount){
                  $("#pagination").css('display', 'inline-table');
                  $("#pagination").jPages({
                    containerID : "products_list",
                    perPage: amount,
                    previous: ' ',
                    next: ' '
                  });
                }
                else{
                  $("#pagination").css('display', 'none');
                }
            }

    $('#products_list').ready(function(){
        pagination();
    })
    function filterProducts(){
                var checkboxArray = $('input[checked=checked]');
                    var filters = '';
                    var cnt = checkboxArray.length;
                    var values = '';
                    var nameFirst = $(checkboxArray.get(0)).attr('name');
                    var name = nameFirst;

                    for(var i = 0; i < cnt; i++){
                            var tempName = $(checkboxArray.get(i)).attr('name');

                            if (tempName == name){
                                values = values + $(checkboxArray.get(i)).attr('value');
                                if((i+1) != cnt) values = values + ',';
                            } else{
                                name = $(checkboxArray.get(i)).attr('name');
                                values = values.slice(0, -1)
                                values = values + ';' + name + ':' + $(checkboxArray.get(i)).attr('value');
                                if((i+1) != cnt) values = values + ',';
                            }
                    }
                    filters = 'filters=' + nameFirst + ':' + values;
                    var price = '&price=' + $('#minCost').attr('value') + '-' + $('#maxCost').attr('value');

                    filters = filters + price;


                    if(!nameFirst) filters = 'filters=none' + price;

                    if($('.sort.active').hasClass('alphabet')) var sort = '&sort=' + 0;
                    else sort = '&sort=' + 1;

                    var count = '&cnt=4';

                    $.ajax({
                        type: "GET",
                        data: filters + sort + count,
                        url: window.location.href,
                        dataFilter: function(server){
                            return $(server).find("#products_list").html()
                        },
                        success: onAjaxSuccess
                     });

                     function onAjaxSuccess(data)
                        {
                          // Здесь мы получаем данные, отправленные сервером и выводим их на экран.
                          $('#products_list').empty();
                          $('#products_list').append(data);
                          changeCatalogCount();

                          $('.adv_buy_button').on('click', function(e){
                                e.preventDefault();

                                $.ajax({
                                    type: 'GET',
                                    url: $(this).attr('href'),
                                    success: function(data){
                                        var amount = $(data).find('header .orange').html();
                                        var sum = $(data).find('.sum_cart_price .orange').html();
                                        var content = '<span class="green_color"><span class="small_cart_amount">' + amount + '</span> <span class="small_cart_word">товаров</span></span> на <span class="small_cart_price">' +  sum + "</span>";
                                        $('.info_text').empty().append(content);
                                        changeGoodWord($('.small_cart_amount').html());
                                    }
                                });
                            });
                          pagination();
                        }

                    $('.adv_buy_button').live('click', function(e){
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
            
                }
</script>

    <script type="text/javascript">
            $(function(){
                var minValue = $("#minCost").attr("value");
                var maxValue = $("#maxCost").attr("value");
                $("#minPrice").text(minValue);
                $("#maxPrice").text(maxValue);
                $('#slider').before('<div id="slider_border"></div>');

                var minStart = "<?php echo $data['fullInfo']['minPrice']; ?>";
                var maxStart = "<?php echo $data['fullInfo']['maxPrice']; ?>";

                if(!minStart || !maxStart){
                    minStart = 0;
                    maxStart = 0;
                }

                $("#slider").slider({
                min: minStart * 1,
                max: maxStart * 1,
                values: [minValue, maxValue],
                range: true,
                slide: function(event, ui){
                    $("#minCost").val(ui.values[0]);
                    $("#maxCost").val(ui.values[1]); 
                    $("#minPrice").text(ui.values[0]);
                    $("#maxPrice").text(ui.values[1]);
                },
                stop: function() {
                    filterProducts();
                }
              });
              
            });
    </script>


    <script type="text/javascript" src="<?php echo  PATH_SITE_TEMPLATE; ?>/js/checkbox/jquery.xdcheckbox.js"></script>
    <script>
        $(function(){
	       $('.filter_checkbox').xdCheckbox({width: 13, height: 13});
        });
    </script>
    
    <script>

        $(function(){
            $('#main_li').click(function(){
                if($('.select_item_cnt ul').css('display') == 'none'){
                    $('.select_item_cnt ul').css('display', 'block');
                    $('.select_item_cnt').hover(function(){}, function(){
                        $('.select_item_cnt ul').css('display', 'none');
                    })
                }
                else{
                    $('.select_item_cnt ul').css('display', 'none');
                }
            });
            
            $('.list_item_cnt a').click(function(e){
                $('#main_li').text($(this).text());
                $('.list_item_cnt').css('display', 'none');
                filterProducts();
            });
            
            $('.sort').on('click', function(e){
                 e.preventDefault();

                 $('.sort').removeClass('active');
                 $(this).toggleClass('active');
                 filterProducts();
            });


            $('.checkbox').on('click', function(){
                filterProducts();
            });
        });
    </script>

    <script type="text/javascript" src="<?php echo  PATH_SITE_TEMPLATE; ?>/js/pagination.js"></script>