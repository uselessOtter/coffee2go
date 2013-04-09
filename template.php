<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<meta name="keywords" content="#"/>
<meta name="description" content="#"/>

    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <?php mgMeta(); ?>

    <!--[if IE]>
        <link rel="stylesheet" href="<?php echo  PATH_SITE_TEMPLATE; ?>/css/ie_style.css" type="text/css" charset="utf-8" />
    <![endif]-->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Cuprum:400,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Lobster&subset=latin,cyrillic-ext,cyrillic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="<?php echo  PATH_SITE_TEMPLATE; ?>/css/fonts/OfficinaSansCTT-Bold.css" type="text/css" charset="utf-8" />

<title>Главная страница</title>
</head>
<body>

    <section id="wraper">
    
    <div id="global_bg"></div>
    
        <header id="global_header">
            
            <nav id="submenu">
                <ul>
                    <?php foreach ($data['menu'] as $title => $url): ?>
                        <li><a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . '/' . $url; ?>"><?php echo $title; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </nav>
            
            <div id="logo"><a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/'; ?>"></a></div>
            
            <h1>Coffee2Go - Все для "кофе с собой"</h1>
            
            <div id="head_contacts">
                <p>Телефон: <span class="green_color">(044) 361-13-55</span></p>
                <p>E-mail: <span class="green_color">info@coffee2go.com.ua</span></p>
            </div>
            
            <nav id="main_menu">
                <ul>
                    <?php foreach ($data['categoryHierarchyList'] as $cat): ?>
                        <li class="<?php echo $cat['url']; ?>"><a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . '/' . $cat['url']; ?>"><?php echo $cat['title']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </nav>

            <div id="cart_block" class="empty">
                <p class="main_p">Корзина пуста</p>
            </div>
            <div id="cart_block" class="full">
                <div class="small_cart_wraper">
                    <p class="main_p show_small_cart"><span class="info_text"><span class="green_color"><span class="small_cart_amount"><?php echo $data['cartCount']; ?></span> <span class="small_cart_word"> товаров</span></span> на <span class="small_cart_price"><?php echo $data['cartPrice']; ?> грн</span></p>
                    <div class="sc-wraper">
                        <div class="triangle"></div>
                        <div class="small_cart_list" data-opened="false">
                        </div>
                    </div>
                </div>
                <a href="cart" class="showSmallCart"><button>Оформить заказ</button></a>
            </div>
            
            <form id="search_form" method="get" action="<?php echo SITE?>/catalog">
                <input type="text" name="search" id="search_field" autocomplete="off" value="поиск по товарам" onfocus="if (this.value == 'поиск по товарам') {this.value = '';}" onblur="if (this.value == '') {this.value = 'поиск по товарам';}" />
                <input type="submit" name="submit" id="search_button" value="Поиск" />
            </form>
            
        </header>
        
        <section id="midle">
        
            <?php echo $data['content']; ?>
            
        </section>
        
        <div class="clr"></div>
    </section>
    
    <footer id="global_footer">
        <div class="footer_wrap">
            <div id="tree"></div>
            <p>&copy; 2013 Coffee2Go. Все права защищены</p>

            <div id="back-top"><a href="#">Вверх</a></div>
            
            <nav>
                <menu id="footer_menu">
                    <li><a href="<?php echo SITE; ?>">Главная</a></li>
                    <?php foreach ($data['menu'] as $title => $url): ?>
                        <li><a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . '/' . $url; ?>"><?php echo $title; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div>
    </footer>

    <div class="cart_wraper_fade">
        <div class="cart_wraper">
            <hr />
            <a href="#" class="close_window_button close_popup_window"></a>
        </div>
    </div>

    <div class="feedback">
        <button class="openFeedback">Оставить отзыв</button>
        <div class="feedback-window">
            <button class="close_window_button close_feedback"> </button>
            <div class="fb-form">
            </div>
        </div>
    </div>

    
    
    <script type="text/javascript" src="<?php echo  PATH_SITE_TEMPLATE; ?>/js/jquery-ui-1.10.2.custom.min.js"></script>
    <script>
        $(function(){
            var clas = "<?php $class = URL::getSections(); echo $class[1];?>";
            if(clas != '')
                $('li.' + clas).toggleClass('selected');
        })
    </script>
    <script src="<?php echo PATH_SITE_TEMPLATE; ?>/js/cart.js"></script>
    <script>
        $(function(){
            $('.feedback-window').css('display', 'none');
            $('body').append('<div class="fade"></div>');

            var height = $('body').height() + 19;
            $('.fade').css({
                width: 100 + '%',
                height: height,
                backgroundColor: '#000',
                position: 'absolute',
                top: '-15px',
                left: '0',
                zIndex: 1500,
                opacity: '.6',
                display: 'none'
            });
        })
        
        
        jQuery(document).ready(function(){
            if($('.admin-top-menu').hasClass('admin-top-menu')){
                $('body').css({'background-position' : '0 31px'});
            };
        });

        jQuery(document).ready(function(){

            var cartCount = '<?php echo $data["cartCount"];?>';
            if(cartCount == 0){
                $('#cart_block.full').css('display', 'none');
                $('#cart_block.empty').css('display', 'block');
            }
            else{
                changeGoodWord($('.small_cart_amount').html());
            }
        });

        $(document).ready(function(){
            // появление/затухание кнопки #back-top
            $(function (){
                // прячем кнопку #back-top
                $("#back-top").hide();
            
                $(window).scroll(function (){
                    if ($(this).scrollTop() > 100){
                        $("#back-top").fadeIn();
                    } else{
                        $("#back-top").fadeOut();
                    }
                });

                // при клике на ссылку плавно поднимаемся вверх
                $("#back-top a").click(function (){
                    $("body,html").animate({
                        scrollTop:0
                    }, 800);
                    return false;
                });
            });


        });
    </script>

    <script src="<?php echo PATH_SITE_TEMPLATE; ?>/js/scroll-wheel.js"></script>
    <script src="<?php echo PATH_SITE_TEMPLATE; ?>/js/scroll.js"></script>
    <script>
        $(function()
        {
            $('.scroll-block').jScrollPane();
        });
    </script>
    <script src="<?php echo  PATH_SITE_TEMPLATE; ?>/js/feedback.js"></script>

    <div class="img-loader"></div>
    
</body>
</html>