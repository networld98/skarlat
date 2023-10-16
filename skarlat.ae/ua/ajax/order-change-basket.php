<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Sale;
$basket = \Bitrix\Sale\Basket::loadItemsForFUser($_POST['USER'], $_POST['SITE']);
$basketItems = $basket->getBasketItems();

foreach ($basketItems as $basketItem) {
    if(in_array($basketItem->getProductId(),$_POST['DELETE'])){
        $basket->getItemById($basketItem->getId())->delete();
    }
}
$basket->save();

