<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
Bitrix\Main\Loader::includeModule("sale");

CSaleOrder::CancelOrder($_POST['id'], 'Y', 'Отменен из личного кабинета пользователем');