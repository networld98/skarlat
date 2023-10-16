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

<?foreach($arResult as $itemIdex => $arItem):?>
    <?if ($arItem["DEPTH_LEVEL"] == "1"):?>
        <?if(empty($arItem["PARAMS"]["class"])){?>
            <li class="header-list__item <?=($arItem["SELECTED"]) ? " active" : "" ;?>">
                <a href="<?=htmlspecialcharsbx($arItem["LINK"])?>"><?=htmlspecialcharsbx($arItem["TEXT"])?></a>
            </li>
        <?}else{?>
            <li class="header-list__item <?=$arItem["PARAMS"]["class"]?> <?=($arItem["SELECTED"]) ? " active" : "" ;?>" data-tab="<?=$arItem["PARAMS"]["data"]?>">
                <?=htmlspecialcharsbx($arItem["TEXT"])?>
            </li>
       <?}?>
    <?endif?>
<?endforeach;?>
