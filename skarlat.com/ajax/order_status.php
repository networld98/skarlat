<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
Bitrix\Main\Loader::includeModule("sale");

$result = \Bitrix\Sale\Internals\OrderChangeTable::getList(array(
    'order'=>array('DATE_CREATE'=>'ASC'),
    'filter'=>array('ORDER_ID'=>$_POST['id'])
));
while($historyItem = $result->fetch()){
    if ( $historyItem['TYPE'] == "ORDER_STATUS_CHANGED" ||  $historyItem['TYPE'] == "ORDER_ADDED") {
        preg_match('/"([^"]+)"/', explode(";",$historyItem['DATA'])[1], $statusId);
        if (empty($statusId)){
            $statusId[1]='N';
        }
        $arStatus = CSaleStatus::GetByID($statusId[1]);
        ?>
        <li data-status="<?=$statusId[1]?>" class="history-list-order__item"><time class="data"><span><?=FormatDate('d.m.Y', $historyItem['DATE_CREATE'])?></span><span class="time"><?=FormatDate('H:i', $historyItem['DATE_CREATE'])?></span></time> <span class="status"><?=$arStatus['NAME']?></span></li>
       <?
    }
}