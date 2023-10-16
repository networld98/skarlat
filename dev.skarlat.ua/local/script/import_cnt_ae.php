<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader,
    Bitrix\Highloadblock\HighloadBlockTable as HLBT,
    Bitrix\Main\Config\Option;
Loader::includeModule("iblock");
Loader::includeModule("catalog");
Loader::includeModule("sale");

$catalog_iblock = Option::get("maycat.d7dull", "catalog_iblock_ae");
$comparison_hlblock= Option::get("maycat.d7dull", "comparison");
$black_list_ua = Option::get("maycat.d7dull", "black_list_ua");
$black_list_en = Option::get("maycat.d7dull", "black_list_en");
$export_ua = Option::get("maycat.d7dull", "export_ae_ua");
$export_en = Option::get("maycat.d7dull", "export_ae_en");
$export_ru = Option::get("maycat.d7dull", "export_ae_ru");

$iblock = explode(',',$catalog_iblock);

foreach ($iblock as $value) {
    $value = str_replace(' ', '', $value);
    CIBlock::clearIblockTagCache($value);
}

$file = $_SERVER["DOCUMENT_ROOT"].CFile::GetPath($_POST["DOPFILE"]);
$typePrice = 1;
$cont = 0;
$new = NULL;

//подключаем модуль highloadblock
CModule::IncludeModule('highloadblock');

//Функция получения экземпляра класса:
function GetEntityDataClass($HlBlockId) {
    if (empty($HlBlockId) || $HlBlockId < 1)
    {
        return false;
    }
    $hlblock = HLBT::getById($HlBlockId)->fetch();
    $entity = HLBT::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();
    return $entity_data_class;
}
$entity_data_class = GetEntityDataClass($comparison_hlblock);
$rsData = $entity_data_class::getList(array(
    'order' => array('UF_PRODUCT_NAME'=>'ASC'),
    'select' => array('*'),
    'filter' => array('!UF_PRODUCT_NAME'=>false)
));
while($el = $rsData->fetch()){
    $comparison[$el['UF_PRODUCT_NAME']] = array('UA' => $el['UF_PDODUCT_ID_UA'], 'RU'=> $el['UF_PDODUCT_ID_RU']);
}
//Получаем товары из черного списка
$entity_data_class = GetEntityDataClass($black_list_ua);
$rsData = $entity_data_class::getList(array(
    'select' => array('UF_ELEMENT'),
));
while($el = $rsData->fetch()){
    $all[] = $el['UF_ELEMENT'];
}
$entity_data_class = GetEntityDataClass($black_list_en);
$rsData = $entity_data_class::getList(array(
    'select' => array('UF_ELEMENT'),
));
while($el = $rsData->fetch()){
    $all[] = $el['UF_ELEMENT'];
}
$f = fopen($_SERVER["DOCUMENT_ROOT"].'/local/script/import_cnt.log','a');
fwrite($f, date('d.m.Y H:i:s')." Импорт запущен\n");
//Открываем файл, проверяем и формируем массив
$src = fopen($file,'r');
if (!$src) die('File read error');
while (($data = fgetcsv($src, 0, "\t")) !== FALSE) {
    $new[] = explode(';',$data[0]);
}
if ($new==NULL){?>
    <script>
        let formBtn = $('#btn_import_cnt');
        let block = $('.import_block_cnt');
        formBtn.css('color','#3f4b54');
        formBtn.val('Запустить импорт остатков');
        block.css('color','red');
        block.html('<strong>Где файл импорта?</strong>');
    </script>
<?
    die;}
//Удаляем ненужные слова + Удаляем гривну с цены
$unnecessary = array('>Свет.Акция ', '>Свет. ', '>Акр. ', '>Арт. ', '>Свет.Акция', '>Свет.', '>Акр.', '>Арт.', 'x','>Светильник Свет. ');
$replacement = array ('','','','','','','','','×','');
foreach ($new as $element) {
    //Удаляем лишнее, убираем пробелы в начале и конце
    $name = trim(str_replace($unnecessary,$replacement,$element[0]));
    //Разбваем название на блоки
    $nameSearch = explode(' ',$name);
    //Удаляем ненужное с артикула
    foreach ($nameSearch as $key => $ll) {
        if (strpos($ll,'\\') !== false) {
            unset($nameSearch[$key]);
        }
    }
    //Собираем название для поиска
    //и добавляем защиту от менеджера который любит удалять лишние колонки
    $nameSearch = implode(' ' , $nameSearch);
    if($element[4] == NULL && $element[3] == NULL){
        if (is_numeric($element[1])) {
            $items[] = array('SEARCH' => $nameSearch, 'NAME' => $name, 'CNT' => $element[1]);
        }
    }elseif($element[4] == NULL && $element[3] != NULL){
        if (is_numeric($element[1])) {
            $items[] = array('SEARCH' => $nameSearch, 'NAME' => $name, 'CNT' => $element[3]);
        }
    }else{
        if (is_numeric($element[4])) {
            $items[] = array('SEARCH' => $nameSearch, 'NAME' => $name, 'CNT' => $element[4]);
        }
    }
}

