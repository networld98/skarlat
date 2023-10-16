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

<ul class="basket-aside__list">
    <?foreach($arResult as $itemIdex => $arItem):?>
        <?if ($arItem["DEPTH_LEVEL"] == "1"):?>
            <li class="basket-aside__item">
                <?=$arItem['PARAMS']['icon']?>
                <a class="basket-aside__link" href="<?=htmlspecialcharsbx($arItem["LINK"])?>"><?=htmlspecialcharsbx($arItem["TEXT"])?></a>
            </li>
        <?endif?>
    <?endforeach;?>
</ul>
