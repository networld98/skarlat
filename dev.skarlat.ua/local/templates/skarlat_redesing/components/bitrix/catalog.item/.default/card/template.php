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
	Bitrix\Catalog,
    Bitrix\Main\IO,
    Bitrix\Main\Application;

Main\Loader::includeModule('catalog');
Main\Loader::includeModule('iblock');
global $USER, $no_shop_site_array, $no_shop_site_price_array;
?>
<div class="col-12 col-xs-6 col-sm-6 col-md-4 col-lg-3">
    <div class="product-category-wrap">
        <div class="product-category-img">
            <div class="product-category-slider">
                <div class="product-category-slider__wrapper product-category-slider__wrapper-<?=$item['ID']?>">
                    <div class="product-category-slider__item">
                        <a class="product-category-slider__link" href="<?=$item['DETAIL_PAGE_URL']?>">
                            <div class="product-category-slider__img-wrap">
                                <?
                                $arFileTmp = CFile::ResizeImageGet(
                                    $item['PREVIEW_PICTURE']['ID'],
                                    array("width" => 390, "height" => 450),
                                    BX_RESIZE_IMAGE_EXACT,
                                    true
                                );
                                $file = new IO\File(Application::getDocumentRoot() . $arFileTmp['src']);
                                $isExist = $file->isExists();
                                if($isExist == false){
                                    $arFileTmp['src']=SITE_TEMPLATE_PATH."/img/no_photo_big.png";
                                }
                                ?>
                                <img class="product-category-slider__img" src="<?=$arFileTmp['src']?>" alt="<?=$item['NAME']?>" />
                            </div>
                            <div class="product-category-slider__info">
                                <?if($item['PROPERTIES']['SHORT_CATEGORY_NAME_ACTIVE']['VALUE']){?>
                                    <p><?=$item['PROPERTIES']['SHORT_CATEGORY_NAME']['VALUE']?></p>
                                <?}?>
                                <span><?=$item['NAME']?></span>
                            </div>
                        </a>
                    </div>
                    <?if($item['PROPERTIES']['ANOTHER_COLOR_PRODUCT']['VALUE']){
                        foreach ($item['PROPERTIES']['ANOTHER_COLOR_PRODUCT']['VALUE'] as $key => $element){
                            $res = CIBlockElement::GetByID($element);
                            if($ar_res = $res->GetNext()){?>
                                <div class="product-category-slider__item">
                                    <a class="product-category-slider__link" <?if($ar_res['ACTIVE']=="Y"){?>href="<?=$ar_res['DETAIL_PAGE_URL']?>"<?}else{?>href="javascript:void(0);" title="<?=Loc::getMessage('NO_IN_STOCK')?>" style="opacity: 0.5;"<?}?>>
                                        <div class="product-category-slider__img-wrap">
                                            <?
                                            $arFileTmp = CFile::ResizeImageGet(
                                                $ar_res['PREVIEW_PICTURE'],
                                                array("width" => 390, "height" => 450),
                                                BX_RESIZE_IMAGE_EXACT,
                                                true
                                            );
                                            $file = new IO\File(Application::getDocumentRoot() . $arFileTmp['src']);
                                            $isExist = $file->isExists();
                                            if($isExist == false){
                                                $arFileTmp['src']=SITE_TEMPLATE_PATH."/img/no_photo_big.png";
                                            }
                                            ?>
                                            <img class="product-category-slider__img" src="<?=$arFileTmp['src']?>" alt="<?=$item['NAME']?>" />
                                        </div>
                                        <div class="product-category-slider__info">
                                            <?if($item['PROPERTIES']['SHORT_CATEGORY_NAME_ACTIVE']['VALUE']){?>
                                                <p><?=$item['PROPERTIES']['SHORT_CATEGORY_NAME']['VALUE']?></p>
                                            <?}?>
                                            <span><?=$ar_res['NAME']?></span>
                                        </div>
                                    </a>
                                </div>
                            <?}
                        }
                    }?>
                </div>
            </div>
            <?foreach ($item['PROPERTIES']['ANOTHER_COLOR_PRODUCT']['VALUE'] as $key => $element){
                $arSelect = Array('PROPERTY_TSVET');
                $arFilter = Array("IBLOCK_ID"=>$item['IBLOCK_ID'], "ID" => $element);
                $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
                while($ob = $res->GetNextElement())
                {
                    $arFields = $ob->GetFields();
                    $thumbs[] = $arFields['PROPERTY_TSVET_VALUE'];
                }
            }?>
            <div class="product-category-slider-thumbs">
                <div class="product-category-slider-thumbs__wrapper product-category-slider-thumbs__wrapper-<?=$item['ID']?>">
                    <div class="product-category-slider-thumbs__item">
                        <div style='background-image: url("<?=colorHL($item['PROPERTIES']['tsvet']['VALUE'])?>");'></div>
                    </div>
                    <?foreach($thumbs as $value){?>
                        <div class="product-category-slider-thumbs__item">
                            <div style="background-image: url('<?colorHL($value)?>')"></div>
                        </div>
                    <?}?>
                </div>
            </div>
        </div>
        <?if($item['PROPERTIES']['NEW']['VALUE']=='Y'){?>
            <ul class="product-label-wrap">
                <li class="product-label__item">New</li>
            </ul>
        <?}?>
        <div class="product-category-slider-price">
        <?if(!in_array(SITE_ID,$no_shop_site_array) || in_array(SITE_ID,$no_shop_site_price_array)){?>
            <?if($price['RATIO_BASE_PRICE']!=$price['RATIO_PRICE']):?>
                <span class="product-category-slider-price__old"><?=$price['RATIO_BASE_PRICE']?>
                    <span class="product-category-slider-price__old-currency"><?=$arResult['CURRENCIES'][$price['CURRENCY']]; ?></span>
                </span>
            <?endif;?>
            <?if($price['RATIO_BASE_PRICE']>0):?>
                <span class="product-category-slider-price__new"><?=$price['RATIO_PRICE']?>
                    <span class="product-category-slider-price__new-currency"><?=$arResult['CURRENCIES'][$price['CURRENCY']]; ?></span>
                </span>
            <?endif;?>
		<?}?>
        </div>
    </div>
</div>
<script>
    $(function() {
        $(".product-category-slider__wrapper-<?=$item['ID']?>").not('.slick-initialized').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            swipe: false,
            arrows: false,
            fade: true,
            asNavFor: ".product-category-slider-thumbs__wrapper-<?=$item['ID']?>",
        });
        $(".product-category-slider-thumbs__wrapper-<?=$item['ID']?>").not('.slick-initialized').slick({
            slidesToShow: 4,
            swipe: false,
            slidesToScroll: 1,
            asNavFor: ".product-category-slider__wrapper-<?=$item['ID']?>",
            dots: false,
            focusOnSelect: true,
        });
    })
</script>