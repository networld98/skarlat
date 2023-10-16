<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
use Bitrix\Main\IO,
    Bitrix\Main\Application;
$arViewModeList = $arResult['VIEW_MODE_LIST'];

$arViewStyles = array(
	'LIST' => array(
		'CONT' => 'bx_sitemap',
		'TITLE' => 'bx_sitemap_title',
		'LIST' => 'bx_sitemap_ul',
	),
	'LINE' => array(
		'CONT' => 'bx_catalog_line',
		'TITLE' => 'bx_catalog_line_category_title',
		'LIST' => 'bx_catalog_line_ul',
		'EMPTY_IMG' => $this->GetFolder().'/images/line-empty.png'
	),
	'TEXT' => array(
		'CONT' => 'bx_catalog_text',
		'TITLE' => 'bx_catalog_text_category_title',
		'LIST' => 'bx_catalog_text_ul'
	),
	'TILE' => array(
		'CONT' => 'bx_catalog_tile',
		'TITLE' => 'bx_catalog_tile_category_title',
		'LIST' => 'bx_catalog_tile_ul',
		'EMPTY_IMG' => $this->GetFolder().'/images/tile-empty.png'
	)
);
$arCurView = $arViewStyles[$arParams['VIEW_MODE']];

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

$arFilter = Array(
    'IBLOCK_ID'=>$arResult['SECTION']['IBLOCK_ID'],
    'DEPTH_LEVEL' => 1,
    'GLOBAL_ACTIVE'=>'Y');
    $obSection = CIBlockSection::GetTreeList($arFilter);
    while($arRes = $obSection->GetNext()){
        $arResult['SECTION_MAIN_CATEGORY'][] = array('SECTION_PAGE_URL' => $arRes['SECTION_PAGE_URL'], 'NAME' => $arRes['NAME']);
    }
if(empty($arResult['SECTIONS'])){
    $rsParentSection = CIBlockSection::GetByID($arResult['SECTION']['IBLOCK_SECTION_ID']);
    if ($arParentSection = $rsParentSection->GetNext())
    {
        $arFilter = array('IBLOCK_ID' => $arResult['SECTION']['IBLOCK_ID'], 'DEPTH_LEVEL' => $arParentSection['DEPTH_LEVEL']);
        $rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilter);
        while ($arSect = $rsSect->GetNext())
        {
            $arResult['SECTIONS_CATEGORY'][] = $arSect;
        }
    }
}else{
    $arResult['SECTIONS_CATEGORY'] = $arResult['SECTIONS'];
}
if(empty($arResult['SECTIONS_CATEGORY']) && empty($arResult['SECTIONS'])){
    $arResult['SECTIONS_CATEGORY'] = $arResult['SECTION_MAIN_CATEGORY'];
}
?>
<div class="category-nav">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="category-nav__slider">
                    <div class="category-nav__wrapper">
                        <?
                        foreach ($arResult['SECTIONS_CATEGORY'] as $arSection){

                            $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
                            $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
                                if(empty($arSection['ID'])){
                                    $arSelect = array("ID");
                                    $arFilter = array("IBLOCK_ID"=>$arResult['SECTION']['IBLOCK_ID'], "ACTIVE"=>"Y");
                                    $obSections = CIBlockSection::GetList(array("name" => "asc"), $arFilter, false, $arSelect);
                                    while($ar_result = $obSections->GetNext())
                                    {
                                        $arSection['ID'] = $ar_result['ID'];
                                    }
                                }

                            $activeElements = CIBlockSection::GetSectionElementsCount($arSection['ID'], Array("CNT_ACTIVE"=>"Y"));
                            if($activeElements>0) {?>
                            <div class="category-nav__item">
                                <a href="<?=$arSection['SECTION_PAGE_URL']?>" class="category-nav__link"><?= $arSection['NAME']; ?></a>
                            </div>
                            <?}
                        }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="category-content">
    <div class="container">
        <div class="row">
            <?if(!empty($arResult['SECTIONS'])){?>
                <div class="col-12">
                    <div class="category-content__title">
                        <h1><?if($arResult['SECTION']['NAME']){echo $arResult['SECTION']['NAME'];}else{echo $APPLICATION->GetTitle();}?></h1>
                    </div>
                </div>
            <?}?>
            <?foreach ($arResult['SECTIONS'] as &$arSection){
                if($arSection['CODE']=='sale') continue;
                $arFileTmp = CFile::ResizeImageGet(
                    $arSection['PICTURE']['ID'],
                    array("width" => 600, "height" => 350),
                    BX_RESIZE_IMAGE_EXACT,
                    true
                );
                $file = new IO\File(Application::getDocumentRoot() . $arFileTmp['src']);
                $isExist = $file->isExists();
                if($isExist == false){
                    $arFileTmp['src'] = SITE_TEMPLATE_PATH."/img/no_photo_big.png";
                }
                $activeElements = CIBlockSection::GetSectionElementsCount($arSection['ID'], Array("CNT_ACTIVE"=>"Y"));
                if($activeElements>0){?>
                <!-- SUBCATEGORY ITEM START -->
                <div class="col-12 col-md-6">
                    <a class="category-content-item" href="<?=$arSection['SECTION_PAGE_URL']?>" target="_self">
                        <img src="<?=$arFileTmp['src']?>" alt="<? echo $arSection['NAME']; ?>" class="category-content-item__img" />
                        <span class="category-content-item__title"><? echo $arSection['NAME']; ?></span>
                    </a>
                </div>
                <!-- SUBCATEGORY ITEM END -->
              <?}
            }?>
        </div>
    </div>
</div>