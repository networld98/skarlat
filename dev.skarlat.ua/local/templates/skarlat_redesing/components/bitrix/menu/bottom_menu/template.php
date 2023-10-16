<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
<ul class="footer-nav-list">
    <?foreach($arResult as $itemIdex => $arItem):?>
        <?if(empty($arItem["LINK"]) && $itemIdex == 0){?>
            <li class="footer-nav__item">
                <strong><?=htmlspecialcharsbx($arItem["TEXT"])?></strong>
            </li>
        <?}elseif(empty($arItem["LINK"]) && $itemIdex == 1){?>
            <li class="footer-nav__item">
                <span><?=htmlspecialcharsbx($arItem["TEXT"])?></span>
            </li>
        <?}elseif(strpos($arItem["LINK"],'tel') !== false){?>
            <li class="footer-nav__item">
                <a href="tel:<?=str_replace(" ","",$arItem["TEXT"]);?>" class="footer-nav__link"><?=htmlspecialcharsbx($arItem["TEXT"])?></a>
            </li>
        <?}else{?>
            <li class="footer-nav__item">
                <a href="<?=htmlspecialcharsbx($arItem["LINK"])?>" class="footer-nav__link"><?=htmlspecialcharsbx($arItem["TEXT"])?></a>
            </li>
        <?}?>
    <?endforeach;?>
</ul>