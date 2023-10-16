<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
/** @global CDatabase $DB */
/** @global CMain $APPLICATION */

use Bitrix\Main\Localization\Loc;

use Bitrix\Main,
    Bitrix\Iblock,
    Bitrix\Catalog;
Main\Loader::includeModule('catalog');

CJSCore::init(array('popup'));

$randomString = $this->randString();

if(SITE_ID =="mg"){
    $url = "https://".$_SERVER['SERVER_NAME']."/";
}elseif(SITE_ID =="sh"){
    $url =  "https://".$_SERVER['SERVER_NAME']."/en/";
}

$APPLICATION->setTitle(Loc::getMessage('CPSL_SUBSCRIBE_TITLE_NEW'));
if(!$arResult['USER_ID'] && !isset($arParams['GUEST_ACCESS'])):?>
    <?
    $contactTypeCount = count($arResult['CONTACT_TYPES']);
    $authStyle = 'display: block;';
    $identificationStyle = 'display: none;';
    if(!empty($_GET['result']))
    {
        $authStyle = 'display: none;';
        $identificationStyle = 'display: block;';
    }
    ?>
<?endif;

?>
<script type="text/javascript">
    BX.message({
        CPSL_MESS_BTN_DETAIL: '<?=('' != $arParams['MESS_BTN_DETAIL']
            ? CUtil::JSEscape($arParams['MESS_BTN_DETAIL']) : GetMessageJS('CPSL_TPL_MESS_BTN_DETAIL'));?>',

        CPSL_MESS_NOT_AVAILABLE: '<?=('' != $arParams['MESS_BTN_DETAIL']
            ? CUtil::JSEscape($arParams['MESS_BTN_DETAIL']) : GetMessageJS('CPSL_TPL_MESS_BTN_DETAIL'));?>',
        CPSL_BTN_MESSAGE_BASKET_REDIRECT: '<?=GetMessageJS('CPSL_CATALOG_BTN_MESSAGE_BASKET_REDIRECT');?>',
        CPSL_BASKET_URL: '<?=$arParams["BASKET_URL"];?>',
        CPSL_TITLE_ERROR: '<?=GetMessageJS('CPSL_CATALOG_TITLE_ERROR') ?>',
        CPSL_TITLE_BASKET_PROPS: '<?=GetMessageJS('CPSL_CATALOG_TITLE_BASKET_PROPS') ?>',
        CPSL_BASKET_UNKNOWN_ERROR: '<?=GetMessageJS('CPSL_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
        CPSL_BTN_MESSAGE_SEND_PROPS: '<?=GetMessageJS('CPSL_CATALOG_BTN_MESSAGE_SEND_PROPS');?>',
        CPSL_BTN_MESSAGE_CLOSE: '<?=GetMessageJS('CPSL_CATALOG_BTN_MESSAGE_CLOSE') ?>',
        CPSL_STATUS_SUCCESS: '<?=GetMessageJS('CPSL_STATUS_SUCCESS');?>',
        CPSL_STATUS_ERROR: '<?=GetMessageJS('CPSL_STATUS_ERROR') ?>'
    });
</script>
<?

if(!empty($_GET['result']) && !empty($_GET['message']))
{
    $successNotify = strpos($_GET['result'], 'Ok') ? true : false;
    $postfix = $successNotify ? 'Ok' : 'Fail';
    $popupTitle = Loc::getMessage('CPSL_SUBSCRIBE_POPUP_TITLE_'.strtoupper(str_replace($postfix, '', $_GET['result'])));

    $arJSParams = array(
        'NOTIFY_USER' => true,
        'NOTIFY_POPUP_TITLE' => $popupTitle,
        'NOTIFY_SUCCESS' => $successNotify,
        'NOTIFY_MESSAGE' => urldecode($_GET['message']),
    );
    ?>
    <script type="text/javascript">
        var <?='jaClass_'.$randomString;?> = new JCCatalogProductSubscribeList(<?=CUtil::PhpToJSObject($arJSParams, false, true);?>);
    </script>
    <?
}
?>

