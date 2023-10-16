<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords", "світильники, купити світильник, світлодіодні світильники, світильники стельові, точкові світильники, led світильники, настінні світильники, світильник, світильники київ, інтернет магазин, інтернет, магазин, люстри, торшери, світильники,");
$APPLICATION->SetPageProperty("description", "Купити освітлення в Києві ▾ Ціна, відгуки, продаж ▾ Доставка по Україні ▾ Skarlat.ua");
$APPLICATION->SetTitle("Інтернет-магазин Skarlat");
?>
  <?/*   <div class="main-cat-slider">
        <div class="container p-lg-none">
            <div class="row main-section-cat no-gutters">
                <div class="col-xl-2 d-none d-xl-flex">
                    <!-- BLOCK MENU NAV START -->
                    <div class="category-menu-nav--wrapper">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:menu",
                            "main",
                            Array(
                                "ALLOW_MULTI_SELECT" => "N",
                                "CHILD_MENU_TYPE" => "left",
                                "DELAY" => "N",
                                "MAX_LEVEL" => "3",
                                "MENU_CACHE_GET_VARS" => array(""),
                                "MENU_CACHE_TIME" => "3600",
                                "MENU_CACHE_TYPE" => "N",
                                "MENU_CACHE_USE_GROUPS" => "Y",
                                "ROOT_MENU_TYPE" => "main",
                                "USE_EXT" => "N"
                            )
                        );?>
                    </div>
                    <!-- BLOCK MENU NAV END -->
                </div>
                <div class="col-xl-10 col-12">
                    <div class="wrapper-main-block">
					<div id="jumboAjaxWrapper">
                        <? if(basketItemsCount() !== 0): ?>
                        <!-- JUMBOTRON BASKET START -->
                        <div class="jumbotron jumbotron-basket jumbotron-fluid" id="jumbotronBasket">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="row">
                                            <div class="col d-flex align-items-center justify-content-start">
                                                <div class="jumbotron-basket-title">
                                                    <h3>
                                                        <?=GetMessage("IN_BASKET_PRESENT")?>
                                                        <a href="javascript:void(0)" id="basketModalButtonJumbotronBasketTitle" onclick="$('#basketModalButtonHeader').click();">
                                                            <?=basketItemsCount()?> <?=GetMessage("PRODUCT")?><?=BITGetDeclNum(basketItemsCount(), GetMessage("PRODUCT_ENDING"))?>
                                                        </a>
                                                    </h3>
                                                    <div class="jumbotron-basket-value">
                                                        <span><?=GetMessage("ON_SUM")?></span>
                                                        <div class="jumbotron-basket-price">
                                                            <?=basketPrice()?>
                                                            <div class="jumbotron-basket-currency">
                                                                <?=GetMessage("CURRENCY_".CCurrency::GetBaseCurrency())?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <?$APPLICATION->IncludeComponent(
                                                    "bitrix:main.include",
                                                    "",
                                                    Array(
                                                        "AREA_FILE_SHOW" => "file",
                                                        "AREA_FILE_SUFFIX" => "inc",
                                                        "EDIT_TEMPLATE" => "",
                                                        "PATH" => "/include/main_page/jumbotron_basket_list.php"
                                                    )
                                                );?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 d-flex jumbotron-basket-btn-block--wrapper">
                                        <div class="jumbotron-basket-btn-block">
                                            <a class="jumbotron-basket-btn-basket" id="basketModalButtonJumbotronBasket" onclick="$('#basketModalButtonHeader').click();" href="javascript:void(0)" role="button"><?=GetMessage("IN_BASKET")?></a>
                                            <a class="jumbotron-basket-btn-pay" href="/personal/order/make/"><?=GetMessage("ORDER")?></a>
                                        </div>
                                    </div>
                                    <button type="button" class="close jumbotron-basket-close" aria-label="Close">
                                        <span aria-hidden="true">
                                            <svg viewBox="0 0 20 20">
                                                <path
                                                        d="M.8 0L0 .8 9.2 10 0 19.2l.8.8 9.2-9.2 9.2 9.2.8-.8-9.2-9.2L20 .8l-.8-.8L10 9.2.8 0z"
                                                />
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- JUMBOTRON BASKET END -->
                        <? endif; ?>
					</div>
                        <!-- MAIN SLIDER START -->
                        <?$APPLICATION->IncludeComponent(
	"bitrix:advertising.banner", 
	"skarlat", 
	array(
		"CACHE_TIME" => "0",
		"CACHE_TYPE" => "A",
		"NOINDEX" => "Y",
		"QUANTITY" => "100",
		"TYPE" => "MAIN",
		"COMPONENT_TEMPLATE" => "skarlat"
	),
	false
);?>
                        <!-- MAIN SLIDER END -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- SECTION PRODUCT LINE START HOT-->
    <div class="product-lines">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product-lines__header">
                        <h2><?=GetMessage("HOT")?></h2>
                    </div>
                </div>
            </div>
            <?
            $arrFilter['PROPERTY_HOT_VALUE'] = 'Y';
            ?>
            <?$APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                "hot-slider",
                Array(
                    "ACTION_VARIABLE" => "action",
                    "ADD_PICT_PROP" => "-",
                    "ADD_PROPERTIES_TO_BASKET" => "Y",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "ADD_TO_BASKET_ACTION" => "ADD",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "BACKGROUND_IMAGE" => "-",
                    "BASKET_URL" => "/personal/basket.php",
                    "BROWSER_TITLE" => "-",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "COMPARE_NAME" => "CATALOG_COMPARE_LIST",
                    "COMPARE_PATH" => "/compare/",
                    "COMPATIBLE_MODE" => "N",
                    "CONVERT_CURRENCY" => "N",
                    "CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",
                    "DETAIL_URL" => "",
                    "DISABLE_INIT_JS_IN_COMPONENT" => "Y",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "DISPLAY_COMPARE" => "Y",
                    "DISPLAY_TOP_PAGER" => "N",
                    "ELEMENT_SORT_FIELD" => "rand",
                    "ELEMENT_SORT_FIELD2" => "id",
                    "ELEMENT_SORT_ORDER" => "asc",
                    "ELEMENT_SORT_ORDER2" => "desc",
                    "ENLARGE_PRODUCT" => "STRICT",
                    "FILTER_NAME" => "arrFilter",
                    "HIDE_NOT_AVAILABLE" => "N",
                    "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                    "IBLOCK_ID" => "47",
                    "IBLOCK_TYPE" => "catalog",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "LABEL_PROP" => array(),
                    "LAZY_LOAD" => "N",
                    "LINE_ELEMENT_COUNT" => "15",
                    "LOAD_ON_SCROLL" => "N",
                    "MESSAGE_404" => "",
                    "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                    "MESS_BTN_BUY" => "Купить",
                    "MESS_BTN_COMPARE" => "Сравнить",
                    "MESS_BTN_DETAIL" => "Подробнее",
                    "MESS_BTN_SUBSCRIBE" => "Подписаться",
                    "MESS_NOT_AVAILABLE" => "Нет в наличии",
                    "META_DESCRIPTION" => "-",
                    "META_KEYWORDS" => "-",
                    "OFFERS_FIELD_CODE" => array("", ""),
                    "OFFERS_LIMIT" => "0",
                    "OFFERS_SORT_FIELD" => "sort",
                    "OFFERS_SORT_FIELD2" => "id",
                    "OFFERS_SORT_ORDER" => "asc",
                    "OFFERS_SORT_ORDER2" => "desc",
                    "PAGER_BASE_LINK_ENABLE" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => ".default",
                    "PAGER_TITLE" => "Товары",
                    "PAGE_ELEMENT_COUNT" => "15",
                    "PARTIAL_PRODUCT_PROPERTIES" => "N",
                    "PRICE_CODE" => array("BASE"),
                    "PRICE_VAT_INCLUDE" => "Y",
                    "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
                    "PRODUCT_DISPLAY_MODE" => "N",
                    "PRODUCT_ID_VARIABLE" => "id",
                    "PRODUCT_PROPS_VARIABLE" => "prop",
                    "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                    "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
                    "PRODUCT_SUBSCRIPTION" => "Y",
                    "PROPERTY_CODE_MOBILE" => array(),
                    "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
                    "RCM_TYPE" => "personal",
                    "SECTION_CODE" => "",
                    "SECTION_CODE_PATH" => "",
                    "SECTION_ID" => "",
                    "SECTION_ID_VARIABLE" => "SECTION_ID",
                    "SECTION_URL" => "",
                    "SECTION_USER_FIELDS" => array("", ""),
                    "SEF_MODE" => "N",
                    "SEF_RULE" => "",
                    "SET_BROWSER_TITLE" => "N",
                    "SET_LAST_MODIFIED" => "N",
                    "SET_META_DESCRIPTION" => "N",
                    "SET_META_KEYWORDS" => "N",
                    "SET_STATUS_404" => "N",
                    "SET_TITLE" => "N",
                    "SHOW_404" => "N",
                    "SHOW_ALL_WO_SECTION" => "Y",
                    "SHOW_CLOSE_POPUP" => "N",
                    "SHOW_DISCOUNT_PERCENT" => "N",
                    "SHOW_FROM_SECTION" => "N",
                    "SHOW_MAX_QUANTITY" => "N",
                    "SHOW_OLD_PRICE" => "N",
                    "SHOW_PRICE_COUNT" => "1",
                    "SHOW_SLIDER" => "Y",
                    "SLIDER_INTERVAL" => "3000",
                    "SLIDER_PROGRESS" => "N",
                    "TEMPLATE_THEME" => "blue",
                    "USE_ENHANCED_ECOMMERCE" => "N",
                    "USE_MAIN_ELEMENT_SECTION" => "N",
                    "USE_PRICE_COUNT" => "N",
                    "USE_PRODUCT_QUANTITY" => "N"
                )
            );?>
        </div>
    </div>
    <!-- SECTION PRODUCT LINE END-->
    <!-- SECTION PRODUCT LINE START NEW-->
    <div class="product-lines">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product-lines__header">
                        <h2><?=GetMessage("NEW")?></h2>
                    </div>
                </div>
            </div>
            <?
            $arrFilter = [];
            $arrFilter['PROPERTY_NEW_VALUE'] = 'Y';
            ?>
            <?$APPLICATION->IncludeComponent(
                "bitrix:catalog.section",
                "hot-slider",
                Array(
                    "ACTION_VARIABLE" => "action",
                    "ADD_PICT_PROP" => "-",
                    "ADD_PROPERTIES_TO_BASKET" => "Y",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "ADD_TO_BASKET_ACTION" => "ADD",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "BACKGROUND_IMAGE" => "-",
                    "BASKET_URL" => "/personal/basket.php",
                    "BROWSER_TITLE" => "-",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "Y",
                    "CACHE_TIME" => "36000000",
                    "CACHE_TYPE" => "A",
                    "COMPARE_NAME" => "CATALOG_COMPARE_LIST",
                    "COMPARE_PATH" => "/compare/",
                    "COMPATIBLE_MODE" => "N",
                    "CONVERT_CURRENCY" => "N",
                    "CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",
                    "DETAIL_URL" => "",
                    "DISABLE_INIT_JS_IN_COMPONENT" => "Y",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "DISPLAY_COMPARE" => "Y",
                    "DISPLAY_TOP_PAGER" => "N",
                    "ELEMENT_SORT_FIELD" => "rand",
                    "ELEMENT_SORT_FIELD2" => "id",
                    "ELEMENT_SORT_ORDER" => "asc",
                    "ELEMENT_SORT_ORDER2" => "desc",
                    "ENLARGE_PRODUCT" => "STRICT",
                    "FILTER_NAME" => "arrFilter",
                    "HIDE_NOT_AVAILABLE" => "N",
                    "HIDE_NOT_AVAILABLE_OFFERS" => "N",
                    "IBLOCK_ID" => "47",
                    "IBLOCK_TYPE" => "catalog",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "LABEL_PROP" => array(),
                    "LAZY_LOAD" => "N",
                    "LINE_ELEMENT_COUNT" => "15",
                    "LOAD_ON_SCROLL" => "N",
                    "MESSAGE_404" => "",
                    "MESS_BTN_ADD_TO_BASKET" => "В корзину",
                    "MESS_BTN_BUY" => "Купить",
                    "MESS_BTN_COMPARE" => "Сравнить",
                    "MESS_BTN_DETAIL" => "Подробнее",
                    "MESS_BTN_SUBSCRIBE" => "Подписаться",
                    "MESS_NOT_AVAILABLE" => "Нет в наличии",
                    "META_DESCRIPTION" => "-",
                    "META_KEYWORDS" => "-",
                    "OFFERS_FIELD_CODE" => array("", ""),
                    "OFFERS_LIMIT" => "0",
                    "OFFERS_SORT_FIELD" => "sort",
                    "OFFERS_SORT_FIELD2" => "id",
                    "OFFERS_SORT_ORDER" => "asc",
                    "OFFERS_SORT_ORDER2" => "desc",
                    "PAGER_BASE_LINK_ENABLE" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_TEMPLATE" => ".default",
                    "PAGER_TITLE" => "Товары",
                    "PAGE_ELEMENT_COUNT" => "15",
                    "PARTIAL_PRODUCT_PROPERTIES" => "N",
                    "PRICE_CODE" => array("BASE"),
                    "PRICE_VAT_INCLUDE" => "Y",
                    "PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
                    "PRODUCT_DISPLAY_MODE" => "N",
                    "PRODUCT_ID_VARIABLE" => "id",
                    "PRODUCT_PROPS_VARIABLE" => "prop",
                    "PRODUCT_QUANTITY_VARIABLE" => "quantity",
                    "PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
                    "PRODUCT_SUBSCRIPTION" => "Y",
                    "PROPERTY_CODE_MOBILE" => array(),
                    "RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
                    "RCM_TYPE" => "personal",
                    "SECTION_CODE" => "",
                    "SECTION_CODE_PATH" => "",
                    "SECTION_ID" => "",
                    "SECTION_ID_VARIABLE" => "SECTION_ID",
                    "SECTION_URL" => "",
                    "SECTION_USER_FIELDS" => array("", ""),
                    "SEF_MODE" => "N",
                    "SEF_RULE" => "",
                    "SET_BROWSER_TITLE" => "N",
                    "SET_LAST_MODIFIED" => "N",
                    "SET_META_DESCRIPTION" => "N",
                    "SET_META_KEYWORDS" => "N",
                    "SET_STATUS_404" => "N",
                    "SET_TITLE" => "N",
                    "SHOW_404" => "N",
                    "SHOW_ALL_WO_SECTION" => "Y",
                    "SHOW_CLOSE_POPUP" => "N",
                    "SHOW_DISCOUNT_PERCENT" => "N",
                    "SHOW_FROM_SECTION" => "N",
                    "SHOW_MAX_QUANTITY" => "N",
                    "SHOW_OLD_PRICE" => "N",
                    "SHOW_PRICE_COUNT" => "1",
                    "SHOW_SLIDER" => "Y",
                    "SLIDER_INTERVAL" => "3000",
                    "SLIDER_PROGRESS" => "N",
                    "TEMPLATE_THEME" => "blue",
                    "USE_ENHANCED_ECOMMERCE" => "N",
                    "USE_MAIN_ELEMENT_SECTION" => "N",
                    "USE_PRICE_COUNT" => "N",
                    "USE_PRODUCT_QUANTITY" => "N"
                )
            );?>
        </div>
    </div>
    <!-- SECTION PRODUCT LINE END-->
    <!-- BLOG SECTION START -->

<?/*
use \Bitrix\Conversion\Internals\MobileDetect;

$detect = new MobileDetect;
$is_mobile = $detect->isMobile();
?>
    <div class="blog">
        <div class="container">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "skarlat_mainpage",
                    Array(
                        "ACTIVE_DATE_FORMAT" => "d.m.Y",
                        "ADD_SECTIONS_CHAIN" => "N",
                        "AJAX_MODE" => "N",
                        "AJAX_OPTION_ADDITIONAL" => "",
                        "AJAX_OPTION_HISTORY" => "N",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "N",
                        "CACHE_FILTER" => "N",
                        "CACHE_GROUPS" => "N",
                        "CACHE_TIME" => "36000000",
                        "CACHE_TYPE" => "A",
                        "CHECK_DATES" => "N",
                        "DETAIL_URL" => "",
                        "DISPLAY_BOTTOM_PAGER" => "N",
                        "DISPLAY_DATE" => "Y",
                        "DISPLAY_NAME" => "Y",
                        "DISPLAY_PICTURE" => "Y",
                        "DISPLAY_PREVIEW_TEXT" => "Y",
                        "DISPLAY_TOP_PAGER" => "N",
                        "FIELD_CODE" => array("", ""),
                        "FILTER_NAME" => "",
                        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                        "IBLOCK_ID" => "41",
                        "IBLOCK_TYPE" => "news",
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
                        "INCLUDE_SUBSECTIONS" => "Y",
                        "MESSAGE_404" => "",
                        "NEWS_COUNT" => $is_mobile ? "2" : "4",
                        "PAGER_BASE_LINK_ENABLE" => "N",
                        "PAGER_DESC_NUMBERING" => "N",
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                        "PAGER_SHOW_ALL" => "N",
                        "PAGER_SHOW_ALWAYS" => "N",
                        "PAGER_TEMPLATE" => ".default",
                        "PAGER_TITLE" => "Новости",
                        "PARENT_SECTION" => "",
                        "PARENT_SECTION_CODE" => "",
                        "PREVIEW_TRUNCATE_LEN" => "",
                        "PROPERTY_CODE" => array("", ""),
                        "SET_BROWSER_TITLE" => "N",
                        "SET_LAST_MODIFIED" => "N",
                        "SET_META_DESCRIPTION" => "N",
                        "SET_META_KEYWORDS" => "N",
                        "SET_STATUS_404" => "N",
                        "SET_TITLE" => "N",
                        "SHOW_404" => "N",
                        "SORT_BY1" => "ACTIVE_FROM",
                        "SORT_BY2" => "SORT",
                        "SORT_ORDER1" => "DESC",
                        "SORT_ORDER2" => "ASC",
                        "STRICT_SECTION_CHECK" => "N"
                    )
                );?>
        </div>
    </div>
    <!-- BLOG SECTION END -->
    <!-- SEO SECTION START -->
    <div class="seo-main d-none d-lg-flex">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "EDIT_TEMPLATE" => "",
                            "PATH" => "/include/main_page/mainpage_static.php"
                        )
                    );?>
                </div>
            </div>
        </div>
    </div>
    <!-- SEO SECTION END -->
    <!-- SUBSCRIBE SECTION START -->
    <div class="subscribe-main">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-7">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "EDIT_TEMPLATE" => "",
                            "PATH" => "/include/main_page/advantages.php"
                        )
                    );?>
                </div>
                <div class="col-12 col-md-6 col-lg-5 d-flex align-items-center">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:form.result.new",
                        "main_page",
                        Array(
                            "CACHE_TIME" => "3600",
                            "CACHE_TYPE" => "A",
                            "CHAIN_ITEM_LINK" => "",
                            "CHAIN_ITEM_TEXT" => "",
                            "EDIT_URL" => "result_edit.php",
                            "IGNORE_CUSTOM_TEMPLATE" => "Y",
                            "LIST_URL" => "/",
                            "SEF_MODE" => "N",
                            "SUCCESS_URL" => "",
                            "USE_EXTENDED_ERRORS" => "N",
                            "VARIABLE_ALIASES" => Array(
                                "RESULT_ID" => "RESULT_ID",
                                "WEB_FORM_ID" => "WEB_FORM_ID"
                            ),
                            "WEB_FORM_ID" => "12"
                        )
                    );?>
                </div>
            </div>
        </div>
    </div>*/?>
    <!-- SUBSCRIBE SECTION END -->
