<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Новый раздел");
?>

<?
$IBLOCK_ID = 29;
$TARGETIB_ID = 65;

if(CModule::IncludeModule("iblock"))
{

    $res = CIBlock::GetByID($IBLOCK_ID);
    if($ar_res = $res->Fetch()) {
        //echo "<pre>"; print_r($ar_res); echo "</pre>";
    }
    $proplist = CIBlockProperty::GetList(Array("SORT"=>"ASC"), Array("IBLOCK_ID"=>$IBLOCK_ID));
    while ($ar_property = $proplist->GetNext())
    {
        $arFields = Array();
        $ar_enum_list = Array();
        $is_property = CIBlockProperty::GetByID($ar_property["ID"]);
        if($ar_prop = $is_property->Fetch()) {
            $id=$ar_prop["ID"];
            unset($ar_prop["ID"]);
            unset($ar_prop["XML_X"]);
            unset($ar_prop["TIMESTAMP_X"]);
            $ar_prop["IBLOCK_ID"] = $TARGETIB_ID;
            $arFields = $ar_prop;

            $db_enum_list = CIBlockProperty::GetPropertyEnum($id, Array("SORT"=>"ASC"), Array());
            while($ar_enum_list = $db_enum_list->Fetch())
            {
                unset($ar_enum_list["ID"]);
                unset($ar_enum_list["PROPERTY_ID"]);
                unset($ar_enum_list["XML_ID"]);
                unset($ar_enum_list["TMP_ID"]);
                unset($ar_enum_list["EXTERNAL_ID"]);
                $arFields["VALUES"][] = $ar_enum_list;
            }

            $ibp = new CIBlockProperty;
            $PropID = $ibp->Add($arFields);

            /*echo "<div style='margin: 10px; border:1px dashed #990000; padding:15px;'><pre>";
            print_r($arFields);
            echo "</pre></div>";   */
        }
    }
}
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>