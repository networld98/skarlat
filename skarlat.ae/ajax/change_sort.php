<?
include_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';
$sorter=explode('|',$_POST['sort']);
$_SESSION['SORT']=$sorter[0];
$_SESSION['SORT_BY']=$sorter[1];
?>