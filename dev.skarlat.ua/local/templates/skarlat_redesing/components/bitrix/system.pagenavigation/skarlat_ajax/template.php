<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$ClientID = 'navigation_'.$arResult['NavNum'];

$this->setFrameMode(true);

if(!$arResult["NavShowAlways"])
{
    if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
        return;
}
?>
<div class="row d-flex">
    <nav class="col">
        <nav aria-label="pagination">
            <div class="pagination">
    <?
    $strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
    $strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");
    if($arResult["bDescPageNumbering"] === true)
    {
    // to show always first and last pages
    $arResult["nStartPage"] = $arResult["NavPageCount"];
    $arResult["nEndPage"] = 1;

    $sPrevHref = '';
    if ($arResult["NavPageNomer"] < $arResult["NavPageCount"])
    {
        $bPrevDisabled = false;
        if ($arResult["bSavePage"])
        {
            $sPrevHref = $arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.($arResult["NavPageNomer"]+1);
        }
        else
        {
            if ($arResult["NavPageCount"] == ($arResult["NavPageNomer"]+1))
            {
                $sPrevHref = $arResult["sUrlPath"].$strNavQueryStringFull;
            }
            else
            {
                $sPrevHref = $arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.($arResult["NavPageNomer"]+1);
            }
        }
    }
    else
    {
        $bPrevDisabled = true;
    }

    $sNextHref = '';
    if ($arResult["NavPageNomer"] > 1)
    {
        $bNextDisabled = false;
        $sNextHref = $arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.($arResult["NavPageNomer"]-1);
    }
    else
    {
        $bNextDisabled = true;
    }
    ?>
    <div class="navigation-arrows 1">
        <?if ($bPrevDisabled):?><span class="disabled"><?=GetMessage("nav_prev")?></span><?else:?><a href="<?=$sPrevHref;?>" id="<?=$ClientID?>_previous_page"><?=GetMessage("nav_prev")?></a><?endif;?>&nbsp;<?if ($bNextDisabled):?><span class="disabled"><?=GetMessage("nav_next")?></span><?else:?><a href="<?=$sNextHref;?>" id="<?=$ClientID?>_next_page"><?=GetMessage("nav_next")?></a><?endif;?>
    </div>

    <div class="navigation-pages">
        <span class="navigation-title"><?=GetMessage("pages")?></span>
        <?
        $bFirst = true;
        $bPoints = false;
        do
        {
            $NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1;
            if ($arResult["nStartPage"] <= 2 || $arResult["NavPageCount"]-$arResult["nStartPage"] <= 1 || abs($arResult['nStartPage']-$arResult["NavPageNomer"])<=2)
            {

                if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
                    ?>
                    <span class="nav-current-page"><?=$NavRecordGroupPrint?></span>
                <?
                elseif($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false):
                    ?>
                    <a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=$NavRecordGroupPrint?></a>
                <?
                else:
                    ?>
                    <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$NavRecordGroupPrint?></a>
                <?
                endif;
                $bFirst = false;
                $bPoints = true;
            }
            else
            {
                if ($bPoints)
                {
                    ?>...<?
                    $bPoints = false;
                }
            }
            $arResult["nStartPage"]--;
        } while($arResult["nStartPage"] >= $arResult["nEndPage"]);
        }
        else
        {
        // to show always first and last pages
        $arResult["nStartPage"] = 1;
        $arResult["nEndPage"] = $arResult["NavPageCount"];

        $sPrevHref = '';
        if ($arResult["NavPageNomer"] > 1)
        {
            $bPrevDisabled = false;

            if ($arResult["bSavePage"] || $arResult["NavPageNomer"] > 2)
            {
                $sPrevHref = $arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.($arResult["NavPageNomer"]-1);
            }
            else
            {
                $sPrevHref = $arResult["sUrlPath"].$strNavQueryStringFull;
            }
        }
        else
        {
            $bPrevDisabled = true;
        }

        $sNextHref = '';
        if ($arResult["NavPageNomer"] < $arResult["NavPageCount"])
        {
            $bNextDisabled = false;
            $sNextHref = $arResult["sUrlPath"].'?'.$strNavQueryString.'PAGEN_'.$arResult["NavNum"].'='.($arResult["NavPageNomer"]+1);
        }
        else
        {
            $bNextDisabled = true;
        }
        ?>
            <?if ($bPrevDisabled):?>
                <a class="page-item page-icon page-arrow-prev disabled" href="javascript:void(0)"> </a>
            <?else:?>
                <a class="page-item page-icon page-arrow-prev" href="<?=$sPrevHref;?>"> </a>
            <?endif;?>

            <?
            $bFirst = true;
            $bPoints = false;
            do
            {
                if ($arResult["nStartPage"] <= 2 || $arResult["nEndPage"]-$arResult["nStartPage"] <= 1 || abs($arResult['nStartPage']-$arResult["NavPageNomer"])<=2)
                {

                    if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):
                        ?>
                        <div class="page-item active">
                            <span class="page-link">
                              <?=$arResult["nStartPage"]?>
                            </span>
                        </div>
                    <?
                    elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):
                        ?>
                        <div class="page-item">
                            <a class="page-link" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=$arResult["nStartPage"]?></a>
                        </div>
                    <?
                    else:
                        ?>
                        <div class="page-item">
                            <a class="page-link" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$arResult["nStartPage"]?></a>
                        </div>
                    <?
                    endif;
                    $bFirst = false;
                    $bPoints = true;
                }
                else
                {
                    if ($bPoints)
                    {
                        ?>
                        <div class="page-item">
                            <a class="page-link" href="javascript:void(0)">...</a>
                        </div>
                        <?
                        $bPoints = false;
                    }
                }
                $arResult["nStartPage"]++;
            } while($arResult["nStartPage"] <= $arResult["nEndPage"]);
            }
            ?>
        <?if ($bNextDisabled):?>
            <a class="page-item page-icon page-arrow-next disabled" href="javascript:void(0)"> </a>
        <?else:?>
            <a class="page-item page-icon page-arrow-next" href="<?=$sNextHref;?>"> </a>
        <?endif;?>
    </div>
    </div>
    </nav>
    </div>
