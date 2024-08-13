<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Highloadblock\HighloadBlockTable as HLBT;
CModule::IncludeModule('highloadblock');

$btn = 0;
$id = $_POST['item_id'];
$block = $_POST['item_block'];
$connection = Bitrix\Main\Application::getConnection();
$sqlHelper = $connection->getSqlHelper();
if($block=='47'){
    $sql = "SELECT ID FROM remainsblacklistua WHERE UF_ELEMENT = '".$id."'";
    $hlblock = 6;
}else if($block=='29') {
    $sql = "SELECT ID FROM remainsblacklistru WHERE UF_ELEMENT = '".$id."'";
    $hlblock = 7;
}

$recordset = $connection->query($sql);

while ($record = $recordset->fetch())
{
    $btn = $record['ID'];
}

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
$entity_data_class = GetEntityDataClass($hlblock);
$rsData = $entity_data_class::getList(array(
    'order' => array(),
    'select' => array('*'),
    'filter' => array()
));
while($el = $rsData->fetch()){
    $ElementID = $el['ID'];
    $ProductID = $el['UF_ELEMENT'];
}
if($btn != 0){
    $entity_data_class = GetEntityDataClass($hlblock);
    $result = $entity_data_class::delete($btn);
    echo '<span style="color:rgb(58, 150, 64);">∅ Добавить в чёрный список</span>';
}else{
    $entity_data_class = GetEntityDataClass($hlblock);
    $result = $entity_data_class::add(array(
        'UF_ELEMENT' => $id,
    ));
    echo '<span style="color:rgb(255, 0, 1);">∅ Удалить из чёрного списка</span>';
}?>