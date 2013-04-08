<div class="order_list">
<?php mgTitle('Корзина');
    MG::disableTemplate();
?>
  <header>В вашей корзине <span class="orange"><?php echo $data['total']['cart_count']; ?></span> <span class="small_cart_word">товаров<span></header>

<?php if($data['isEmpty']): ?>
    <?php//echo '<pre>', print_r($data), '</pre>'; ?>
	<ul class="cart_item_list">
        <?php foreach($data['productPositions'] as $product): ?>
            <li>
                <img src="<?php echo SITE; ?>/uploads/<?php echo $product['image_url']; ?>" alt="<?php echo $product['title']; ?>" class="cart_item_image" />
                <div class="cart_item_info">
                    <p class="cart_item_title"><a href=""><?php echo $product['title']; ?></a></p>
                    <p class="cart_item_code">Код товара: <?php echo $product['code']; ?></p>
                    <p class="cart_item_price"><?php echo $product['price']; ?> грн</p>
                </div>
                <div class="cart_item_count">
                    <form id="cart_from_item_<?php echo $product['id']; ?>">
                        <input id="spinner" type="text" class="amount_input" name="item_<?php echo $product['id'] ?>" value="<?php echo $_SESSION['cart'][$product['id']]?>" />
                        <input type="hidden" name="refresh" value="Пересчитать" />
                    </form>
                </div>
                <a href="" class="delete_item_from_cart">&nbsp;</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <p class="sum_cart_price">Общая сумма: <span class="orange"><?php echo '0' ? !$data['totalSumm'] : $data['totalSumm']  ; ?> <?php echo MG::getOption('currency'); ?></span></p>
    <a href="#" class="continue_view close_popup_window">Продолжить выбор товаров</a>
    
<?php else : ?>
<div class="payment-option empty-cart-block">
  <h3 class="empty-cart-text">Ваша корзина пуста!</h3>
  <img src="<?php echo PATH_TEMPLATE ?>/images/empty-cart.png" alt="" />
</div>
<?php endif; ?>
</div>