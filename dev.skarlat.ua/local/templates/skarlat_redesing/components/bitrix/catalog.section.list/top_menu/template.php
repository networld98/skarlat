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

$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));

?>

<? if (0 < $arResult["SECTIONS_COUNT"]) { ?>
    <ul class="category-menu">
        <?
        $intCurrentDepth = 1;
        $boolFirst = true;
        foreach ($arResult['SECTIONS'] as &$arSection)
        {
        $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
        $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

        switch ($arSection['RELATIVE_DEPTH_LEVEL']) {
            case '1':
                $class_ident = '';
                break;
            case '2':
                $class_ident = '-second';
                break;
            case '3':
                $class_ident = '-third';
                break;
        }

        if ($intCurrentDepth < $arSection['RELATIVE_DEPTH_LEVEL']) {
            if (0 < $intCurrentDepth)
                echo "\n", str_repeat("\t", $arSection['RELATIVE_DEPTH_LEVEL']), "<ul class='category-menu$class_ident'>";
        } elseif ($intCurrentDepth == $arSection['RELATIVE_DEPTH_LEVEL']) {
            if (!$boolFirst)
                echo '</li>';
        } else {
            while ($intCurrentDepth > $arSection['RELATIVE_DEPTH_LEVEL']) {
                echo '</li>', "\n", str_repeat("\t", $intCurrentDepth), '</ul>', "\n", str_repeat("\t", $intCurrentDepth - 1);
                $intCurrentDepth--;
            }
            echo str_repeat("\t", $intCurrentDepth - 1), '</li>';
        }

        echo(!$boolFirst ? "\n" : ''), str_repeat("\t", $arSection['RELATIVE_DEPTH_LEVEL']);
        ?>
        <li id="<?= $this->GetEditAreaId($arSection['ID']); ?>" class="category-menu<?= $class_ident; ?>__item">
            <a href="<?= $arSection["SECTION_PAGE_URL"]; ?>">
                <svg viewbox="0 0 10 10" class="category-menu__item-icon">
                    <path
                            d="M.4 5L0 6.9v.2s.1.1.2.1h.6v.4c0 .7.5 1.2 1.2 1.2s1.2-.5 1.2-1.2v-.3c0-.3.3-.6.6-.6H4c.2 0 .4 0 .5.1-.2.2-.3.5-.3.7 0 .4.2.7.6.8v1.5c0 .1 0 .2.2.2 0 0 .1-.1.1-.2V8.3c.3-.1.6-.4.6-.8 0-.3-.1-.5-.3-.7.2-.1.3-.1.5-.1h.3c.3 0 .6.3.6.6v.2c0 .7.5 1.2 1.2 1.2.3 0 .6-.1.8-.3.2-.3.3-.6.3-.9v-.4h.6c.1 0 .1 0 .2-.1 0 0 .1-.1 0-.2L9.5 5c0-.1-.1-.2-.2-.2h-.8s-.1.1-.1.2L8 6.9c-.1.1 0 .1 0 .2 0 0 .1.1.2.1h.6v.4c0 .2-.1.4-.2.6-.2 0-.4.1-.6.1-.5 0-.8-.3-.8-.8v-.2c0-.3-.2-.6-.5-.8.1-.1.1-.2.1-.3V6h.6c.1 0 .1 0 .2-.1v-.2l-.4-2c0-.1-.1-.2-.2-.2h-.8c-.1.1-.1.2-.2.3l-.4 2V6h.8v.2c0 .1-.1.2-.2.2h-.3c-.3 0-.5.1-.7.2V4.4c.2-.1.4-.3.4-.6s-.2-.4-.5-.5v-1c.3-.1.6-.4.6-.7.5 0 1-.4 1-1V.2c0-.1-.1-.2-.2-.2H3.4c-.1 0-.2.1-.2.2v.4c0 .5.4 1 1 1 0 .4.2.7.6.7v1c-.3.1-.4.3-.4.5s.2.5.4.6v2.2c-.3-.2-.5-.2-.8-.2h-.3c-.1 0-.2-.1-.2-.2V6h.6c.1 0 .1 0 .2-.1 0 0 .1-.1 0-.2l-.4-2c0-.1-.1-.2-.2-.2h-.8c-.1 0-.2.1-.2.2l-.4 2v.2c.1.1.2.1.2.1h.6v.2c0 .1 0 .2.1.3-.3.2-.5.5-.5.8v.2c0 .4-.3.8-.8.8s-.7-.3-.7-.8v-.4h.6c.1 0 .1 0 .2-.1 0 0 .1-.1 0-.2L1.5 5c0-.1-.1-.2-.2-.2H.6c-.1 0-.2.1-.2.2z"
                    />
                </svg>
                <?= $arSection["NAME"]; ?>
                <svg viewbox="0 0 6 9">
                    <path d="M0 0.7L3.5 4.4L0 8.4L0.8 9L5 4.4L0.8 0L0 0.7Z"></path>
                </svg>
            </a>

            <?
            $intCurrentDepth = $arSection['RELATIVE_DEPTH_LEVEL'];
            $boolFirst = false;
            }
            unset($arSection);
            while ($intCurrentDepth > 1) {
                echo '</li>', "\n", str_repeat("\t", $intCurrentDepth), '</ul>', "\n", str_repeat("\t", $intCurrentDepth - 1);
                $intCurrentDepth--;
            }
            if ($intCurrentDepth > 0) {
                echo '</li>', "\n";
            }
            ?>
    </ul>
<? } ?>
