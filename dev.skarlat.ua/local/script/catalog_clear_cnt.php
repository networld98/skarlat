<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader,
    Bitrix\Main\Config\Option;

Loader::includeModule("iblock");
Loader::includeModule("catalog");
Loader::includeModule("sale");

$iblock = Option::get("maycat.d7dull", "catalog_iblock");
$iblock = explode(',',$iblock);
$obProduct = new CCatalogProduct();

$arSelect = Array('ID');
$arFilter = Array("IBLOCK_ID"=>$iblock);
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $obProduct->Update($arFields['ID'], ['QUANTITY' => 0]);
}

print 'Количество товаров в каталогах сайта обнулено';