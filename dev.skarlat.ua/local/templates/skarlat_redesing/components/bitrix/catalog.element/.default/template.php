<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;
use Bitrix\Highloadblock\HighloadBlockTable as HLBT,
    Bitrix\Main\IO,
    Bitrix\Main\Application,
    Bitrix\Main,
	Bitrix\Iblock,
	Bitrix\Catalog;
Main\Loader::includeModule('catalog');
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */
global $USER, $no_shop_site_array, $no_shop_site_price_array;

if (!$USER->IsAuthorized()) // Для неавторизованного
{
    if($_COOKIE["favorites"]){
        $favorites = unserialize($_COOKIE["favorites"]);
    }else{
        $favorites = [];
    }

}
$site=SITE_ID;
$this->setFrameMode(true);
$rsCurrency = \Bitrix\Currency\CurrencyLangTable::getList();
while($currency=$rsCurrency->fetch()){
	if($currency['LID']!=LANGUAGE_ID) continue;
	$arCurres[$currency['CURRENCY']]=str_replace("# ","",$currency['FORMAT_STRING']);
}

//Получить содержимое корзины
$arBasketCount = 0;
$arID = array();
$arBasketItems = array();
$count = 0;
$dbBasketItems = CSaleBasket::GetList(
    array(
        "NAME" => "ASC",
        "ID" => "ASC"
    ),
    array(
        "FUSER_ID" => CSaleBasket::GetBasketUserID(),
        "LID" => SITE_ID,
        "ORDER_ID" => "NULL",
    ),
    false,
    false,
    array("ID", "CALLBACK_FUNC", "MODULE", "PRODUCT_ID", "QUANTITY", "PRODUCT_PROVIDER_CLASS")
);
while ($arItems = $dbBasketItems->Fetch())
{
    if ('' != $arItems['PRODUCT_PROVIDER_CLASS'] || '' != $arItems["CALLBACK_FUNC"])
    {
        CSaleBasket::UpdatePrice($arItems["ID"],
            $arItems["CALLBACK_FUNC"],
            $arItems["MODULE"],
            $arItems["PRODUCT_ID"],
            $arItems["QUANTITY"],
            "N",
            $arItems["PRODUCT_PROVIDER_CLASS"]
        );
        $arID[] = $arItems["ID"];
    }
}
if (!empty($arID))
{
    $dbBasketItems = CSaleBasket::GetList(
        array(
            "NAME" => "ASC",
            "ID" => "ASC"
        ),
        array(
            "ID" => $arID,
            "ORDER_ID" => "NULL"
        ),
        false,
        false,
        array("ID", "CALLBACK_FUNC", "MODULE", "PRODUCT_ID", "QUANTITY", "DELAY", "CAN_BUY", "PRICE", "WEIGHT", "PRODUCT_PROVIDER_CLASS", "NAME")
    );
    while ($arItems = $dbBasketItems->Fetch())
    {
        $count++;
        if($count<=2){
            $arBasketItems[] = $arItems;
        }
        $arBasketCount = $arBasketCount + $arItems['QUANTITY'];
    }
}

$mainId = $this->GetEditAreaId($arResult['ID']);
$itemIds = array(
	'ID' => $mainId,
	'DISCOUNT_PERCENT_ID' => $mainId.'_dsc_pict',
	'STICKER_ID' => $mainId.'_sticker',
	'BIG_SLIDER_ID' => $mainId.'_big_slider',
	'BIG_IMG_CONT_ID' => $mainId.'_bigimg_cont',
	'SLIDER_CONT_ID' => $mainId.'_slider_cont',
	'OLD_PRICE_ID' => $mainId.'_old_price',
	'PRICE_ID' => $mainId.'_price',
	'DISCOUNT_PRICE_ID' => $mainId.'_price_discount',
	'PRICE_TOTAL' => $mainId.'_price_total',
	'SLIDER_CONT_OF_ID' => $mainId.'_slider_cont_',
	'QUANTITY_ID' => $mainId.'_quantity',
	'QUANTITY_DOWN_ID' => $mainId.'_quant_down',
	'QUANTITY_UP_ID' => $mainId.'_quant_up',
	'QUANTITY_MEASURE' => $mainId.'_quant_measure',
	'QUANTITY_LIMIT' => $mainId.'_quant_limit',
	'BUY_LINK' => $mainId.'_buy_link',
	'ADD_BASKET_LINK' => $mainId.'_add_basket_link',
	'BASKET_ACTIONS_ID' => $mainId.'_basket_actions',
	'NOT_AVAILABLE_MESS' => $mainId.'_not_avail',
	'COMPARE_LINK' => $mainId.'_compare_link',
	'TREE_ID' => $mainId.'_skudiv',
	'DISPLAY_PROP_DIV' => $mainId.'_sku_prop',
	'DISPLAY_MAIN_PROP_DIV' => $mainId.'_main_sku_prop',
	'OFFER_GROUP' => $mainId.'_set_group_',
	'BASKET_PROP_DIV' => $mainId.'_basket_prop',
	'SUBSCRIBE_LINK' => $mainId.'_subscribe',
	'TABS_ID' => $mainId.'_tabs',
	'TAB_CONTAINERS_ID' => $mainId.'_tab_containers',
	'SMALL_CARD_PANEL_ID' => $mainId.'_small_card_panel',
	'TABS_PANEL_ID' => $mainId.'_tabs_panel'
); ?>
<?
//подключаем модуль highloadblock
CModule::IncludeModule('highloadblock');

//Функция получения экземпляра класса:
function GetEntityDataClass($HlBlockId)
{
    if (empty($HlBlockId) || $HlBlockId < 1) {
        return false;
    }
    $hlblock = HLBT::getById($HlBlockId)->fetch();
    $entity = HLBT::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();
    return $entity_data_class;
}

