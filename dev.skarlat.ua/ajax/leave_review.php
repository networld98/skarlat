<?
include_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';
CModule::IncludeModule("sale");
	$el = new CIBlockElement;

	$PROP = array();
	$PROP['PRODUCT'] = $_POST['PRODUCT'];
	$PROP['ANSWER_TO'] = $_POST['ANSWER_TO'];
	$PROP['RANTING'] = $_POST['RANTING'];
	$PROP['USER'] =  $_POST['USER'];
	$PROP['ADVANTAGES'] =  $_POST['ADVANTAGES'];
	$PROP['DISADVANTAGES'] =  $_POST['DISADVANTAGES'];
	$PROP['NAME'] =  $_POST['NAME'];
	$PROP['EMAIL'] =  $_POST['EMAIL'];
	$PROP['review'] =  $_POST['review'];
	if($PROP['NAME']!='' && $PROP['ANSWER_TO']!=''){
		$mess1="Комментарий пользователя ".$PROP['NAME']." к отзыву ".$PROP['ANSWER_TO'];
		$mess2="Спасибо, Ваш комментарий будет опубликован после проверки модератором";
	}else{
		$mess1="Комментарий пользователя ".$PROP['USER']." к товару ".$PROP['PRODUCT'];
		$mess2="Спасибо за Ваш отзыв, он будет опубликован после проверки модератором";
	}
	
	if( ($PROP['NAME']!='' && $PROP['ANSWER_TO']!='') || ($PROP['PRODUCT']!='' && $PROP['review']!='')):
		$arLoadProductArray = Array(
			"MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
			"IBLOCK_ID"      => 33,
			"PROPERTY_VALUES"=> $PROP,
			"NAME"           => $mess1,
			"ACTIVE"         => "N",            // активен
			"PREVIEW_TEXT"   => $_POST['review'],            // активен
		);
	endif;
	if($PRODUCT_ID = $el->Add($arLoadProductArray))
		echo $mess2;
	else
		echo "Ошибка: ".$el->LAST_ERROR." Пожалуйста обновите страницу и попробуйте еще раз";
?>