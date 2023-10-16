<? $arSelect = array("NAME","SECTION_PAGE_URL","PICTURE");
$arFilter = array("IBLOCK_ID"=>$iblCatalog, "DEPTH_LEVEL" => 1,"ACTIVE"=>"Y");
$obSections = CIBlockSection::GetList(array("name" => "asc"), $arFilter, false, $arSelect);
while($ar_result = $obSections->GetNext())
{$file = CFile::ResizeImageGet($ar_result['PICTURE'], array('width'=>307, 'height'=>205), BX_RESIZE_IMAGE_EXACT, true);
    ?>
    <li class="header-tab-content__item animation">
        <a href="<?=$ar_result["SECTION_PAGE_URL"]?>" class="header-tab-content__link">
            <img src="<?=$file["src"]?>" alt="<?=$ar_result["NAME"]?>" class="header-tab-content__img" />
            <span class="header-tab-content__title"><?=$ar_result["NAME"]?></span>
        </a>
    </li>
<?}?>