<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\IO,
    Bitrix\Main\Application,
    Bitrix\Main\Localization\Loc;
//Получить содержимое корзины
$arBasketCount = 0;
$arID = array();
$arBasketItems = array();
$count = 0;
$dbBasketItems = CSaleBasket::GetList(
    array(
        "NAME" => "ASC",
        "ID" => "ASC"
    ),
    array(
        "FUSER_ID" => CSaleBasket::GetBasketUserID(),
        "LID" => SITE_ID,
        "ORDER_ID" => "NULL",
    ),
    false,
    false,
    array("ID", "CALLBACK_FUNC", "MODULE", "PRODUCT_ID", "QUANTITY", "PRODUCT_PROVIDER_CLASS")
);
while ($arItems = $dbBasketItems->Fetch())
{
    if ('' != $arItems['PRODUCT_PROVIDER_CLASS'] || '' != $arItems["CALLBACK_FUNC"])
    {
        CSaleBasket::UpdatePrice($arItems["ID"],
            $arItems["CALLBACK_FUNC"],
            $arItems["MODULE"],
            $arItems["PRODUCT_ID"],
            $arItems["QUANTITY"],
            "N",
            $arItems["PRODUCT_PROVIDER_CLASS"]
        );
        $arID[] = $arItems["ID"];
    }
}
if (!empty($arID))
{
    $dbBasketItems = CSaleBasket::GetList(
        array(
            "NAME" => "ASC",
            "ID" => "ASC"
        ),
        array(
            "ID" => $arID,
            "ORDER_ID" => "NULL"
        ),
        false,
        false,
        array("ID", "CALLBACK_FUNC", "MODULE", "PRODUCT_ID", "QUANTITY", "DELAY", "CAN_BUY", "PRICE", "WEIGHT", "PRODUCT_PROVIDER_CLASS", "NAME")
    );
    while ($arItems = $dbBasketItems->Fetch())
    {
        $count++;
        if($count<=2){
            $arBasketItems[] = $arItems;
        }
        $arBasketCount = $arBasketCount + $arItems['QUANTITY'];
    }
}?>
<ul class="order-product__list">
    <?foreach ($arBasketItems as $basket_item) {
        $arFilter = Array( "ID"=> $basket_item['PRODUCT_ID']);
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>2), Array());
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
            <a href="<?= $$basket_item['DETAIL_PAGE_URL'] ?>" class="order-product__link">
                <div class="order-product__img-wrapper">
                    <img src="<?= $imgFile['src'] ?>" alt="<?= $basket_item['NAME'] ?>" class="order-product__img">
                </div>
                <div class="order-product__info">
                    <p><?= $shortName ?></p>
                    <p><?= $basket_item['NAME'] ?></p>
                    <p class="order-product-quantity"><?= round($basket_item['QUANTITY']) ?></p>
                </div>
            </a>
        </li>
    <?}?>
</ul>
<div class="controls">
    <p><?=GetMessage('PRODUCT_CART_'.$_GET['lang'])?>: <?=$arBasketCount?></p><button class="outline" onclick="location.href='<?if ($_GET['lang']!='en'){echo '/'.$_GET['lang'];}?><?=SITE_DIR?>personal/cart/'" ><?=GetMessage('GO_TO_CART_'.$_GET['lang'])?></button>
</div>
