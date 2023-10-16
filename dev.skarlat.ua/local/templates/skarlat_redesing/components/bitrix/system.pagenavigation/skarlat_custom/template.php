<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);

if(!$arResult["NavShowAlways"])
{
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}
if($arResult["sUrlPath"]=='/presonal/' && ($_GET['tab']=="new-order" || $_GET['tab']=="partner" || $_GET['tab']=="history")){
   $arResult["sUrlPath"] == '/presonal/?tab='.$_GET['tab'];
}
?>
<div class="pagination-block">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="pagination">
                    <ul>
                        <?
                        $strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"] . "&amp;" : "");
                        $strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?" . $arResult["NavQueryString"] : "");
                        if ($arResult["bDescPageNumbering"] === true):
                            $bFirst = true;
                            if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
                                if ($arResult["bSavePage"]):?>
                                    <li class="pagination-item modern-page-previous">
                                        <a class="modern-page-previous"
                                           href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] + 1) ?>"></a>
                                    </li>
                                <?
                                else:
                                    if ($arResult["NavPageCount"] == ($arResult["NavPageNomer"] + 1)):
                                        ?>
                                        <li class="pagination-item modern-page-previous">
                                            <a class="modern-page-previous"
                                               href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>"></a>
                                        </li>
                                    <? else:?>
                                        <li class="pagination-item modern-page-previous">
                                            <a class="modern-page-previous"
                                               href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] + 1) ?>"></a>
                                        </li>
                                    <?endif;
                                endif;
                                if ($arResult["nStartPage"] < $arResult["NavPageCount"]):
                                    $bFirst = false;
                                    if ($arResult["bSavePage"]):?>
                                        <li class="pagination-item">
                                            <a class="modern-page-first"
                                               href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["NavPageCount"] ?>">1</a>
                                        </li>
                                    <? else:?>
                                        <li class="pagination-item">
                                            <a class="modern-page-first"
                                               href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>">1</a>
                                        </li>
                                    <? endif;
                                    if ($arResult["nStartPage"] < ($arResult["NavPageCount"] - 1)):
                                        ?>
                                        <span class="modern-page-dots">...</span>
                                        <li class="pagination-item">
                                            <a class="modern-page-dots"
                                               href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= intval($arResult["nStartPage"] + ($arResult["NavPageCount"] - $arResult["nStartPage"]) / 2) ?>">...</a>
                                        </li>
                                    <?
                                    endif;
                                endif;
                            endif;
                            do {
                                $NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1;
                                if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
                                elseif ($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false):
                                    ?>
                                    <li class="pagination-item">
                                        <a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>"
                                           class="<?= ($bFirst ? "modern-page-first" : "") ?>"><?= $NavRecordGroupPrint ?></a>
                                    </li>
                                <? else:?>
                                    <li class="pagination-item">
                                        <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["nStartPage"] ?>"<?
                                        ?>
                                           class="<?= ($bFirst ? "modern-page-first" : "") ?>"><?= $NavRecordGroupPrint ?></a>
                                    </li>
                                <?endif;
                                $arResult["nStartPage"]--;
                                $bFirst = false;
                            } while ($arResult["nStartPage"] >= $arResult["nEndPage"]);
                            if ($arResult["NavPageNomer"] > 1):
                                if ($arResult["nEndPage"] > 1):
                                    if ($arResult["nEndPage"] > 2):?>
                                        <li class="pagination-item">
                                            <a class="modern-page-dots"
                                               href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= round($arResult["nEndPage"] / 2) ?>">...</a>
                                        </li>
                                    <?endif;?>
                                    <li class="pagination-item">
                                        <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=1"><?= $arResult["NavPageCount"] ?></a>
                                    </li>
                                <?endif;?>
                                <li class="pagination-item modern-page-next">
                                    <a class="modern-page-next"
                                       href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>"></a>
                                </li>
                            <?
                            endif;
                        else:
                            $bFirst = true;
                            if ($arResult["NavPageNomer"] > 1):
                                if ($arResult["bSavePage"]):
                                    ?>
                                    <li class="pagination-item modern-page-previous">
                                        <a class="modern-page-previous"
                                           href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>"></a>
                                    </li>
                                <?else: if ($arResult["NavPageNomer"] > 2):
                                        ?>
                                        <li class="pagination-item modern-page-previous">
                                            <a class="modern-page-previous"
                                               href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] - 1) ?>"></a>
                                        </li>
                                    <?
                                    else:
                                        ?>
                                        <li class="pagination-item modern-page-previous">
                                            <a class="modern-page-previous"
                                               href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>"></a>
                                        </li>
                                    <?
                                    endif;
                                endif;
                                if ($arResult["nStartPage"] > 1):
                                    $bFirst = false;
                                    if ($arResult["bSavePage"]):
                                        ?>
                                        <li class="pagination-item">
                                            <a class="modern-page-first"
                                               href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=1">1</a>
                                        </li>
                                    <?else:?>
                                        <li class="pagination-item">
                                            <a class="modern-page-first"
                                               href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>">1</a>
                                        </li>
                                    <?
                                    endif;
                                    if ($arResult["nStartPage"] > 2):?>
                                        <li class="pagination-item">
                                            <a class="modern-page-dots 1"
                                               href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= round($arResult["nStartPage"] / 2) ?>">...</a>
                                        </li>
                                    <?
                                    endif;
                                endif;
                            endif;
                            do {
                                if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
                                    ?>
                                    <li class="pagination-item active"><?= $arResult["nStartPage"] ?></li>
                                <?
                                elseif ($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):
                                    ?>
                                    <li class="pagination-item">
                                        <a href="<?= $arResult["sUrlPath"] ?><?= $strNavQueryStringFull ?>"
                                           class="<?= ($bFirst ? "modern-page-first" : "") ?>"><?= $arResult["nStartPage"] ?></a>
                                    </li>
                                <?else:?>
                                    <li class="pagination-item">
                                        <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["nStartPage"] ?>"<?
                                        ?>
                                           class="<?= ($bFirst ? "modern-page-first" : "") ?>"><?= $arResult["nStartPage"] ?></a>
                                    </li>
                                <?
                                endif;
                                $arResult["nStartPage"]++;
                                $bFirst = false;
                            } while ($arResult["nStartPage"] <= $arResult["nEndPage"]);
                            if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
                                if ($arResult["nEndPage"] < $arResult["NavPageCount"]):
                                    if ($arResult["nEndPage"] < ($arResult["NavPageCount"] - 1)):
                                        /*?>
                                                <span class="modern-page-dots">...</span>
                                        <?*/
                                        ?>
                                        <li class="pagination-item">
                                            <a class="modern-page-dots"
                                               href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= round($arResult["nEndPage"] + ($arResult["NavPageCount"] - $arResult["nEndPage"]) / 2) ?>">...</a>
                                        </li>
                                    <?endif;?>
                                    <li class="pagination-item">
                                        <a href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= $arResult["NavPageCount"] ?>"><?= $arResult["NavPageCount"] ?></a>
                                    </li>
                                <?endif;?>
                                <li class="pagination-item modern-page-next">
                                    <a class="modern-page-next"
                                       href="<?= $arResult["sUrlPath"] ?>?<?= $strNavQueryString ?>PAGEN_<?= $arResult["NavNum"] ?>=<?= ($arResult["NavPageNomer"] + 1) ?>"></a>
                                </li>
                            <?
                            endif;
                        endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>