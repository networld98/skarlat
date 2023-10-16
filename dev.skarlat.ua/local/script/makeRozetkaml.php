<?
ini_set("memory_limit", "512M");
if ('cli' ==  php_sapi_name()){
    $_SERVER["DOCUMENT_ROOT"] = '/home/bitrix/ext_www/dev.skarlat.ua';
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$iblockId=29; $active = ""; $noSections = "";

CModule::IncludeModule('iblock');
$dom = new domDocument("1.0", "utf-8");
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$full = $dom->createElement("yml_catalog");
$full->setAttribute("date", date('d-m-Y H:i'));
$body = $dom->createElement("shop");
$bodyname = $dom->createElement("name","Skarlat");
$bodycomp = $dom->createElement("company","Skarlat");
$bodycurrs = $dom->createElement("currencies");
$bodycurr = $dom->createElement("currency");
$bodycurr->setAttribute("id", "UAH");
$bodycurr->setAttribute("rate","1");
$bodycurrs->appendChild($bodycurr);
$body->appendChild($bodyname);
$body->appendChild($bodycomp);
$body->appendChild($bodycurrs);
$noSections=array(51210);
$sections = $dom->createElement("categories");
$arFilter=array(
    'IBLOCK_ID' => $iblockId,
    'ACTIVE' => "Y",
    "!ID"=>array(56439,51210)
);
$rsSect = \CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilter,false,array("ID","IBLOCK_ID","NAME","SECTION_ID","UF_EXPORT_NAME") );

while($arSect = $rsSect->Fetch())
{
    $allSects[$arSect['ID']]=$arSect['NAME'];
    $section = $dom->createElement("category",$arSect['NAME']);
    $section->setAttribute("id", $arSect['ID']);
    if($arSect['SECTION_ID']>1) $section->setAttribute("parentId", $arSect['SECTION_ID']);
    $sections->appendChild($section);

    $arExportSect[$arSect['ID']]=$arSect['UF_EXPORT_NAME'];

}
$body->appendChild($sections);

$elements = $dom->createElement("offers");
$arSelect = Array("ID", "NAME", "IBLOCK_ID","DETAIL_TEXT","SECTION_ID","IBLOCK_SECTION_ID","DETAIL_PICTURE","PREVIEW_PICTURE", "CATALOG_GROUP_1", "DETAIL_PAGE_URL");
$arFilter = Array("IBLOCK_ID"=>$iblockId, "ACTIVE"=>"Y", '!IBLOCK_SECTION_ID'=>$noSections);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $arProps = $ob->GetProperties();

    if($arFields['DETAIL_PICTURE']=='' && $arFields['PREVIEW_PICTURE']=='' || $arFields['CATALOG_PRICE_1']<1) continue;

    $element = $dom->createElement("offer");
    $element->setAttribute("id", $arFields['ID']);
    $element->setAttribute("available", 'true');
    $element->appendChild($dom->createElement("name",trim($arExportSect[$arFields['IBLOCK_SECTION_ID']]." ".$arFields['NAME'])));
    $element->appendChild($dom->createElement("url","https://skarlat.ua".$arFields['DETAIL_PAGE_URL']));
    if($arFields['DETAIL_TEXT']!=''):
        $cdata=$dom->createCDATASection($arFields['DETAIL_TEXT']);
        $detail_text=$dom->createElement("description");
        $detail_text->appendChild($cdata);
        $element->appendChild($detail_text);
    endif;
    $subsections = $dom->createElement("categoryId",$arFields['IBLOCK_SECTION_ID']);
    $element->appendChild($subsections);
    if($arFields['DETAIL_PICTURE']>0):
        $medias = $dom->createElement("picture","https://skarlat.ua".CFile::GetPath($arFields['DETAIL_PICTURE']));
        $element->appendChild($medias);
    elseif($arFields['PREVIEW_PICTURE']>0):
        $medias = $dom->createElement("picture","https://skarlat.ua".CFile::GetPath($arFields['PREVIEW_PICTURE']));
        $element->appendChild($medias);
    endif;
    $i=1;
    foreach($arProps['MORE_PHOTO']['VALUE'] as $pict):
        if($i==10) break;
        $medias = $dom->createElement("picture","https://skarlat.ua".CFile::GetPath($pict));
        $element->appendChild($medias);
    endforeach;
    $element->appendChild($dom->createElement('price',$arFields['CATALOG_PRICE_1']));
    foreach($arProps as $prop):
        if($prop['SORT']==404 || $prop['VALUE']=='') continue;
        $value = $prop['VALUE'];
        if (is_numeric($value)) {
            // Если $value является числом, просто присвоим его без кавычек
            $param = $dom->createElement('param', $value);
        } else {
            // Иначе, преобразуем в JSON и убираем кавычки для Unicode-символов
            $jsonValue = json_encode($value, JSON_UNESCAPED_UNICODE);

            // Убираем кавычки для чисел, оставляем только для строк
            $jsonValue = preg_replace('/"(\\d+|true|false)"/', '$1', $jsonValue);

            $param = $dom->createElement('param',  str_replace('"', '', $jsonValue));
        }
        $param->setAttribute("name", $prop['NAME']);
        $element->appendChild($param);
    endforeach;

    $element->appendChild($dom->createElement('vendor','Skarlat'));
    $element->appendChild($dom->createElement('currencyId','UAH'));
    $element->appendChild($dom->createElement('stock_quantity','10'));


    $elements->appendChild($element);
}

$body->appendChild($elements);
$full->appendChild($body);

$dom->appendChild($full);
$dom->save("/home/bitrix/ext_www/skarlat.ua/upload/rozetka_catalog.xml");
print "отработал";