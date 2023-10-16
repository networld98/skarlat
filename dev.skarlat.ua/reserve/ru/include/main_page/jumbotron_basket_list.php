<ul class="jumbotron-basket-list ">
    <?
    $arID = [];
    $arBasketItems = [];

    $dbBasketItems = CSaleBasket::GetList(
        array(
            "NAME" => "ASC",
            "ID" => "ASC"
        ),
        array(
            "FUSER_ID" => CSaleBasket::GetBasketUserID(),
            "LID" => SITE_ID,
            "ORDER_ID" => "NULL"
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
            array("PRODUCT_ID")
        );
        while ($arItem = $dbBasketItems->Fetch())
        {
            $res = CIBlockElement::GetByID($arItem["PRODUCT_ID"]);
            if ($basketItem = $res->GetNext()) {
                if ($basketItem['IBLOCK_TYPE_ID'] == 'offers') {
                    $offer_info = CCatalogSku::GetProductInfo(
                        $arItem["PRODUCT_ID"]
                    );

                    $item = CIBlockElement::GetByID($offer_info["ID"]);
                    if ($item_res = $item->GetNext()) {
                        $basketItem = $item_res;
                    }
                }
                $basketItemImage = CFile::GetPath($basketItem["DETAIL_PICTURE"]);

                if (!$basketItemImage) {
                    $basketItemImage = '/images/no_photo.png';
                }
                ?>
                <li class="jumbotron-basket-item m-2">
                    <img
                        alt="<?=$basketItem['NAME'];?>"
                        class="lazy"
                        src="data:image/gif;base64,R0lGODlhFAAHAIAAAP///wAAACH5BAEAAAEALAAAAAAUAAcAAAIKjI+py+0Po5wUFQA7"
                        data-src="<?=$basketItemImage;?>"
                        data-srcset="<?=$basketItemImage;?> 1x, <?=$basketItemImage;?> 2x"
                    />
                </li>
                <?
            }
        }?>
        <li class="jumbotron-basket-item m-2" id="show-more-jumbotron-basket-items">...</li>
    <?}?>
</ul>
