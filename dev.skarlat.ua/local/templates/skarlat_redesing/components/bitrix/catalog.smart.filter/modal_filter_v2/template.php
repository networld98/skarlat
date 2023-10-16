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
<div class="modal-content">
    <div class="modal-header">
        <h2><?=GetMessage("CT_BCSF_FILTER_TITLE")?></h2>
        <button class="close" data-close="true">
            <svg x="0px" y="0px" viewBox="0 0 30 30">
                <path d="M25,6.2L23.8,5L15,13.8L6.2,5L5,6.2l8.8,8.8L5,23.8L6.2,25l8.8-8.8l8.8,8.8l1.2-1.2L16.2,15L25,6.2z"></path>
            </svg>
        </button>
    </div>
    <form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" class="smartfilter" id="FilterForm">
        <div class="modal-body">
            <?foreach($arResult["HIDDEN"] as $arItem):?>
                <input type="hidden" name="<?echo $arItem["CONTROL_NAME"]?>" id="<?echo $arItem["CONTROL_ID"]?>" value="<?echo $arItem["HTML_VALUE"]?>" />
            <?endforeach;?>
            <?
            foreach($arResult["ITEMS"] as $key=>$arItem)
            {
                if(
                    empty($arItem["VALUES"])
                    || isset($arItem["PRICE"])
                )
                    continue;

                if (
                    $arItem["DISPLAY_TYPE"] == "A"
                    && (
                        $arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0
                    )
                )
                    continue;
                ?>

                <fieldset class="filter" data-role="bx_filter_block">
                    <div class="filter-title" data-toggle="collapse" data-target="#el<?=$key?>">
                        <lagend><?=$arItem["NAME"]?></lagend>
                    </div>
                    <div class="filter-content" id="el<?=$key?>">
                        <?
                        $arCur = current($arItem["VALUES"]);
                        switch ($arItem["DISPLAY_TYPE"])
                        {
                            default://CHECKBOXES
                                ?>
                                    <?foreach($arItem["VALUES"] as $val => $ar):?>
                                <div class="filter-item">
                                    <label data-role="label_<?=$ar["CONTROL_ID"]?>"<? echo $ar["DISABLED"] ? 'disabled="disabled"': '' ?> ">
                                        <input
                                                class="checkbox"
                                                type="checkbox"
                                                value="<? echo $ar["HTML_VALUE"] ?>"
                                                name="<? echo $ar["CONTROL_NAME"] ?>"
                                                id="<? echo $ar["CONTROL_ID"] ?>"
                                                onclick="smartFilter.click(this)"
                                            <? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
                                            <? echo $ar["DISABLED"] ? 'disabled="disabled"': '' ?>
                                        />
                                        <span class="bx-filter-param-text" title="<?=$ar["VALUE"];?>"><?=$ar["VALUE"];?><?

                                            if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
                                                ?>&nbsp;(<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
                                            endif;?></span>

                                    </label>

                                </div>
                                    <?endforeach;?>
                                    <?if(count($arItem["VALUES"])>5):?>
                                        <span class="filter-all--show ">
                                            <span class="filter-all--show-icon"></span>
                                        </span>
                                    <?endif;?>
                        <?
                        }
                        ?>
                        </div>
                </fieldset>
            <?
            }
            ?>
        </div>
        <div class="modal-footer">
            <button class="filters-reset" type="button" id="del_filter_modal" name="del_filter_modal" value="Сбросить"><? echo GetMessage("CLEAR") ?></button>
            <button class="primary" type="submit" id="set_filter" name="set_filter"><?=GetMessage("CT_BCSF_SET_FILTER")?></button>
        </div>
    </form>
</div>
<script type="text/javascript">
    var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>

