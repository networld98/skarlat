<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords", "Светильники, купить светильник, светодиодные светильники, светильники потолочные, точечные светильники, led светильники, настенные светильники, потолочный светильник,  светильники киев, интернет магазин, интернет, магазин, люстры, торшеры, светильники");
$APPLICATION->SetPageProperty("description", "Оплата - Освещение для дома по лучшим ценам - ✅ Светильники SKARLAT 🔅 Огромный выбор 💥 Всегда в наличии на складе ✈ Доставка по Украине ☎: (044) 333 92 96; (067) 938 72 48 skarlat.ua");
$APPLICATION->SetTitle("Оплата");
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
                        "PATH" => "/include/about/pay.php"
                    )
                );?>
            </div>
        </div>
    </div>
</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
