<ul class="footer-nav collapse" id="footer-dial">
    <?
    //$arSelect = Array();
    $arSelect = Array("ID", "NAME", "PREVIEW_TEXT", "PROPERTY_FILE_PDF");
    $arFilter = Array("IBLOCK_ID"=>36, "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array(), $arFilter, false, [], $arSelect);
    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
        ?>
        <li class="footer-nav__item">
            <a target="_blank" href="<?=CFile::GetPath($arFields["PROPERTY_FILE_PDF_VALUE"]);?>">
                <?=$arFields['NAME'];?>
            </a>
        </li>
        <?
    }
    ?>
</ul>
