<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords", "Светильники, купить светильник, светодиодные светильники, светильники потолочные, точечные светильники, led светильники, настенные светильники, потолочный светильник,  светильники киев, интернет магазин, интернет, магазин, люстры, торшеры, светильники");
$APPLICATION->SetPageProperty("description", "Купить освещение в Киеве ▾ Цена, отзывы, продажа ▾ Доставка по Украине ▾ Skarlat.ua");
$APPLICATION->SetTitle("Интернет-магазин Skarlat ");
?>
    <div class="main-cat-slider">
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
                                                        "PATH" => "/ru/include/main_page/jumbotron_basket_list.php"
                                                    )
                                                );?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 d-flex jumbotron-basket-btn-block--wrapper">
                                        <div class="jumbotron-basket-btn-block">
                                            <a class="jumbotron-basket-btn-basket" id="basketModalButtonJumbotronBasket" onclick="$('#basketModalButtonHeader').click();" href="javascript:void(0)" role="button"><?=GetMessage("IN_BASKET")?></a>
                                            <a class="jumbotron-basket-btn-pay" href="/ru/personal/order/make/"><?=GetMessage("ORDER")?></a>
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
                            Array(
                                "CACHE_TIME" => "0",
                                "CACHE_TYPE" => "A",
                                "NOINDEX" => "Y",
                                "QUANTITY" => "100",
                                "TYPE" => "MAIN"
                            )
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
                    "IBLOCK_ID" => "29",
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
                    "IBLOCK_ID" => "29",
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
<?
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
                        "IBLOCK_ID" => "28",
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
                            "PATH" => "/ru/include/main_page/mainpage_static.php"
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
                            "PATH" => "/ru/include/main_page/advantages.php"
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
                            "LIST_URL" => "/ru",
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
    </div>
    <!-- SUBSCRIBE SECTION END -->
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
