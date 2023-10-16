<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle(GetMessage('ORDER_TITLE'));

use Bitrix\Main\Loader,
    Bitrix\Sale\Fuser,
    Bitrix\Main\Config\Option,
    Bitrix\Sale,
    Bitrix\Sale\Order,
    Bitrix\Main\IO,
    Bitrix\Main\Application,
    Bitrix\Main\Localization\Loc,
    Bitrix\Sale\DiscountCouponsManager;
CModule::IncludeModule("catalog");
CModule::IncludeModule("sale");
CModule::IncludeModule("iblock");
$session = \Bitrix\Main\Application::getInstance()->getSession();
$session->set('email', '');

// Напопленная сумма на внутреннем счету
global $USER;
$personalBonus = floor(CSaleUserAccount::GetByUserID($USER->GetID(), "UAH")['CURRENT_BUDGET']);

if (basketItemsCount() > 0):
    if ($_POST["ordered"] == 'Y' && check_bitrix_sessid()) {
        $registeredUserID = $USER->getId();
        if (empty($registeredUserID)) {
            $arParams = array("replace_space" => "-", "replace_other" => "-");
            $nameTrans = Cutil::translit($_POST['ORDER']['PROPS']['FIO'], "ru", $arParams);


            $user_login = $nameTrans . date("dmYHis");
            $password = randString(8);

            $user = new CUser;

            $arFields = array(
                'LOGIN' => $user_login,
                'NAME' => $_POST['ORDER']['PROPS']['FIO'],
                'EMAIL' => $_POST['ORDER']['PROPS']['EMAIL'],
                'PASSWORD' => $password,
                'CONFIRM_PASSWORD' => $password,
                "GROUP_ID" => array(3, 4, 16, 17),
                'ACTIVE' => "Y",
                'ADMIN_NOTES' => "Зарегистрирован автоматически при оформлении заказа"
            );
            $registeredUserID = $user->Add($arFields);

            //Отправляет уведомление о регистрации
            $arEventFields= array(
                "LOGIN" =>$user_login,
                "NAME" => $_POST['ORDER']['PROPS']['FIO'],
                'PASSWORD' => $password,
                "EMAIL" => $_POST['ORDER']['PROPS']['EMAIL'],
                "SERVER_NAME" => "skarlat.ua",
            );
            CEvent::Send("USER_INFO", SITE_ID, $arEventFields, "N");
        }

        $request = Application::getInstance()->getContext()->getRequest();
        $siteId = \Bitrix\Main\Context::getCurrent()->getSite();
        $currencyCode = Option::get('sale', 'default_currency', 'UAH');
        DiscountCouponsManager::init();

        $basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
        $basket->save();

        $order = Order::create($siteId, $registeredUserID);
        \Bitrix\Sale\Compatible\DiscountCompatibility::stopUsageCompatible();
        $order->setPersonTypeId(3);

        $basket = Sale\Basket::loadItemsForFUser(\CSaleBasket::GetBasketUserID(), Bitrix\Main\Context::getCurrent()->getSite())->getOrderableItems();
        $order->setBasket($basket);
        $order->doFinalAction(true);
        $fullprice = $basket->getPrice();

        /*Shipment*/
        $db_dtype = CSaleDelivery::GetList(array("SORT" => "ASC", "NAME" => "ASC"), array("LID" => SITE_ID, "ACTIVE" => "Y",), false, false, array());
        while ($ptype = $db_dtype->Fetch()) {
            $name_delivery[$ptype['ID']] = $ptype['NAME'];
            $deliv_price[$ptype['ID']] = $ptype['PRICE'];
        }

        $shipmentCollection = $order->getShipmentCollection();
        $shipment = $shipmentCollection->createItem();
        $shipment->setFields(array(
            'DELIVERY_ID' => $_POST['ORDER']['DELIVERY']['TYPE'],
            'DELIVERY_NAME' => $name_delivery[$_POST['ORDER']['DELIVERY']['TYPE']],
        ));
        $shipmentItemCollection = $shipment->getShipmentItemCollection();
        foreach ($order->getBasket() as $item) {
            $shipmentItem = $shipmentItemCollection->createItem($item);
            $shipmentItem->setQuantity($item->getQuantity());

            $shipmentItemStoreCollection = $shipmentItem->getShipmentItemStoreCollection();
            $basketItem = $shipmentItem->getBasketItem();

            $shipmentItemStore = $shipmentItemStoreCollection->createItem($basketItem);

            $barcode = array(
                'ORDER_DELIVERY_BASKET_ID' => $shipmentItem->getId(),
                'STORE_ID' => 'STORAGE_STORE_MAIN_ID',
                'QUANTITY' => $item->getQuantity()
            );
            $setFieldResult = $shipmentItemStore->setFields($barcode);
        }

        $db_ptype = CSalePaySystem::GetList($arOrder = array("SORT" => "ASC", "PSA_NAME" => "ASC"), array("LID" => SITE_ID, "ACTIVE" => "Y", "PERSON_TYPE_ID" => 1));
        while ($ptype = $db_ptype->Fetch()) {
            $name_pay[$ptype["ID"]] = $ptype["PSA_NAME"];
        }
        $paymentCollection = $order->getPaymentCollection();
        if ($_POST['ORDER']['PAY_CURRENT_ACCOUNT'] == 'Y'){
            if ($personalBonus>$order->getPrice()){
                $personalBonus = $order->getPrice();
            }
            $paidSumm = $order->getPrice()-$personalBonus;
            $extPayment = $paymentCollection->createItem();
            $extPayment->setFields(array(
                'PAY_SYSTEM_ID' => 5,
                'PAY_SYSTEM_NAME' => 'Внyрішній рахунок',
                'PAID' => 'Y',
                'DATE_PAID' => date(), // Дата оплаты
                'EXTERNAL_PAYMENT' => 'Y',
                'SUM' => $personalBonus,
            ));
            $extPayment = $paymentCollection->createItem();
            $extPayment->setFields(array(
                'PAY_SYSTEM_ID' => $_POST['ORDER']['PAYMENT'],
                'PAY_SYSTEM_NAME' => $name_pay[$_POST['ORDER']['PAYMENT']],
                'SUM' => $paidSumm,

            ));
        }else{
            $extPayment = $paymentCollection->createItem();
            $extPayment->setFields(array(
                'PAY_SYSTEM_ID' => $_POST['ORDER']['PAYMENT'],
                'PAY_SYSTEM_NAME' => $name_pay[$_POST['ORDER']['PAYMENT']],
                'SUM' => $order->getPrice()
            ));
        }
       // $price = $order->getPrice()-$personalBonus;
        /**/
        $propertyCollection = $order->getPropertyCollection();

        foreach ($propertyCollection->getGroups() as $group) {
            foreach ($propertyCollection->getGroupProperties($group['ID']) as $property) {
                $p = $property->getProperty();
                if ($_POST['ORDER']['DELIVERY']['TYPE'] != 18):
                    switch ($p["CODE"]) {
                        case "STREET":
                            $property->setValue(htmlspecialcharsEx($_POST['ORDER']['DELIVERY'][$_POST['ORDER']['DELIVERY']['TYPE']]["STREET"]));
                            break;
                        case "HOUSE":
                            $property->setValue(htmlspecialcharsEx($_POST['ORDER']['DELIVERY'][$_POST['ORDER']['DELIVERY']['TYPE']]["HOUSE"]));
                            break;
                        case "FLAT":
                            $property->setValue(htmlspecialcharsEx($_POST['ORDER']['DELIVERY'][$_POST['ORDER']['DELIVERY']['TYPE']]["FLAT"]));
                            break;
                        case "NP_OFFICE":
                            break;
                        default:
                            $property->setValue(htmlspecialcharsEx($_POST['ORDER']['PROPS'][$p["CODE"]]));
                            break;
                    }
                else:
                    switch ($p["CODE"]) {
                        case "NP_OFFICE":
                            $property->setValue(htmlspecialcharsEx($_POST['ORDER']['PROPS']["NP_OFFICE"]));
                            break;
                        case "STREET":
                            break;
                        case "FLAT":
                            break;
                        case "HOUSE":
                            break;
                        default:
                            $property->setValue(htmlspecialcharsEx($_POST['ORDER']['PROPS'][$p["CODE"]]));
                            break;
                    }
                endif;
            }
        }

        $order->save();
        $orderId = $order->GetId();
        $session->set('email', $_POST['ORDER']['PROPS']['EMAIL']);
        $USER->Authorize($registeredUserID);
        LocalRedirect('/personal/order/result/?ORDER=' . $orderId);
    }
