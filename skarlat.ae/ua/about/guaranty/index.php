<?
define("HIDE_SIDEBAR", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords", "світильники, купити світильник, світлодіодні світильники, світильники стельові, точкові світильники, led світильники, настінні світильники, світильник, світильники київ, інтернет магазин, інтернет, магазин, люстри, торшери, світильники,");
$APPLICATION->SetPageProperty("description", "Гарантії - Світло для дому за найкращими цінами - ✅ Світильники SKARLAT 🔅 Величезний вибір 💥 Завжди в наявності на складі ✈ Доставка по Україні ☎: (044) 333 92 96; (067) 938 72 48 skarlat.ua");
$APPLICATION->SetTitle("Гарантії");
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
