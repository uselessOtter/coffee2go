<?php mgTitle('Восстановление пароля'); ?>

<h2 class="new-products-title">Восстановление пароля</h2>
<div class="restore-pass"> 
<?php
if($msg){
  echo $msg;
}

switch($step){
  case 1:
?>   
    <p class="auth-text">На адрес электронной почты будет отправлена инструкция по восстановлению пароля.</p>
    <form action = "<?php echo SITE?>/forgotpass" method = "POST">
	<ul class="form-list">
		<li><input type = "text" name = "email" value="Email" onfocus="if (this.value == 'Email') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Email';}" /></li>
	</ul>
      <input type = "submit" name="forgotpass" class="enter-btn" value = "Отправить" />
    </form>

<?php break;

case "2.1":?>
    К сожалению, такой логин не найден<br>
    Если вы уверены, что данный логин существует, свяжитесь, пожалуйста, с нами.
<?php break;

  case "2.2":?>

    <p class="auth-text">Инструкция по восстановлению пароля была отправлена на <strong><?php echo $email ?></strong></p>

<?php ;
break;
  case 3:?>
  <form action = "<?php echo SITE?>/forgotpass" method = "POST">
    Смена пароля
    <table>
        <td>Новый пароль (не менее 5 символов)</td>
        <td><input type="password" name="newPass"></td>
      </tr>
      <tr>
        <td>Подтвердите новый пароль</td>
        <td><input type="password" name="pass2"></td>
      </tr>
    </table>
    <input type = "submit" class="btn" name="chengePass" value = "Сохранить" />
  </form>
<?php echo $url;
break;
  case 4:?>
    Вы можете войти в личный кабинет по адресу <a href="<?php echo SITE ?>/enter" ><?php echo SITE ?>/enter</a>
<?php
} ?>
</div>