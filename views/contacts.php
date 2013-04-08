<?php MG::titlePage('Контакты'); ?>
<div class="breadcrumps"><a href="<?php echo SITE; ?>">Главная</a> &rsaquo; <a href="<?php echo SITE; ?>/contacts">Контакты</a></div>
            
            <div class="main cnt">
                <header><h2>Контакты</h2></header>
                
                <div class="content_wraper cnt">
                
                    <nav class="contacts_menu">
                            [show-contacts-menu]
                    </nav>
    
                    <div class="city">
                        <div class="dashed_border cnt">
                            <div class="content cnt">
                                
                            </div>
                        </div>
                        <div class="clr"></div>
                    </div>
                    
                    <div class="clr"></div>
                </div>
            </div>
        </section>
        
        <div class="clr"></div>

        <script>


        var map;

        $(function() {
            $('#cities_menu li:first').attr('class', 'city_menu_first_item selected');
            $('#cities_menu li:last').attr('class', 'city_menu_last_item');

            $('#cities_menu li').click(function(){
                $('#cities_menu li').removeClass('selected');
                $(this).toggleClass('selected');
            })
                $.ajax({
                    type: 'GET',
                    url: $('#cities_menu li.selected').children().attr('href'),
                    dataType: 'html',
                    success: function(data){
                        var content = $(data).find('.city').html();
                        map = $(data).find('.route').text();
                        $('.city').empty();
                        $('.city').append(content);
                    }
                })

                $('.city-change').on('click', function(e){
                    e.preventDefault();
                    $.ajax({
                        type: 'GET',
                        url: $(this).attr('href'),
                        dataType: 'html',

                        success: function(data){
                            if($(data).find('.city').hasClass('city')){
                                var content = $(data).find('.city').html();
                                $('.city').empty();
                                $('.city').append(content);
                            }
                            else{
                                var content = $(data).find('#midle').html();
                                $('.city').empty().append('<div class="dashed_border cnt"><div class="content cnt"></div></div>');
                                $('.content').append(content);
                            }
                        }
                    })
                })
        });

        </script>