<?php
if (!empty($arResult['ITEMS']))
{
    $skuTemplate = array();
    if (!empty($arResult['SKU_PROPS']))
    {
        foreach ($arResult['SKU_PROPS'] as $itemId => $arProp)
        {
            foreach($arProp as $propId => $prop)
            {
                $propId = $prop['ID'];
                $skuTemplate[$itemId][$propId] = array(
                    'SCROLL' => array(
                        'START' => '',
                        'FINISH' => '',
                    ),
                    'FULL' => array(
                        'START' => '',
                        'FINISH' => '',
                    ),
                    'ITEMS' => array()
                );
                $templateRow = '';
                if ('TEXT' == $prop['SHOW_MODE'])
                {
                    $skuTemplate[$itemId][$propId]['SCROLL']['START'] = '<div class="bx_item_detail_size full" id="#ITEM#_prop_'.$propId.'_cont">'.
                        '<span class="bx_item_section_name_gray">'.htmlspecialcharsbx($prop['NAME']).'</span>'.
                        '<div class="bx_size_scroller_container"><div class="bx_size"><ul id="#ITEM#_prop_'.$propId.'_list" style="width: #WIDTH#;">';;
                    $skuTemplate[$itemId][$propId]['SCROLL']['FINISH'] = '</ul></div>'.
                        '<div class="bx_slide_left" id="#ITEM#_prop_'.$propId.'_left" data-treevalue="'.$propId.'" style=""></div>'.
                        '<div class="bx_slide_right" id="#ITEM#_prop_'.$propId.'_right" data-treevalue="'.$propId.'" style=""></div>'.
                        '</div></div>';

                    $skuTemplate[$itemId][$propId]['FULL']['START'] = '<div class="bx_item_detail_size" id="#ITEM#_prop_'.$propId.'_cont">'.
                        '<span class="bx_item_section_name_gray">'.htmlspecialcharsbx($prop['NAME']).'</span>'.
                        '<div class="bx_size_scroller_container"><div class="bx_size"><ul id="#ITEM#_prop_'.$propId.'_list" style="width: #WIDTH#;">';;
                    $skuTemplate[$itemId][$propId]['FULL']['FINISH'] = '</ul></div>'.
                        '<div class="bx_slide_left" id="#ITEM#_prop_'.$propId.'_left" data-treevalue="'.$propId.'" style="display: none;"></div>'.
                        '<div class="bx_slide_right" id="#ITEM#_prop_'.$propId.'_right" data-treevalue="'.$propId.'" style="display: none;"></div>'.
                        '</div></div>';
                    foreach ($prop['VALUES'] as $value)
                    {
                        $value['NAME'] = htmlspecialcharsbx($value['NAME']);
                        $skuTemplate[$itemId][$propId]['ITEMS'][$value['ID']] = '<li data-treevalue="'.$propId.'_'.$value['ID'].
                            '" data-onevalue="'.$value['ID'].'" style="width: #WIDTH#;" title="'.$value['NAME'].'"><i></i><span class="cnt">'.$value['NAME'].'</span></li>';
                    }
                    unset($value);
                }
                elseif ('PICT' == $prop['SHOW_MODE'])
                {
                    $skuTemplate[$itemId][$propId]['SCROLL']['START'] = '<div class="bx_item_detail_scu full" id="#ITEM#_prop_'.$propId.'_cont">'.
                        '<span class="bx_item_section_name_gray">'.htmlspecialcharsbx($prop['NAME']).'</span>'.
                        '<div class="bx_scu_scroller_container"><div class="bx_scu"><ul id="#ITEM#_prop_'.$propId.'_list" style="width: #WIDTH#;">';
                    $skuTemplate[$itemId][$propId]['SCROLL']['FINISH'] = '</ul></div>'.
                        '<div class="bx_slide_left" id="#ITEM#_prop_'.$propId.'_left" data-treevalue="'.$propId.'" style=""></div>'.
                        '<div class="bx_slide_right" id="#ITEM#_prop_'.$propId.'_right" data-treevalue="'.$propId.'" style=""></div>'.
                        '</div></div>';

                    $skuTemplate[$itemId][$propId]['FULL']['START'] = '<div class="bx_item_detail_scu" id="#ITEM#_prop_'.$propId.'_cont">'.
                        '<span class="bx_item_section_name_gray">'.htmlspecialcharsbx($prop['NAME']).'</span>'.
                        '<div class="bx_scu_scroller_container"><div class="bx_scu"><ul id="#ITEM#_prop_'.$propId.'_list" style="width: #WIDTH#;">';
                    $skuTemplate[$itemId][$propId]['FULL']['FINISH'] = '</ul></div>'.
                        '<div class="bx_slide_left" id="#ITEM#_prop_'.$propId.'_left" data-treevalue="'.$propId.'" style="display: none;"></div>'.
                        '<div class="bx_slide_right" id="#ITEM#_prop_'.$propId.'_right" data-treevalue="'.$propId.'" style="display: none;"></div>'.
                        '</div></div>';
                    foreach ($prop['VALUES'] as $value)
                    {
                        $value['NAME'] = htmlspecialcharsbx($value['NAME']);
                        $skuTemplate[$itemId][$propId]['ITEMS'][$value['ID']] = '<li data-treevalue="'.$propId.'_'.$value['ID'].
                            '" data-onevalue="'.$value['ID'].'" style="width: #WIDTH#; padding-top: #WIDTH#;"><i title="'.$value['NAME'].'"></i>'.
                            '<span class="cnt"><span class="cnt_item" style="background-image:url(\''.$value['PICT']['SRC'].'\');" title="'.$value['NAME'].'"></span></span></li>';
                    }
                    unset($value);
                }
            }
        }
        unset($templateRow, $prop);
    }
    ?>

    <div class="row grid-padding" id="row-favotrite-product">
        <? foreach ($arResult['ITEMS'] as $key => $arItem) {
            $strMainID = $this->GetEditAreaId($arItem['ID']);

            $arItemIDs = array(
                'ID' => $strMainID,
                'PICT' => $strMainID . '_pict',
                'SECOND_PICT' => $strMainID . '_secondpict',
                'MAIN_PROPS' => $strMainID . '_main_props',

                'QUANTITY' => $strMainID . '_quantity',
                'QUANTITY_DOWN' => $strMainID . '_quant_down',
                'QUANTITY_UP' => $strMainID . '_quant_up',
                'QUANTITY_MEASURE' => $strMainID . '_quant_measure',
                'BUY_LINK' => $strMainID . '_buy_link',
                'SUBSCRIBE_LINK' => $strMainID . '_subscribe',
                'SUBSCRIBE_DELETE_LINK' => $strMainID . '_delete_subscribe',

                'PRICE' => $strMainID . '_price',
                'DSC_PERC' => $strMainID . '_dsc_perc',
                'SECOND_DSC_PERC' => $strMainID . '_second_dsc_perc',

                'PROP_DIV' => $strMainID . '_sku_tree',
                'PROP' => $strMainID . '_prop_',
                'DISPLAY_PROP_DIV' => $strMainID . '_sku_prop',
                'BASKET_PROP_DIV' => $strMainID . '_basket_prop'
            );

            $strObName = 'ob' . preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
            $strObName2 = 'ob' . preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID . "2");

            $strTitle = (
            isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"])
            && '' != isset($arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"])
                ? $arItem["IPROPERTY_VALUES"]["ELEMENT_PREVIEW_PICTURE_FILE_TITLE"]
                : $arItem['NAME']
            );
            $showImgClass = $arParams['SHOW_IMAGE'] != "Y" ? "no-imgs" : "";
            $arPrice = CCatalogProduct::GetOptimalPrice($arItem['ID'], false, $USER->GetUserGroupArray(), false);
            if (!$arPrice || count($arPrice) <= 0) {
                if ($nearestQuantity = CCatalogProduct::GetNearestQuantityPrice($arItem['ID'], 1, $USER->GetUserGroupArray())) {
                    $quantity = $nearestQuantity;
                    $arPrice = CCatalogProduct::GetOptimalPrice($arItem['ID'], $quantity, $USER->GetUserGroupArray(), false);
                }
            }
            ?>
            <div class="col-12 col-xs-6 col-sm-6 col-md-4 col-lg-3 favorite-item_block" data-url="<?=$url?>"  data-id="<?=$arItem['ID']?>" id="<?= $strMainID; ?>">
                <?
                $res = CCatalogSKU::getOffersList($arItem['ID']);
                $first_sku_arr = current($res);
                $first_sku = CCatalogProduct::GetOptimalPrice($first_sku_arr['ID'], 1, $USER->GetUserGroupArray(), $renewal);
                $first_sku['ID'] = $first_sku_arr["ID"];
                ?>
                <a href="javascript:void(0)" class="product-item__wrapper-block-btn_favorite active product-item--remove"
                   id="<?= $arItemIDs['SUBSCRIBE_DELETE_LINK']; ?>2">
                    <svg class="heart" viewBox="0 0 20 20">
                        <path d="M18.5 2.9c-.9-1.1-2.3-1.7-3.8-1.7-2.1 0-3.5 1.3-4.2 2.3-.2.3-.4.5-.5.8-.1-.3-.3-.5-.5-.8-.7-1-2.1-2.3-4.2-2.3-1.5 0-2.9.6-3.9 1.7C.5 4 0 5.4 0 7c0 1.6.6 3.2 2.1 4.9 1.2 1.5 3 3 5.1 4.8.8.6 1.6 1.3 2.4 2.1h.1c.1.1.2.1.4.1s.3 0 .4-.1h.1c.9-.8 1.6-1.4 2.4-2.1 2.1-1.8 3.9-3.3 5.1-4.8C19.4 10.2 20 8.6 20 7c0-1.6-.5-3-1.5-4.1zm-6.4 12.8c-.6.6-1.4 1.1-2.1 1.8l-2.1-1.8C3.9 12.3 1.1 10 1.1 7c0-1.3.4-2.4 1.2-3.3.7-.9 1.8-1.4 2.9-1.4 1.6 0 2.6 1 3.3 1.9.6.7.9 1.5.9 1.8.1.2.3.3.6.3.2 0 .5-.1.6-.4.1-.3.4-1.1.9-1.8.6-.9 1.6-1.9 3.3-1.9 1.1 0 2.2.5 2.9 1.4.8.9 1.1 2 1.1 3.3 0 3.1-2.7 5.4-6.7 8.8z"></path>
                    </svg>
                </a>
                <a id="<?= $arItemIDs['SUBSCRIBE_DELETE_LINK']; ?>" class="product-item--remove"
                   href="javascript:void(0)">
                    <svg viewBox="0 0 20 20">
                        <path d="M.8 0L0 .8 9.2 10 0 19.2l.8.8 9.2-9.2 9.2 9.2.8-.8-9.2-9.2L20 .8l-.8-.8L10 9.2.8 0z"/>
                    </svg>
                </a>
                <? if (!isset($arItem['OFFERS']) || empty($arItem['OFFERS'])) // Simple Product
                {
                    $arJSParams = array(
                        'PRODUCT_TYPE' => $arItem['CATALOG_TYPE'],
                        'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
                        'SHOW_ADD_BASKET_BTN' => false,
                        'SHOW_BUY_BTN' => true,
                        'SHOW_ABSENT' => true,
                        'PRODUCT' => array(
                            'ID' => $arItem['ID'],
                            'NAME' => $arItem['~NAME'],
                            'PICT' => ('Y' == $arItem['SECOND_PICT'] ? $arItem['PREVIEW_PICTURE_SECOND'] : $arItem['PREVIEW_PICTURE']),
                            'CAN_BUY' => $arItem["CAN_BUY"],
                            'SUBSCRIPTION' => ('Y' == $arItem['CATALOG_SUBSCRIPTION']),
                            'CHECK_QUANTITY' => $arItem['CHECK_QUANTITY'],
                            'MAX_QUANTITY' => $arItem['CATALOG_QUANTITY'],
                            'STEP_QUANTITY' => $arItem['CATALOG_MEASURE_RATIO'],
                            'QUANTITY_FLOAT' => is_double($arItem['CATALOG_MEASURE_RATIO']),
                            'ADD_URL' => $arItem['~ADD_URL'],
                            'SUBSCRIBE_URL' => $arItem['~SUBSCRIBE_URL'],
                            'LIST_SUBSCRIBE_ID' => $arParams['LIST_SUBSCRIPTIONS'],
                        ),
                        'BASKET' => array(
                            'ADD_PROPS' => ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET']),
                            'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
                            'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
                            'EMPTY_PROPS' => $emptyProductProperties
                        ),
                        'VISUAL' => array(
                            'ID' => $arItemIDs['ID'],
                            'PICT_ID' => ('Y' == $arItem['SECOND_PICT'] ? $arItemIDs['SECOND_PICT'] : $arItemIDs['PICT']),
                            'QUANTITY_ID' => $arItemIDs['QUANTITY'],
                            'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
                            'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
                            'PRICE_ID' => $arItemIDs['PRICE'],
                            'BUY_ID' => $arItemIDs['BUY_LINK'],
                            'BASKET_PROP_DIV' => $arItemIDs['BASKET_PROP_DIV'],
                            'DELETE_SUBSCRIBE_ID' => $arItemIDs['SUBSCRIBE_DELETE_LINK'],
                        ),
                        'LAST_ELEMENT' => $arItem['LAST_ELEMENT'],
                    );
                    ?>
                    <script type="text/javascript">
                        var <?=$strObName;?> = new JCCatalogProductSubscribeList(
                            <?=CUtil::PhpToJSObject($arJSParams, false, true);?>);
                    </script>

                <? $arJSParams['VISUAL']['DELETE_SUBSCRIBE_ID'] = $arItemIDs['SUBSCRIBE_DELETE_LINK'] . '2'; ?>
                    <script type="text/javascript">
                        var <?=$strObName2;?> = new JCCatalogProductSubscribeList(
                            <?=CUtil::PhpToJSObject($arJSParams, false, true);?>);
                    </script>
                <?
                } ?>
                <div class="product-category-img">
                    <div class="product-category-slider">
                        <div class="product-category-slider__wrapper product-category-slider__wrapper-<?= $arItem['ID'] ?>">
                            <div class="product-category-slider__item">
                                <a class="product-category-slider__link" href="<?= $arItem['DETAIL_PAGE_URL'] ?>">
                                    <div class="product-category-slider__img-wrap">
                                        <?
                                        $arFileTmp = CFile::ResizeImageGet(
                                            $arItem['PREVIEW_PICTURE']['ID'],
                                            array("width" => 390, "height" => 450),
                                            BX_RESIZE_IMAGE_EXACT,
                                            true
                                        );
                                        if ($arFileTmp == '') {
                                            $arFileTmp['src'] = SITE_TEMPLATE_PATH."/img/no_photo_big.png";
                                        }
                                        ?>
                                        <img class="product-category-slider__img" src="<?= $arFileTmp['src'] ?>"
                                             alt="<?= $arItem['NAME'] ?>"/>
                                    </div>
                                    <div class="product-category-slider__info">
                                        <? if ($arItem['PROPERTIES']['SHORT_CATEGORY_NAME_ACTIVE']['VALUE']) {
                                            ?>
                                            <p><?= $arItem['PROPERTIES']['SHORT_CATEGORY_NAME']['VALUE'] ?></p>
                                            <?
                                        } ?>
                                        <span><?= $arItem['NAME'] ?></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product-category-slider-price">
                    <? if ($arPrice['RESULT_PRICE']['BASE_PRICE'] != $arPrice['RESULT_PRICE']['DISCOUNT_PRICE']): ?>
                        <span class="product-category-slider-price__old"><?= $arPrice['RESULT_PRICE']['BASE_PRICE'] ?>
                                        <span class="product-category-slider-price__old-currency"><?= $arPrice['RESULT_PRICE']['CURRENCY'] ?></span>
                                    </span>
                    <? endif; ?>
                    <span class="product-category-slider-price__new"><?= $arPrice['RESULT_PRICE']['BASE_PRICE'] ?>
                                    <span class="product-category-slider-price__new-currency"><?= $arPrice['RESULT_PRICE']['CURRENCY'] ?></span>
                                </span>
                </div>
            </div>
        <?
        } ?>
    </div>
    <div class="row">
        <div class="col-12">
            <nav aria-label="pagination">
                <div class="pagination">
                </div>
            </nav>
        </div>
    </div>
    <?
}
else
{
    echo '<h3>'.Loc::getMessage('CPSL_SUBSCRIBE_NOT_FOUND').'</h3>';
}
?>
