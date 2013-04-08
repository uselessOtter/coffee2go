<?php mgTitle('Корзина');?>
  <h2 class="new-products-title"><span>Корзина</span> товаров</h2>

<?php if($data['isEmpty']): ?>
	<div class="payment-option">
		<form method="post" action="<?php echo SITE?>/cart">
				<table class="cart-table">
					<tr>
						<th>№</th>
						<th>Наименование</th>
						<th>Артикул</th>
						<th class="qty-field">Количество</th>
						<th>Цена за одну шт.</th>
						<th>Общая сумма</th>
					</tr>
					    <?php
						$i = 1;
						foreach($data['productPositions'] as $product):?>
					<tr>
						<td><?php echo $i++ ?></td>
						<td><?php echo $product['title'] ?></td>
						<td><?php echo $product['code'] ?></td>
						<td>
							<input type="text" class="amount_input"  name="item_<?php echo $product['id'] ?>" value = "<?php echo $_SESSION['cart'][$product['id']]?>"/>
						</td>
						<td><?php echo $product['price'] ?>  <?php echo MG::get('currency'); ?></td>
						<td> <?php echo ($_SESSION['cart'][$product['id']] * $product['price'])?>  <?php echo MG::get('currency'); ?></td>
					</tr>
					<?php endforeach;?>
				</table>
        <button type="submit" name="refresh" class="refresh" value="Пересчитать">Пересчитать</button>

			</form>
     <form action="<?php echo SITE?>/order" method="post" class="checkout-form">
        <button type="submit" class="checkout" name="order" value="Оформить заказ">Оформить заказ</button>
     </form>
		<div class="clear">&nbsp;</div>
	</div>

<?php else : ?>
<div class="payment-option empty-cart-block">
  <h3 class="empty-cart-text">Ваша корзина пуста!</h3>
  <img src="<?php echo PATH_TEMPLATE ?>/images/empty-cart.png" alt="" />
</div>
<?php endif; ?>
