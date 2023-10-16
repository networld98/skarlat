<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $item
 * @var array $actualItem
 * @var array $minOffer
 * @var array $itemIds
 * @var array $price
 * @var array $measureRatio
 * @var bool $haveOffers
 * @var bool $showSubscribe
 * @var array $morePhoto
 * @var bool $showSlider
 * @var bool $itemHasDetailUrl
 * @var string $imgTitle
 * @var string $productTitle
 * @var string $buttonSizeClass
 * @var CatalogSectionComponent $component
 */
use Bitrix\Main,
	Bitrix\Iblock,
	Bitrix\Catalog;
Main\Loader::includeModule('catalog');
Main\Loader::includeModule('iblock');
$arFileTmp = CFile::ResizeImageGet($item['PREVIEW_PICTURE']['ID'], array("width" => 390, "height" => 450), BX_RESIZE_IMAGE_EXACT, true);
?>
<div class="col-12 col-xs-6 col-sm-6 col-md-4 col-lg-3">
    <div class="product-model__item">
        <a class="product-model__link" href="<?=CFile::GetPath($item['PROPERTIES']['D3_MODEL']['VALUE']);?>">
            <div class="product-model__img-wrap">
                <img class="product-model__img" src="<?=$arFileTmp['src']?>" alt="<?=$item['NAME']?>">
            </div>
            <div class="product-model__info">
                <p><?=$item['PROPERTIES']['SHORT_CATEGORY_NAME']['VALUE']?></p>
                <span><?=$item['NAME']?></span>
            </div>
        </a>
    </div>
</div>
