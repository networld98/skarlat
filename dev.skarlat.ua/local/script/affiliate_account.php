<?php
if ('cli' ==  php_sapi_name()){
    $_SERVER["DOCUMENT_ROOT"] = '/home/bitrix/ext_www/dev.skarlat.ua';
}
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader;
$el = new CIBlockElement;

//получаем начисление
$arSelect = array("PROPERTY_USER_ID","PROPERTY_ORDER_ID","PROPERTY_SUMA_DISCONT","ID");
$arFilter = array("IBLOCK_ID" => 57, "ACTIVE" => "N");
$res = CIBlockElement::GetList(array("TIMESTAMP_X" => "asc"), $arFilter, false, array(), $arSelect);
while ($ob = $res->GetNextElement()) {
    unset($your_date);
    unset($datediff);
    $arFields = $ob->GetFields();
    $arOrder = CSaleOrder::GetByID($arFields['PROPERTY_ORDER_ID_VALUE']);
    $now = time(); // текущее время (метка времени)
    $your_date = strtotime($arOrder['DATE_STATUS']); //дата статуса заказа
    $datediff = $now - $your_date; // получим разность дат (в секундах)
    if($arOrder["STATUS_ID"] == "F" && floor($datediff / (60 * 60 * 24))>0 ){
        //начисление на бонусные счет по истичению 14 дней посте выполнения заказа
        if (!CSaleUserAccount::UpdateAccount(
            $arFields['PROPERTY_USER_ID_VALUE'],
            ($arFields['PROPERTY_SUMA_DISCONT_VALUE']),
            "UAH",
            "MANUAL",
            $arFields['PROPERTY_USER_ID_VALUE']
        ));
        $arLoadProductArray = Array("ACTIVE" => "Y");
        $el->Update($arFields["ID"], $arLoadProductArray);
        // Получаем данные пользователя и отправляем ему уведомление о начислении
        $rsUser = CUser::GetByID($arFields['PROPERTY_USER_ID_VALUE']);
        $arUser = $rsUser->Fetch();

        $arEventFields= array(
            "NAME" => $arUser['NAME'],
            "LAST_NAME" => $arUser['LAST_NAME'],
            "EMAIL" => $arUser['EMAIL'],
            "BONUS" => round($arFields['PROPERTY_SUMA_DISCONT_VALUE'],0),
            "SERVER_NAME" => "skarlat.ua"
        );
        CEvent::Send("CALCULATION_BONUSES", $arUser['LID'], $arEventFields, "N");
    }
}
print "отработал";
