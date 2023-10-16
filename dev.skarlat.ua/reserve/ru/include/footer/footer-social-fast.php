<ul class="vidget-list">
<?
    $arSelect = Array("ID", "NAME", "CODE", "PREVIEW_TEXT");
    $arFilter = Array("IBLOCK_ID"=>31, "IBLOCK_SECTION_ID"=>55645, "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array(), $arFilter, false, [], $arSelect);
    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
        ?>
        <li class="vidget-item">
            <a target="_blank" href="<?=$arFields['CODE'];?>" title="<?=$arFields['NAME'];?>">
                <svg viewBox="0 0 20 20">
                    <?=$arFields['PREVIEW_TEXT'];?>
                </svg>
                <?=$arFields['NAME'];?>
            </a>
        </li>
        <?
    }
    ?>
</ul>
