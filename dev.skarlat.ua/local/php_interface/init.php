<?
use Bitrix\Highloadblock as HL;
use Bitrix\Catalog;
use Bitrix\Main\UI\Extension;
use Bitrix\Sale;
use Bitrix\Main\Config\Option;
Bitrix\Main\Loader::includeModule("sale");
Bitrix\Main\Loader::includeModule("catalog");

global $USER;

if(SITE_ID=='sh')
	define("CATALOG_IBLOCK_ID",29);
else
	define("CATALOG_IBLOCK_ID",47);

define("OFFERS_IBLOCK_ID",30);
function printer($data){
    GLOBAL $USER;
    if($USER->isAdmin()):
        echo '<pre class="findme">';
            print_r($data);
        echo '</pre>';
    endif;
}

function checkSectLevel($level){
    switch($level){
        case 2:
            $res="-second";
            break;
        case 3:
            $res="-third";
            break;
        default:
            $res="";
            break;
    }
    return $res;
}

function basketPrice() {
    $basket = \Bitrix\Sale\Basket::loadItemsForFUser(
        \Bitrix\Sale\Fuser::getId(),
        \Bitrix\Main\Context::getCurrent()->getSite()
    );

    return $basket->getPrice();
}

function basketItemsCount() {
    CModule::includeModule('sale');
    unset($_SESSION['IN_BASKET']);
    $basket = \Bitrix\Sale\Basket::loadItemsForFUser(
        \Bitrix\Sale\Fuser::getId(),
        \Bitrix\Main\Context::getCurrent()->getSite()
    );
    $quantity=0;
    foreach ($basket as $item){
        $_SESSION['IN_BASKET'][$item->getProductId()]=$item->getProductId();
        $quantity+=$item->getQuantity();
    }
    return $quantity;
}

function favouriteItemsCount($user_id) {

    $filter['USER_ID'] = $user_id;
    $subscquantity = 0;

    $resultObject = Catalog\SubscribeTable::getList(
        array(
            'select' => array(
                'ID',
                'ITEM_ID',
                'TYPE' => 'PRODUCT.TYPE',
                'IBLOCK_ID' => 'IBLOCK_ELEMENT.IBLOCK_ID',
            ),
            'filter' => $filter,
        )
    );

    while($item = $resultObject->fetch())
    {
        $subscquantity++;
    }

    return $subscquantity;
}

function BITGetDeclNum( $value = 1, $status = ['','а','ов'] ) {
    $array = [2,0,1,1,1,2];
    return $status[($value%100>4 && $value%100<20)? 2 : $array[($value%10<5)?$value%10:5]];
}

function setWatermarkImage() {
    $res = CIBlockElement::GetByID(503);
    if ($ar_res = $res->GetNext()) {
        $_SESSION['WATERMARK_IMAGE'] = $ar_res['PREVIEW_TEXT'];
        return $ar_res['PREVIEW_TEXT'];
    }
}

function getHLReviesClass() {
    $hlbl = 4;
    $hlblock = HL\HighloadBlockTable::getById($hlbl)->fetch();
    $entity = HL\HighloadBlockTable::compileEntity($hlblock);
    return $entity->getDataClass();
}

