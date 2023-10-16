<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords", "lighting fixtures, buy lighting fixtures, led lighting fixtures, ceiling lights, spotlights, led fixtures, wall lamps, light fixtures, lighting cues, online store, online store, chandeliers, floor lamps, lighting fixtures,");
$APPLICATION->SetPageProperty("description", "Delivery - Home Lights at the best prices - ✅ SKARLAT Lights 🔅 Huge choice 💥 Always in stock ✈ Delivery in Ukraine and Europe ☎: (044) 333 92 96; (067) 938 72 48 skarlat.uane and Europe ☎: (044) 333 92 96; (067) 938 72 48 skarlat.ua");
$APPLICATION->SetTitle("Delivery");
?>
<section class="bg-lightgrey">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="block-head">
                    <h1 id="change-title"><?$APPLICATION->ShowTitle()?></h1>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="info-content">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    Array(
                        "AREA_FILE_SHOW" => "file",
                        "AREA_FILE_SUFFIX" => "inc",
                        "EDIT_TEMPLATE" => "",
                        "PATH" => "/include/about/delivery.php"
                    )
                );?>
            </div>
        </div>
    </div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