//Получаем список товаров
    $basket_storage = \Bitrix\Sale\Basket\Storage::getInstance(Fuser::getId(), SITE_ID);
    $basket = $basket_storage->getBasket();

    //получаем сумму скидки от промокода
    $discounts = \Bitrix\Sale\Discount::buildFromBasket($basket, new \Bitrix\Sale\Discount\Context\Fuser($basket->getFUserId(true)));
    $discounts->calculate();
    $fullDiscounts = $discounts->getApplyResult();
    $fullDiscountPrice = 0;
    foreach ($fullDiscounts['PRICES']['BASKET'] as $key => $item){
        $discountPrice[$key] = $item['PRICE'];
    }
    foreach ($basket as $basketItem)
    {
        $code = $basketItem->getBasketCode();
        $fullDiscountPrice = $fullDiscountPrice + $discountPrice[$code] * $basketItem->getQuantity();
    }
    ?>
    <section class="bg-lightgrey">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="block-head">
                        <h1><?=GetMessage('ORDER_TITLE')?></h1>
                        <div class="d-flex">
                            <p><?=GetMessage('ORDER_SUMM')?>:</p>
                            <span class="price_order"><?=$fullDiscountPrice;?></span>
                            <span class="currency"><?=GetMessage('ORDER_CURRENCY')?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="checkout">
        <?$siteId = \Bitrix\Main\Context::getCurrent()->getSite();?>
        <div class="container" id="block-change-cart">
            <form method="POST" action="" data-url="<?=SITE_DIR?>" id="cart-change-form">
                <input type="hidden" name="USER" value="<?=Sale\Fuser::getId()?>"/>
                <input type="hidden" name="SITE" value="<?=$siteId?>"/>
                <div class="control-block">
                    <div id="control" class="control-edit"><?=GetMessage('CHANGE_BASKET')?></div>
                    <button id="control-remove" type="submit" class="hide control-remove"><?=GetMessage('DEL_BASKET')?></button>
                    <div id="control-cancel" class="hide control-cancel"><?=GetMessage('CANCEL_BASKET')?></div>
                </div>
                <div class="order-block-body">
                    <ul class="order-product__list">
                        <?
                        foreach ($basket as $basket_item) {
                            $product = $basket_item->getFieldValues();
                            $arFilter = Array( "ID"=> $product['PRODUCT_ID']);
                            $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), Array());
                            while($ob = $res->GetNextElement())
                            {
                                $imgId = $ob->GetFields()['PREVIEW_PICTURE'];
                                $shortName = $ob->GetProperties()['SHORT_CATEGORY_NAME']['VALUE'];
                            }
                            $imgFile = CFile::ResizeImageGet($imgId, array('width'=>100, 'height'=>100), BX_RESIZE_IMAGE_EXACT, true);
                            $file = new IO\File(Application::getDocumentRoot() . $imgFile['src']);
                            $isExist = $file->isExists();
                            if($isExist == false){
                                $imgFile['src'] = SITE_TEMPLATE_PATH."/img/no_photo_small.png";
                            }
                            ?>
                            <li class="order-product__item">
                                <input type="checkbox" class="checkbox" name="DELETE[]" value="<?=$product['PRODUCT_ID']?>"/>
                                <a href="<?= $product['DETAIL_PAGE_URL'] ?>" class="order-product__link">
                                    <div class="order-product__img-wrapper">
                                        <img src="<?= $imgFile['src'] ?>" alt="<?= $product['NAME'] ?>"
                                             class="order-product__img">
                                    </div>
                                    <div class="order-product__info">
                                        <p><?= $shortName ?></p>
                                        <p><?= $product['NAME'] ?></p>
                                        <p class="order-product-quantity"><?= round($product['QUANTITY']) ?></p>
                                    </div>
                                </a>
                            </li>
                            <?
                        } ?>
                    </ul>
                </div>
            </form>
            <div class="order-block-footer row">
                <form method="POST" action="" id="order-form">
                    <section class="order-user">
                        <div class="col-12 col-md-6">
                            <?= bitrix_sessid_post() ?>

                            <!-- ORDER BLOCK USER INFO START -->
                            <div class="order-block order-block__info">
                                <div class="order-block__info-body">
                                    <div class="tab-content order-block__info-tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-new-user" role="tabpanel"
                                             aria-labelledby="pills-new-user-tab">
                                            <?
                                            //Если авторизован подставляем город из личного кабинета если нет ставим дефолтный
                                            $defaultCity = 18; //Киев
                                            global $USER;
                                            if($USER->IsAuthorized()){
                                                $order = array('sort' => 'asc');
                                                $tmp = 'sort';
                                                $filter = array('ID' => $USER->getId());
                                                $select = array("SELECT" => array("UF_PUSH_TOKEN", "UF_SEND_EMAIL", "UF_SEND_SMS", "UF_SEND_PUSH", "NAME", "SECOND_NAME", "LAST_NAME", "PERSONAL_PHONE"));
                                                $rsUsers = CUser::GetList($order, $tmp, $filter, $select);
                                                while ($arUser = $rsUsers->Fetch()) {
                                                    $arResult['USER_DATA'] = $arUser;
                                                    $ufio = $arUser['LAST_NAME'] . " " . $arUser['NAME'] . " " . $arUser['SECOND_NAME'];
                                                    $uphone = $arUser['PERSONAL_PHONE'];
                                                    $uemail = $arUser['EMAIL'];
                                                }
                                                if($arResult['USER_DATA']['PERSONAL_CITY']){
                                                    $db_vars = CSaleLocation::GetList(
                                                        array(
                                                            "SORT" => "ASC",),
                                                        array("LID" => LANGUAGE_ID,
                                                            'CITY_NAME_LANG'=> $arResult['USER_DATA']['PERSONAL_CITY']
                                                        ),
                                                        false,
                                                        false,
                                                        array()
                                                    );
                                                    while ($vars = $db_vars->Fetch()){
                                                        if(!empty($vars['ID']) ||$vars['ID']!=""){
                                                            $defaultCity = $vars['ID'];
                                                        }
                                                    }
                                                }
                                            }?>
                                            <div class="form-group">
                                                <label for="InputName-reg-order"><?=GetMessage('ORDER_NAME')?></label>
                                                <input type="text" class="form-control" name="ORDER[PROPS][FIO]"
                                                       required="required" id="InputName-reg-order" value="<?= $ufio ?>"
                                                       placeholder="<?=GetMessage('ORDER_NAME_PLACE')?>"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="InputTel-reg-order"><?=GetMessage('ORDER_PHONE')?></label>
                                                <input type="text" class="form-control" name="ORDER[PROPS][PHONE]"
                                                       required="required" id="InputTel-reg-order"
                                                       value="<?= $uphone ?>" placeholder="<?=GetMessage('ORDER_PHONE_PLACE')?>"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="InputEmail-reg-order"><?=GetMessage('ORDER_EMAIL')?></label>
                                                <input
                                                        type="email"
                                                        name="ORDER[PROPS][EMAIL]"
                                                        class="form-control"
                                                        id="InputEmail-reg-order"
                                                        placeholder="<?=GetMessage('ORDER_EMAIL_PLACE')?>"
                                                        value="<?= $uemail ?>"
                                                        required="required"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="order-delivery">
                        <div class="col-12">
                            <p class="order-delivery__title"><?=GetMessage('ORDER_SPOSOB')?>:</p>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="order-tab-delivery-nav">
                                <!--<div class="order-tab-delivery-nav__item" data-delivery="self">Самовывоз</div>-->
                                <div class="order-tab-delivery-nav__item order-tab-delivery-nav__item_nova" data-delivery="nova"><?=GetMessage('ORDER_NP')?></div>
                                <div class="order-tab-delivery-nav__item order-tab-delivery-nav__item_curier" data-delivery="curier"><?=GetMessage('ORDER_DK')?></div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="order-block order-block__delivery">
                                <div class="accordion" id="delivery-acardion">
                                    <div class="order-block__delivery-item order-tab-delivery__content order-tab-delivery__content-city form-group">
                                        <label for="autocompleteCity" class="order-block__delivery-autocomplete-label"><?=GetMessage('ORDER_CITY')?></label>
                                        <div class="select-city form-group">
                                            <?
                                            $APPLICATION->IncludeComponent(
                                                "bitrix:sale.location.selector.search",
                                                "custom",
                                                array(
                                                    "COMPONENT_TEMPLATE" => ".default",
                                                    "ID" => $defaultCity,
                                                    "NP" => $arResult['USER_DATA']['PERSONAL_NOTES'],
                                                    "CODE" => "",
                                                    "INPUT_NAME" => "ORDER[PROPS][CITY]",
                                                    "PROVIDE_LINK_BY" => "id",
                                                    "JSCONTROL_GLOBAL_ID" => "",
                                                    "JS_CALLBACK" => "",
                                                    "FILTER_BY_SITE" => "Y",
                                                    "SHOW_DEFAULT_LOCATIONS" => "Y",
                                                    "CACHE_TYPE" => "A",
                                                    "CACHE_TIME" => "36000000",
                                                    "FILTER_SITE_ID" => "mg",
                                                    "INITIALIZE_BY_GLOBAL_EVENT" => "",
                                                    "SUPPRESS_ERRORS" => "N"
                                                )
                                            ); ?>
                                        </div>
                                        <input type="hidden" value="Y" name="ordered">
                                        <div class="order-block__delivery-way-group" id="ajaxHelpCities">
                                            <a href="javascript:void(0)" onclick="setCity(18);"
                                               class="order-block__delivery-way"><?=GetMessage('ORDER_CITY_KYIV')?></a>
                                            <a href="javascript:void(0)" onclick="setCity(2256);"
                                               class="order-block__delivery-way"><?=GetMessage('ORDER_CITY_ODESA')?></a>
                                            <a href="javascript:void(0)" onclick="setCity(25736);"
                                               class="order-block__delivery-way"><?=GetMessage('ORDER_CITY_KHARKIV')?></a>
                                            <a href="javascript:void(0)" onclick="setCity(20724);"
                                               class="order-block__delivery-way"><?=GetMessage('ORDER_CITY_DNIPRO')?></a>
                                            <a href="javascript:void(0)" onclick="setCity(6746);"
                                               class="order-block__delivery-way"><?=GetMessage('ORDER_CITY_LVIV')?></a>
                                        </div>
                                    </div>
                                    <?
                                    $db_dtype = CSaleDelivery::GetList(
                                        array(
                                            "SORT" => "ASC",
                                            "NAME" => "ASC"
                                        ),
                                        array(
                                            "LID" => SITE_ID,
                                            "ACTIVE" => "Y",
                                        ),
                                        false,
                                        false,
                                        array()
                                    );
                                    if ($ar_dtype = $db_dtype->Fetch()) {
                                        do {
                                            ?>
                                            <? if ($ar_dtype['ID'] == 18): ?>
                                                <div id="nova"
                                                     class="order-block__delivery-item order-tab-delivery__content">
                                                    <div class="order-block__delivery-item-header">
                                                        <input class="checkbox delivery-val checkbox delivery-val-nova"
                                                               type="radio"
                                                               name="ORDER[DELIVERY][TYPE]"
                                                               id="order-block__delivery-item-<?= $ar_dtype['ID'] ?>"
                                                               data-toggle="collapse"
                                                               data-target="#order-block__delivery-item-<?= $ar_dtype['ID'] ?>-description"
                                                               aria-controls="order-block__delivery-item-<?= $ar_dtype['ID'] ?>-description"
                                                               value="<?= $ar_dtype['ID'] ?>"
                                                               required="required"
                                                               onclick="changeDelivery(<?= $ar_dtype['ID'] ?>);"
                                                               data-price="<?= $ar_dtype['PRICE'] ?>"/>
                                                    </div>
                                                    <div class="order-block__delivery-item-description"
                                                         id="order-block__delivery-item-<?= $ar_dtype['ID'] ?>-description"
                                                         data-parent="#delivery-acardion">
                                                        <div class="form-group">
                                                            <label for="selectPost"><?=GetMessage('ORDER_VIDDILENYA')?></label>
                                                            <div id="npoffice-container">
                                                                <select class="form-control"
                                                                        name="ORDER[DELIVERY][NP_OFFICE]"
                                                                        id="selectPost">
                                                                    <option><?=GetMessage('ORDER_YOU_CITY')?></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="order-tab-delivery__content-info">
                                                            <h4><?=GetMessage('ORDER_NP')?></h4>
                                                            <?=GetMessage('ORDER_OPIS_NP')?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <? elseif ($ar_dtype['ID'] == 19): ?>
                                                <div id="curier"
                                                     class="order-block__delivery-item order-tab-delivery__content">
                                                    <div class="order-block__delivery-item-header">
                                                        <input
                                                                class="checkbox delivery-val delivery-val-curier"
                                                                type="radio"
                                                                name="ORDER[DELIVERY][TYPE]"
                                                                id="order-block__delivery-item-<?= $ar_dtype['ID'] ?>-cur"
                                                                data-toggle="collapse"
                                                                data-target="#order-block__delivery-item-<?= $ar_dtype['ID'] ?>-cur-description"
                                                                aria-controls="order-block__delivery-item-<?= $ar_dtype['ID'] ?>-cur-description"
                                                                value="<?= $ar_dtype['ID'] ?>"
                                                                required="required"
                                                                onclick="changeDelivery(<?= $ar_dtype['ID'] ?>);"
                                                                data-price="<?= $ar_dtype['PRICE'] ?>"
                                                        />
                                                    </div>
                                                    <div id="order-block__delivery-item-<?= $ar_dtype['ID'] ?>-cur-description"
                                                         class="order-block__delivery-item-description"
                                                         data-parent="#delivery-acardion">
                                                        <div class="form-group">
                                                            <label for="ORDER[DELIVERY][<?= $ar_dtype['ID'] ?>][STREET]"
                                                                   class="order-block__delivery-autocomplete-label"><?=GetMessage('ORDER_STREET')?></label>
                                                            <input type="text" class="form-control delivery-unstable"
                                                                   value="<?= $arResult['USER_DATA']['PERSONAL_STREET'] ?>"
                                                                   data-delivery="<?= $ar_dtype['ID'] ?>"
                                                                   name="ORDER[DELIVERY][<?= $ar_dtype['ID'] ?>][STREET]"
                                                                   placeholder="<?=GetMessage('ORDER_STREET_PLACE')?>"/>
                                                        </div>
                                                        <div class="form-group form-group-row">
                                                            <div class="form-group w-50 mr-2">
                                                                <label for="ORDER[DELIVERY][<?= $ar_dtype['ID'] ?>][HOUSE]"
                                                                       class="order-block__delivery-autocomplete-label"><?=GetMessage('ORDER_HOUSE')?></label>
                                                                <input type="text"
                                                                       class="form-control delivery-unstable"
                                                                       value="<?= $arResult['USER_DATA']['PERSONAL_STATE'] ?>"
                                                                       data-delivery="<?= $ar_dtype['ID'] ?>"
                                                                       name="ORDER[DELIVERY][<?= $ar_dtype['ID'] ?>][HOUSE]"
                                                                       placeholder="<?=GetMessage('ORDER_HOUSE_PLACE')?>"/>
                                                            </div>

                                                            <div class="form-group w-50 ">
                                                                <label for="ORDER[DELIVERY][<?= $ar_dtype['ID'] ?>][FLAT]"
                                                                       class="order-block__delivery-autocomplete-label"><?=GetMessage('ORDER_FLAT_PLACE')?></label>
                                                                <input type="text"
                                                                       class="form-control delivery-unstable"
                                                                       value="<?= $arResult['USER_DATA']['PERSONAL_ZIP'] ?>"
                                                                       data-delivery="<?= $ar_dtype['ID'] ?>"
                                                                       name="ORDER[DELIVERY][<?= $ar_dtype['ID'] ?>][FLAT]"
                                                                       placeholder="<?=GetMessage('ORDER_FLAT_PLACE')?>"/>
                                                            </div>
                                                        </div>
                                                        <div class="order-tab-delivery__content-info">
                                                            <h4><?=GetMessage('ORDER_DK')?></h4>
                                                            <?=GetMessage('ORDER_OPIS_DK')?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <? endif; ?>
                                            <?
                                        } while ($ar_dtype = $db_dtype->Fetch());
                                    } else {
                                        echo GetMessage('ORDER_NO_NP')."<br>";
                                    }
                                    ?>
                                    <? if ($arResult['USER_DATA']['WORK_ZIP'] > 0 && $arResult['USER_DATA']['WORK_ZIP'] != 18): ?>
                                        <script>
                                            $(document).ready(function () {
                                                $('#order-block__delivery-item-<?=$arResult["USER_DATA"]["WORK_ZIP"]?>-cur').click();
                                                $('#order-block__delivery-item-<?=$arResult["USER_DATA"]["WORK_ZIP"]?>-cur-description').addClass('show');
                                                $('#selectCity').change();
                                            });
                                        </script>
                                    <? elseif ($arResult['USER_DATA']['PERSONAL_NOTES'] != ''): ?>
                                        <script>
                                            $('#order-block__delivery-item-<?=$arResult["USER_DATA"]["WORK_ZIP"]?>').click();
                                            $('#order-block__delivery-item-<?=$arResult["USER_DATA"]["WORK_ZIP"]?>-description').addClass('show');
                                            getNPOffices($('#autocompleteCity').val(), "<?=$arResult['USER_DATA']['PERSONAL_NOTES']?>");
                                        </script>
                                    <? endif; ?>
                                </div>
                            </div>
                            <button type="submit" id="falseButton"></button>
                        </div>
                    </section>
                    <section class="order-payment d-none" data-show="send">
                        <div class="col-12 col-md-6">
                            <?if($personalBonus>0){?>
                            <div class="order-block order-block__pay order-tab-payment-nav">
                                <div class="form-group">
                                    <label class="order-tab-payment-nav__item_account" for="pay-account" data-payment="account">
                                        <input class="checkbox" type="checkbox" name="ORDER[PAY_CURRENT_ACCOUNT]" id="pay-account" value="Y"><?=GetMessage('ORDER_ACC')?>
                                        <span style="float: right"><? echo $personalBonus;?></span>
                                    </label>
                                </div>
                            </div>
                            <?}?>
                            <div class="order-block order-block__pay order-tab-payment-nav">
                                <div class="form-group">
                                    <label class="order-tab-payment-nav__item" for="pay-cash" data-payment="cach">
                                        <input class="checkbox" required="required" type="radio" name="ORDER[PAYMENT]" id="pay-cash" value="6"><?=GetMessage('ORDER_CASH')?>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="order-tab-payment-nav__item" for="pay-forway" data-payment="visa">
                                        <input class="checkbox" required="required" type="radio" name="ORDER[PAYMENT]" id="pay-forway" value="7"><?=GetMessage('ORDER_CARD')?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div id="visa" class="order-tab-payment__content">
                                <h3><?=GetMessage('ORDER_CARD')?></h3>
                                <?=GetMessage('ORDER_OPIS_CARD')?>

                            </div>
                            <div id="cach" class="order-tab-payment__content">
                                <h3><?=GetMessage('ORDER_CASH')?></h3>
                                <?=GetMessage('ORDER_OPIS_CASH')?>
                            </div>
                        </div>
                    </section>
                    <section class="order-send-form">
                        <div class="col-12 col-md-6">
                            <button class="primary" id="send-order" onclick="$('#falseButton').click();"><?=GetMessage('ORDER_SUBMIT')?></button>
                        </div>
                    </section>
                </form>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function() {
            $('.order-tab-delivery-nav__item_<?=$arResult['USER_DATA']['PERSONAL_MAILBOX']?>').trigger('click');
        });
        $('#control-remove').click(function(){
            setCity(<?=$defaultCity?>);
        });
    </script>
<? else:
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . SITE_DIR . 'personal/cart/');
endif; ?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