function checkUserLike($user,$review){
    CModule::IncludeModule('highloadblock');
    $entity_rev_class=getHLReviesClass();
    $arFilter = Array(
        'LOGIC' => 'OR',
        array(
            "UF_USER"=>$user,
            "UF_COMMENT"=>$review
        ),
        array(
            "UF_USER_IP"=>$user,
            "UF_COMMENT"=>$review
        )
    );
    $rsData = $entity_rev_class::getList(
        array(
            'select' => ['ID','UF_USER','UF_RATING','UF_COMMENT'],
            'filter' => $arFilter,
            'order' => ['ID'=>'ASC'],
        )
    );

    while($revinfo=$rsData->fetch()){

        $revid=$revinfo['ID'];
    }
    if($revid>0) return true;
    else return false;
}
function true_wordform($num, $form_for_1, $form_for_2, $form_for_5){
    $num = abs($num) % 100;
    $num_x = $num % 10;
    if ($num > 10 && $num < 20)
        return $form_for_5;
    if ($num_x > 1 && $num_x < 5)
        return $form_for_2;
    if ($num_x == 1)
        return $form_for_1;
    return $form_for_5;
}
function color_wordform($num, $form_for_1, $form_for_2, $form_for_5){
    if ($num > 5)
        return $form_for_5;
    if ($num > 1 && $num < 5)
        return $form_for_2;
    if ($num == 1)
        return $form_for_1;
    return $form_for_5;
}
function isUserPassword($userId, $password)
{
    $userData = CUser::GetByID($userId)->Fetch();
    $salt = substr($userData['PASSWORD'], 0, (strlen($userData['PASSWORD']) - 32));
    $realPassword = substr($userData['PASSWORD'], -32);
    $password = md5($salt.$password);
    return ($password == $realPassword);
}
AddEventHandler("iblock", "OnAfterIBlockElementAdd", "OnAfterIBlockElementAddHandler");
function OnAfterIBlockElementAddHandler(&$arFields)
{
    if($arFields["IBLOCK_ID"]==29 || $arFields["IBLOCK_ID"]==47){
		CIBlockElement::SetPropertyValuesEx(
			$arFields["ID"],
			$arFields['IBLOCK_ID'],
			array('kod' => $arFields["ID"])
		);
	}
}
/**
	 * Счетчик обратного отсчета
	 *
	 * @param mixed $date
	 * @return
	 */
	function downcounter($date){
	    $check_time = strtotime($date) - time();
	    if($check_time <= 0){
	        return false;
	    }

	    $days = floor($check_time/86400);
	    $hours = floor(($check_time%86400)/3600);
	    $minutes = floor(($check_time%3600)/60);
	    $seconds = $check_time%60; 

	    $str = '';
	    $str .= declension($days);
	    $str .= declension($hours);
	    $str .= declension($minutes);
	    $str .= declension($seconds);

	    return $str;
	}


	/**
	 * Функция склонения слов
	 *
	 * @param mixed $digit
	 * @param mixed $expr
	 * @param bool $onlyword
	 * @return
	 */
	function declension($digit){
		if($digit<10) $digit='0'.$digit;
		if($digit<1) $digit=(string)'00';
	    return '<div class="promo-info__timer-item"><span class="promo-info__timer-value">'.(string)$digit.'</span></div>';
	}

    \Bitrix\Main\EventManager::getInstance()->addEventHandler('search', 'BeforeIndex',
        array('\Olegpro\Classes\Handlers\Search\Stemming', 'beforeIndex')
    );

    \Bitrix\Main\EventManager::getInstance()->addEventHandler('search', 'OnBeforeIndexUpdate',
        array('\Olegpro\Classes\Handlers\Search\Stemming', 'beforeIndexUpdate')
    );

    \Bitrix\Main\EventManager::getInstance()->addEventHandler('search', 'OnAfterIndexAdd',
        array('\Olegpro\Classes\Handlers\Search\Stemming', 'beforeIndexUpdate')
    );

    \Bitrix\Main\Loader::registerAutoLoadClasses(null, array(
        '\Olegpro\Classes\Handlers\Search\Stemming' => '/local/php_interface/classes/handlers/search/stemming.php',
    ));


function OrderDetailAdminContextMenuShow(&$items){
    if ($_SERVER['REQUEST_METHOD']=='GET' && $GLOBALS['APPLICATION']->GetCurPage()=='/bitrix/admin/iblock_element_edit.php')
    {
        if (!empty($_GET['ID']) && ($_GET['IBLOCK_ID']==47 || $_GET['IBLOCK_ID']==29)){
            $btn = 0;
            $id = $_GET['ID'];
            $connection = Bitrix\Main\Application::getConnection();
            $sqlHelper = $connection->getSqlHelper();
            if($_GET['IBLOCK_ID']=='47'){
                $sql = "SELECT ID FROM remainsblacklistua WHERE UF_ELEMENT = '".$id."'";
            }else if($_GET['IBLOCK_ID']=='29') {
                $sql = "SELECT ID FROM remainsblacklisten WHERE UF_ELEMENT = '".$id."'";
            }
            $recordset = $connection->query($sql);
            while ($record = $recordset->fetch())
            {
                $btn = $record;
            }
            if($btn == 0){
                $items[] = array(
                    "TEXT"=>"∅ Добавить в чёрный список",
                    "LINK_PARAM" => 'style="color: rgb(58, 150, 64);" id="blacklist"',
                    "TITLE"=>"Добавить в чёрный список",
                );
            }else{
                $items[] = array(
                    "TEXT"=>"∅ Удалить из чёрного списка",
                    "LINK_PARAM" => 'style="color: rgb(255, 0, 1);" id="blacklist"',
                    "TITLE"=>"Удалить из чёрного списка",
                );
            }
        }
    }
}
AddEventHandler('main', 'OnAdminContextMenuShow', 'OrderDetailAdminContextMenuShow');

