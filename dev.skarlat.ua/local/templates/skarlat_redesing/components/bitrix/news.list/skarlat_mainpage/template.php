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

<?
$count = 0;
$arSelect = Array("ID");
$arFilter = Array("IBLOCK_ID"=>$arParams["IBLOCK_ID"], "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->fetch()){
    $count++;
}
?>

<div class="row">
    <div class="col-12">
        <div class="blog-header">
            <?if($_SERVER['PHP_SELF'] !== '/blog/index.php'):?>
                <h2><?=GetMessage("INTERESTING")?></h2>
                <?if($count > $arParams["NEWS_COUNT"]):?><a href="/blog/" class="article-all"><?=GetMessage("ALL_ARTICLES")?></a><?endif;?>
            <?endif;?>
        </div>
    </div>
</div>

<?if($arParams['BLOG'] == 'Y'):?>
<div class="row">
<?else:?>
<div class="row grid-blog">
<?endif;?>
    <? foreach ($arResult["ITEMS"] as $arItem): ?>
        <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>
        <div class="col-12 col-sm-6 col-md-6 col-lg-3" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
            <article
                    class="article-item"
                    title="<?= $arItem["NAME"] ?>"
            >
                <div class="article-img">
                    <div class="article-img-wrapper">
                        <img alt="<?= $arItem["NAME"] ?>" src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"/>
                    </div>
                </div>

                <div class="article-content">
                    <div class="article-content-description">
                        <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="article-title">
                            <h3><?= $arItem["NAME"] ?></h3>
                        </a>
                        <div class="article-desctiption">
                            <?= $arItem["PREVIEW_TEXT"]; ?>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    <? endforeach; ?>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
    <?=$arResult["NAV_STRING"]?>
<?endif;?>
