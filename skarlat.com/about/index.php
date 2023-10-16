<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords", "lighting fixtures, buy lighting fixtures, led lighting fixtures, ceiling lights, spotlights, led fixtures, wall lamps, light fixtures, lighting cues, online store, online store, chandeliers, floor lamps, lighting fixtures");
$APPLICATION->SetPageProperty("description", "Про компанію - Світло для дому за найкращими цінами - ✅ Світильники SKARLAT 🔅 Величезний вибір 💥 Завжди в наявності на складі ✈ Доставка по Україні ☎: (044) 333 92 96; (067) 938 72 48 skarlat.ua");
$APPLICATION->SetTitle("About us");
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