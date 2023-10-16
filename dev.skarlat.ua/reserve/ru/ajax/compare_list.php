<?
include_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';
$APPLICATION->IncludeComponent(
    "custom:catalog.compare.result",
    "",
    array(
        "IBLOCK_TYPE" => "catalog",
        "IBLOCK_ID" => '29',
        "BASKET_URL" => '/ua/personal/cart/',
        "ACTION_VARIABLE" => 'action',
        "PRODUCT_ID_VARIABLE" => 'id',
        "SECTION_ID_VARIABLE" => 'SECTION_ID',
        "FIELD_CODE" => Array
        (
            2 => 'NAME'
        ),
        "PROPERTY_CODE" => Array
        (
            0 => 'ARTNUMBER',
            1 => 'MANUFACTURER'
        ),
        "NAME" => 'CATALOG_COMPARE_LIST',
        "CACHE_TYPE" => 'N',
        "CACHE_TIME" => '36000000',
        "PRICE_CODE" => Array
        (
            0 => 'BASE'
        ),
        "USE_PRICE_COUNT" => '',
        "SHOW_PRICE_COUNT" => '1',
        "PRICE_VAT_INCLUDE" => '1',
        "PRICE_VAT_SHOW_VALUE" => 'N',
        "DISPLAY_ELEMENT_SELECT_BOX" => '',
        "ELEMENT_SORT_FIELD_BOX" => 'sort',
        "ELEMENT_SORT_ORDER_BOX" => 'asc',
        "ELEMENT_SORT_FIELD_BOX2" => 'id',
        "ELEMENT_SORT_ORDER_BOX2" => 'desc',
        "ELEMENT_SORT_FIELD" => 'sort',
        "ELEMENT_SORT_ORDER" => 'asc',
        "DETAIL_URL" => '/ua/catalog/#SECTION_CODE_PATH#/#ELEMENT_CODE#/',
        "OFFERS_FIELD_CODE" => Array(),
        "OFFERS_PROPERTY_CODE" => Array
        (
            0 => 'ARTNUMBER',
            2 => 'COLOR_REF'
        ),
        "OFFERS_CART_PROPERTIES" => Array
        (
            0 => 'SIZES_SHOES',
            1 => 'SIZES_CLOTHES',
            2 => 'COLOR_REF'
        ),
        'CONVERT_CURRENCY' => 'Y',
        'CURRENCY_ID' => 'UAH',
        'HIDE_NOT_AVAILABLE' => 'N',
        'TEMPLATE_THEME' => 'green'
    ),
    $component,
    array("HIDE_ICONS" => "Y")
);?>
