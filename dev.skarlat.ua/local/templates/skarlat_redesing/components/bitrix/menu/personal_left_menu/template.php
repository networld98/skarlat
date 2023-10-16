<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$theme = COption::GetOptionString("main", "wizard_eshop_bootstrap_theme_id", "blue", SITE_ID);
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

if (empty($arResult))
	return;
?>
<ul>
	<?foreach($arResult as $itemIdex => $arItem):
        if ($arItem["DEPTH_LEVEL"] == "1"):?>
            </ul>
                <div class="lk-nav__title">
                    <span><?=htmlspecialcharsbx($arItem["TEXT"])?></span>
                </div>
            <ul>
        <?endif;
		if ($arItem["DEPTH_LEVEL"] == "2"):?>
            <?if(!empty($arItem['PARAMS']['link'])){?>
                <li data-link="<?=$arItem['PARAMS']['link']?>" class="list-group-item list-group-item-action<?=($arItem["SELECTED"]) ? " active" : "" ;?>">
                    <?=$arItem['PARAMS']['icon']?>
                    <?=htmlspecialcharsbx($arItem["TEXT"])?>
                </li>
            <?}else{?>
                <li class="list-group-item list-group-item-action">
                    <?=$arItem['PARAMS']['icon']?>
                    <a href="<?=htmlspecialcharsbx($arItem["LINK"])?>"><?=htmlspecialcharsbx($arItem["TEXT"])?></a>
                </li>
            <?}?>
		<?endif?>
	<?endforeach;?>
</ul>