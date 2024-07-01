<?
ini_set("memory_limit", "512M");

if ('cli' ==  php_sapi_name()){
    $_SERVER["DOCUMENT_ROOT"] = '/home/bitrix/ext_www/dev.skarlat.ua';
}
require($_SERVER["DOCUMENT_ROOT"].'/bitrix/modules/main/include/prolog_before.php');

require_once($_SERVER['DOCUMENT_ROOT'].'/local/script/Delivery/NovaPoshtaApi2.php');

use LisDev\Delivery\NovaPoshtaApi2;
$np = new NovaPoshtaApi2(
    'cf114057215df364f51bc7ef9f96d834cf114057215df364f51bc7ef9f96d834',
    'ru', // Язык возвращаемых данных: ru (default) | ua | en
    FALSE, // При ошибке в запросе выбрасывать Exception: FALSE (default) | TRUE
    'curl' // Используемый механизм запроса: curl (defalut) | file_get_content
);
global $USER;
$iblockId = 53;
$cities = $np->getCities();
$sections = [];
/*
$bs = new CIBlockSection;
$arSelect = array("ID","DESCRIPTION","NAME");
$arFilter = array("IBLOCK_ID"=>$iblockId,"ACTIVE"=>"Y");
$obSections = CIBlockSection::GetList(array("name" => "asc"), $arFilter,array(), $arSelect);
while($ar_result = $obSections->GetNext())
{
    $activeElements = CIBlockSection::GetSectionElementsCount($ar_result['ID'], Array("CNT_ACTIVE"=>"Y"));
    if($activeElements==0) {
        if(!mb_strstr($ar_result['NAME'], '(') && !mb_strstr($ar_result['NAME'], ')') && !mb_strstr($ar_result['NAME'], '\'')) {
            $sections[$ar_result['ID']] = $ar_result['DESCRIPTION'];
        }else{
            $arLoadProductArray = array("ACTIVE" => "N");
            $bs->Update($ar_result['ID'], $arLoadProductArray);
        }
    }
}*/
/*
$arrayCities = [];
foreach ($cities['data'] as $city){
    if(!in_array($city['CityID'],$sections)){
        if(!in_array($city['Description'],$arrayCities)){
            $arrayCities[$city['CityID']] = array('NAME'=> $city['Description'], 'CITY' => $city['Description'], 'AREA' => $city['AreaDescription']);
        }else{
            $arrayCities[$city['CityID']] = array('NAME'=> $city['Description'].'('.$city['AreaDescription'].')','CITY' => $city['Description'], 'AREA' => $city['AreaDescription']);
        }
    }
}

$bs = new CIBlockSection;
foreach ($arrayCities as $key => $city){
    if(!in_array($key,$sections)){
        $arFields = Array(
           "ACTIVE" => 'Y',
           "IBLOCK_SECTION_ID" => false,
           "IBLOCK_ID" => $iblockId,
           "NAME" => $city['NAME'],
           "SORT" => 500,
           "DESCRIPTION" => $key.";".$city['CITY'].";".$city['AREA'],
       );
       $ID = $bs->Add($arFields);
    }
}
$elements = [];
$arSelect = array("NAME","IBLOCK_SECTION_ID");
$arFilter = array("IBLOCK_ID"=>$iblockId);
$res = CIBlockElement::GetList(Array("name" => "asc"), $arFilter, false, Array(), $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $elements[$arFields['IBLOCK_SECTION_ID']][] = $arFields['NAME'];
}

$el = new CIBlockElement;
foreach ($sections as $key => $section){
        $data = explode(';', $section);
        $city = $data[1];
        $area = $data[2];
       $cityNp = $np->getCity($city, $area);
        $result = $np->getWarehouses($cityNp['data'][0]['Ref']);
        foreach ($result['data'] as $warehouse) {
            if (!in_array(str_replace('"', '', $warehouse['Description']), $elements[$key]) && !mb_strstr($warehouse['Description'], 'Почтомат') && !mb_strstr($warehouse['Description'], 'Поштомат')) {
                $arLoadProductArray = array(
                    "MODIFIED_BY" => $USER->GetID(), // элемент изменен текущим пользователем
                    "IBLOCK_SECTION_ID" => $key,          // элемент лежит в корне раздела
                    "IBLOCK_ID" => $iblockId,
                    "NAME" => str_replace('"', '', $warehouse['Description']),
                    "ACTIVE" => "Y",            // активен
                );
                $el->Add($arLoadProductArray);
            unset($warehouse);
            }
        }
    unset($key);
    unset($result);
    unset($city);
    unset($area);
}*/
print "Обновление отделений завершено:-) (Укр)";
?>
<script>
    let formBtn = $('.import_block_ua');
    formBtn.css('color','green');
</script>

