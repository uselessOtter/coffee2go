<div class="order_form_block">
<?php
  MG::disableTemplate();
  if($data['dislpayForm']):
  ?>
  <?php //echo '<pre>', print_r($data), '</pre>';?>
  <header>Оформить заказ</header>
      <div class="errorSend">
        <?php
        if($data['error']['emptyCart']){
          echo $data['error'];
        }?>
		</div>
  <?php else : ?>
  <?php
    endif;

    if($data['dislpayForm']):
  ?>
<form class="order_form">
    <p>Заполните пожалуйста следующую форму</p>

    <label for="fio">ФИО<span class="red-star">*</span> <span class="error name"><?php echo $data['error']['fio']; ?></span></label>
    <input type="text" id="fio" name="fio" value="<?php echo $data['insert']['fio']; ?>" />
            
    <label for="phone">Телефон<span class="red-star">*</span> <span class="error phone"><?php echo $data['error']['phone']; ?></span></label>
    <input type="text" id="phone" name="phone" value="<?php echo $data['insert']['phone']; ?>" />
            
    <label for="cart_email">Email<span class="red-star">*</span> <span class="error email"><?php echo $data['error']['email']; ?></span></label>
    <input type="text" id="cart_email" name="email" value="<?php echo $data['insert']['email']; ?>" />
            
    <label for="city">Город<span class="red-star">*</span> <span class="error cart_city"><?php echo $data['error']['city']; ?></span></label>
    <input type="text" id="city" name="city" value="<?php echo $data['insert']['city']; ?>" />
            
    <label for="address">Адрес доставки</label>
    <input type="text" id="address" name="address" value="<?php echo $data['insert']['adress']; ?>" />
            
    <label for="comment">Дополнительная иформация</label>
    <textarea id="comment" name="comment" value="<?php echo $data['insert']['comment']; ?>"></textarea>
            
    <input type="hidden" name="toOrder" value="Оформить заказ">
    <input type="submit" name="toOrder" class="enter-btn ie7-fix" value="Оформить заказ">
</form>
    <?php else:?>
    <div class="checkout-form-wrapper"><span style="color:green">Ваша заявка <strong>№ <?php echo $data['id']?></strong> принята!</span>
      <br>На Ваш электронный адрес выслано письмо для подтверждения заказа
  <?php
  endif;
echo '</div>';