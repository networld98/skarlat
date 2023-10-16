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
<?
$fullCount = count($arResult);
if(($fullCount % 3) === 0) {
    $rowCount = 3;
}elseif(($fullCount % 4) === 0 || ($fullCount % 3) !== 0) {
    $rowCount = 4;
}
?>
<ul class="footer-nav-list social">
    <?foreach($arResult as $itemIdex => $arItem):
    $itemIdex = $itemIdex+1;?>
        <li class="footer-nav__item social <?=$itemIdex?>">
            <a href="<?=htmlspecialcharsbx($arItem["LINK"])?>" class="footer-nav__link"><?=$arItem['PARAMS']['icon']?></a>
        </li>
    <?if(($itemIdex % $rowCount) === 0 && $itemIdex != 0){?>
        </ul>
        <ul class="footer-nav-list social">
    <?}
    endforeach;?>
</ul>