function colorHL($color){
    $entity_data_class = GetEntityDataClass(2);
    $rsData = $entity_data_class::getList(array(
        'order' => array('UF_NAME' => 'ASC'),
        'select' => array('*'),
        'filter' => array('UF_XML_ID' => $color)
    ));
    while ($el = $rsData->fetch()) {
        $file = CFile::ResizeImageGet($el['UF_FILE'], array('width'=>20, 'height'=>20), BX_RESIZE_IMAGE_EXACT, true);
        echo $file['src'];
    }
}
?>
<?if($arResult['ID']!=''):?>
	<?$this->SetViewTarget('articul');?>
		<div class="product-sku">
            <?=Loc::getMessage('CODE')?>:
			<span class="product-sku-code"><?=$arResult['ID']?></span>
		</div>
	<?$this->EndViewTarget();?>
<?endif;?>
<?
if ($arResult['PROPERTIES']['SHORT_CATEGORY_NAME_ACTIVE']['VALUE']) {
    $_SESSION['DETAIL_CUSTOM_TITLE'] = $arResult['PROPERTIES']['SHORT_CATEGORY_NAME']['VALUE'] . ' ' . $arResult['NAME'];
	$_SESSION['ADD_SECT_ONE']=$arResult['PROPERTIES']['SHORT_CATEGORY_NAME']['VALUE']." ";
} else {
	$arFilter=array(
		'IBLOCK_ID' => $arParams['IBLOCK_ID'],
		'ID'=>$arResult["IBLOCK_SECTION_ID"]
	);
	$rsSect = \CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilter,false,array("ID","IBLOCK_ID","NAME","SECTION_ID","UF_EXPORT_NAME") );
	while($arSect = $rsSect->Fetch())
	{
		$_SESSION['DETAIL_CUSTOM_TITLE']=($arSect['UF_EXPORT_NAME']=='') ? $arSect['NAME']." ".$arResult['NAME'] : $arSect['UF_EXPORT_NAME']." ".$arResult['NAME'];
		$_SESSION['ADD_SECT_ONE']=($arSect['UF_EXPORT_NAME']=='') ? $arSect['NAME']." " : $arSect['UF_EXPORT_NAME']." ";
	} 
}
if(count((array)$arResult['OFFERS'])<1){
	$arResult['OFFERS'][0]=$arResult;
	$arResult['OFFERS'][0]['NO_OFFER']="Y";
}
$_SESSION['CUSTOM_DESCRIPTION']=$_SESSION['ADD_SECT_ONE'].$arResult['IPROPERTY_VALUES']['SECTION_META_DESCRIPTION'];
?>
<?$this->SetViewTarget('OpenGraph');?>
	<meta property="og:title" content="<?=$_SESSION['ADD_SECT_ONE'].$arResult['NAME'];?>">
	<meta property="og:description" content="<?=$_SESSION['ADD_SECT_ONE'].$arResult['IPROPERTY_VALUES']['SECTION_META_DESCRIPTION']?>">
	<meta property="og:url" content="https://<?=$_SERVER['SERVER_NAME']?><?=$_SERVER['REQUEST_URI']?>">
	<?if(count((array)$arResult['DETAIL_PICTURE']['ID'])>0):?>
        <meta property="og:image" content="https://<?=$_SERVER['SERVER_NAME']?><?=$arResult['DETAIL_PICTURE']['SRC']?>">
        <meta property="og:image:url" content="https://<?=$_SERVER['SERVER_NAME']?><?=$arResult['DETAIL_PICTURE']['SRC']?>">
    <?elseif(count((array)$arResult['PREVIEW_PICTURE']['ID'])>0):?>
        <meta property="og:image" content="https://<?=$_SERVER['SERVER_NAME']?><?=$arResult['PREVIEW_PICTURE']['SRC']?>">
        <meta property="og:image:url" content="https://<?=$_SERVER['SERVER_NAME']?><?=$arResult['PREVIEW_PICTURE']['SRC']?>">
    <?endif;?>
    <meta property="og:image:type" content="article">
    <meta property="og:image:width" content="300">
    <meta property="og:image:height" content="300">
	<meta property="product:brand" content="Skarlat">
    <?if($arResult['CATALOG_QUANTITY']>0 && !empty($arResult['OFFERS'][0]['ITEM_PRICES'])){?>
        <meta property="product:availability" content="in stock">
    <?}else{?>
        <meta property="product:availability" content="no in stock">
    <?}?>
	<meta property="product:condition" content="new">
	<meta property="product:price:amount" content="<?=$arResult['OFFERS'][0]['ITEM_PRICES'][0]['PRICE']?>">
	<meta property="product:price:currency" content="UAH">
	<meta property="product:retailer_item_id" content="<?=$arResult['ID']?>">
