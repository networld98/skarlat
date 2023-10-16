<?
include_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';
CModule::IncludeModule("sale");
if($_POST['count']!=NULL){
    $count = $_POST['count'];
}else{
    $count = 1;
}
$result=Add2BasketByProductID(
    $_POST['id'],
    $count,
	array()
);
if($result>0) echo 'added';
else echo $APPLICATION->LAST_ERROR;
?>