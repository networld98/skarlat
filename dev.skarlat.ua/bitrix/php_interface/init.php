<?
use Bitrix\Highloadblock as HL;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Bitrix\Catalog;
use Bitrix\Main\UI\Extension;
use Bitrix\Sale;
use Bitrix\Main\Config\Option;
Bitrix\Main\Loader::includeModule("sale");
Bitrix\Main\Loader::includeModule("catalog");

global $USER;

function sendPost($url, $postVars = array()){
    $options = array(
        'http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/json',
                'content' => $postVars
            )
    );
    $streamContext  = stream_context_create($options);
    $result = file_get_contents($url, false, $streamContext);
    if($result === false){
        $error = error_get_last();
        throw new Exception('POST request failed: ' . $error['message']);
    }
    return $result;
}
function sectionDeleter(){
	$refId=34;
	CModule::IncludeModule('iblock');
	$arFilter = array('IBLOCK_ID' => $refId);

	$rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilter,false, array("ID","IBLOCK_ID","IBLOCK_TYPE_ID","IBLOCK_SECTION_ID","CODE","SECTION_ID","NAME","SECTION_PAGE_URL"),array("nTopCount"=>20));
	while ($arSect = $rsSect->fetch()){
		file_put_contents($_SERVER['DOCUMENT_ROOT']."/test.txt",var_export($arSect,true));
		CIBlockSection::Delete($arSect['ID']);

	}
	return 'sectionDeleter();';
}
function getNPwarehouses(){
	$data=json_encode(array("modelName"=>"AddressGeneral", "calledMethod"=>"getWarehouses", "methodProperties"=> array("Language"=>"ru"),	"apiKey"=>"1e44322b3c2f3930ddbe0c5299cac334"));
	$result=sendPost("https://api.novaposhta.ua/v2.0/json/",$data);
	$result=json_decode($result,true);
	if($result['success']==1):
		CModule::IncludeModule('iblock');
		$refId=34;
		$arFilter = array('IBLOCK_ID' => $refId); // выберет потомков без учета активности
		$rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilter);
		while ($arSect = $rsSect->fetch()){
			$arAllSects[$arSect['NAME']]=$arSect['ID'];
		}

		$arSelect = Array("ID", "IBLOCK_ID", "NAME", "SECTION_ID", "CODE");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
		$arFilter = Array("IBLOCK_ID"=>$refId);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
		while($ob = $res->fetch()){
			$arAllElements[$ob['CODE']]=$ob['ID'];
		}

		foreach($result['data'] as $item){
			if($arAllSects[$item['CityDescriptionRu']]==''){
				$bs = new CIBlockSection;
				$arSectFields = Array(
					"ACTIVE" => "Y",
					"IBLOCK_ID" => $refId,
					"NAME" => $item['CityDescriptionRu'],
					"CODE" => $item['CityDescription'],
					"SORT" => $SORT,
				);
				$ID = $bs->Add($arSectFields);
				$arAllSects[$item['CityDescriptionRu']]=$ID;
			}

			if($arAllElements[$item['Ref']]==''){
				$el = new CIBlockElement;
				$arLoadProductArray = Array(
					"IBLOCK_SECTION_ID" => $arAllSects[$item['CityDescriptionRu']],
					"IBLOCK_ID"      => $refId,
					"NAME"           => $item['ShortAddressRu'],
					"ACTIVE"         => "Y",
					"PREVIEW_TEXT"   => $item['ShortAddress'],
					"CODE"    => $item['Ref'],
				);

				if($PRODUCT_ID = $el->Add($arLoadProductArray))
					$arAllElements[$item[$ob['Ref']]]=$PRODUCT_ID;
				else
					file_put_contents($_SERVER['DOCUMENT_ROOT']."/local/sitelog/errors_".date('d_m_Y').".txt"," - ".date("H:i:s")." Ошибка создания отделения ".$el->LAST_ERROR);

			}
		}

	else:
		file_put_contents($_SERVER['DOCUMENT_ROOT']."/local/sitelog/errors_".date('d_m_Y').".txt"," - ".date("H:i:s")." Ошибка получения списка отделений".var_export($result,true) );
	endif;
	return "getNPwarehouses();";
}
function getNPwarehousesUa(){
	$data=json_encode(array("modelName"=>"AddressGeneral", "calledMethod"=>"getWarehouses", "methodProperties"=> array("Language"=>"ru"),	"apiKey"=>"1e44322b3c2f3930ddbe0c5299cac334"));
	$result=sendPost("https://api.novaposhta.ua/v2.0/json/",$data);
	$result=json_decode($result,true);
	if($result['success']==1):
		CModule::IncludeModule('iblock');
		$refId=45;
		$arFilter = array('IBLOCK_ID' => $refId); // выберет потомков без учета активности
		$rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilter);
		while ($arSect = $rsSect->fetch()){
			$arAllSects[$arSect['NAME']]=$arSect['ID'];
		}

		$arSelect = Array("ID", "IBLOCK_ID", "NAME", "SECTION_ID", "CODE");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
		$arFilter = Array("IBLOCK_ID"=>$refId);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
		while($ob = $res->fetch()){
			$arAllElements[$ob['CODE']]=$ob['ID'];
		}

		foreach($result['data'] as $item){
			if($arAllSects[$item['CityDescription']]==''){
				$bs = new CIBlockSection;
				$arSectFields = Array(
					"ACTIVE" => "Y",
					"IBLOCK_ID" => $refId,
					"NAME" => $item['CityDescription'],
					"CODE" => $item['CityDescription'],
					"SORT" => $SORT,
				);
				$ID = $bs->Add($arSectFields);
				$arAllSects[$item['CityDescription']]=$ID;
			}

			if($arAllElements[$item['Ref']]==''){
				$el = new CIBlockElement;
				$arLoadProductArray = Array(
					"IBLOCK_SECTION_ID" => $arAllSects[$item['CityDescription']],
					"IBLOCK_ID"      => $refId,
					"NAME"           => $item['ShortAddress'],
					"ACTIVE"         => "Y",
					"PREVIEW_TEXT"   => $item['ShortAddress'],
					"CODE"    => $item['Ref'],
				);

				if($PRODUCT_ID = $el->Add($arLoadProductArray))
					$arAllElements[$item[$ob['Ref']]]=$PRODUCT_ID;
				else
					file_put_contents($_SERVER['DOCUMENT_ROOT']."/local/sitelog/errors_".date('d_m_Y').".txt"," - ".date("H:i:s")." Ошибка создания отделения ".$el->LAST_ERROR);

			}
		}

	else:
		file_put_contents($_SERVER['DOCUMENT_ROOT']."/local/sitelog/errors_".date('d_m_Y').".txt"," - ".date("H:i:s")." Ошибка получения списка отделений".var_export($result,true) );
	endif;
	return "getNPwarehousesUa();";
}

