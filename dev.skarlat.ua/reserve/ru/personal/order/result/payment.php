<?
use Bitrix\Sale;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
?>
Перенаправление на страницу оплаты
<div style="display:none;">
<?
if($_REQUEST['ORDER_ID']>0){
	$order = Sale\Order::load($_REQUEST['ORDER_ID']);
	$propertyCollection = $order->getPropertyCollection();
	$somePropValue = $propertyCollection->getItemByOrderPropertyId(45);
	$somePropValue->setValue(date("d.m.Y H:i:s"));
	$order->save(); 
}
$APPLICATION->IncludeComponent(
    "bitrix:sale.order.payment",
    "",
    Array(
    )
);?>
</div>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>