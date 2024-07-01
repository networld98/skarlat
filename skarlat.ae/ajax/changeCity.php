<?
include_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';
$APPLICATION->IncludeComponent(
        "bitrix:sale.location.selector.search",
        "custom",
        Array(
            "COMPONENT_TEMPLATE" => ".default",
            "ID" => $_POST['id'],
            "CODE" => "",
            "INPUT_NAME" => "ORDER[PROPS][CITY]",
            "PROVIDE_LINK_BY" => "id",
            "JSCONTROL_GLOBAL_ID" => "",
            "JS_CALLBACK" => "",
            "FILTER_BY_SITE" => "Y",
            "SHOW_DEFAULT_LOCATIONS" => "Y",
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "36000000",
            "FILTER_SITE_ID" => "ae",
            "INITIALIZE_BY_GLOBAL_EVENT" => "",
            "SUPPRESS_ERRORS" => "N",
            "POST_CITY" => 'Y'
        )
    );
?>