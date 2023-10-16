<ul class="footer-social">
    <?
    $arSelect = Array("ID", "NAME", "CODE", "PREVIEW_TEXT");
    $arFilter = Array("IBLOCK_ID"=>44, "IBLOCK_SECTION_ID"=> 55856, "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array(), $arFilter, false, [], $arSelect);
    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
        ?>
        <li class="footer-social__item">
            <a target="_blank" href="<?=$arFields['CODE'];?>" title="<?=$arFields['NAME'];?>">
                <div class="footer-social__item-text">
                    <?=$arFields['NAME'];?>
                </div>
                <div class="footer-social__item-icon">
                    <svg viewBox="0 0 20 20">
                        <?=$arFields['PREVIEW_TEXT'];?>
                    </svg>
                </div>
            </a>
        </li>
        <?
    }
    ?>
</ul>
