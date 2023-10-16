<?
define("HIDE_SIDEBAR", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords", "lighting fixtures, buy lighting fixtures, led lighting fixtures, ceiling lights, spotlights, led fixtures, wall lamps, light fixtures, lighting cues, online store, online store, chandeliers, floor lamps, lighting fixtures");
$APPLICATION->SetPageProperty("description", "Warranty - Home lighting at the best prices - ✅ SKARLAT lights 🔅 Huge selection 💥 Always in stock ✈ Delivery in Ukraine and Europe ☎: (044) 333 92 96; (067) 938 72 48 skarlat.ua");
$APPLICATION->SetTitle("Warranty");
?>
<!-- SECTION GARANTEG CONTANT START -->
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
                        "PATH" => "/include/about/guaranty.php"
                    )
                );?>
            </div>
        </div>
    </div>
</div>
<!-- SECTION GARANTEG CONTANT END -->
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
