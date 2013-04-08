<?php
/**
 * Контроллер: Order
 *
 * Класс Controllers_Order обрабатывает действия пользователей на странице оформления заказа.
 * - Производит проверку ввденых данных в форму оформления заказа;
 * - Добавляет заказ в базу данных сайта;
 * - Для нового покупателя производится регистрация пользователя
 * - Отправляет письмо с подтверждением заказа на указанный адрес покупателя и администратору сайта с составом заказа;
 * - Очищает корзину товаров, при успешно оформлении заказа;
 * - Перенаправляет на страницу с сообщеним об успешном оформлении заказа;
 * - Генерирует данные для страниц успешной и неудавшейся электронной оплаты товаров.
 *
 * @todo сделать единую передачу данных в представление, сделать более внятными стадии оформления заказов использую step
 * @author Авдеев Марк <mark-avdeev@mail.ru>
 * @author dmgriny
 * @package moguta.cms
 * @subpackage Controller
 */
class Controllers_Order extends BaseController{

  function __construct(){
    // сразу проверим, наполнена корзина товарами или нет
    $cart=SmalCart::getCartData();


    $error = array();
    $data = array(
     'error' => $error,
     'dislpayForm' => true,
    );
    // Создает модель для работы заказом
    $model = new Models_Order;

    // Если пришли данные с формы.
    if(isset($_POST['toOrder'])){
      if(empty($cart['cart_count'])){
        echo '<div class="order_form_block"><span class="error emptyCart">Корзина пуста! Пожалуйста выберите товар.</span></div>';
        exit;
      }
      // Проверяет на корректность ввода.
      $error = $model->isValidData($_POST);
       $data = array(
        'error' => $error['error'],
        'insert' => $error['insert'],
        'fail' => $error['fail'],
        'dislpayForm' => true,
       );

      // Если ошибок нет, то добавляет заказ в БД.
      if(!$error){
        // если заказ производит новый пользователь, то регистрируем его

        $orderId = $model->addOrder();

        // Пересчитывает маленькую корзину.
        SmalCart::setCartData();
        MG::redirect('/order?thanks='.$orderId.'&pay='.$model->payment."&summ=".$model->summ);
        exit;
      }
    }

    if(isset($_REQUEST['thanks']) && !$error){
      $data = array(
        'id' => $_REQUEST['thanks'],
        'summ' => $_REQUEST['summ'],
        'pay' => $_REQUEST['pay'],
        'dislpayForm' => false,
      );
    }

    if(isset($_REQUEST['payment']) && !$error){

      if('success' == $_REQUEST['payment']){
        $message = 'Вы успешно оплатили заказ!';
      }

      if('fail' == $_REQUEST['payment']){
        $message = 'Платеж не удался!<br/> Попробуйте снова, перейдя по ссылке из письма с уведомлением о принятии вашего заказа.';
      }

      $data = array(
        'dislpayForm' => false,
        'message' => $message,
        'pay' => $_REQUEST['pay'],
        'payment'=> $_REQUEST['payment']
      );
    }

    //отработка действия при переход по ссылке подтверждения заказа
    if($id = URL::getQueryParametr('id')){
      //информация о заказе по переденному id
      $orderInfo = $model->getOrder(' order.id = '.$id);
      $hash = URL::getQueryParametr('sec');
      //информация о пользователе, сделавший заказ
      $orderUser = USER::getUserInfoByEmail($orderInfo[$id]['user_email']);
      //если присланный хэш совпадает с хэшом из БД для соответствующего id
      if($orderInfo[$id]['confirmation'] == $hash){
        //если статус заказа "Не подтвержден"
        if(0 == $orderInfo[$id]['status_id']){
          $data = array(
            'confirmation' => true,
            'status' => true,
            'orderID' => $id,
           );
          //подтверждаем заказ
          $model->setOrderStatus($id, 1);
        }else{
          $data = array(
            'confirmation' => true,
            'status' => false,
            'error' => 'Заказ уже подтвержден и находится в работе<br>',
          );
        }
        //если пользователь не активизирован, то показываем форму задания пароля
        if(!$orderUser->activeted){
          $this->form ='
            <br>Вы успешно зарегестрировались на сайте '.SITE.' и можете отслеживать заказ в личном кабинете.
            <br>Установка пароля для доступа в личный кабинет.
              <form action = "'.SITE.'/forgotpass" method = "POST">
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
              </form>';
          $_SESSION['id'] = $orderUser->id;
        }
      }else{
        $data = array(
          'confirmation' => true,
          'status' => false,
          'error' => 'Не корректная ссылка.<br> Заказ не подтвержден<br>',
        );
      }
    }
//формирование таблицы методов доставки
    $deliveryTable = '<table class="table_order_form">';
    foreach($model->getDeliveryMethod() as $delivery){
      $deliveryTable .= '
        <tr>
          <td>'.$delivery['description'].'</td>
          <td><input type="radio"';

      if('express' == $delivery['name'])
        $deliveryTable .= 'checked="checked"';

      $deliveryTable .= ' name="delivery" value='.$delivery['id'].'>'.$delivery['cost'].' </td>
        </tr>';
    }
    $deliveryTable .= '</table>';
    $this->deliveryTable = $deliveryTable;

//формирование таблицы способов оплаты
    $paymentTable = '<table class="table_order_form">';
    $i['payment_id'] = 0;

    while($payment = $model->getPaymentMethod($i)){
      $paymentTable.= '
        <tr>
          <td>'.$payment.'</td>
          <td><input type="radio"';

      if('Наложенный платеж' == $payment)
        $paymentTable .= 'checked="checked"';

      $paymentTable.= 'name="payment" value='.$i['payment_id'].'></td>
        </tr>';
      $i['payment_id']++;
    }

    $paymentTable .= '</table>';

    //если пользователь авторизован, то заполняем форму личными даными
    if(User::isAuth()){
      $_POST['email'] = User::getThis()->email;
      $_POST['phone'] = User::getThis()->phone;
      $_POST['fio'] = User::getThis()->name.' '.User::getThis()->sname;
      $_POST['address'] = User::getThis()->address;
    }

    $this->paymentTable = $paymentTable;
    $this->data = $data;


  }

}