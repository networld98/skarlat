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
?>
<div class="col-6 col-sm-4">
								<div class="product-item__wrapper <?if($_SESSION['CATALOG_COMPARE_LIST'][CATALOG_IBLOCK_ID]["ITEMS"][$actualItem['LINK_ELEMENT_ID']]==$actualItem['LINK_ELEMENT_ID']) echo 'checked';?>" onclick="$(this).toggleClass('checked');" data-item="<?=$actualItem['LINK_ELEMENT_ID']?>">
                                    <!-- PRODUCT CARD TOP START -->
                                    <div class="product-item">
                                        <!-- PRODUCT CARD IMAGE BLOCK START -->
                                        <div class="product-item__wrapper-img">
                                            <div class="product-item__wrapper-assistant-img">
												<?
												$pict=($item['PREVIEW_PICTURE']['ID']>0) ? $item['PREVIEW_PICTURE']['ID'] : $item['DETAIL_PICTURE']['ID'];
												$arFileTmp = CFile::ResizeImageGet(
													$pict,
													array("width" => 190, "height" => 190),
													BX_RESIZE_IMAGE_PROPORTIONAL,
													true
												);
												if($pict==''){
													$arFileTmp['src']=SITE_TEMPLATE_PATH."/img/no_photo.png";
												}
												?>
                                                <img
                                                        alt="image"
                                                        class="lazy"
                                                        src="data:image/gif;base64,R0lGODlhFAAHAIAAAP///wAAACH5BAEAAAEALAAAAAAUAAcAAAIKjI+py+0Po5wUFQA7"
                                                        data-src="<?=$arFileTmp['src']?>"
                                                        data-srcset="<?=$arFileTmp['src']?> 1x, <?=$arFileTmp['src']?> 2x"
                                                />
                                            </div>
                                        </div>
                                        <!-- PRODUCT CARD IMAGE BLOCK END -->
                                        <!-- PRODUCT CARD INFORMATION BLOCK START -->
                                        <div class="product-item__wrapper-info">
                                            <p class="product-item__wrapper-info-cat">
												<?
                                                if ($arResult['ITEM']['PROPERTIES']['SHORT_CATEGORY_NAME_ACTIVE']['VALUE']) {
                                                    echo $arResult['ITEM']['PROPERTIES']['SHORT_CATEGORY_NAME']['VALUE'];
                                                } else {
                                                    $arFilter=array(
														'IBLOCK_ID' => $item['IBLOCK_ID'],
														'ID'=>$item["~IBLOCK_SECTION_ID"]
													);
													$rsSect = \CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilter,false,array("ID","IBLOCK_ID","NAME","SECTION_ID","UF_EXPORT_NAME") );
													while($arSect = $rsSect->Fetch())
													{

														echo ($arSect['UF_EXPORT_NAME']=='') ? $arSect['NAME'] : $arSect['UF_EXPORT_NAME'];
													} 
                                                }
												?>
											</p>
                                            <span class="product-item__wrapper-info-name">
												<?=$item['NAME']?>
											</span>
                                            <div class="product-item__wrapper-price">
                                                <?if($price['RATIO_BASE_PRICE']!=$price['RATIO_PRICE']):?>
													<div class="product-item__wrapper-price_old">
														<?=$price['RATIO_BASE_PRICE']?>
														<div class="product-item__wrapper-price_old-currency"><?=GetMessage("CURRENCY")?></div>
													</div>
												<?endif;?>
												<div class="product-item__wrapper-price_new">
													<?=$price['RATIO_PRICE']?>
													<div class="product-item__wrapper-price_new-currency"><?=GetMessage("CURRENCY")?></div>
												</div>
                                            </div>
                                        </div>
                                        <!-- PRODUCT CARD INFORMATION BLOCK END -->
                                    </div>
                                    <!-- PRODUCT CARD TOP END -->
                                </div>
</div>
