<?php mgTitle('Авторизация'); ?>
<h2 class="new-products-title">Авторизация пользователя</h2>
<?php echo $data['msgError'] ?>
	<div class="create-user-account">
		<h2>Новый пользователь</h2>
		<p class="auth-text">Создание учетной записи в нашем интерент-магазине даст Вам массу преимуществ перед обычными покупателями. Вы сможете следить за своими заказами, вносить изменения в Ваши данные покупателя.</p>
		<a href="<?php echo SITE?>/registration" class="create-account-btn">Создать учетную запись</a>
		<div class="clear"></div>
	</div>
	<div class="user-login">
		<h2>Зарегистрированный пользователь</h2>
		<p class="auth-text">Если Вы уже зарегистрированы у нас в интернет-магазине, пожалуйста авторизуйтесь.</p>
		<form action="<?php echo SITE?>/enter" method="POST">
			<ul class="form-list">
				<li>Email:<span class="red-star">*</span></li>
				<li><input type = "text" name = "email" value = "<?php echo $_POST['email']?>"></li>
				<li>Пароль:<span class="red-star">*</span></li>
				<li><input type="password" name="pass"></li>
			</ul>
			<a href="<?php echo SITE?>/forgotpass" class="forgot-link">Забыли пароль?</a>
			<button type="submit" class="enter-btn">Войти</button>
		</form>
	</div>

