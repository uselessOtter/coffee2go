<section id="categories">
            
                <nav>
                
                    <?php foreach($data['categoryHierarchyList'] as $category): ?>
                            <div class="category_wraper">
                                <a href="<?php echo $category['url']; ?>">
                                    <table class="cat_nav_coffee">
                                        <tr><td><img src="<?php echo PATH_SITE_TEMPLATE ?>/images/<?php echo $category['img']; ?>.png" alt="" /></td></tr>
                                        <tr><td><?php echo $category['title']; ?></td></tr>
                                    </table>
                                </a>
                            </div>
                    <?php endforeach; ?>
                
                </nav>
                
                <hr />
                
            </section>
            
            <div class="clr"></div>
            
            <section id="adv">
                <div id="adv_bg"><div id="adv_gradient"></div></div>
                <article class="sales">
                    <header class="hits_header"><h3>Акции</h3></header>
                    <div class="d-carousel">
                    
                        <ul class="carousel">
                            <li>
                                <div style="background-color: red; width: 120px; height:160px"></div>
                            </li>
                            
                            <li>
                                <div style="background-color: green; width: 120px; height:160px"></div>
                            </li>
                            
                            <li>
                                <div style="background-color: blue; width: 120px; height:160px"></div>
                            </li>
                            
                            <li>
                                <div style="background-color: yellow; width: 120px; height:160px"></div>
                            </li>
                            
                            <li>
                                <div style="background-color: black; width: 120px; height:160px"></div>
                            </li>
                            
                            <li>
                                <div style="background-color: orange; width: 120px; height:160px"></div>
                            </li>
                        </ul>

                    </div>
                </article>
                
                <article class="hits">
                    <header class="sales_header"><h3>Хиты продаж</h3></header>
                    <div class="d-carousel">
                    
                        <ul class="carousel">
                            <li>
                                <div>
                                    <img src="images/coffe_machine.jpg" alt="" />
                                    <h4><a href="#">DELONGHI ESAM <br /> 3000B</a></h4>
                                    <p>4 499 грн</p>
                                    <form>
                                        <input type="hidden" name="product_title" value="" />
                                        <input type="submit" value="Купить" name="buy" class="adv_buy_button" />
                                    </form>
                                </div>
                            </li>
                            
                            <li>
                                <div style="background-color: green; width: 120px; height:160px"></div>
                            </li>
                            
                            <li>
                                <div style="background-color: blue; width: 120px; height:160px"></div>
                            </li>
                            
                            <li>
                                <div style="background-color: yellow; width: 120px; height:160px"></div>
                            </li>
                            
                            <li>
                                <div style="background-color: black; width: 120px; height:160px"></div>
                            </li>
                            
                            <li>
                                <div style="background-color: orange; width: 120px; height:160px"></div>
                            </li>
                        </ul>

                    </div>
                </article>
            </section>