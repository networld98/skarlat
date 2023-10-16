<?php
define('ADMIN_MODULE_NAME', 'maycat.d7dull');

require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin_before.php';

// @todo: Здесь - какой-то системный код, читающие данные и всё такое

require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_admin_after.php';
CJSCore::Init(array("jquery"));
?>
    <p><a target="_blank" href="/bitrix/admin/highloadblock_rows_list.php?ENTITY_ID=5&lang=ru">Перейти на страницу сведения</a></p>
    <form id="importForm" action="" method="POST">
        <?$APPLICATION->IncludeComponent("bitrix:main.file.input", "drag_n_drop",
            array(
                       "INPUT_NAME"=>"DOPFILE",
                       "MULTIPLE"=>"Y",
                       "MODULE_ID"=>"iblock",
                       "MAX_FILE_SIZE"=>"25000000",//25000000 25mb
                       "ALLOW_UPLOAD"=>"F",
                       "INPUT_CAPTION" => "Добавить файлы",
                       "INPUT_VALUE" => $_POST["DOPFILE"]
                     ),
                     false
        );?>
        <input class="pic" type="text" value="" id="newF">
        <p><input type="submit" value="Запустить импорт цен"></p>
    </form>
    <div class="import_block"></div>
    <script>
        var inp = BX("newF");
        BX.adjust(inp, {props: {value: result.element_id}});
    </script>
<?
require_once $_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_admin.php';
