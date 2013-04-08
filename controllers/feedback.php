<?php

/**
 * Контроллер Feedback
 *
 * Класс Controllers_Feedback обрабатывает действия пользователей на странице обратной связи.
 * - Проверяет корректность ввода данных с формы обратной связи;
 * - При успешной валидации данных, отправляет сообщение админам интернет магазина, и выводит сообщение об успешной отправке.
 *
 * @author Авдеев Марк <mark-avdeev@mail.ru>
 * @package moguta.cms
 * @subpackage Controller
 */
class Controllers_Feedback extends BaseController{

  function __construct(){

    $data = array(
      'dislpayForm' => true
    );

    // Если пришли данные с формы.
    if(isset($_POST['send'])){

      // Создает модель отправки сообщения.
      $feedBack = new Models_Feedback;

      // Проверяет на корректность вода
      $error = $feedBack->isValidData($_POST);
      $data['error'] = $error;

      // Если есть ошибки заносит их в переменную.
      if(!$error){
        //Отправляем админам
        $sitename = MG::getOption('sitename');
        $message = '<b>Имя:</b> ' . $feedBack->getFio() . '<br /> <b>Email:</b> ' . $feedBack->getEmail() . '<br /><b>Телефон:</b> ' . $feedBack->getPhone() . '<br /><br /><b>Сообщение:<b/><br />';
        $message .= str_replace('№', '#', $feedBack->getMessage());
        $mails = explode(',', MG::getOption('adminEmail'));

        foreach($mails as $mail){
          if(preg_match('/^[A-Za-z0-9._-]+@[A-Za-z0-9_-]+.([A-Za-z0-9_-][A-Za-z0-9_]+)$/', $mail)){
            Mailer::addHeaders(array("Reply-to" => $feedBack->getEmail()));
            Mailer::sendMimeMail(array(
              'nameFrom' => $feedBack->getFio(),
              'emailFrom' => $feedBack->getEmail(),
              'phoneFrom' => $feedBack->getPhone(),
              'nameTo' => $sitename,
              'emailTo' => $mail,
              'subject' => $feedBack->getSubject(),
              'body' => $message,
              'html' => true
            ));
          }
        }

        MG::redirect('/feedback?thanks=1');
      }
    }

    // Формирует сообщение.
    if(isset($_REQUEST['thanks'])){
      $data = array(
        'message' => 'Ваше сообщение отправленно!',
        'dislpayForm' => false
      );
    }

    $this->data = $data;
  }

}