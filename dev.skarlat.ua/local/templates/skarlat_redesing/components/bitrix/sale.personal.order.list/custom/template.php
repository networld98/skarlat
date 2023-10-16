<?

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main,
	Bitrix\Main\Localization\Loc,
	Bitrix\Main\Page\Asset,
    Bitrix\Sale;
Asset::getInstance()->addJs("/bitrix/components/bitrix/sale.order.payment.change/templates/.default/script.js");
Asset::getInstance()->addCss("/bitrix/components/bitrix/sale.order.payment.change/templates/.default/style.css");
CJSCore::Init(array('clipboard', 'fx'));

Loc::loadMessages(__FILE__);

Bitrix\Main\Loader::includeModule("sale");
Bitrix\Main\Loader::includeModule("catalog");

if (!empty($arResult['ERRORS']['FATAL']))
{
	foreach($arResult['ERRORS']['FATAL'] as $error)
	{
		ShowError($error);
	}
	$component = $this->__component;
	if ($arParams['AUTH_FORM_IN_TEMPLATE'] && isset($arResult['ERRORS']['FATAL'][$component::E_NOT_AUTHORIZED]))
	{
		$APPLICATION->AuthForm('', false, false, 'N', false);
	}

}
else
{
    $url = "https://".$_SERVER['SERVER_NAME']."/";

if (count($arResult['ORDERS'])==0) {?>
    <h6><?=Loc::getMessage('SPOL_TPL_NOT_ORDERS')?></h6>
    <?}else{
		foreach ($arResult['ORDERS'] as $key => $order) {
            $arStatus = CSaleStatus::GetByID($order['ORDER']['STATUS_ID']);
            $obProps = Bitrix\Sale\Internals\OrderPropsValueTable::getList(array('filter' => array('ORDER_ID' => $order['ORDER']['ID'])));
            while($prop = $obProps->Fetch()){
                if($prop['CODE']=='FIO')
                    $fio = $prop['VALUE'];
                if($prop['CODE']=='PHONE')
                    $phone = $prop['VALUE'];
                if($prop['CODE']=='NP_OFFICE')
                    $np = $prop['VALUE'];
                if($prop['CODE']=='STREET')
                    $street = $prop['VALUE'];
                if($prop['CODE']=='HOUSE')
                    $house = $prop['VALUE'];
                if($prop['CODE']=='FLAT')
                    $flat = $prop['VALUE'];
                if($prop['CODE']=='CITY')
                    $city = $prop['VALUE'];
            }
            ?>
            <div class="order">
                <div class="order__item">
                    <div class="collapse status-canceled">
                        <div class="short-info">
                            <small>№<?=$order['ORDER']['ID']?> <?=Loc::getMessage('SPOL_TPL_DATE_AT')?> <?=$order['ORDER']['DATE_INSERT_FORMATED']?></small>
                            <span><?=$arStatus['NAME']?></span>
                        </div>
                        <div class="order__cost">
                            <span><?=round($order['ORDER']['PRICE'],0)?></span>
                            <span><?if(SITE_ID == 'mg' && $order['ORDER']['CURRENCY'] == 'UAH'){echo Loc::getMessage('SPOL_TPL_CURENCY');}else{echo $order['ORDER']['CURRENCY'];}?></span>
                        </div>
                        <div class="arrow"></div>
                    </div>
                    <div class="collapse-content-new-order" style="">
                        <button class="modal-info__icon" data-id="<?=$order['ORDER']['ID']?>" data-url="<?=$url?>"  data-info="history"><?=Loc::getMessage('SPOL_TPL_HISTORY')?></button>
                        <div class="info-order">
                            <p><?=Loc::getMessage('SPOL_TPL_INFO')?></p>
                            <ul>
                                <li><?=$order['SHIPMENT'][0]['DELIVERY_NAME']?></li>
                                <li><?=$city?>, <?if($np!='curier'){echo $np;}else{?> <?=$street?> <?=$house?> <?if($flat){?>/<?=$flat;?><?}}?></li>
                                <li><?=$fio?></li>
                                <li><?=$phone?></li>
                            </ul>
                        </div>
                        <div class="product-list">
                            <?foreach ($order['BASKET_ITEMS'] as $key => $item){
                                $arFilter = Array( "ID"=> $item['PRODUCT_ID']);
                                $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), Array());
                                while($ob = $res->GetNextElement())
                                {
                                    $imgId = $ob->GetFields()['PREVIEW_PICTURE'];
                                    $shortName = $ob->GetProperties()['SHORT_CATEGORY_NAME']['VALUE'];
                                }
                                $file = CFile::ResizeImageGet($imgId, array('width'=>100, 'height'=>100), BX_RESIZE_IMAGE_EXACT, true);
                                ?>
                                <div class="product-item">
                                    <div class="product-item__info">
                                        <div class="product-item__img">
                                            <img src="<?=$file['src']?>" alt="<?=$item['NAME']?>">
                                        </div>
                                        <div class="product-item__name">
                                            <p><?=$shortName?></p>
                                            <a href="<?=$item['DETAIL_PAGE_URL']?>">
                                                <span><?=$item['NAME']?></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-item__order">
                                        <div class="coll">
                                            <div class="title">
                                                <?=Loc::getMessage('SPOL_TPL_CNT')?>
                                            </div>
                                            <div class="product-item__count">
                                                <?=$item['QUANTITY']?>x
                                            </div>
                                        </div>
                                        <div class="coll">
                                            <div class="title">
                                                <?=Loc::getMessage('SPOL_TPL_SUMOF')?>
                                            </div>
                                            <div class="product-item__price"><?=round($item['PRICE'],0)?><span><?if(SITE_ID == 'mg' && $item['CURRENCY'] == 'UAH'){echo Loc::getMessage('SPOL_TPL_CURENCY');}else{echo $item['CURRENCY'];}?></span></div>
                                        </div>
                                    </div>
                                </div>
                            <?}?>
                        </div>
                        <ul class="order-total-list">
                            <?foreach ($order['PAYMENT'] as $payment){?>
                                <li class="order-total__item">
                                    <div class="order-total__item-title"><?=Loc::getMessage('SPOL_TPL_PAYMENT')?></div>
                                    <div class="order-total__value"><?=$payment['PAY_SYSTEM_NAME']?><?if(count($order['PAYMENT'])>1){?> (<?echo $payment['FORMATED_SUM'];?>)<?}?></div>
                                </li>
                            <?}?>
                            <li class="order-total__item">
                                <div class="order-total__item-title"><?=Loc::getMessage('SPOL_TPL_DELIVERY')?></div>
                                <div class="order-total__value"><?=$order['SHIPMENT'][0]['DELIVERY_NAME']?></div>
                            </li>
                            <li class="order-total__item">
                                <div class="order-total__item-title"><?=Loc::getMessage('SPOL_TPL_FULL')?></div>
                                <div class="order-total__value cost"><?=round((int)$order['PAYMENT'][0]['CURRENCY'],0)?><span><?if(SITE_ID == 'mg' && $order['PAYMENT'][0]['CURRENCY'] == 'UAH'){echo Loc::getMessage('SPOL_TPL_CURENCY');}else{echo $order['PAYMENT'][0]['CURRENCY'];}?></span></div>
                            </li>
                        </ul>
                        <?
                        $show = 'Y';
                            $showStyle = '';
                        if((count($order['PAYMENT']) == 1 && $order['PAYMENT'][0]['PAY_SYSTEM_ID'] != 7) || ($order['PAYMENT'][1]['SUM'] == 0 && !empty($order['PAYMENT'][1]['SUM']) && $order['PAYMENT'][1]['PAY_SYSTEM_ID']== 7) || $order['PAYMENT'][1]['PAY_SYSTEM_ID']== 6){
                            $show = 'N';
                            $showStyle = "justify-content: flex-end;";
                        }?>
                        <div class="order__control" style="<?=$showStyle?>">
                            <? if($order['ORDER']['CAN_CANCEL'] != 'N' && $show != 'N'){
                                $showDelimeter = false;
                                foreach ($order['PAYMENT'] as $payment)
                                {
                                    if ($order['ORDER']['LOCK_CHANGE_PAYSYSTEM'] !== 'Y')
                                    {
                                        $paymentChangeData[$payment['ACCOUNT_NUMBER']] = array(
                                            "order" => htmlspecialcharsbx($order['ORDER']['ACCOUNT_NUMBER']),
                                            "payment" => htmlspecialcharsbx($payment['ACCOUNT_NUMBER']),
                                            "allow_inner" => $arParams['ALLOW_INNER'],
                                            "refresh_prices" => $arParams['REFRESH_PRICES'],
                                            "path_to_payment" => $arParams['PATH_TO_PAYMENT'],
                                            "only_inner_full" => $arParams['ONLY_INNER_FULL'],
                                            "return_url" => $arResult['RETURN_URL'],
                                        );
                                    }
                                    if ($payment['PAY_SYSTEM_ID'] != 5){?>
                                        <a class="primary ajax_reload" href="<?=htmlspecialcharsbx($payment['PSA_ACTION_FILE'])?>"><?=Loc::getMessage('SPOL_TPL_PAY')?></a>
                                    <?}
                                }
                            }?>
                            <? if($order['ORDER']['CAN_CANCEL'] !== 'N'){
                                $link = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>
                                <a class="delete-order outline" data-id="<?=$order['ORDER']['ID']?>" href="<?=$link?>"><?=Loc::getMessage('SPOL_TPL_CANCEL_ORDER')?></a>
                            <?}?>
                        </div>
                    </div>
                </div>
            </div>
			<?
		}
    }?>
	<div class="clearfix"></div>
    <div class="bx-catalog-subscribe-alert-popup">
        <span class="bx-catalog-subscribe-alert-text">
            <?=Loc::getMessage('CPST_STATUS_SUCCESS')?>
        </span>
    </div>
	<?
	echo $arResult["NAV_STRING"];
}
?>
