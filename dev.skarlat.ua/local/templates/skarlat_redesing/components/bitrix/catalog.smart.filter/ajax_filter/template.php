<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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

$templateData = array(
    'TEMPLATE_THEME' => $this->GetFolder() . '/themes/' . $arParams['TEMPLATE_THEME'] . '/colors.css',
    'TEMPLATE_CLASS' => 'bx-' . $arParams['TEMPLATE_THEME']
);

if (isset($templateData['TEMPLATE_THEME'])) {
    $this->addExternalCss($templateData['TEMPLATE_THEME']);
}
?>
<div class="row">
    <div class="col-12 col-xl-9 d-none d-xl-flex">
        <form name="<? echo $arResult["FILTER_NAME"] . "_form" ?>" action="<? echo $arResult["FORM_ACTION"] ?>"
              method="get" class="smartfilter" id="FilterForm">
            <div class="row">
                <? foreach ($arResult["HIDDEN"] as $arItem): ?>
                    <input type="hidden" name="<? echo $arItem["CONTROL_NAME"] ?>" id="<? echo $arItem["CONTROL_ID"] ?>"
                           value="<? echo $arItem["HTML_VALUE"] ?>"/>
                <? endforeach; ?>
                <?
                $cont = 0;
                foreach ($arResult["ITEMS"] as $key => $arItem) {
                    $arItem['DISPLAY_TYPE'] = "P";
                    if ($cont < 3) {
                        if (
                            empty($arItem["VALUES"])
                            || isset($arItem["PRICE"])
                        )
                            continue;
                        ?>
                        <div class="col-4 d-none d-xl-flex" data-role="bx_filter_block">
                            <?
                            $cont++;
                            $arCur = current($arItem["VALUES"]);
                            switch ($arItem["DISPLAY_TYPE"]) {
                                case "P"://DROPDOWN
                                    $checkedItemExist = false;
                                    ?>
                                    <div class="select"
                                         onclick="smartFilter.showDropDownPopup(this, '<?= CUtil::JSEscape($key) ?>')">
                                        <div class="select-selected" id="el<?= $key ?>">
                                            <div class="bx-filter-select-container">
                                                <div class="bx-filter-select-block">
                                                    <div class="bx-filter-select-text" data-role="currentOption">
                                                        <?
                                                        foreach ($arItem["VALUES"] as $val => $ar) {
                                                            if ($ar["CHECKED"]) {
                                                                echo $ar["VALUE"];
                                                                $checkedItemExist = true;
                                                                if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):?> (<? echo $ar["ELEMENT_COUNT"]; ?>)<?endif;
                                                            break;
                                                            }
                                                        }
                                                        if (!$checkedItemExist) {
                                                            echo $arItem["NAME"];
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="bx-filter-select-arrow"></div>
                                                    <input
                                                            style="display: none"
                                                            type="radio"
                                                            name="<?= $arCur["CONTROL_NAME_ALT"] ?>"
                                                            id="<? echo "all_" . $arCur["CONTROL_ID"] ?>"
                                                            value=""
                                                    />
                                                    <? foreach ($arItem["VALUES"] as $val => $ar):?>
                                                        <input
                                                                style="display: none"
                                                                type="radio"
                                                                name="<?= $ar["CONTROL_NAME_ALT"] ?>"
                                                                id="<?= $ar["CONTROL_ID"] ?>"
                                                                value="<? echo $ar["HTML_VALUE_ALT"] ?>"
                                                            <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                                        />
                                                    <?endforeach ?>
                                                    <div class="bx-filter-select-popup" data-role="dropdownContent"
                                                         style="display: none;">
                                                        <ul>
                                                            <li>
                                                                <label for="<?= "all_" . $arCur["CONTROL_ID"] ?>"
                                                                       class="bx-filter-param-label"
                                                                       data-role="label_<?= "all_" . $arCur["CONTROL_ID"] ?>"
                                                                       onclick="smartFilter.selectDropDownItem(this, '<?= CUtil::JSEscape("all_" . $arCur["CONTROL_ID"]) ?>')">
                                                                    <? echo GetMessage("CT_BCSF_FILTER_ALL"); ?>
                                                                </label>
                                                            </li>
                                                            <?
                                                            foreach ($arItem["VALUES"] as $val => $ar):
                                                                $class = "";
                                                                if ($ar["CHECKED"])
                                                                    $class .= " selected";
                                                                if ($ar["DISABLED"])
                                                                    $class .= " disabled"; ?>
                                                                <li>
                                                                    <label for="<?= $ar["CONTROL_ID"] ?>"
                                                                           class="bx-filter-param-label<?= $class ?>"
                                                                           data-role="label_<?= $ar["CONTROL_ID"] ?>"
                                                                           onclick="smartFilter.selectDropDownItem(this, '<?= CUtil::JSEscape($ar["CONTROL_ID"]) ?>')"><?= $ar["VALUE"] ?>
                                                                            <?if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):?> (<? echo $ar["ELEMENT_COUNT"]; ?>)<?endif;?>
                                                                    </label>
                                                                </li>
                                                            <?endforeach ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?
                                    break;
                                default://CHECKBOXES
                                    ?>
                                    <? if (count($arItem["VALUES"]) > 5):?>
                                    <span class="filter-all--show ">
                                        <span class="filter-all--show-icon"></span>
                                    </span>
                                <?endif; ?>
                                <?
                            }
                            ?>

                        </div>

                        <?
                    }
                }
                ?>
            </div>
        </form>
    </div>
    <div class="col-12 col-xl-3">
        <button class="more-filters" id="modalFilters"><? echo GetMessage("CT_BCSF_FILTER_ALL") ?></button>
    </div>
    <div class="col col-sm-4 col-md-3">
        <div class="select sort">
            <select class="sort-cat__title-block_select select-selected"
                    onchange="changeSort($(this).val()); location.reload();"
                    name="sort_by" id="sort_cat">
                <option value="DATE_CREATED|DESC" <? if ($_SESSION['SORT'] == "DATE_CREATED"): ?> selected="selected" <? endif; ?>><? echo GetMessage("NEW") ?></option>
                <option value="catalog_PRICE_1|ASC" <? if ($_SESSION['SORT'] == "catalog_PRICE_1" && $_SESSION['SORT_BY'] == 'ASC'): ?> selected="selected" <? endif; ?>><? echo GetMessage("FROM_LOW") ?></option>
                <option value="catalog_PRICE_1|DESC" <? if ($_SESSION['SORT'] == "catalog_PRICE_1" && $_SESSION['SORT_BY'] == 'DESC'): ?> selected="selected" <? endif; ?>><? echo GetMessage("FROM_EXPENSIVE") ?></option>
                <option value="SHOW_COUNTER|DESC" <? if ($_SESSION['SORT'] == "SHOW_COUNTER"): ?> selected="selected" <? endif; ?>><? echo GetMessage("BY_POPULAR") ?></option>
            </select>
        </div>
    </div>
    <div class="col justify-content-xl-center justify-content-end align-items-center d-none d-sm-flex ">
        <? $APPLICATION->ShowViewContent('catalog_download'); ?>
    </div>
    <div class="d-none d-xl-flex col-xl-3">
        <button class="filters-reset" type="button" id="del_filter" name="del_filter"
                value="Сбросить"><? echo GetMessage("CLEAR") ?></button>
    </div>
</div>
<div class="bx_filter_popup_result right" id="modef" <?if(!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"'; else echo 'style="display:inline-block"';?>>
    <?echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<b><span id="modef_num">'.intval($arResult["ELEMENT_COUNT"]).'</span></b>'));?>
    <span class="arrow"></span><br/>
    <a class="bxr-color-button bxr-color-button-small bxr-show-filter-btn" href="<?echo $arResult["FILTER_URL"]?>"><?echo GetMessage("CT_BCSF_FILTER_SHOW")?></a>
</div>
<script type="text/javascript">
    var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
</script>
