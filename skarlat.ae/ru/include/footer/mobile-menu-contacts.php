<ul class="mob-nav-contacts">
    <?
    $arSelect = Array("ID", "NAME", "CODE", "DETAIL_TEXT", "PROPERTY_WORKTIME");
    $arFilter = Array("IBLOCK_ID"=>31, "IBLOCK_SECTION_ID"=>79, "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(array("ID"=>"DESC"), $arFilter, false, [], $arSelect);
    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
        ?>
        <li>
            <a href="<?=$arFields['CODE'];?>">
                <svg class="mob-menu-icon" viewBox="0 0 20 20">
                    <?=$arFields['DETAIL_TEXT'];?>
                </svg>
                <span><?=$arFields['NAME'];?></span>
                <p><?=$arFields['PROPERTY_WORKTIME_VALUE'];?></p>
            </a>
        </li>
        <?
    }
    ?>
</ul>
