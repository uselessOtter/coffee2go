<?php
/**
 * Контроллер: Cart
 *
 * Класс Controllers_Cart обрабатывает действия пользователей в корзине интернет магазина.
 * - Пересчитывает суммарную стоимость товаров в корзине;
 * - Очищает корзину;
 * - Подготавливает массив данных $data для вывода в шаблоне.
 *
 * @author Авдеев Марк <mark-avdeev@mail.ru>
 * @package moguta.cms
 * @subpackage Controller
 */
class Controllers_Cart extends BaseController{

  /**
   * Определяет поведение при изменении и удаление данных в корзине,
   * а так же выводит список позиций к заказу
   *
   * @return void
   */
  public function __construct(){

    $model = new Models_Cart;

    // если пользователь изменил данные в корзине
    if($_REQUEST['refresh']){
      $listItemId = $_REQUEST;

      // пробегаем по массиву, находим пометки на удаление и на изменение количества
      foreach($listItemId as $ItemId => $newCount){
        $id = '';

        if('item_' == substr($ItemId, 0, 5)){
          $id = substr($ItemId, 5);
          $count = $newCount;
        }elseif('del_' == substr($ItemId, 0, 4)){
          $id = substr($ItemId, 4);
          $count = 0;
        }

        if($id){
          $arrayProductId[$id] = (int) $count;
        }
      }

      // передаем в модель данные для обновления корзины
      $model->refreshCart($arrayProductId);

      // пересчитываем маленькую корзину
      SmalCart::setCartData();

      if($_REQUEST['json']){
        $result = SmalCart::getCartData();
        echo json_encode($result);
        exit;
      }

      header('Location: '.SITE.'/cart');
      exit;
    }

    // если пользователь изменил данные в корзине
    if($_REQUEST['clear']){

      // передаем в модель данные для обновления корзины
      $model->clearCart();

      // пересчитываем маленькую корзину
      SmalCart::setCartData();
      header('Location: '.SITE.'/cart');
      exit;
    }

    // Количество вещей в корзине.
    $res['cart_count'] = 0;

    // Общая стоимость.
    $res['cart_price'] = 0;

    // Если удалось получить данные из куков и они успешно десериализованы в $_SESSION['cart'].
    //self::getCokieCart() &&
    if ($_SESSION['cart']) {

      // Пробегаем по содержимому.
      foreach ($_SESSION['cart'] as $id => $count) {
        $result = DB::query('
          SELECT c.url AS category_url, p.url AS product_url, p.*
          FROM `product` AS p
          JOIN `category` AS c ON c.id = p.cat_id
          WHERE p.id=%d', $id);

        if ($row = DB::fetchAssoc($result)) {
            $row['countInCart']=$count;
            $row['priceInCart']=$row['price'] * $count." ".MG::get('currency');
            $res['dataCart'][] =$row;
            $totalPrice += $row['price'] * $count;
            $totalCount += $count;
        } else{
          $result = DB::query('
          SELECT p.url AS product_url, p.*
          FROM `product` AS p
          WHERE p.id=%d', $id);
          if ($row = DB::fetchAssoc($result)) {
            $row['countInCart']=$count;
            $row['priceInCart']=$row['price'] * $count." ".MG::get('currency');
            $row['category_url']='';
            $res['dataCart'][] =$row;
            $totalPrice += $row['price'] * $count;
            $totalCount += $count;
        }
        }
      }
      if($totalPrice == 0) $totalPrice = '0';
      $res['cart_price_wc'] = $totalPrice." ".MG::get('currency');
      $res['cart_count'] = $totalCount;
      $res['cart_price'] = $totalPrice;
    }

    // формируем стандартный массив для представления
    $this->data = array (
      'isEmpty' => $model->isEmptyCart(),
      'productPositions' => $model->getItemsCart(),
      'totalSumm' => $model->getTotalSumm(),
      'total' => $res
    );

    if($_REQUEST['json']){
      echo json_encode($this->data);
      exit;
    }
  }

}