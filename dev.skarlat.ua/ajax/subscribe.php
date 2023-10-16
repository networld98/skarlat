<?
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");
// require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
// $APPLICATION->SetTitle("test");
CModule::IncludeModule('subscribe');
global $USER;

if($_POST['s'] !== '') {
############ НЕ ПОДПИСАН ли УЖЕ? ############
    $subscr = CSubscription::GetList(
        array(),
        array()
    );
    while(($subscr_arr = $subscr->Fetch()))
        $aEmail[] = $subscr_arr["EMAIL"];

    if(!in_array($USER->GetEmail(), $aEmail) && $_POST['s'] == 1) {
# пидпысаты нахiй
// запрос всех рубрик
        $rub = CRubric::GetList(
            array("LID"=>"ASC","SORT"=>"ASC","NAME"=>"ASC"),
            array("ACTIVE"=>"Y", "LID"=>LANG)
        );
        $arRubIDS = array();
        while ($arRub = $rub->Fetch()){
            $arRubIDS[] = $arRub['ID'];
        }

// формируем массив с полями для создания подписки
        $arFields = Array(
            "USER_ID" => $USER->GetID(),
            "FORMAT" => "html",
            "EMAIL" => $USER->GetEmail(),
            "ACTIVE" => "Y",
            "RUB_ID" => $arRubIDS,
            "SEND_CONFIRM" => 'N'
        );
        $subscr = new CSubscription;
// создаем подписку
        $ID = $subscr->Add($arFields);
        if ($ID > 0){
            $arResult['status'] = 'ok';
        } else {
            $arResult['status'] = 'error';
            $arResult['msg'] = str_replace("<br>","",$subscr->LAST_ERROR);
        }

        $subscr->Update($ID, array("ACTIVE"=>"Y", "CONFIRM"=>"Y"));
        echo "вы подписались на рассылку";
    } elseif(in_array($USER->GetEmail(), $aEmail) && $_POST['s'] == 2) {

# видпысаты нахiй
        if (($res = CSubscription::Delete($_POST['subid'])) && $res->AffectedRowsCount() < 1 || $res == false){
            echo "Error deleting subscription.";
        } else {
            echo "Subscription deleted.";
        }
    }

} else {
    echo "error";
}