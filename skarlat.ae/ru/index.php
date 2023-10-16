<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords", "светильники, купить светильник, светодиодные светильники, потолочные светильники, точечные светильники, led светильники, настенные светильники, светильник, светильники киев, интернет магазин, интернет, магазин, люстры, торшеры, светильники," );
$APPLICATION->SetPageProperty("description", "Купить освещение в Киеве ▾ Цена, отзывы, продажа ▾ Доставка по Украине ▾ Skarlat.ua");
$APPLICATION->SetTitle("Интернет-магазин Skarlat");
global $iblCatalog;
?>
    <div class="main-slider <?if($APPLICATION->GetCurPage(false) === '/ru/'):?>dark-main-desktop<? endif; ?>">
    <div class="main-slider__wrapper">
            <?$APPLICATION->IncludeComponent(
            "bitrix:advertising.banner",
            "",
            Array(
                "BS_ARROW_NAV" => "N",
                "BS_BULLET_NAV" => "Y",
                "BS_CYCLING" => "N",
                "BS_EFFECT" => "fade",
                "BS_HIDE_FOR_PHONES" => "Y",
                "BS_HIDE_FOR_TABLETS" => "N",
                "BS_KEYBOARD" => "Y",
                "BS_PAUSE" => "Y",
                "BS_WRAP" => "Y",
                "CACHE_TIME" => "36000000",
                "CACHE_TYPE" => "A",
                "COMPONENT_TEMPLATE" => "",
                "NOINDEX" => "Y",
                "QUANTITY" => "5",
                "TYPE" => "Main"
            )
            );?>
    </div>
    </div>
    <div class="products-slider">
        <div class="container">
            <div class="row">
                <?
                $arSelect = array("NAME", "SECTION_PAGE_URL", "UF_MAIN_ICON");
                $arFilter = array("IBLOCK_ID"=>$iblCatalog, "DEPTH_LEVEL" => 1, "ACTIVE" => "Y");
                $obSections = CIBlockSection::GetList(array("sort" => "asc"), $arFilter,  array('nTopCount' => 8), $arSelect);
                $i=0;
                while($ar_result = $obSections->GetNext())
                {
                    $i++;
                    if($ar_result['UF_MAIN_ICON']){
                        $file = CFile::ResizeImageGet($ar_result['UF_MAIN_ICON'], array('width'=>80, 'height'=>80), BX_RESIZE_IMAGE_EXACT, true); ?>
                        <div class="col-6 col-sm-3 col-lg-3 сol-xlg-slider">
                            <a href="<?=$ar_result['SECTION_PAGE_URL'] ?>"> <img alt="<?= $ar_result['NAME'] ?>" src="<?= $file['src'] ?>"> <p><?= $ar_result['NAME'] ?></p> </a>
                        </div>
                    <?}
                } ?>
            </div>
        </div>
    </div>
    <section class="advantages ptb">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-5 order-lg-1 order-2">
                    <div class="advantages-article">
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => SITE_DIR."include/main_page/main_text_3.php"
                            )
                        ); ?>
                    </div>
                </div>
                <div class="col-12 col-lg-7 order-lg-2 order-1">
                    <div class="architect-content__img">
                        <? $APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            array(
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => SITE_DIR."include/main_page/main_picture_3.php"
                            )
                        ); ?>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="advantages-white">
        <div class="row">
            <div class="col-12 col-lg-7 order-lg-1 order-1 left">
                <div class="architect-content__img">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => SITE_DIR."include/main_page/main_picture_1.php"
                        )
                    ); ?>
                </div>
            </div>
            <div class="col-12 col-lg-5 order-lg-2 order-2 right">
                <div class="advantages-article">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => SITE_DIR."include/main_page/main_text_1.php"
                        )
                    ); ?>
                </div>
            </div>
            <div class="col-12 col-lg-5 order-lg-3 order-4 left">
                <div class="advantages-article">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => SITE_DIR."include/main_page/main_text_2.php"
                        )
                    ); ?>
                </div>
            </div>
            <div class="col-12 col-lg-7 order-lg-4 order-3 right">
                <div class="architect-content__img">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => SITE_DIR."include/main_page/main_picture_2.php"
                        )
                    ); ?>
                </div>
            </div>
        </div>
    </section>
  <? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>