<!-- Main -->

<main>
    <aside class="basket-aside__wrap">
        <div class="basket-aside" id="basket">
            <a href="#" class="account">
                <svg viewBox="0 0 25 25">
                    <g>
                        <path
                                d="M24.5801 11.176L13.3635 0.955395C12.8711 0.506714 12.1287 0.506763 11.6366 0.955346L0.419826 11.176C0.0254415 11.5354 -0.104832 12.0891 0.0878438 12.5866C0.280568 13.0841 0.749805 13.4056 1.28335 13.4056H3.07485V23.6458C3.07485 24.0518 3.40405 24.381 3.81005 24.381H9.95819C10.3642 24.381 10.6934 24.0519 10.6934 23.6458V17.4283H14.3068V23.6459C14.3068 24.0519 14.636 24.3811 15.042 24.3811H21.1898C21.5958 24.3811 21.925 24.0519 21.925 23.6459V13.4056H23.7169C24.2503 13.4056 24.7196 13.0841 24.9124 12.5866C25.1048 12.0891 24.9745 11.5354 24.5801 11.176Z"
                                fill="#787878"
                        />
                        <path
                                d="M21.7329 2.08643H16.7954L22.4681 7.24442V2.82158C22.4681 2.41558 22.1389 2.08643 21.7329 2.08643Z"
                                fill="#787878"
                        />
                    </g>
                </svg>
                <div class="account-info">
                    <span>
                        <?
                        if(\Bitrix\Main\Engine\CurrentUser::get()->getId())
                        {
                            echo \Bitrix\Main\Engine\CurrentUser::get()->getFullName();
                        }else{
                            echo 'Гость';
                        }
                        ?>
                    </span>
                       <?
                        if(\Bitrix\Main\Engine\CurrentUser::get()->getId())
                        {?>
                            <p><?= \Bitrix\Main\Engine\CurrentUser::get()->getEmail();?></p>
                       <?}?>
                </div>
            </a>

            <nav class="basket-aside__nav">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "auth_user_menu",
                    Array(
                        "ALLOW_MULTI_SELECT" => "N",
                        "CHILD_MENU_TYPE" => "left",
                        "DELAY" => "N",
                        "MAX_LEVEL" => "1",
                        "MENU_CACHE_GET_VARS" => array(""),
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_TYPE" => "N",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "ROOT_MENU_TYPE" => "user_menu",
                        "USE_EXT" => "N"
                    )
                );?>
            </nav>
        </div>
    </aside>
    <div class="main-slider">
        <div class="main-slider__wrapper">
            <div class="main-slider__item">
                <div class="main-slider__content">
                    <div class="main-slider__text">
                        <span>Новая коллекция</span>
                        <h1 class="main-slider__title">Новая коллекция<br />SKARLAT</h1>
                        <div class="d-none d-md-flex">
                            <a href="#" class="primary">Кто мы?</a>
                            <a href="#" class="primary">Посмотреть коллекцию</a>
                        </div>
                    </div>
                </div>
                <picture>
                    <source media="(max-width: 575px)" srcset="<?=SITE_TEMPLATE_PATH?>/img/main-slider/h400/1.jpg" />
                    <source media="(max-width: 768px)" srcset="<?=SITE_TEMPLATE_PATH?>/img/main-slider/h500/1.jpg" />
                    <source media="(max-width: 992px)" srcset="<?=SITE_TEMPLATE_PATH?>/img/main-slider/h600/1.jpg" />
                    <img src="<?=SITE_TEMPLATE_PATH?>/img/main-slider/1.jpg" alt="Important slider" />
                </picture>
            </div>
            <div class="main-slider__item">
                <div class="main-slider__content">
                    <div class="main-slider__text">
                        <span>Новая коллекция</span>
                        <h1 class="main-slider__title">Новая коллекция 2<br />SKARLAT</h1>
                        <div class="d-none d-md-flex">
                            <a href="#" class="primary">Кто мы?</a>
                            <a href="#" class="primary">Посмотреть коллекцию</a>
                        </div>
                    </div>
                </div>
                <picture>
                    <source media="(max-width: 575px)" srcset="<?=SITE_TEMPLATE_PATH?>/img/main-slider/h400/1.jpg" />
                    <source media="(max-width: 768px)" srcset="<?=SITE_TEMPLATE_PATH?>/img/main-slider/h500/1.jpg" />
                    <source media="(max-width: 992px)" srcset="<?=SITE_TEMPLATE_PATH?>/img/main-slider/h600/1.jpg" />
                    <img src="<?=SITE_TEMPLATE_PATH?>/img/main-slider/1.jpg" alt="Important slider" />
                </picture>
            </div>

            <div class="main-slider__item">
                <div class="main-slider__content">
                    <div class="main-slider__text">
                        <span>Новая коллекция</span>
                        <h1 class="main-slider__title">Новая коллекция 3<br />SKARLAT</h1>
                        <div class="d-none d-md-flex">
                            <a href="#" class="primary">Кто мы?</a>
                            <a href="#" class="primary">Посмотреть коллекцию</a>
                        </div>
                    </div>
                </div>
                <picture>
                    <source media="(max-width: 575px)" srcset="<?=SITE_TEMPLATE_PATH?>/img/main-slider/h400/1.jpg" />
                    <source media="(max-width: 768px)" srcset="<?=SITE_TEMPLATE_PATH?>/img/main-slider/h500/1.jpg" />
                    <source media="(max-width: 992px)" srcset="<?=SITE_TEMPLATE_PATH?>/img/main-slider/h600/1.jpg" />
                    <img src="<?=SITE_TEMPLATE_PATH?>/img/main-slider/1.jpg" alt="Important slider" />
                </picture>
            </div>
        </div>
        <div class="main-slider-pagination-wrap">
            <ul class="main-slider-pagination"></ul>
        </div>
    </div>
    <div class="products-slider">
        <div class="products-slider__wrapper">
            <div class="products-slider__item">
                <a href="#">
                    <img src="<?=SITE_TEMPLATE_PATH?>/img/product/1.jpg" alt="" />
                    <span>Circle</span>
                </a>
            </div>
            <div class="products-slider__item">
                <a href="#">
                    <img src="<?=SITE_TEMPLATE_PATH?>/img/product/2.jpg" alt="" />
                    <span>Circle</span>
                </a>
            </div>
            <div class="products-slider__item">
                <a href="#">
                    <img src="<?=SITE_TEMPLATE_PATH?>/img/product/3.jpg" alt="" />
                    <span>Circle</span>
                </a>
            </div>
            <div class="products-slider__item">
                <a href="#">
                    <img src="<?=SITE_TEMPLATE_PATH?>/img/product/4.jpg" alt="" />
                    <span>Circle</span>
                </a>
            </div>
            <div class="products-slider__item">
                <a href="#">
                    <img src="<?=SITE_TEMPLATE_PATH?>/img/product/5.jpg" alt="" />
                    <span>Circle</span>
                </a>
            </div>
            <div class="products-slider__item">
                <a href="#">
                    <img src="<?=SITE_TEMPLATE_PATH?>/img/product/6.jpg" alt="" />
                    <span>Circle</span>
                </a>
            </div>
            <div class="products-slider__item">
                <a href="#">
                    <img src="<?=SITE_TEMPLATE_PATH?>/img/product/6.jpg" alt="" />
                    <span>Circle</span>
                </a>
            </div>
        </div>
        <div class="products-slider-pagination-wrap">
            <ul class="products-slider-pagination"></ul>
        </div>
    </div>
    <section class="advantages ptb">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="advantages-article">
                        <div class="advantages-article__head">
                            <h2>Вы архитектор?</h2>
                        </div>
                        <p>
                            Сегодня, СПАСИБО ДЛЯ ЭВОЛЮЦИИ светодиодных технологий, вы можете создать динамическое освещение,
                            которое дарит жизнь и эмоции архитектуре. Но в то же время вы должны понимать, когда использовать
                            определенный тип света и как управлять его цветом, интенсивностью и ритмом. Вам нужна поддержка
                            специализированной команды, и мы подготовили для вас специальные ресурсы, посвященные архитекторам и
                            дизайнерам.
                        </p>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="advantages-article">
                        <div class="advantages-article__head">
                            <h2>Ты украшаешь свой дом?</h2>
                        </div>
                        <p>
                            Хорошо сконструированное освещение позволит Вам и Вашей семье чувствовать себя комфортно, так же как и
                            изображение, которое Ваши гости будут воспринимать, когда войдут в Ваш дом. Чтобы избежать
                            дорогостоящих ошибок и придать вашему дому элегантную атмосферу, о которой вы всегда мечтали, вот
                            серия практических советов о том, как выбрать правильное освещение в каждой комнате.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="architect">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="architect-content">
                        <div class="architect-content-wrap">
                            <div class="architect-content__img">
                                <img src="<?=SITE_TEMPLATE_PATH?>/img/architect.jpg" alt="photo architect" />
                            </div>
                            <div class="architect-content__text">
                                <h2>
                                    Наша последняя коллекция?
                                </h2>
                                <span class="architect-content__subtitle">
                      Лампа также может быть оснащена ультратемными ламельными экранами, которые предотвращают блики в
                      любом направлении, гарантируя значение UGR (Unified Glare Rating) менее 19.</span
                                >
                                <a href="#" class="outline">Перейти</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="seo ptb">
        <div class="container">
            <div class="row ">
                <div class="col-12">
                    <ol>
                        <li>
                            $9.99 в месяц после бесплатной пробной версии. Без обязательств. План автоматически продлевается после
                            пробного периода до тех пор, пока не будет отменен.
                        </li>
                        <li>
                            В стоимость входит скидка в размере $30 AT&T, T-Mobile, Sprint или Verizon. Требуется активация с
                            перевозчиком. Ежемесячная цена: Доступен для квалифицированных клиентов и требует 0% годовых,
                            24-месячного рассроченного кредита с ежемесячными установками Citizens One или Apple Card и активации
                            iPhone с AT&T, Sprint, T-Mobile или Verizon для покупок в магазине Apple Store. Налоги и доставка не
                            включены. Применяются дополнительные условия ежемесячных рассрочек Apple Card и оплаты iPhone.
                        </li>
                    </ol>

                    <p>
                        Чтобы получить доступ ко всем функциям Apple Card и пользоваться ими, Вы должны добавить карту Apple
                        Card в кошелек iPhone или iPad с iOS 12.4 или более поздней версии или iPadOS. Для управления
                        ежемесячными установками Apple Card Вам понадобится iPhone с iOS 13.2 или более поздней версии или iPad
                        с iOS 13.2 или более поздней версии. Обновитесь до последней версии iOS или iPadOS, перейдя в
                        "Настройки" > "Общие" > "Обновление программного обеспечения". Нажмите пункт Загрузить и установить.
                    </p>

                    <p>Доступно для квалифицированных претендентов в США.</p>
                    <p>Apple Card выдается Goldman Sachs Bank USA, отделение в Солт-Лейк-Сити.</p>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Main end -->
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>