<?$this->EndViewTarget();?>
    <div class="product-content-block" itemscope itemtype="http://schema.org/Product">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="product-gallery-container">
                        <div class="product-gallery">
                            <div class="product-gallery__wrapper">
                                <div class="product-gallery__item">
                                    <div class="img-zoom__wrapper easyzoom">
                                        <?
                                        $arFileTmp = CFile::ResizeImageGet($arResult['DETAIL_PICTURE']['ID'], array('width'=>620, 'height'=>620), BX_RESIZE_IMAGE_EXACT, true);
                                        $arFileZoomTemp = CFile::ResizeImageGet($arResult['DETAIL_PICTURE']['ID'], array('width'=>1200, 'height'=>1200), BX_RESIZE_IMAGE_EXACT, true);
                                        $file = new IO\File(Application::getDocumentRoot() . $arFileTmp['src']);
                                        $isExist = $file->isExists();
                                        if($isExist == false){
                                            $arFileTmp['src']= SITE_TEMPLATE_PATH."/img/no_photo_big.png";
                                        }?>
                                        <a href="<?=$arFileZoomTemp['src']?>">
                                            <img class="product-gallery__img" itemprop="image" src="<?=$arFileTmp['src']?>" alt="<?=$arResult['NAME']?>" itemprop="image" />
                                        </a>
                                    </div>
                                </div>
                                <?if(!empty($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'])){
                                    foreach($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'] as $key => $photo) {
                                        $arFileTmp = CFile::ResizeImageGet($photo, array('width'=>620, 'height'=>620), BX_RESIZE_IMAGE_EXACT, true);
                                        $arFileZoomTemp = CFile::ResizeImageGet($photo, array('width'=>1200, 'height'=>1200), BX_RESIZE_IMAGE_EXACT, true);
                                        $file = new IO\File(Application::getDocumentRoot() . $arFileTmp['src']);
                                        $isExist = $file->isExists();
                                        if($isExist == false){
                                            $arFileTmp['src']=SITE_TEMPLATE_PATH."/img/no_photo_big.png";
                                        }?>
                                        <div class="product-gallery__item">
                                            <div class="img-zoom__wrapper easyzoom">
                                                <a href="<?=$arFileZoomTemp['src']?>">
                                                     <img class="product-gallery__img" src="<?=$arFileTmp['src']?>" alt="<?=$arResult['NAME']?>" />
                                                </a>
                                            </div>
                                        </div>
                                    <?}
                                }?>
                            </div>
                        </div>
                        <?if(!empty($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'])){?>
                            <div class="product-gallery-thumbs">
                                <?if($arResult['PROPERTIES']['VIDEOS']['VALUE']!=NULL && $arResult['PROPERTIES']['VIDEOS']['VALUE']!=' ' && stripos((string)$arResult['PROPERTIES']['VIDEOS']['VALUE'],'{}')=== false){
                                    $i=1;
                                    $arResult['PROPERTIES']['VIDEOS']['VALUE'] = str_replace('https://www.youtube.com/embed/','', $arResult['PROPERTIES']['VIDEOS']['VALUE']);
                                    $arResult['PROPERTIES']['VIDEOS']['VALUE'] = str_replace('https://youtu.be/', '', $arResult['PROPERTIES']['VIDEOS']['VALUE']);?>
                                    <div class="product-gallery-thumbs__item youtube">
                                        <div class="overflow"></div>
                                        <img src="https://img.youtube.com/vi/<?=str_replace('https://www.youtube.com/embed/','', $arResult['PROPERTIES']['VIDEOS']['VALUE'])?>/maxresdefault.jpg" alt="Youtube video <?=$arResult['NAME']?>" />
                                    </div>
                                <?}else{
                                    $i=0;
                                }?>
                                <div class="product-gallery-thumbs__wrapper">
                                    <?if(!empty($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'])){
                                        $arFileTmp = CFile::ResizeImageGet($arResult['DETAIL_PICTURE']['ID'], array('width'=>48, 'height'=>48), BX_RESIZE_IMAGE_EXACT, true);
                                        $file = new IO\File(Application::getDocumentRoot() . $arFileTmp['src']);
                                        $isExist = $file->isExists();
                                        if($isExist == false){
                                            $arFileTmp['src']= SITE_TEMPLATE_PATH."/img/no_photo.png";
                                        }?>
                                        <div class="product-gallery-thumbs__item">
                                            <img src="<?=$arFileTmp['src']?>" alt="<?=$arResult['NAME']?>" />
                                        </div>
                                        <?

                                        foreach($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'] as $key => $photo) {
                                           $i++;
                                           if($i<9) {
                                               $arFileTmp = CFile::ResizeImageGet($photo, array('width' => 48, 'height' => 48), BX_RESIZE_IMAGE_EXACT, true);
                                               $file = new IO\File(Application::getDocumentRoot() . $arFileTmp['src']);
                                               $isExist = $file->isExists();
                                               if ($isExist == false) {
                                                   $arFileTmp['src'] = SITE_TEMPLATE_PATH . "/img/no_photo.png";
                                               }
                                           ?>
                                            <div class="product-gallery-thumbs__item 1">
                                                <img src="<?=$arFileTmp['src']?>" alt="<?=$arResult['NAME'].'-'.$key?>" />
                                            </div>
                                            <?}
                                        }
                                        unset($i);
                                    }?>
                                </div>
                            </div>
                        <?}?>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="product-info-section">
                        <div id="zoom"></div>
                        <div class="product-info-block">
                            <h1 class="product-info-title" itemprop="name"><?=$arResult['PROPERTIES']['SHORT_CATEGORY_NAME']['VALUE']?> <?=$arResult['NAME']?></h1>
                            <span itemprop="brand" itemscope itemtype="https://schema.org/Brand">
                                <meta itemprop="name" content="Skarlat" />
                            </span>
                            <div class="product-info-subtitle">
                                <?if(!empty($arResult['PROPERTIES']['kod']['VALUE']) || !empty($arResult['PROPERTIES']['ARTNUMBER']['VALUE'])){?>
                                    <span class="product-info-sku" itemprop="model"><?=$arResult['PROPERTIES']['kod']['VALUE'];if(empty($arResult['PROPERTIES']['kod']['VALUE'])){echo $arResult['PROPERTIES']['ARTNUMBER']['VALUE'];}?></span>
                                <?}?>
                                <? if(!in_array(SITE_ID,$no_shop_site_array) && !in_array(SITE_ID,$no_shop_site_price_array)){?>
                                    <span class="product-info-sku">
                                        <?if($arResult['CATALOG_QUANTITY']>0 && !empty($arResult['OFFERS'][0]['ITEM_PRICES'])){?>
                                            <?=Loc::getMessage('IN_STOCK')?>
                                        <?}elseif($arResult['CATALOG_QUANTITY']==0 && !empty($arResult['OFFERS'][0]['ITEM_PRICES'])){?>
                                            <?=Loc::getMessage('NO_IN_STOCK')?>
                                        <?}else{?>
                                            <?=Loc::getMessage('NO_PRICE_STATUS')?>
                                        <?}?>
                                    </span>
                                <?}?>
                            </div>
                        </div>
                        <div class="product-info-block">
                            <table class="product-info-table">
                                <?
                                foreach ($arResult['DISPLAY_PROPERTIES'] as $index => $DISPLAY_PROPERTY) {?>
                                   <?if($index == "ANOTHER_COLOR_PRODUCT"){?>
                                        <tr>
                                           <td class="product-info-table__props"><?=Loc::getMessage('CT_BCE_COLOR')?>:</td>
                                           <td class="product-info-table__value">
                                               <ul class="product-info-pallete">
                                                   <li class="product-info-pallete__item active">
                                                       <a href="javascript:void(0);">
                                                           <div class="product-info-pallete__img" style="background-image: url('<?colorHL($arResult['PROPERTIES']['tsvet']['VALUE']);?>')"></div>
                                                       </a>
                                                   </li>
                                               <?
                                               foreach ($DISPLAY_PROPERTY['VALUE'] as $key => $element){
                                                   $arSelect = Array('PROPERTY_TSVET','DETAIL_PAGE_URL','ACTIVE');
                                                   $arFilter = Array("IBLOCK_ID"=>$arResult['IBLOCK_ID'], "ID" => $element);
                                                   $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
                                                   while($ob = $res->GetNextElement())
                                                   {$arFields = $ob->GetFields(); ?>
                                                       <li class="product-info-pallete__item">
                                                           <a <?if($arFields['ACTIVE']=="Y"){?>href="<?=$arFields['DETAIL_PAGE_URL']?>"<?}else{?>href="javascript:void(0);" title="<?=Loc::getMessage('NO_IN_STOCK')?>" style="opacity: 0.5;"<?}?>>
                                                               <div class="product-info-pallete__img"
                                                                    style="background-image: url('<?colorHL($arFields['PROPERTY_TSVET_VALUE']);?>')"></div>
                                                           </a>
                                                       </li>
                                                   <?}
                                               }?>
                                            </ul>
                                        </td>
                                        </tr>
                                    <?}elseif($index == "ANOTHER_TEMPERATURE_PRODUCT" ){?>
                                        <tr>
                                           <td class="product-info-table__props"><?=Loc::getMessage('CT_BCE_TEMP_COLOR')?>:</td>
                                           <td class="product-info-table__value">
                                               <ul>
                                                   <li class="active"><a href="javascript:void(0);"><?=$arResult['PROPERTIES']['tsvetovaya_temperatura']['VALUE']?></a></li>
                                                   <? foreach ($DISPLAY_PROPERTY['VALUE'] as $key => $element){
                                                       $arSelect = Array('PROPERTY_tsvetovaya_temperatura','DETAIL_PAGE_URL');
                                                       $arFilter = Array("IBLOCK_ID"=>$arResult['IBLOCK_ID'], "ID" => $element);
                                                       $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
                                                       while($ob = $res->GetNextElement())
                                                       {
                                                           $arFields = $ob->GetFields();?>
                                                           <li><a href="<?=$arFields['DETAIL_PAGE_URL']?>"><?=$arFields['PROPERTY_TSVETOVAYA_TEMPERATURA_VALUE']?></a></li>
                                                       <?}
                                                   }?>
                                               </ul>
                                           </td>
                                        </tr>
                                   <?}elseif(in_array($index,$arParams['PROPERTY_CODE'])){?>
                                        <?if(($index == "tsvet" && empty($arResult['DISPLAY_PROPERTIES']['ANOTHER_COLOR_PRODUCT']['VALUE'])) || ($index == "tsvetovaya_temperatura" && empty($arResult['DISPLAY_PROPERTIES']['ANOTHER_TEMPERATURE_PRODUCT']['VALUE'])) ){?>
                                            <tr>
                                               <td class="product-info-table__props"><?=$DISPLAY_PROPERTY['NAME']?>:</td>
                                               <td class="product-info-table__value">
                                                   <?if($index == "tsvet"){?>
                                                       <ul class="product-info-pallete">
                                                           <li class="product-info-pallete__item active">
                                                               <div class="product-info-pallete__img" style="background-image: url('<?colorHL($DISPLAY_PROPERTY['VALUE']);?>')"></div>
                                                           </li>
                                                       </ul>
                                                   <?}else{?>
                                                       <?=$DISPLAY_PROPERTY['DISPLAY_VALUE']?>
                                                   <?}?>
                                               </td>
                                            </tr>
                                        <?}elseif($index != "tsvet" && $index != "tsvetovaya_temperatura"){?>
                                            <tr>
                                                <td class="product-info-table__props"><?=$DISPLAY_PROPERTY['NAME']?>:</td>
                                                <td class="product-info-table__value"><?=$DISPLAY_PROPERTY['DISPLAY_VALUE']?></td>
                                            </tr>
                                        <?}?>
                                    <?}?>
                                <?}?>
                            </table>
                        </div>
                        <div class="product-info-action" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                        <?if((!in_array(SITE_ID,$no_shop_site_array) && !in_array(SITE_ID,$no_shop_site_price_array)) || in_array(SITE_ID,$no_shop_site_price_array)){?>
                                <?if(!empty($arResult['OFFERS'][0]['ITEM_PRICES'])){?>
                                <div class="product-info-price">
                                    <?foreach($arResult['OFFERS'] as $key=> &$offer):?>
                                        <?if(SITE_ID=='sh'){$arCurres[$offer['ITEM_PRICES'][0]['CURRENCY']]=$offer['ITEM_PRICES'][0]['CURRENCY'];}?>
                                        <?if($offer['ITEM_PRICES'][0]['DISCOUNT']>0):?>
                                            <span class="product-info-price__old">
                                                <?=$offer['ITEM_PRICES'][0]['BASE_PRICE']?>
                                                <span class="product-info-price__old-currency"><?=$arCurres[$offer['ITEM_PRICES'][0]['CURRENCY']]?></span>
                                            </span>
                                        <?endif;?>
                                            <span class="product-info-price__new">
                                                <meta itemprop="priceValidUntil" content="<?= date("Y-m-d",strtotime("+ 365 day"));?>">
                                                <meta itemprop="price" content="<?=$offer['ITEM_PRICES'][0]['PRICE']?>"> <meta itemprop="priceCurrency" content="UAH">
                                                <?=$offer['ITEM_PRICES'][0]['PRICE']?><span class="product-info-price__new-currency"><?=$arCurres[$offer['ITEM_PRICES'][0]['CURRENCY']]?></span>
                                                 <?if($arResult['CATALOG_QUANTITY']==0 || empty($offer['ITEM_PRICES'][0]['PRICE'])):?>
                                                     <meta itemprop="availability" content="http://schema.org/InStock">
                                                 <?else:?>
                                                     <meta itemprop="availability" content="http://schema.org/OutOfStock">
                                                 <?endif;?>
                                        </span>
                                    <?endforeach;?>
                                </div>
                                <?}else{?>
                                    <meta itemprop="availability" content="http://schema.org/OutOfStock">
                                <?}?>
                            <?}?>
                            <?if(!in_array(SITE_ID,$no_shop_site_array)){?>
                            <div class="product-info__btn-block">
                                <?if($arResult['CATALOG_QUANTITY']==0 && !empty($offer['ITEM_PRICES'][0]['PRICE'])):?>
                                    <button class="outline catalog header-phone-app"><?=Loc::getMessage('NO_STOCK')?></button>
                                <?elseif(empty($offer['ITEM_PRICES'][0]['PRICE'])):?>
                                    <button class="outline catalog header-phone-app"><?=Loc::getMessage('NO_PRICE')?></button>
                                <?else:?>
                                    <button class="primary cart-button" onclick="sendToBasketCard(<?=$arResult['ID']?>,1);"><?=Loc::getMessage('BUY')?></button>
                                <?endif;?>
                                <?
                                if ($USER->IsAuthorized()) // Для неавторизованного
                                {
                                    $filter['USER_ID'] = $USER->getId();
                                    $resultObject = Bitrix\Catalog\SubscribeTable::getList(
                                        array(
                                            'select' => array(
                                                'ID',
                                                'ITEM_ID',
                                                'TYPE' => 'PRODUCT.TYPE',
                                                'IBLOCK_ID' => 'IBLOCK_ELEMENT.IBLOCK_ID',
                                            ),
                                            'filter' => $filter,
                                        )
                                    );

                                    $listIblockId = array();
                                    while($item = $resultObject->fetch())
                                    {
                                        if($item['ITEM_ID'] == $arResult['ID'] ){
                                            $itemInfo=$item;
                                        }else {
                                            $itemInfo['ID'] = $arResult['ID'];
                                        }
                                    }
                                }
                                ?>
                                <input type="hidden" id="<?='favfield'.$arResult['ID']?>" value="<?=$itemInfo['ID']?>" />
                                <?
                                if ($USER->IsAuthorized()){?>
                                    <button class=" 1 product-detail__btn-favorite favorite subsbutton <?if($itemInfo['ITEM_ID'] == $arResult['ID']){ echo 'active';}?>" onclick="subscribe(<?=$arResult['ID']?>,'.subsbutton','<?echo '#favfield'.$arResult['ID']?>');">
                                <?}else{?>
                                    <button class=" 2 product-detail__btn-favorite favorite subsbutton <?if(in_array($arResult['ID'], $favorites)){ echo 'active';}?>" onclick="subscribe(<?=$arResult['ID']?>,'.subsbutton','<?echo '#favfield'.$arResult['ID']?>');">
                                <?}?>
                                    <svg viewBox="0 0 23 23">
                                        <path
                                                d="M21.1,2.8c-1.2-1.3-2.9-2-4.6-2c-1.7,0-3.4,0.7-4.6,2l-0.4,0.4l-0.4-0.4C8.7,0.3,4.8,0.1,2.2,2.5
                                C2.1,2.6,2,2.7,1.9,2.8c-2.5,2.7-2.5,6.9,0,9.6l9,9.5c0.3,0.3,0.8,0.3,1.2,0c0,0,0,0,0,0l9-9.5C23.6,9.7,23.6,5.5,21.1,2.8z M10.9,5
                                c0.3,0.3,0.9,0.3,1.2,0l1-1.1c1.7-1.9,4.7-2,6.6-0.3c0.1,0.1,0.2,0.2,0.3,0.3c1.9,2.1,1.9,5.3,0,7.3h0l-8.4,8.9l-8.4-8.9
                                C1.2,9.2,1.2,6,3.1,4c1.7-1.9,4.7-2,6.6-0.3"
                                        />
                                        <path
                                                d="M21.1,2.8c-1.2-1.3-2.9-2-4.6-2c-1.7,0-3.4,0.7-4.6,2l-0.4,0.4l-0.4-0.4C8.7,0.3,4.8,0.1,2.2,2.5C2.1,2.6,2,2.7,1.9,2.8
                                c-2.5,2.7-2.5,6.9,0,9.6l9,9.5c0.3,0.3,0.8,0.3,1.2,0c0,0,0,0,0,0l9-9.5C23.6,9.7,23.6,5.5,21.1,2.8z"
                                        />
                                    </svg>
                                </button>
                            </div>
                            <?}?>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="product-file-block d-flex d-lg-none">
                        <div class="product-block-title"><?=Loc::getMessage('CT_BCE_CATALOG_FILES')?></div>
                        <div class="product-download-block">
                            <?if($arResult['PROPERTIES']['INSTRUCTIONS']['VALUE']>0):?>
                                <a class="product-download-btn" href="<?=CFile::GetPath($arResult['PROPERTIES']['INSTRUCTIONS']['VALUE']);?>" download><?=Loc::getMessage('tab7')?></a>
                            <?endif;?>
                            <?if($arResult['PROPERTIES']['D3_MODEL']['VALUE']>0):?>
                                <a class="product-download-btn" href="<?=CFile::GetPath($arResult['PROPERTIES']['D3_MODEL']['VALUE']);?>" download><?=Loc::getMessage('tab6')?></a>
                            <?endif;?>
                            <?if($arResult['PROPERTIES']['DATA_SHEET']['VALUE']>0):?>
                                <a class="product-download-btn" href="<?=CFile::GetPath($arResult['PROPERTIES']['DATA_SHEET']['VALUE']);?>" download><?=Loc::getMessage('tab8')?></a>
                            <?endif;?>
                        </div>
                    </div>

                    <div class="product-properties-block">
                        <div class="product-block-title">
                            <?=Loc::getMessage('CT_BCE_CATALOG_PROPERTIES')?>
                        </div>
                        <table class="product-properties-table">
                            <tbody>
                                <?
                                $sort[300] = [];
                                $sort[200] = [];
                                foreach($arResult['PROPERTIES'] as $key=>$arProp){
                                    if(!empty($arProp['VALUE']) && $arProp['SORT']>=200 && $sort[200] == NULL){?>
                                        </tbody>
                                        <tbody>
                                    <?$sort[200]="Y";
                                    }
                                    if(!empty($arProp['VALUE']) && $arProp['SORT']>=300 && $sort[300] == NULL){?>
                                        </tbody>
                                        <tbody>
                                    <?$sort[300]="Y";
                                    }if(!empty($arProp['VALUE']) && $arProp['VALUE']!='Y' && !is_array($arProp['VALUE']) && !in_array($key,$arParams['PROPERTY_CODE']) && $arProp['SORT']!=404){?>
                                    <tr>
                                        <td class="product-properties-table__props"><?=$arProp['NAME']?>:</td>
                                        <td class="product-properties-table__value"><?=$arProp['VALUE'];?></td>
                                    </tr>
                                    <?}
                                }?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="product-special-block">
                        <?if($arResult['DETAIL_TEXT']!=''):?>
                            <div class="product-special-block__wrap" >
                                <div class="product-block-title"><?=Loc::getMessage('CT_BCE_CATALOG_DESCRIPTION')?></div>
                                <div class="description" itemprop="description">
                                    <?=$arResult['DETAIL_TEXT']?>
                                </div>
                            </div>
                        <?endif;?>
                        <?if($arResult['PROPERTIES']['D3_MODEL']['VALUE']>0 || $arResult['PROPERTIES']['INSTRUCTIONS']['VALUE']>0 || $arResult['PROPERTIES']['DATA_SHEET']['VALUE']>0):?>
                        <div class="product-file-block d-none d-lg-flex">
                            <div class="product-block-title"><?=Loc::getMessage('CT_BCE_CATALOG_FILES')?></div>
                            <div class="product-download-block">
                                <?if($arResult['PROPERTIES']['INSTRUCTIONS']['VALUE']>0):?>
                                    <a class="product-download-btn" href="<?=CFile::GetPath($arResult['PROPERTIES']['INSTRUCTIONS']['VALUE']);?>" download><?=Loc::getMessage('tab7')?></a>
                                <?endif;?>
                                <?if($arResult['PROPERTIES']['D3_MODEL']['VALUE']>0):?>
                                    <a class="product-download-btn" href="<?=CFile::GetPath($arResult['PROPERTIES']['D3_MODEL']['VALUE']);?>" download><?=Loc::getMessage('tab6')?></a>
                                <?endif;?>
                                <?if($arResult['PROPERTIES']['DATA_SHEET']['VALUE']>0):?>
                                    <a class="product-download-btn" href="<?=CFile::GetPath($arResult['PROPERTIES']['DATA_SHEET']['VALUE']);?>" download><?=Loc::getMessage('tab8')?></a>
                                <?endif;?>
                            </div>
                        </div>
                        <?endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?//Модалка корзины?>
<div id="card-basket" class="order-aside modal">
    <div class="modal-content basket-aside">
        <div class="modal-header">
            <h2><?=Loc::getMessage('CT_BCE_CATALOG_ADD_TO_BASKET_OK')?></h2>
            <button class="close" data-close="true">
                <svg x="0px" y="0px" viewBox="0 0 30 30">
                    <path d="M25,6.2L23.8,5L15,13.8L6.2,5L5,6.2l8.8,8.8L5,23.8L6.2,25l8.8-8.8l8.8,8.8l1.2-1.2L16.2,15L25,6.2z"></path>
                </svg>
            </button>
        </div>
        <div class="modal-body">
        </div>
    </div>
</div>
<?$this->SetViewTarget('comment_popup_form');?>
    <div class="modal faden modal-coment" tabindex="-1" role="dialog" aria-labelledby="review" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header modal-header-coment">
            <h3><?=Loc::getMessage('WRITE_COMMENT_POPUP')?></h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">
                <svg viewBox="0 0 20 20">
                  <path d="M.8 0L0 .8 9.2 10 0 19.2l.8.8 9.2-9.2 9.2 9.2.8-.8-9.2-9.2L20 .8l-.8-.8L10 9.2.8 0z"></path>
                </svg>
              </span>
            </button>
          </div>
          <div class="modal-body modal-body-coment">
            <form id="review_comment">
				<input type="hidden" id="connection" name="ANSWER_TO" value="" />
              <div class="form-group w-100">
                <label for="coment"><?=Loc::getMessage('COMMENT')?> *</label>
                <textarea name="review" id="reviewreview" cols="40" rows="10" required="required"></textarea>
              </div>

              <div class="form-group w-100">
                <label for="user-coment-name"><?=Loc::getMessage('NAME')?> *</label>
                <input type="text" name="NAME" class="form-control" id="user-coment-name" required="required" />
              </div>

              <div class="form-group w-100">
                <label for="e-mail-coment-user"><?=Loc::getMessage('EMAIL')?> *</label>
                <input type="text" name="EMAIL" class="form-control" id="e-mail-coment-user" required="required" />
              </div>

              <button type="submit" class="btn-main"><?=Loc::getMessage('SEND')?></button>
            </form>
          </div>
        </div>
      </div>
    </div>
<?$this->EndViewTarget();?>
<?$this->SetViewTarget('review_popup_form');?>
	<div class="modal fade modal-review" tabindex="-1" role="dialog" aria-labelledby="coment" aria-hidden="true">
		  <div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
			  <div class="modal-header modal-header-review">
				<h3><?=Loc::getMessage('WRITE_COMMENT')?></h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">
					<svg viewBox="0 0 20 20">
					  <path d="M.8 0L0 .8 9.2 10 0 19.2l.8.8 9.2-9.2 9.2 9.2.8-.8-9.2-9.2L20 .8l-.8-.8L10 9.2.8 0z"></path>
					</svg>
				  </span>
				</button>
			  </div>
			  <div class="modal-body modal-body-review">
				<form id="product_review">
				  <div class="award-block w-100">
					<ul class="award-list__stars" id="stars">
					  <li class="award-list__item" title="Poor" data-value="1">
						<svg viewBox="0 0 10 10">
						  <path d="M5.5.5l1.1 2.3c.1.2.2.3.4.3l2.5.4c.4.1.6.6.3.9L8 6.2c-.1.1-.2.3-.1.4l.4 2.5c.1.4-.4.8-.8.6L5.3 8.5c-.2-.1-.3-.1-.5 0L2.5 9.7c-.4.2-.9-.1-.8-.5l.4-2.5c0-.2 0-.4-.2-.5L.2 4.4c-.4-.3-.2-.9.3-.9L3 3.1c.2 0 .3-.1.4-.3L4.5.5c.2-.4.8-.4 1 0z"></path>
						</svg>
						<div class="award-list__item-title"><?=Loc::getMessage('Poor')?></div>
					  </li>
					  <li class="award-list__item" title="Fair" data-value="2">
						<svg viewBox="0 0 10 10">
						  <path d="M5.5.5l1.1 2.3c.1.2.2.3.4.3l2.5.4c.4.1.6.6.3.9L8 6.2c-.1.1-.2.3-.1.4l.4 2.5c.1.4-.4.8-.8.6L5.3 8.5c-.2-.1-.3-.1-.5 0L2.5 9.7c-.4.2-.9-.1-.8-.5l.4-2.5c0-.2 0-.4-.2-.5L.2 4.4c-.4-.3-.2-.9.3-.9L3 3.1c.2 0 .3-.1.4-.3L4.5.5c.2-.4.8-.4 1 0z"></path>
						</svg>
						<div class="award-list__item-title"><?=Loc::getMessage('Fair')?></div>
					  </li>
					  <li class="award-list__item" title="Good" data-value="3">
						<svg viewBox="0 0 10 10">
						  <path d="M5.5.5l1.1 2.3c.1.2.2.3.4.3l2.5.4c.4.1.6.6.3.9L8 6.2c-.1.1-.2.3-.1.4l.4 2.5c.1.4-.4.8-.8.6L5.3 8.5c-.2-.1-.3-.1-.5 0L2.5 9.7c-.4.2-.9-.1-.8-.5l.4-2.5c0-.2 0-.4-.2-.5L.2 4.4c-.4-.3-.2-.9.3-.9L3 3.1c.2 0 .3-.1.4-.3L4.5.5c.2-.4.8-.4 1 0z"></path>
						</svg>
						<div class="award-list__item-title"><?=Loc::getMessage('Good')?></div>
					  </li>
					  <li class="award-list__item" title="Excellent" data-value="4">
						<svg viewBox="0 0 10 10">
						  <path d="M5.5.5l1.1 2.3c.1.2.2.3.4.3l2.5.4c.4.1.6.6.3.9L8 6.2c-.1.1-.2.3-.1.4l.4 2.5c.1.4-.4.8-.8.6L5.3 8.5c-.2-.1-.3-.1-.5 0L2.5 9.7c-.4.2-.9-.1-.8-.5l.4-2.5c0-.2 0-.4-.2-.5L.2 4.4c-.4-.3-.2-.9.3-.9L3 3.1c.2 0 .3-.1.4-.3L4.5.5c.2-.4.8-.4 1 0z"></path>
						</svg>
						<div class="award-list__item-title"><?=Loc::getMessage('Excellent')?></div>
					  </li>
					  <li class="award-list__item " title="WOW!!!" data-value="5">
						<svg viewBox="0 0 10 10">
						  <path d="M5.5.5l1.1 2.3c.1.2.2.3.4.3l2.5.4c.4.1.6.6.3.9L8 6.2c-.1.1-.2.3-.1.4l.4 2.5c.1.4-.4.8-.8.6L5.3 8.5c-.2-.1-.3-.1-.5 0L2.5 9.7c-.4.2-.9-.1-.8-.5l.4-2.5c0-.2 0-.4-.2-.5L.2 4.4c-.4-.3-.2-.9.3-.9L3 3.1c.2 0 .3-.1.4-.3L4.5.5c.2-.4.8-.4 1 0z"></path>
						</svg>
						<div class="award-list__item-title"><?=Loc::getMessage('WOW')?></div>
					  </li>
					</ul>
				  </div>
					<input type="hidden" id="ratingfield" name="RANTING" value="" />
					<input type="hidden" name="PRODUCT" value="<?=$arResult['ID']?>" />
					<input type="hidden" name="USER" value="<?=$USER->getId();?>" />

					<div class="form-group w-100">
						<label for="advantages"><?=Loc::getMessage('advantages')?></label>
						<input type="text" class="form-control" name="ADVANTAGES" id="advantages">
					</div>

					<div class="form-group w-100">
						<label for="disadvantages"><?=Loc::getMessage('disadvantages')?></label>
						<input type="text" class="form-control" name="DISADVANTAGES" id="disadvantages">
					</div>

					<div class="form-group w-100">
						<label for="review"><?=Loc::getMessage('COMMENT')?> *</label>
						<textarea name="review" required="required" id="review" cols="40" rows="10"></textarea>
					</div>
					<button type="submit" class="btn-main"><?=Loc::getMessage('SEND')?></button>
				</form>
			  </div>
			</div>
		  </div>
		</div>
<?$this->EndViewTarget();?>
<?
	$offerIds = array();
	$offerCodes = array();

	$useRatio = $arParams['USE_RATIO_IN_RANGES'] === 'Y';

	foreach ($arResult['JS_OFFERS'] as $ind => &$jsOffer)
	{
		$offerIds[] = (int)$jsOffer['ID'];
		$offerCodes[] = $jsOffer['CODE'];

		$fullOffer = $arResult['OFFERS'][$ind];
		$measureName = $fullOffer['ITEM_MEASURE']['TITLE'];

		$strAllProps = '';
		$strMainProps = '';
		$strPriceRangesRatio = '';
		$strPriceRanges = '';

		if ($arResult['SHOW_OFFERS_PROPS'])
		{
			if (!empty($jsOffer['DISPLAY_PROPERTIES']))
			{
				foreach ($jsOffer['DISPLAY_PROPERTIES'] as $property)
				{
					$current = '<dt>'.$property['NAME'].'</dt><dd>'.(
						is_array($property['VALUE'])
							? implode(' / ', $property['VALUE'])
							: $property['VALUE']
						).'</dd>';
					$strAllProps .= $current;

					if (isset($arParams['MAIN_BLOCK_OFFERS_PROPERTY_CODE'][$property['CODE']]))
					{
						$strMainProps .= $current;
					}
				}

				unset($current);
			}
		}

		if ($arParams['USE_PRICE_COUNT'] && count((array)$jsOffer['ITEM_QUANTITY_RANGES']) > 1)
		{
			$strPriceRangesRatio = '('.Loc::getMessage(
					'CT_BCE_CATALOG_RATIO_PRICE',
					array('#RATIO#' => ($useRatio
							? $fullOffer['ITEM_MEASURE_RATIOS'][$fullOffer['ITEM_MEASURE_RATIO_SELECTED']]['RATIO']
							: '1'
						).' '.$measureName)
				).')';

			foreach ($jsOffer['ITEM_QUANTITY_RANGES'] as $range)
			{
				if ($range['HASH'] !== 'ZERO-INF')
				{
					$itemPrice = false;

					foreach ($jsOffer['ITEM_PRICES'] as $itemPrice)
					{
						if ($itemPrice['QUANTITY_HASH'] === $range['HASH'])
						{
							break;
						}
					}

					if ($itemPrice)
					{
						$strPriceRanges .= '<dt>'.Loc::getMessage(
								'CT_BCE_CATALOG_RANGE_FROM',
								array('#FROM#' => $range['SORT_FROM'].' '.$measureName)
							).' ';

						if (is_infinite($range['SORT_TO']))
						{
							$strPriceRanges .= Loc::getMessage('CT_BCE_CATALOG_RANGE_MORE');
						}
						else
						{
							$strPriceRanges .= Loc::getMessage(
								'CT_BCE_CATALOG_RANGE_TO',
								array('#TO#' => $range['SORT_TO'].' '.$measureName)
							);
						}

						$strPriceRanges .= '</dt><dd>'.($useRatio ? $itemPrice['PRINT_RATIO_PRICE'] : $itemPrice['PRINT_PRICE']).'</dd>';
					}
				}
			}

			unset($range, $itemPrice);
		}

		$jsOffer['DISPLAY_PROPERTIES'] = $strAllProps;
		$jsOffer['DISPLAY_PROPERTIES_MAIN_BLOCK'] = $strMainProps;
		$jsOffer['PRICE_RANGES_RATIO_HTML'] = $strPriceRangesRatio;
		$jsOffer['PRICE_RANGES_HTML'] = $strPriceRanges;
	}

	$templateData['OFFER_IDS'] = $offerIds;
	$templateData['OFFER_CODES'] = $offerCodes;
	unset($jsOffer, $strAllProps, $strMainProps, $strPriceRanges, $strPriceRangesRatio, $useRatio);

	$jsParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => true,
			'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'] === 'Y',
			'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'] === 'Y',
			'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'SHOW_SKU_PROPS' => $arResult['SHOW_OFFERS_PROPS'],
			'OFFER_GROUP' => $arResult['OFFER_GROUP'],
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE'],
			'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
			'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'] === 'Y',
			'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
			'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
			'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
			'USE_STICKERS' => true,
			'USE_SUBSCRIBE' => $showSubscribe,
			'SHOW_SLIDER' => $arParams['SHOW_SLIDER'],
			'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
			'ALT' => $alt,
			'TITLE' => $title,
			'MAGNIFIER_ZOOM_PERCENT' => 200,
			'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
			'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
			'BRAND_PROPERTY' => !empty($arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']])
				? $arResult['DISPLAY_PROPERTIES'][$arParams['BRAND_PROPERTY']]['DISPLAY_VALUE']
				: null
		),
		'PRODUCT_TYPE' => $arResult['PRODUCT']['TYPE'],
		'VISUAL' => $itemIds,
		'DEFAULT_PICTURE' => array(
			'PREVIEW_PICTURE' => $arResult['DEFAULT_PICTURE'],
			'DETAIL_PICTURE' => $arResult['DEFAULT_PICTURE']
		),
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'ACTIVE' => $arResult['ACTIVE'],
			'NAME' => $arResult['~NAME'],
			'CATEGORY' => $arResult['CATEGORY_PATH']
		),
		'BASKET' => array(
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'BASKET_URL' => $arParams['BASKET_URL'],
			'SKU_PROPS' => $arResult['OFFERS_PROP_CODES'],
			'ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
			'BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE']
		),
		'OFFERS' => $arResult['JS_OFFERS'],
		'OFFER_SELECTED' => $arResult['OFFERS_SELECTED'],
		'TREE_PROPS' => $skuProps
	);
?>