function makeArticles(){
	CModule::IncludeModule('iblock');

	$iblockIdRu=29;
	$iblockIdUa=47;
	$articlePropCode='ARTNUMBER';

	$arSelect = Array("ID", "NAME", "IBLOCK_ID");
	$arFilter = Array("IBLOCK_ID"=>$iblockIdRu, "PROPERTY_".$articlePropCode=>false);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
	while($ob = $res->fetch()){
		CIBlockElement::SetPropertyValuesEx($ob['ID'], false, array($articlePropCode => $ob['ID']));
	}

	$arSelect = Array("ID", "NAME", "IBLOCK_ID");
	$arFilter = Array("IBLOCK_ID"=>$iblockIdUa, "PROPERTY_".$articlePropCode=>false);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
	while($ob = $res->fetch()){
		CIBlockElement::SetPropertyValuesEx($ob['ID'], false, array($articlePropCode => $ob['ID']));
	}
	return 'makeArticles();';
}
	require $_SERVER['DOCUMENT_ROOT'].'/bitrix/php_interface/lib/make_ansi_xls.php';
function getPropHLColor($code){
	CModule::IncludeModule('highloadblock');
    $entity_rev_class=getHLColorClass();
    $arFilter = Array(
        'UF_XML_ID'=>$code
    );
    $rsData = $entity_rev_class::getList(
        array(
            'select' => ['ID','UF_NAME'],
            'filter' => $arFilter,
            'order' => ['ID'=>'ASC'],
        )
    );

    while($revinfo=$rsData->fetch()){
        $result=$revinfo['UF_NAME'];
    }
    return $result;
}
function getHLColorClass() {
    $hlbl = 2;
    $hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch();
    $entity = HL\HighloadBlockTable::compileEntity($hlblock);
    return $entity->getDataClass();
}

