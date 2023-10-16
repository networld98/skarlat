<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader,
    Bitrix\Highloadblock\HighloadBlockTable as HLBT,
    Bitrix\Main\Config\Option;
Loader::includeModule("iblock");
Loader::includeModule("catalog");
Loader::includeModule("sale");

$catalog_iblock = Option::get("maycat.d7dull", "catalog_iblock");
$comparison_hlblock= Option::get("maycat.d7dull", "comparison");
$export_ua = Option::get("maycat.d7dull", "export_ua");
$export_en = Option::get("maycat.d7dull", "export_en");

$iblock = explode(',',$catalog_iblock);

foreach ($iblock as $value) {
    $value = str_replace(' ', '', $value);
    CIBlock::clearIblockTagCache($value);
}

$file = $_SERVER["DOCUMENT_ROOT"].CFile::GetPath($_POST["DOPFILE"]);

$typePrice = 1;
$nofound = 0;
$notPrice = 0;
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
$f = fopen($_SERVER["DOCUMENT_ROOT"].'/local/script/price.log','a');
fwrite($f, date('d.m.Y H:i:s')." Импорт запущен\n");
//Открываем файл, проверяем и формируем массив
$src = fopen($file,'r');
if (!$src) die('File read error');
while (($data = fgetcsv($src, 0, "\t")) !== FALSE) {
    $new[] = explode(';',$data[0]);
}
if ($new==NULL){?>
    <script>
        let formBtn = $('#btn_import');
        let block = $('.import_block');
        formBtn.css('color','#3f4b54');
        formBtn.val('Запустить импорт цен');
        block.css('color','red');
        block.html('<strong>Где файл импорта?</strong>');
    </script>
<?
    die;}
//Удаляем ненужные слова + Удаляем гривну с цены
$unnecessary = array('Свет.Акция ', 'Свет. ', 'Акр. ', 'Арт. ', 'Свет.Акция', 'Свет.', 'Акр.', 'Арт.', 'x');
$replacement = array ('','','','','','','','','×');
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
    $nameSearch = implode(' ' , $nameSearch);
    //Убираем в цене гривну
    if (count((array)$element) == 2){
        $priceBase = trim(str_replace('грн','',$element[1]));
    }else{
        $priceBase = trim(str_replace('грн','',$element[2]));
    }
    //Меняем в цене запятую на точку
    $priceBase = str_replace(',','.', $priceBase);
    //Убираем в цене пробел
    $priceBase = trim(str_replace(' ','', $priceBase));
    //Формируем список
    if ($element[1] == 'шт.' || $element[1] == 'шт') {
        $currency = 'UAH';
    }elseif ($element[1] == 'м.' || $element[1] == 'м'){
        $currency = 'QWE';
    }
    $items[] = array('SEARCH'=> $nameSearch, 'NAME' => $name,'PRICE' =>  $priceBase, 'CURRENCY' => $currency);

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
$el = new CIBlockElement;
$arLoadProductArray = Array();
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
        if($item['NAME']!= 'Найменування товару' && $item['PRICE']!=NULL){
            $found[$arFields['ID']] = array('NAME'=>$arFields['NAME'],'IBLOCK_ID'=>$arFields['IBLOCK_ID'], 'PRICE'=> $item['PRICE'], "CURRENCY" => $item['CURRENCY']);
        }
    }

    if($i==0 || $item['NAME']!='Найменування товару' || $item['NAME']!= 'Наименование'){
        if (!empty($comparison[$item['NAME']])){
            if ($comparison[$item['NAME']]['UA'] == NULL || $comparison[$item['NAME']]['RU'] == NULL) {
                $notPrice++;
            }
            //Присваем цены сопоставленные ранее
            if ($comparison[$item['NAME']]['UA']){
                CPrice::DeleteByProduct($comparison[$item['NAME']]['UA']);
                CPrice::SetBasePrice($comparison[$item['NAME']]['UA'],$item['PRICE'],$item['CURRENCY']);
                $delItem[] = $comparison[$item['NAME']]['UA'];
                print 'Цена '.$item['PRICE'].' на товар ('.$comparison[$item['NAME']]['UA'].') '.$item['NAME'].' (UA) установлена <br>';
            }
            if ($comparison[$item['NAME']]['RU']){
                CPrice::DeleteByProduct($comparison[$item['NAME']]['RU']);
                CPrice::SetBasePrice($comparison[$item['NAME']]['RU'],$item['PRICE'],$item['CURRENCY']);
                $delItem[] = $comparison[$item['NAME']]['RU'];
                print 'Цена '.$item['PRICE'].' на товар ('.$comparison[$item['NAME']]['RU'].') '.$item['NAME'].' (RU) установлена <br>';
            }
        }else{
            $nofound++;
            $entity_data_class = GetEntityDataClass($comparison_hlblock);
            $result = $entity_data_class::add(array(
                'UF_PRODUCT_NAME' => $item['NAME'],
                'UF_ACTIVE'   => '1'
            ));
        }
    }
}

//Присваем цены найденым товарам
foreach ($found as $key => $value){
    if(!in_array($key,$delItem)){
        CPrice::DeleteByProduct($key);
        CPrice::SetBasePrice($key,$value['PRICE'],$value['CURRENCY']);
        unset($allItemsCatalogs[$key]);
        print 'Цена '.$value['PRICE'].' на товар ('.$key.') '.$value['NAME'].' ('.$value['IBLOCK_ID'].') установлена <br>';
    }
}
foreach ($allItemsCatalogs as $key => $item){
    if(!in_array($key,$delItem) && !in_array($key,$found)) {
      /*   $arLoadProductArray = Array("ACTIVE" => "N");*/
         $res = $el->Update($key, $arLoadProductArray);
    }
}

print '<br>Товаров в прайсе: '.(count((array)$items)-1).'<br>';
print 'Сопоставлено товаров: '.(count((array)$items)-count((array)$nofound)-$notPrice).'<br><br>';
print 'Не сопоставленные товары: '.(count((array)$nofound)-1+$notPrice).' (<a target="_blank" href="/bitrix/admin/highloadblock_rows_list.php?ENTITY_ID='.$comparison_hlblock.'&lang=ru">Перейти на страницу сведения</a>)<br><br>';
print 'Деактивировано товаров: '.count((array)$allItemsCatalogs).'<br><br>';
fwrite($f, date('d.m.Y H:i:s')." Импорт завершен\n");
fclose($f);
$static_html_cache = \Bitrix\Main\Data\StaticHtmlCache::getInstance();
$static_html_cache->deleteAll();
CIBlock::clearIblockTagCache($export_en);
CIBlock::clearIblockTagCache($export_ua);
?>
<script>
    let formBtn = $('#btn_import');
    formBtn.css('color','green');
    formBtn.val('Импорт цен завершен:-)');
</script>
