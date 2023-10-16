<?
define("HIDE_SIDEBAR", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle('Співробітництво');
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
<section class="cooperation-page">
    <div class="container">
        <div class="row cooperation-text-block">
            <div class="col-lg-6 col-md-6 col-sm-12 order-lg-1 order-md-1 order-1">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => SITE_DIR."include/cooperation/cooperation_picture_1.php"
                    )
                ); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 order-lg-2 order-md-2 order-2 cooperation-text">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => SITE_DIR."include/cooperation/cooperation_text_1.php"
                    )
                ); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 order-lg-3 order-md-3 order-4 cooperation-text">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => SITE_DIR."include/cooperation/cooperation_text_2.php"
                    )
                ); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 order-lg-4 order-md-4 order-3">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => SITE_DIR."include/cooperation/cooperation_picture_2.php"
                    )
                ); ?>
            </div>
        </div>
        <div class="row cooperation-download-block">
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => SITE_DIR."include/cooperation/cooperation_download_1.php"
                    )
                ); ?>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => SITE_DIR."include/cooperation/cooperation_download_2.php"
                    )
                ); ?>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => SITE_DIR."include/cooperation/cooperation_download_3.php"
                    )
                ); ?>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "PATH" => SITE_DIR."include/cooperation/cooperation_download_4.php"
                    )
                ); ?>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <p class="message">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        array(
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => SITE_DIR."include/cooperation/cooperation_text_form.php"
                        )
                    ); ?>
                </p>
                <?$APPLICATION->IncludeComponent(
                    "bitrix:form.result.new",
                    "cooperation_page",
                    array(
                        "AJAX_MODE" => "Y",
                        "AJAX_OPTION_SHADOW" => "N",
                        "AJAX_OPTION_JUMP" => "Y",
                        "AJAX_OPTION_STYLE" => "Y",
                        "AJAX_OPTION_HISTORY" => "N",
                        "CACHE_TIME" => "3600",
                        "CACHE_TYPE" => "A",
                        "CHAIN_ITEM_LINK" => "",
                        "CHAIN_ITEM_TEXT" => "",
                        "EDIT_URL" => "",
                        "IGNORE_CUSTOM_TEMPLATE" => "N",
                        "LIST_URL" => "",
                        "SEF_MODE" => "N",
                        "SUCCESS_URL" => "",
                        "USE_EXTENDED_ERRORS" => "N",
                        "WEB_FORM_ID" => "13",
                        "COMPONENT_TEMPLATE" => "cooperation_page",
                        "VARIABLE_ALIASES" => array(
                            "WEB_FORM_ID" => "WEB_FORM_ID",
                            "RESULT_ID" => "RESULT_ID",
                        )
                    ),
                    false
                );?>
            </div>
        </div>
    </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="cooperation-slider">
                    <?
                    global $arFileTmp;
                    $arFilter = array("IBLOCK_ID"=>56, "ACTIVE" =>'Y');
                    $res = CIBlockElement::GetList(Array("SORT" => "asc"), $arFilter, false, Array(), Array('NAME',"PREVIEW_TEXT","PROPERTY_IMAGE","PROPERTY_YOUTUBE", "PROPERTY_NAME_EN", "PROPERTY_PREVIEW_TEXT_EN"));
                    while($ob = $res->GetNextElement())
                    { $arFields = $ob->GetFields();?>
                        <?if($arFields['PROPERTY_IMAGE_VALUE']!=NULL){
                            $arFileTmp = CFile::ResizeImageGet($arFields['PROPERTY_IMAGE_VALUE'], array('width'=>1000, 'height'=>1000), BX_RESIZE_IMAGE_EXACT, true); ?>
                            <div class="cooperation-slide">
                                <div class="overflow">
                                    <span><?echo (SITE_ID != 'mg' ? $arFields['PROPERTY_NAME_EN_VALUE'] : $arFields['NAME'])?></span>
                                    <p><?echo (SITE_ID != 'mg' ? $arFields['PROPERTY_PREVIEW_TEXT_EN_VALUE']['TEXT'] : $arFields['PREVIEW_TEXT'])?></p>
                                </div>
                                <img src="<?=$arFileTmp['src']?>" alt="<?echo (SITE_ID != 'mg' ? $arFields['PROPERTY_NAME_EN_VALUE'] : $arFields['NAME'])?>" />
                            </div>
                        <?}elseif($arFields['PROPERTY_YOUTUBE_VALUE']!=NULL && $arFields['PROPERTY_YOUTUBE_VALUE']!=' ' && stripos($arFields['PROPERTY_YOUTUBE_VALUE'],'{}')=== false){
                        $arFields['PROPERTY_YOUTUBE_VALUE'] = str_replace('https://www.youtube.com/embed/','', $arFields['PROPERTY_YOUTUBE_VALUE']);
                        $arFields['PROPERTY_YOUTUBE_VALUE'] = str_replace('https://youtu.be/', '', $arFields['PROPERTY_YOUTUBE_VALUE']);?>
                        <div class="cooperation-slide youtube">
                            <div class="overflow" data-id-video="<?=$arFields['PROPERTY_YOUTUBE_VALUE']?>" data-name-video="<?=$arFields['NAME']?>"  data-text-video="<?=$arFields['PREVIEW_TEXT']?>"></div>
                            <img src="https://img.youtube.com/vi/<?=str_replace('https://www.youtube.com/embed/','', $arFields['PROPERTY_YOUTUBE_VALUE'])?>/maxresdefault.jpg" alt="Youtube video <?=$arFields['NAME']?>" />
                        </div>
                    <?}
                    }?>
                </div>
            </div>
        </div>
</section>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
