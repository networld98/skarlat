<?
define("HIDE_SIDEBAR", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle('Проєкти');
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
<section class="project-page">
    <div class="container">
        <div class="row">
                <?
                global $arFileTmp;
                $arFilter = array("IBLOCK_ID"=>55, "ACTIVE" =>'Y');
                $res = CIBlockElement::GetList(Array("SORT" => "asc"), $arFilter, false, Array(), Array('NAME',"PREVIEW_TEXT","PREVIEW_PICTURE", "PROPERTY_NAME_EN", "PROPERTY_PREVIEW_TEXT_EN"));
                while($ob = $res->GetNextElement())
                { $arFields = $ob->GetFields();?>
                    <?if($arFields['PREVIEW_PICTURE']!=NULL){
                        $arFileTmp = CFile::ResizeImageGet($arFields['PREVIEW_PICTURE'], array('width'=>630, 'height'=>444), BX_RESIZE_IMAGE_EXACT, true); ?>
                    <div class="col-12 col-lg-6 col-md-6 col-sm-12">
                        <div class="project-slide">
                            <div class="overflow">
                                <span><?echo (SITE_ID != 'mg' ? $arFields['PROPERTY_NAME_EN_VALUE'] : $arFields['NAME'])?></span>
                                <p><?echo (SITE_ID != 'mg' ? $arFields['PROPERTY_PREVIEW_TEXT_EN_VALUE']['TEXT'] : $arFields['PREVIEW_TEXT'])?></p>
                            </div>
                            <img src="<?=$arFileTmp['src']?>" alt="<?echo (SITE_ID != 'mg' ? $arFields['PROPERTY_NAME_EN_VALUE'] : $arFields['NAME'])?>" />
                        </div>
                    </div>
                <?}
                }?>
            </div>
        </div>
</section>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
