<?
include_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';
if($_REQUEST['SALE']!=''){
	$arSelect = Array("ID", "IBLOCK_ID", "CODE", "NAME", "DETAIL_TEXT",'ACTIVE_FROM','ACTIVE_TO','DETAIL_PICTURE','PROPERTY_PRODUCTS_'.SITE_ID,'PROPERTY_SECTIONS_'.SITE_ID);//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
	$arFilter = Array("IBLOCK_ID"=>49, "CODE"=>$_REQUEST['SALE'], "ACTIVE"=>"Y",'PROPERTY_SITE'=>SITE_ID);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
	while($ob = $res->GetNextElement()){ 
		$arSaleFields = $ob->GetFields(); 
	}
}
$start_date = new \DateTime($arSaleFields['ACTIVE_FROM']);
$end_date=new \DateTime($arSaleFields['ACTIVE_TO']);
	echo downcounter($arSaleFields['ACTIVE_TO']);
?>