AddEventHandler("sale", "OnSaleStatusOrder", Array("Ready", "OnBeforeStatusUpdate"));

class Ready
{

    static function OnBeforeStatusUpdate($ID, $val)
    {
        if ($val == "F"){
            $accrued = Option::get("maycat.d7dull", "accrued");

            global $USER;
            $order = Sale\Order::load($ID);
            $basket = Sale\Basket::loadItemsForOrder($order);

            //Получаем промокод заказа
            $couponList = \Bitrix\Sale\Internals\OrderCouponsTable::getList(array(
                'select' => array('COUPON','ID'),
                'filter' => array('=ORDER_ID' => $ID)
            ));
            while ($coupon = $couponList->fetch()) {
                $promoNum = $coupon['COUPON'];
            }

            //получаем ID партнера
            $filter = Array("UF_COUPON" => $promoNum);
            $rsUsers = CUser::GetList(($by=""), ($order="desc"), $filter);
            $userId = $rsUsers->NavNext()['ID'];

            //получаем цены
            $rsUser = CUser::GetByID($userId);
            $arUser = $rsUser->Fetch();

            //Получить процент скидки партнера
            $rsGender = CUserFieldEnum::GetList(array(), array("ID" => $arUser["UF_AFFILIATE_DISCONT"]));
            if ($arCat = $rsGender->GetNext()){
                $partnerPercent = $arCat["VALUE"];
            }

            $partnerDiscount = $basket->getBasePrice() * $partnerPercent / 100;
            $discount = $basket->getBasePrice() - $basket->getPrice();
            $finishDiscount = $partnerDiscount - $discount;

            $el = new CIBlockElement;
            $PROP = array();
            $PROP['USER_ID'] = $userId;
            $PROP['ORDER_ID'] = $ID;
            $PROP['SUMA_DISCONT'] = $finishDiscount;

            $arLoadProductArray = Array(
                "MODIFIED_BY"    => $USER->GetID(),
                "IBLOCK_SECTION_ID" => false,
                "IBLOCK_ID"      => $accrued,
                "PROPERTY_VALUES"=> $PROP,
                "NAME"           => "Начисление скидки партнеру (".$userId.") ".date("d.m.y"),
                "ACTIVE"         => "N",
            );
            $el->Add($arLoadProductArray);
        }
    }
}
$url = explode('/',$_SERVER['SCRIPT_URL']);
$url = array_diff($url, array(''));
if(in_array('contact',$url)){
    $idUser = end($url);

    Extension::load('ui.buttons');
    Extension::load('ui.buttons.icons');

    ob_start();
    ?>
    <a target="_blank" href="/bitrix/admin/user_edit.php?lang=ua&ID=<?=$idUser?>&partner=Y" class="ui-btn i0btn-light-light-border ui-btn-incon-info">Партнерка</a>
    <?
    $html = ob_get_clean();
    $APPLICATION->AddViewContent('pagetitle',$html);
}