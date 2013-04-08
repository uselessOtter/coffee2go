<?php mgTitle('Регистрация'); ?>
<h2 class="new-products-title">Регистрация пользователя</h2>
<?php
if($data['massage']){
  echo $data['massage'];
}
if(!$data['status']){
?>
<div class="create-user-account-form">
	<h2>Новый пользователь</h2>
	<p class="auth-text">Заполните форму ниже что бы получить дополнительные возможности в нашем интерент-магазине.</p>
	<form action="<?php echo SITE?>/registration" method="POST">
		<ul class="form-list">
			<li>Email:<span class="red-star">*</span></li>
			<li><input type = "text" name = "email" value = "<?php echo $_POST['email']?>"></li>
			<li>Пароль:<span class="red-star">*</span></li>
			<li><input type="password" name="pass"></li>
			<li>Подтвердите пароль:<span class="red-star">*</span></li>
			<li><input type="password" name="pass2"></li>
			<li>Имя:<span class="red-star">*</span></li>
			<li><input type="text" name="name" value = "<?php echo $_POST['name']?>"></li>
			<li>Фамилия:<span class="red-star">*</span></li>
			<li><input type="text" name="sname" value = "<?php echo $_POST['sname']?>"></li>
			<li>Телефон:<span class="red-star">*</span></li>
			<li><input type="text" name="phone"  value = "<?php echo $_POST['phone']?>"></li>
			<li>Адрес:<span class="red-star">*</span></li>
			<li><textarea class="address-area" name="address"><?php echo $_POST['address']?></textarea></li>
			<li><img style="border: 1px solid gray; background: url('<?php echo PATH_TEMPLATE ?>/images/cap.png');" src = "captcha.html" width="140" height="36"></li>
			<li><input type="text" name="capcha" class="captcha"></li>
		</ul>
		<input type = "submit" name="registration" class="enter-btn" value = "Зарегистрироваться">
	</form>
	<div class="clear">&nbsp;</div>
</div>
<?php } ?>