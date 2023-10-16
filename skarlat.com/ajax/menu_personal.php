<?include_once $_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php';
CModule::IncludeModule("sale");
global $countItemsInCart;
//Получаем количество товаров в корзине
$dbBasketItems = CSaleBasket::GetList(
    false,
    array("FUSER_ID" => CSaleBasket::GetBasketUserID(), "LID" => SITE_ID, "ORDER_ID" => "NULL"),
    false,
    false,
    array("ID","PRODUCT_ID","QUANTITY"));
while ($arItems=$dbBasketItems->Fetch())
{
    $arItems=CSaleBasket::GetByID($arItems["ID"]);
    $countItemsInCart+=$arItems['QUANTITY']+1;
}
$APPLICATION->IncludeComponent(
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