//Получаем список всех товаров на русской и украинской версии
$arSelect = Array('ID');
$arFilter = Array("IBLOCK_ID"=>$iblock);
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $allItemsCatalogs[$arFields['ID']] = '';
}
$obProduct = new CCatalogProduct();
$el = new CIBlockElement;
//Перебираем полученный список и получаем товары которые есть в базе
foreach ($items as $item){
    $i=0;
    $arSelect = Array('IBLOCK_ID','ID','NAME');
    $arFilter = Array("IBLOCK_ID"=>$iblock, "?NAME"=>$item['SEARCH']);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
    while($ob = $res->GetNextElement())
    {
        $i=1;
        $arFields = $ob->GetFields();
        $found[$arFields['ID']] = array('NAME'=>$arFields['NAME'],'IBLOCK_ID'=>$arFields['IBLOCK_ID'], 'CNT'=> $item['CNT']);
    }
       if (!empty($comparison[$item['NAME']]) && $item['CNT']>0){
            //Присваем цены сопоставленные ранее
            if ($comparison[$item['NAME']]['UA'] && $item['CNT']>0 && !in_array($comparison[$item['NAME']]['UA'], $all)){
                $cont++;
                $obProduct->Update($comparison[$item['NAME']]['UA'], ['QUANTITY' => $item['CNT']]);
                print 'Количество '.$item['CNT'].' товара ('.$comparison[$item['NAME']]['UA'].') '.$item['NAME'].' (UA) установлено <br>';
                $delItem[] = $comparison[$item['NAME']]['UA'];
            }
            if ($comparison[$item['NAME']]['RU'] && $item['CNT']>0 && !in_array($comparison[$item['NAME']]['RU'], $all)){
                $cont++;
                $obProduct->Update($comparison[$item['NAME']]['RU'], ['QUANTITY' => $item['CNT']]);
                print 'Количество '.$item['CNT'].' товара ('.$comparison[$item['NAME']]['RU'].') '.$item['NAME'].' (RU) установлено <br>';
                $delItem[] = $comparison[$item['NAME']]['RU'];
            }
        }
}
foreach ($found as $key => $value) {
    if ($value['CNT'] > 0 && !in_array($key, $all)) {
        $obProduct->Update($key, ['QUANTITY' => $value['CNT']]);
        $delItem[] = $key;
        print 'Количество ' . $value['CNT'] . ' на товара (' . $key . ') ' . $value['NAME'] . ' (' . $value['IBLOCK_ID'] . ') установлено <br>';
    }
}
foreach ($delItem as  $item){
    $arLoadProductArray = Array("ACTIVE" => "Y");
    $el->Update($item, $arLoadProductArray);
}
foreach ($allItemsCatalogs as $key => $item){
    if(!in_array($key,$delItem)) {
        $obProduct->Update($key, ['QUANTITY' => 0]);
    /*    $arLoadProductArray = Array("ACTIVE" => "N");
        $el->Update($key, $arLoadProductArray);*/
    }
}
print '<br>Товаров в прайсе: '.(count((array)$items)).'<br>';
print 'Сопоставлено товаров: '.(count((array)$found)+$cont).'<br><br>';
print 'Проигнорировано товаров: '.count((array)$all).'<br><br>';
fwrite($f, date('d.m.Y H:i:s')." Импорт завершен\n");
fclose($f);
$static_html_cache = \Bitrix\Main\Data\StaticHtmlCache::getInstance();
$static_html_cache->deleteAll();
CIBlock::clearIblockTagCache($export_en);
CIBlock::clearIblockTagCache($export_ua);
CIBlock::clearIblockTagCache($export_ru);
?>
<script>
    let formBtn = $('#btn_import_cnt_ae');
    formBtn.css('color','green');
    formBtn.val('Импорт отстаков завершен:-)');
</script>