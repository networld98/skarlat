<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Favorite");
?>
<section class="bg-lightgrey">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="block-head">
                    <h1><?$APPLICATION->ShowTitle()?></h1>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="product-model-block">
    <div class="container">
        <?$APPLICATION->IncludeComponent(
            "bitrix:catalog.product.subscribe.list",
            "skarlat",
            Array(
                "CACHE_TIME" => "3600",
                "CACHE_TYPE" => "N",
                "LINE_ELEMENT_COUNT" => "6"
            )
        );
        ?>
    </div>
</section>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>