AddEventHandler("main", "OnBeforeUserLogin", array("CCustomHookEvent", "DoBeforeUserLoginHandler"));
class CCustomHookEvent {
    //  Проверяем пришел ли email или login и если email авторизуем по нему
    static function DoBeforeUserLoginHandler( &$arFields )
    {
        $userLogin = $_POST["USER_LOGIN"];
        if (isset($userLogin))
        {
            $isEmail = strpos($userLogin,"@");
            if ($isEmail>0)
            {
                $arFilter = Array("EMAIL"=>$userLogin);
                $rsUsers = CUser::GetList(($by="id"), ($order="desc"), $arFilter);
                if($res = $rsUsers->Fetch())
                {
                    if($res["EMAIL"]==$arFields["LOGIN"])
                        $arFields["LOGIN"] = $res["LOGIN"];
                }
            }
        }
    }
    // End
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
                $promoID = $coupon['ID'];
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
AddEventHandler("sale", "OnSaleBeforeOrderCanceled", "OnSaleBeforeOrderCanceledHandlers");

function OnSaleBeforeOrderCanceledHandlers(&$order){
    if ($order->isCanceled()){
        $order->setField("STATUS_ID", 'D');
    }
}
AddEventHandler("main", "OnAfterUserRegister", Array("MyClass", "OnAfterUserRegisterHandler"));
class MyClass
{
    static function OnAfterUserRegisterHandler(&$arFields)
    {
        $arEventFields= array(
            "LOGIN" => $arFields["LOGIN"],
            "NAME" => $arFields["NAME"],
            "LAST_NAME" => $arFields["LAST_NAME"],
            "PASSWORD" => $arFields["PASSWORD"],
            "EMAIL" => $arFields["EMAIL"],
            "SERVER_NAME" => "dev.skarlat.ua",
        );
        CEvent::Send("REGISTRATION_INFO", SITE_ID, $arEventFields, "N");
    }
}
// регистрируем обработчик
AddEventHandler("search", "BeforeIndex", "BeforeIndexHandler");
// создаем обработчик события "BeforeIndex"
function BeforeIndexHandler($arFields)
{
    if(!CModule::IncludeModule("iblock")) // подключаем модуль
        return $arFields;
    if($arFields["MODULE_ID"] == "iblock")
    {
        $db_props = CIBlockElement::GetProperty(                        // Запросим свойства индексируемого элемента
            $arFields["PARAM2"],         // BLOCK_ID индексируемого свойства
            $arFields["ITEM_ID"],          // ID индексируемого свойства
            array("sort" => "asc"),       // Сортировка (можно упустить)
            Array("CODE"=>"SHORT_CATEGORY_NAME")); // CODE свойства (в данном случае артикул)
        if($ar_props = $db_props->Fetch())
            $arFields["TITLE"] .= " ".$ar_props["VALUE"];   // Добавим свойство в конец заголовка индексируемого элемента
    }
    return $arFields; // вернём изменения
}
// Добавляем номер телефона в письмо заказа

AddEventHandler("sale", "OnOrderNewSendEmail", "ModifySaleMails");

function ModifySaleMails($orderID, &$eventName, &$arFields)
{
    $arOrder = CSaleOrder::GetByID($orderID);
    $order_props = CSaleOrderPropsValue::GetOrderProps($orderID);
    $phone = "";
    while ($arProps = $order_props->Fetch()){
        if ($arProps["CODE"] == "PHONE"){
            $phone = htmlspecialchars($arProps["VALUE"]);}

        if ($arProps["CODE"] == "ADDRESS"){
            $address = htmlspecialchars($arProps["VALUE"]);}
    }
    //-- добавляем новые поля в массив результатов
    $arFields["PHONE"] =  $phone;
    $arFields["ADDRESS"] = $address;
}