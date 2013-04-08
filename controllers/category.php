<?php
/**
 * Контроллер: Catalog
 *
 * Класс Controllers_Catalog обрабатывает действия пользователей в каталоге интернет магазина.
 * - Формирует список товаров для конкретной страницы;
 * - Добавляет товар в корзину.
 *
 * @author Авдеев Марк <mark-avdeev@mail.ru>
 * @package moguta.cms
 * @subpackage Controller
 */
class Controllers_Catalog extends BaseController{

  function __construct(){
    // если нажата кнопка купить
    $_REQUEST['category_id'] = URL::getQueryParametr('category_id');
    if($_REQUEST['inCartProductId']){
      $cart = new Models_Cart;
      $cart->addToCart($_REQUEST['inCartProductId']);
      SmalCart::setCartData();
      MG::redirect('/cart');
    }
    $countСatalogProduct=MG::getOption('countСatalogProduct');
    // показать первую страницу выбранного раздела
    $page = 1;

    //запрашиваемая страница
    if(isset($_REQUEST['p'])){
      $page = $_REQUEST['p'];
    }

     $model = new Models_Catalog;
     
     //Получаем необходимое количество отображаемых товаров
     $number = URL::getQueryParametr('cnt');

    //если происходит поиск по ключевым словам
     $keyword = URL::getQueryParametr('search');
     
     //если происходит пользовательская фильтрация товаров
     $filters = URL::getQueryParametr('filters');

    if(!empty($keyword)){
      $items = $model->getListProductByKeyWord($keyword);
      $searchData = array('keyword'=>$keyword, 'count'=>$items['numRows']);
    } elseif(!empty($filters)){
        $items = $model->getListByUserFilter($number, $filters);
    } else {

      //получаем список вложенных категорий, для вывода всех продуктов, на страницах текущей категории
      $model->categoryId = MG::get('category')->getCategoryList($_REQUEST['category_id']);

      // в конец списка, добавляем корневую текущую категорию
      $model->categoryId[] = $_REQUEST['category_id'];

      // передаем номер требуемой страницы, и количество выводимых объектов
      if(!$number){
        $countСatalogProduct=MG::getOption('countСatalogProduct');
        $number = $countСatalogProduct;
      }
      $items = $model->getList($number, false, true);

    }

    $this->data = array(
      'items' => $items['catalogItems'],
      'titeCategory' => $model->currentCategory['title'],
      'pager' => $items['pager'],
      'searchData' => empty($searchData)?'':$searchData
    );
  }

}