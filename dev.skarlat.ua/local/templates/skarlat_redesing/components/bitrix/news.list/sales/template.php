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
?>
    <!-- SUBCATEGORY SECTION START -->
    <div class="actions">
        <div class="container">
			<div class="row grid-padding">
			<?foreach($arResult["ITEMS"] as $arItem):?>
				<?
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				?>
				<!-- SUBCATEGORY ITEM START -->
				<div class="col-12 col-md-6" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				  <div class="action__item">
					<a href="<?=$arItem['DETAIL_PAGE_URL']?>">
					  <div class="action__img">
						<?
							$arFileTmp = CFile::ResizeImageGet(
								$arItem['PREVIEW_PICTURE']['ID'],
								array("width" => 770, "height" => 770),
								BX_RESIZE_IMAGE_PROPORTIONAL,
								true
							);
						?>
						<img
						  alt="image"
						  class="lazy"
						  src="data:image/gif;base64,R0lGODlhFAAHAIAAAP///wAAACH5BAEAAAEALAAAAAAUAAcAAAIKjI+py+0Po5wUFQA7"
						  data-src="<?=$arFileTmp['src']?>"
						  data-srcset="<?=$arFileTmp['src']?> 1x, <?=$arFileTmp['src']?> 2x"
						/>
					  </div>
					</a>
					<div class="action__info">
					  <p class="action__title">
						<?=$arItem['PREVIEW_TEXT']?>
					  </p>
					  <div class="action__footer">
						<div data-v-ce582356="" class="action__date">
						<?
						
							$start_date = new \DateTime($arItem['ACTIVE_FROM']);
							$now_date = new \DateTime();
							$end_date=new \DateTime($arItem['ACTIVE_TO']);
							$diff = $now_date->diff($end_date);
						?>
						<?if($now_date<$end_date && $now_date>$start_date):?>
						  <span class="date__prefix"><?=GetMessage('CT_BNL_ELEMENT_CNT')?></span>&nbsp; <span class="date__value "><?=$diff->d?></span>&nbsp;
						  <span class="date__plural "><?=true_wordform($diff->d,GetMessage("CT_BNL_ELEMENT_DAY"),GetMessage("CT_BNL_ELEMENT_DAY2"),GetMessage("CT_BNL_ELEMENT_DAYS"))?></span>
						<?elseif($diff->d===0 && $start_date<$end_date):?>
							<span class="date__prefix"><?=GetMessage('CT_BNL_ELEMENT_END')?></span>&nbsp;
							<span class="date__alert"><?=GetMessage('CT_BNL_ELEMENT_TODAY')?></span>
						<?elseif($start_date>$end_date):?>
							<span class="date__prefix"><?=GetMessage('CT_BNL_ELEMENT_THE_END')?></span>&nbsp;
						<?else:?>
							<span class="date__prefix"><?=GetMessage('CT_BNL_ELEMENT_BEGIN')?> <?=$arItem['ACTIVE_FROM']?></span>&nbsp;
						<?endif;?>
						</div>
						<a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="action__footer-link"><?=GetMessage('CT_BNL_ELEMENT_DETAIL')?></a>
					  </div>
					</div>
				  </div>
				</div>
				<!-- SUBCATEGORY ITEM END -->
			<?endforeach;?>

			</div>
		</div>
    </div>
	<!-- SUBCATEGORY SECTION END -->
	<div class="container">
		<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
			<?=$arResult["NAV_STRING"]?>
		<?endif;?>
	</div>