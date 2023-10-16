<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords", "светильники, купить светильник, светодиодные светильники, потолочные светильники, точечные светильники, led светильники, настенные светильники, светильник, светильники киев, интернет магазин, интернет, магазин, люстры, торшеры, светильники," );
$APPLICATION->SetPageProperty("description", "О компании - Свет для дома по лучшим ценам - ✅ Светильники SKARLAT 🔅 Огромный выбор 💥 Всегда в наличии на складе ✈ Доставка по Украине ☎: (044) 363 90 72 48 skarlat.ua");
$APPLICATION->SetTitle("О компании");
?><!-- SECTION ABOUT US CONTENT START -->
<article class="article about-items">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => SITE_DIR."include/about/about_picture_row_1.php"
                    )
                ); ?>
            </div>
            <div class="col-12 col-sm-12 col-md-6">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => SITE_DIR."include/about/about_text_row_1.php"
                    )
                ); ?>
            </div>
            <div class="col-12">
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => SITE_DIR."include/about/about_picture_row_2.php"
                    )
                ); ?>
            </div>
            <div class="col-12 col-sm-12 col-md-6">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => SITE_DIR."include/about/about_text_row_2.php"
                    )
                ); ?>
            </div>
            <div class="col-12">
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => SITE_DIR."include/about/about_picture_row_3.php"
                    )
                ); ?>
            </div>
            <div class="col-12 col-sm-12 col-md-6">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => SITE_DIR."include/about/about_text_row_3.php"
                    )
                ); ?>
            </div>
            <div class="col-12">
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => SITE_DIR."include/about/about_picture_row_4.php"
                    )
                ); ?>
            </div>
            <div class="col-12 col-sm-12 col-md-6">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => SITE_DIR."include/about/about_text_row_4.php"
                    )
                ); ?>
            </div>
            <div class="col-12">
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => SITE_DIR."include/about/about_picture_row_5.php"
                    )
                ); ?>
            </div>
            <div class="col-12 col-sm-12 col-md-6">
                <? $APPLICATION->IncludeComponent(
                "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => SITE_DIR."include/about/about_text_row_5.php"
                    )
                ); ?>
            </div>
            <div class="col-12">
                <hr>
            </div>
        </div>
    </div>
</article>
    <!-- SECTION ABOUT US CONTENT END --><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>