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
		$mess1="Коментар користувача ".$PROP['NAME']." до відгуку ".$PROP['ANSWER_TO'];
		$mess2="Дякуємо, Ваш коментар буде опубліковано післе перовірки модератором";
	}else{
		$mess1="Коментар користувача ".$PROP['USER']." до товару ".$PROP['PRODUCT'];
		$mess2="Дякуємо за Ваш відгук, він буде опублікований післе перовірки модератором";
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
