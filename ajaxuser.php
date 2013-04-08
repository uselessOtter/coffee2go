<?php
class Ajaxuser extends Actioner{

  public function updateCart(){
      $cart = new Models_Cart;
      $cart->addToCart($_POST['itemId'], $_POST['count']);
      SmalCart::setCartData();

      $response = array(
        'status' => 'success',
        'data' => SmalCart::getCartData()
        );
      echo json_encode($response);
      exit;
  }

   public function delFromCart(){
      $cart = new Models_Cart;
      $cart->delFromCart($_POST['itemId']);
      SmalCart::setCartData();
      $response = array(
        'status' => 'success',
        'data' => SmalCart::getCartData()
      );
      echo json_encode($response);
      exit;
  }

  /**
   * Получает список продуктов при вводе в поле поиска
   */
  public function getSearchData(){

      $keyword = URL::getQueryParametr('search');
      if(!empty($keyword)){
        $catalog = new Models_Catalog;
        $items = $catalog->getListProductByKeyWord($keyword, true, true);
        $searchData = array(
          'status' => 'success',
          'item'=> array(
            'keyword'=>$keyword,
            'count'=>$items['numRows'],
			    'items'=>$items,
           )
          );
      }

      echo json_encode($searchData);
      exit;
  }


}
