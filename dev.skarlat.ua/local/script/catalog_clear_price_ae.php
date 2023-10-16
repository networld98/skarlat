<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader,
    Bitrix\Main\Config\Option;

Loader::includeModule("iblock");
Loader::includeModule("catalog");
Loader::includeModule("sale");

$iblock = Option::get("maycat.d7dull", "catalog_iblock_ae");
$iblock = explode(',',$iblock);

$arSelect = Array('ID');
$arFilter = Array("IBLOCK_ID"=>$iblock);
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    CPrice::DeleteByProduct($arFields['ID']);
}
print 'Цены товаров в каталогах сайта обнулены';