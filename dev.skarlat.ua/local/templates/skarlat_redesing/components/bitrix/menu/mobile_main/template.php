<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<?
$previousLevel = 0;
foreach($arResult as $arItem):?>

    <?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
        <?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
    <?endif?>

    <?if ($arItem["IS_PARENT"]):?>

        <?if ($arItem["DEPTH_LEVEL"] == 1):?>
			<?if($arItem["LINK"]=='/catalog/sale/') continue;?>
            <li>
                <a href="javascript:void(0)">
                    <span><?=$arItem["TEXT"]?></span>
                    <svg viewbox="0 0 6 9" class="arrow">
                        <path d="M0 0.7L3.5 4.4L0 8.4L0.8 9L5 4.4L0.8 0L0 0.7Z"></path>
                    </svg>
                </a>
                <ul class="mob-nav-main-third">
                    <li class="mob-menu-catalog-back">
                        <a href="javascript:void(0)">
                            <span><?=GetMessage("BACK")?></span>
                            <svg viewbox="0 0 6 9" class="arrow">
                                <path d="M0 0.7L3.5 4.4L0 8.4L0.8 9L5 4.4L0.8 0L0 0.7Z"></path>
                            </svg>
                        </a>
                    </li>
        <?endif?>

    <?else:?>
        <li>
            <a href="<?=$arItem["LINK"]?>">
                <span><?=$arItem["TEXT"]?></span>
            </a>
        </li>
    <?endif?>
    <?$previousLevel = $arItem["DEPTH_LEVEL"];?>
<?endforeach?>

<?if ($previousLevel > 1)://close last item tags?>
    <?=str_repeat("</ul></li>", ($previousLevel-1) );?>
<?endif?>
<?endif?>
