<?php mgTitle('Личный кабинет');?>
<?php if($userInfo = $data['userInfo']):?>
<h2 class="new-products-title">Личный кабинет пользователя "<?php echo $userInfo->name?>"</h2>
<!--тут окошко для сообщений. Если сообщений нет, то окно не выводится-->
<?php if($msg):?>

 <div class="error-message"><?php echo $msg // само сообщение?></div>

<br>
<?php endif;?>
<!--до сюда-->
<div class="create-user-account-form">
  <p class="auth-text">В своем кабинете Вы сможете следить за статусами Ваших заказов, так же изменять свои личные данные.</p>
  <form action = "<?php echo SITE?>/personal" method = "POST">
    <ul class="form-list">
      <li>Email: <span class="normal-text"><?php echo $userInfo->email?></span></li>
      <li>Дата регистрации: <span class="normal-text"><?php echo date('d.m.Y', strtotime($userInfo->date_add))?></span></li>
    </ul>
    <ul class="form-list">
      <li>Имя:</li>
      <li><input type="text" name="name" value="<?php echo $userInfo->name?>"></li>
      <li>Фамилия:</li>
      <li><input type="text" name="sname" value="<?php echo $userInfo->sname?>"></li>
      <li>Телефон:</li>
      <li><input type="text" name="phone" value="<?php echo $userInfo->phone?>"></li>
      <li>Адрес доставки:</li>
      <li><textarea class="address-area" name="address"><?php echo $userInfo->address?></textarea></li>
    </ul>
    <button type="submit" class="enter-btn" name="userData" value ="save">Сохранить</button>
  </form>
  <div class="clear"></div>
  <form action = "<?php echo SITE?>/personal" method = "POST">
    <p class="change-pass-title">Сменить пароль</p>
    <p class="auth-text"><span class="red-star">*</span>Поля отмеченные красной звездочкой, обязательны к заполнению.</p>
    <ul class="form-list">
      <li>Старый пароль:<span class="red-star">*</span></li>
      <li><input type="password" name="pass"></li>
      <li>Новый пароль(не менее 5 символов):<span class="red-star">*</span></li>
      <li><input type="password" name="newPass"></li>
      <li>Повторите новый пароль:<span class="red-star">*</span></li>
      <li><input type="password" name="pass2"></li>
    </ul>
    <button type="submit" class="enter-btn" name="chengePass" value = "save">Сохранить</button>
    <div class="clear"></div>
  </form>
  <?php if($data['orderInfo']):?>
  <div class="order-history-list">
    <p class="change-pass-title">История заказов</p>
    <?php foreach ($data['orderInfo'] as $order):?>
    <div class="order-history" id="<?php echo $order['id'] ?>">
      <p class="order-number">
        Заказ <strong>№<?php echo $order['id'] ?></strong>
        от <?php echo date('d.m.Y', strtotime($order['add_date']))?>
        <!--<span class="order-status"> Cтатус заказа: <strong><?php echo $lang[$order['string_status_id']]?></strong></span>-->
      </p>
      <table class="status-table">
        <tr>
          <th>Товар</th>
          <th>Артикул</th>
          <th>Количество</th>
          <th>Сумма</th>
        </tr>
        <?php $perOrders = unserialize(stripslashes($order['order_content']));
        foreach ($perOrders as $perOrder):?>
        <tr>
          <td><a href="#"><?php echo $perOrder['name'] ?></a></td>
          <td><?php echo $perOrder['code'] ?></td>
          <td><?php echo $perOrder['count'] ?></td>
          <td><?php echo $perOrder['price'] ?>  <?php echo MG::get('currency'); ?></td>
        </tr>
        <?php endforeach; ?>
      </table>
      <?php if($order['status_id'] < 3):?>
      <div class="order-settings">
        <button class="close-order" id="<?php echo $order['id'] ?>" date="<?php echo date('d.m.Y', strtotime($order['add_date']))?>" href="#openModal">
          Закрыть заказ
        </button>
      </div>
      <?php else: ?>
      <div class="order-settings">
        <span class="close-order-text">Заказ закрыт или в работе<span>
      </div>
      <?php endif;?>
      <div class="order-total">
        <ul class="total-list">
          <li>Доставка: <span><?php echo $order['description']?></span></li>
          <?php $totSumm = $order['summ'] + $order['cost'];?>
          <li>Всего к оплате: <?php echo $totSumm?>  <?php echo MG::get('currency'); ?></li>
        </ul>
      </div>
      <div class="clear">&nbsp;</div>
    </div>
    <?php endforeach;?>
    <div class="close-reason">
      <!--Эта часть пропадает после закрытия заказа-->
      <div class="close-reason-wrapper" id="openModal">
        <p class="order-number">Закрытие заказа №<strong name="orderId" class="orderId"></strong> от <span class="orderDate"></span></p>
        <p class="auth-text">Укажите причину закрытия заказа:</p>
        <textarea class="reason-text" type="text" name="comment_textarea"></textarea>
        <button type="submit" class="close-order-btn" >Закрыть</button>
        <a class="close-order" href="#successModal" name="next"></a>
        <a class="close-order" href="#errorModal" name="error"></a>
        <div class="clear"></div>
      </div>
      <!--Эта часть пропадает после закрытия заказа-->

      <!--Эта часть появляется после закрытия заказа без перезагрузки страницы-->
      <div class="successful-closure" id="successModal">
		<div class="succes-img"></div>
        <p class="order-close-text">Заказ №<strong class="orderId"></strong> от <span class="orderDate"></span></p>
        <p class="order-close-text green-color">Был успешно зыкрыт!</p>
        <a href="#" id="close-order-successbtn" onClick="$.fancybox.close();">Выход</a>
        <div class="clear"></div>
      </div>
      <!--Эта часть появляется после закрытия заказа без перезагрузки страницы-->

      <div class="successful-closure" id="errorModal">
        ошибка
      </div>

    </div>
  </div>
  <div class="clear">&nbsp;</div>
  <?php else:?> <!-- if($data['orderInfo']) -->
  <br>У вас нет заказов
  <?php endif?> <!-- if($data['orderInfo']) -->
</div>

<?php else:?> <!-- if($userInfo = $data['userInfo']) -->
Личный кабинет доступен только авторизованым пользователям!
<?php endif;?> <!-- if($userInfo = $data['userInfo']) -->