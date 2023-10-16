<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if(!CModule::IncludeModule("sale") || !CModule::IncludeModule("catalog") || !CModule::IncludeModule("iblock"))
	return;
	use Bitrix\Sale,
	Bitrix\Sale\Order;
	
	$basket = \Bitrix\Sale\Basket::loadItemsForFUser(
	   \Bitrix\Sale\Fuser::getId(),
	   \Bitrix\Main\Context::getCurrent()->getSite()
	);
	$quantity=0;
	foreach ($basket as $item){
		$quantity+=$item->getQuantity();
	}
	echo $quantity;
	basketItemsCount();
?>