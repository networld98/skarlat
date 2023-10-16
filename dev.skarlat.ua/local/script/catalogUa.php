<?
ini_set("memory_limit", "512M");
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="file.xls"');
header('Cache-Control: max-age=0');

if ('cli' ==  php_sapi_name()){
    $_SERVER["DOCUMENT_ROOT"] = '/home/bitrix/ext_www/dev.skarlat.ua';
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

require $_SERVER['DOCUMENT_ROOT'].'/bitrix/php_interface/lib/phpSpreadsheet/index.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet,
    PhpOffice\PhpSpreadsheet\Writer\Xlsx,
    Bitrix\Highloadblock as HL,
    Bitrix\Main\Config\Option;

CModule::IncludeModule('iblock');
CModule::IncludeModule('highloadblock');

global $colorId;

$site_dir = Option::get("maycat.d7dull", "site_dir");
$colorId = Option::get("maycat.d7dull", "color");
$export_ua = Option::get("maycat.d7dull", "export_ua");
$export_en = Option::get("maycat.d7dull", "export_en");
$no_sections_export= Option::get("maycat.d7dull", "no_sections_export");
$no_sections_export = explode(", ",$no_sections_export);

function getPropHLColor($code){
    $entity_rev_class=getHLColorClass();
    $arFilter = Array(
        'UF_XML_ID'=>$code
    );
    $rsData = $entity_rev_class::getList(
        array(
            'select' => ['ID','UF_NAME'],
            'filter' => $arFilter,
            'order' => ['ID'=>'ASC'],
        )
    );

    while($revinfo=$rsData->fetch()){
        $result=$revinfo['UF_NAME'];
    }
    return $result;
}

function getHLColorClass() {
    global $colorId;
    $hlblock = HL\HighloadBlockTable::getById($colorId)->fetch();
    $entity = HL\HighloadBlockTable::compileEntity($hlblock);
    return $entity->getDataClass();
}

$iblockId = $export_ua;

$arFilter = array('IBLOCK_ID' => $iblockId, 'SECTION_ID' => $no_sections_export);
$rsSections = CIBlockSection::GetList(array('LEFT_MARGIN' => 'ASC'), $arFilter);
while ($arSection = $rsSections->Fetch())
{
    $arSections[]= $arSection['ID'];
}

$arHead['NAME']='Найменування';
$arHead['DETAIL_TEXT']='Опис';
$arHead['CATALOG_QUANTITY']='Кількість';
$arHead['PRICE']='Ціна';
$arHead['SECTION_ID1']='Розділ 1';
$arHead['SECTION_ID2']='Розділ 2';
$arHead['SECTION_ID3']='Розділ 3';
$arHead['SECTION_ID4']='Розділ 4';
$path="https://".$site_dir;
$ibres = CIBlock::GetProperties($iblockId, Array(), Array("ACTIVE"=>"Y"));
$arrNoEx=array("VIDEOS","MORE_PHOTO","PREMIUM","HOT","NEW","SHORT_CATEGORY_NAME_ACTIVE","SHORT_CATEGORY_NAME","ANOTHER_COLOR_PRODUCT","WAY_FOR_PAY","BLOG_POST_ID","BLOG_COMMENTS_CNT","RECOMMEND",'tzvet_');
while($ibarr = $ibres->Fetch()){
    if(in_array($ibarr["CODE"],$arrNoEx)) continue;
    $arHead[$ibarr["CODE"]] = $ibarr["NAME"];
}
$arHead['D3_MODEL']='3D Модель';
$arHead['DETAIL_PICTURE']='Основне зображення товару';
$arHead['MORE_PHOTO1']='Зображення1';
$arHead['MORE_PHOTO2']='Зображення2';
$arHead['MORE_PHOTO3']='Зображення3';
$arHead['MORE_PHOTO4']='Зображення4';
$arHead['MORE_PHOTO5']='Зображення5';
$j=0;
$csv[$j]=$arHead;

$arSpecialCode=array("MORE_PHOTO1","MORE_PHOTO2","MORE_PHOTO3","MORE_PHOTO4","MORE_PHOTO5","SECTION_ID1","SECTION_ID2","SECTION_ID3","SECTION_ID4","D3_MODEL","DETAIL_PICTURE","PRICE",'tsvet');
$arSelect = Array("ID", "NAME", "IBLOCK_ID","DETAIL_TEXT","SECTION_ID","IBLOCK_SECTION_ID","DETAIL_PICTURE","PREVIEW_PICTURE", "CATALOG_GROUP_1", "DETAIL_PAGE_URL", "CATALOG_QUANTITY");
$arFilter = Array("IBLOCK_ID"=>$iblockId, "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
    $j++;
    $elem=array();
    $arFields = $ob->GetFields();
    $arProps = $ob->GetProperties();

    if(!in_array($arFields['IBLOCK_SECTION_ID'],(array)$arSections) && $arFields['CATALOG_QUANTITY']) {
        foreach ($arHead as $key => $fieldes):
            if ($arFields[$key] != '' && !in_array($key, $arSpecialCode)) {
                $elem[$key] = $arFields[$key];
            } elseif ($arProps[$key] != '' && !in_array($key, $arSpecialCode)) {
                $elem[$key] = $arProps[$key]['VALUE'];
            } else {
                if ($key == 'MORE_PHOTO1' && count((array)$arProps['MORE_PHOTO']['VALUE']) > 0) {
                    $i = 1;
                    foreach ($arProps['MORE_PHOTO']['VALUE'] as $val) {
                        if ($i > 5) break;
                        $pic = \CFile::GetPath($val);
                        if ($pic != '') {
                            $elem['MORE_PHOTO' . $i] = $path . $pic;
                            $i++;
                        }
                    }
                    while ($i <= 5) {
                        $elem['MORE_PHOTO' . $i] = "";
                        $i++;
                    }
                } elseif ($key == 'DETAIL_PICTURE' && ($arFields['DETAIL_PICTURE'] > 0 || $arFields['PREVIEW_PICTURE'] > 0)) {
                    $elem['DETAIL_PICTURE'] = $path . \CFile::GetPath(($arFields['DETAIL_PICTURE'] > 0) ? $arFields['DETAIL_PICTURE'] : $arFields['PREVIEW_PICTURE']);
                } elseif ($key == 'D3_MODEL') {
                    $d3path = "";
                    $d3path = CFile::GetPath($arProps[$key]['VALUE']);
                    $elem[$key] = ($d3path != '') ? $path . $d3path : "";
                } elseif ($key == 'SECTION_ID1') {
                    $i = 1;
                    $list = CIBlockSection::GetNavChain(false, $arFields['IBLOCK_SECTION_ID'], array("NAME", "ID", "IBLOCK_ID", "UF_EXPORT_NAME", "DEPTH_LEVEL"), true);
                    foreach ($list as $arSectionPath) {
                        if ($arSectionPath['DEPTH_LEVEL'] > 4 || in_array($arSectionPath['ID'], array(56439))) continue;
                        $elem['SECTION_ID' . $arSectionPath['DEPTH_LEVEL']] = ($arSectionPath["UF_EXPORT_NAME"] != '') ? $arSectionPath["UF_EXPORT_NAME"] : $arSectionPath["NAME"];
                        $i++;
                    }
                    while ($i <= 4) {
                        $elem['SECTION_ID' . $i] = "";
                        $i++;
                    }
                } elseif ($key == 'PRICE') {
                    $elem[$key] = $arFields['CATALOG_PRICE_1'];
                } elseif ($key == 'tsvet') {
                    $elem[$key] = getPropHLColor($arProps[$key]['VALUE']);
                } elseif (!in_array($key, $arSpecialCode)) {
                    $elem[$key] = $arFields[$key];
                }
            }
        endforeach;
        $csv[$j] = $elem;
    }
}

$fp = fopen($_SERVER["DOCUMENT_ROOT"].'/upload/catalogUa.csv', 'w');
foreach($csv as $model)
{
    fputcsv($fp, $model, ";");
}
fclose($fp);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->fromArray($csv, NULL, 'A1');
$writer = new Xlsx($spreadsheet);
ob_start();
$writer->save($_SERVER["DOCUMENT_ROOT"].'/upload/catalogUa.xlsx');
$ret['data'] = base64_encode(ob_get_contents());
ob_end_clean();
print "Обновлен";
exit();
?>