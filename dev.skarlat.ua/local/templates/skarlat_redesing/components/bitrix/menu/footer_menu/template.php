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
    <li class="copyright-nav__item">
        <a href="<?=htmlspecialcharsbx($arItem["LINK"])?>" class="copyright-nav__link"><?=htmlspecialcharsbx($arItem["TEXT"])?></a>
    </li>
<?endforeach;?>