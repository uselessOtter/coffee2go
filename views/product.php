<?php
/**
 * Файл вида product.php
 *
 *  @author Авдеев Марк <mark-avdeev@mail.ru>
 *  @package moguta.cms
 */

mgSEO($data);
mgTitle($data['title']);
//echo  '<pre>', print_r($data), '</per>';
?>

<section class="right_side pr">
                <header><h3 class="brown">Похожие товары:</h3></header>
                
                <?php foreach($data['similarProducts'] as $product): ?>
                <div class="dashed_border sim_good">
                    <div class="sim_good">
                        <img src="<?php echo SITE; ?>/uploads/<?php echo $product['image_url']; ?>" alt="" title="" />
                        <h4><a href="<?php echo SITE, '/', $product['cat_url'], '/', $product['url']; ?>"><?php echo $product['title']; ?></a></h4>
                        
                        <ul>
                            <?php foreach ($product['properties'] as $name => $value): ?> 
                            <li><span class="brown"><?php echo $name; ?>: </span><?php echo $value; ?></li>
                            <?php endforeach; ?>
                        </ul>
                        
                        <span class="sim_product_price"><?php echo $product['price']; ?> <?php echo MG::getOption('currency'); ?></span>
                        <a href="<?php echo SITE . '/catalog?inCartProductId=' . $product['id']; ?>" class="adv_buy_button pr">Купить</a>
                        
                        <div class="clr"></div>
                    </div>
                </div>
                <?php endforeach; ?>
                
            </section>
            
            <section class="main pr">
                <div class="breadcrumps"><a href="<?php echo SITE; ?>">Главная</a> > <a href="<?php echo SITE . '/' . $data['cat_url']; ?>"><?php echo $data['cat_title']; ?></a> > <a href="<?php echo SITE . $data['cat_url'] . '/' . $data['url']; ?>"><?php echo $data['title']; ?></a></div>
            
                <aside class="item_img">
                
                    <div class="dashed_border main_img">
                        <div class="main_img pr"><img src="<?php echo SITE; ?>/uploads/<?php echo $data['image_url']; ?>" alt="" title="" /></div>
                    </div>
                    
                    <div class="dashed_border img_list">
                        <ul class="img_list pr">
                        </ul>
                    </div>
                
                </aside>
                
                <section class="item pr">
                    <header class="item_pr_header"><h2><?php echo $data['title']; ?></h2></header>
                    <p><span class="brown">Код товара:</span> <?php echo $data['code']; ?></p>
                    <span class="price pr"> <?php echo  $data['price']; ?> <?php echo MG::getOption('currency'); ?></span>
                    <a href="<?php echo SITE; ?>/catalog?inCartProductId=<?php echo $data['id']; ?>" class="buy_button_pr">Купить сейчас</a>
                    
                    <div class="dashed_border item_props">
                        <ul class="item_props">
                            <?php foreach($data['thisUserFields'] as $field): ?>
                                <li><span class="brown"><?php echo $field['name']; ?>:</span> <?php echo $field['value']; ?></li>
                            <?php endforeach; ?>
                                <li><span class="brown">Дополнительная информация:</span> <?php echo $data['description']; ?></li>
                        </ul>

                        <div class="share-info">
                            <h4><?php echo $data['shareInfo']['title']; ?></h4>
                            <p><?php echo $data['shareInfo']['description']; ?><p>
                        </div>
                    </div>
                </section>
                
                <div class="clr"></div>
                
            </section>

        </section>
        
        <div class="clr"></div>