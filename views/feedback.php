<?php mgTitle('Обратная связь');?>
<?php MG::disableTemplate(); ?>

<h2 class="new-products-title">Оставить отзыв</h2>
<hr />
<div class="feedback-form-wrapper">
<?php if($data['dislpayForm']){ ?>
	<p class="auth-text">Заполните пожалуйста следующую форму</p>
	<form action="" method="post">
		<ul class="form-list">
			<div class="right-fields">
				<li><label>Тема:</label><span class="red-star">*</span><span class="error"><?php echo $data['error']['subject']; ?></span></li>
				<li><input type="text" name="subject" value="<?php echo $_POST['subject'] ?>"></li>
				<li><label>Сообщение:</label></li>
				<li><textarea class="address-area" name="message"><?php echo $_POST['message'] ?></textarea></li>
			</div>
			<li><label>Имя:</label><span class="red-star">*</span><span class="error"><?php echo $data['error']['fio']; ?></span></li>
			<li><input type="text" name="fio" value="<?php echo $_POST['fio'] ?>"></li>
			<li><label>Email:</label><span class="red-star">*</span><span class="error"><?php echo $data['error']['email']; ?></span></li>
			<li><input type="text" name="email" value="<?php echo $_POST['email'] ?>"></li>
			<li><label>Телефон:</label></li>
			<li><input type="text" name="phone" value="<?php echo $_POST['phone'] ?>"></li>
			<input type="hidden" name="send" value="Отправить сообщение" />
		</ul>
		<div class="clr"></div>
		<input type="submit" name="send" class="enter-btn" value="Отправить отзыв">
	</form>
	<div class="clr"></div>
</div>

 <?php
}else{
  echo "<div class='successSend'>".$data['message']."</div>";
};
?>
