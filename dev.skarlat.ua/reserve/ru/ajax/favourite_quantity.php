<?
include_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';
use Bitrix\Main,
	Bitrix\Iblock,
	Bitrix\Catalog,
	Bitrix\Main\Localization\Loc;
Main\Loader::includeModule('catalog');
$filter['USER_ID'] = $USER->getId();
$resultObject = Catalog\SubscribeTable::getList(
	array(
		'select' => array(
			'ID',
			'ITEM_ID',
			'TYPE' => 'PRODUCT.TYPE',
			'IBLOCK_ID' => 'IBLOCK_ELEMENT.IBLOCK_ID',
		),
		'filter' => $filter,
	)
);
$subscquantity=0;
$listIblockId = array();

while($item = $resultObject->fetch())
{
	if($_POST['itemId']==$item['ITEM_ID']) $itemsResult['item']=$item['ID'];
	$subscquantity++;
}
$itemsResult['quantity']=$subscquantity;
echo json_encode($itemsResult);
?>