<?
include_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';
if($_POST['isArray']!="Y"):
	if($_SESSION['CATALOG_COMPARE_LIST'][CATALOG_IBLOCK_ID]["ITEMS"][$_POST['id']]==$_POST['id']){
		unset(	$_SESSION['CATALOG_COMPARE_LIST'][CATALOG_IBLOCK_ID]["ITEMS"][$_POST['id']]);
		echo 'removed';
	}else{
		$_SESSION['CATALOG_COMPARE_LIST'][CATALOG_IBLOCK_ID]["ITEMS"][$_POST['id']]=$_POST['id'];
		echo 'added';
	}
else:
	foreach($_POST['array'] as $item){
		$_SESSION['CATALOG_COMPARE_LIST'][CATALOG_IBLOCK_ID]["ITEMS"][$item]=$item;
	}
endif;
?>