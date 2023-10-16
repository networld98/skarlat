<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Config\Option;

$describe = Option::get("maycat.d7dull", "describe");
$accrued = Option::get("maycat.d7dull", "accrued");

global $USER;
$userId = $_POST['user'];

if($_POST['save'] == "Y"){
    //сохраняем вывод
    $el = new CIBlockElement;
    $arLoadProductArray = Array(
        "MODIFIED_BY"    => $USER->GetID(),
        "ACTIVE"         => "Y",
    );

    $PRODUCT_ID = $_POST['id'];
    $res = $el->Update($PRODUCT_ID, $arLoadProductArray);

}?>
<?//получаем начисление
$arFieldsSumm = 0;
$arSelect = array("PROPERTY_SUMA_DISCONT","TIMESTAMP_X","ACTIVE");
$arFilter = array("IBLOCK_ID"=>$accrued, "PROPERTY_USER_ID" => $userId);
$res = CIBlockElement::GetList(Array("TIMESTAMP_X" => "asc"), $arFilter, false, Array(), $arSelect);
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $arFieldsSumm = $arFieldsSumm + $arFields["PROPERTY_SUMA_DISCONT_VALUE"];
}?>
        <tr class="bonus-info-list">
            <td width="40%" class="adm-detail-content-cell-l">Бонусов на рахунку:</td>
            <td width="60%" class="adm-detail-content-cell-r">
                <span><?echo round(CSaleUserAccount::GetByUserID($userId, "UAH")['CURRENT_BUDGET'],0);?> грн.</span>
            </td>
        </tr>
        <tr class="bonus-info-list">
            <td width="40%" class="adm-detail-content-cell-l">Усього нараховано:</td>
            <td width="60%" class="adm-detail-content-cell-r">
                <span><?=round($arFieldsSumm,0)?> грн.</span>
            </td>
        </tr>
            <?//получаем списание
            $arFieldsSumm = 0;
            $arSelect = array("PROPERTY_SUMM","PROPERTY_METHOD","TIMESTAMP_X","ACTIVE","ID","NAME");
            $arFilter = array("IBLOCK_ID"=>$describe, "PROPERTY_USER_ID" => $userId);
            $res = CIBlockElement::GetList(Array("TIMESTAMP_X" => "desc"), $arFilter, false, Array(), $arSelect);
            while($ob = $res->GetNextElement())
            {
                $arFields = $ob->GetFields();
                if($arFields["ACTIVE"] == 'Y') {
                    $arFieldsSumm = $arFieldsSumm + $arFields["PROPERTY_SUMM_VALUE"];
                }
                ?>
                    <tr class="bonus-info-list">
                        <input type="hidden" value="0" name="UF_ZAPROS_<?=$arFields["ID"]?>">
                        <label>
                            <td width="40%" class="adm-detail-content-cell-r" style="text-align: right">
                                <input type="checkbox" name="UF_ZAPROS_<?=$arFields['ID']?>" id="UF_ZAPROS_<?=$arFields['ID']?>" <?if($arFields["ACTIVE"]=="Y"){?>disabled checked="true" value="1"<?}?> class="adm-designed-checkbox"><label class="adm-designed-checkbox-label zapros-admin-checker" data-user="<?=$userId?>" data-id="<?=$arFields['ID']?>" data-price="<?= round($arFields['PROPERTY_SUMM_VALUE'],0)?>" for="UF_ZAPROS_<?=$arFields["ID"]?>" title=""></label>
                        </td>
                        <td width="60%" class="adm-detail-content-cell-r">
                            <?=$arFields["NAME"]?> сума: <?= round($arFields["PROPERTY_SUMM_VALUE"],0)?> грн.
                        </td>
                        </label>
                    </tr>
                <?}?>
        <tr class="bonus-info-list">
            <td width="40%" class="adm-detail-content-cell-l">Усього виведено:</td>
            <td width="60%" class="adm-detail-content-cell-r">
                <span><?=round($arFieldsSumm,0)?> грн.</span>
            </td>
        </tr>
<?
if($_POST['save'] == "Y") {
    $rsUser = CUser::GetByID($userId);
    $arUser = $rsUser->Fetch();

    $arEventFields = array(
        "NAME" => $arUser['NAME'],
        "LAST_NAME" => $arUser['LAST_NAME'],
        "EMAIL" => $arUser['EMAIL'],
        "BONUS" => round($arFields['PROPERTY_SUMM_VALUE'], 0),
        "METHOD" => $arFields["PROPERTY_METHOD_VALUE"],
        "SERVER_NAME" => "skarlat.ua"
    );
    CEvent::Send("CONFIRMATION_WRITING_BONUSES", $arUser['LID'], $arEventFields, "N");
}
?>
<script>
    $(document).ready(function () {
        $('.zapros-admin-checker').click(function () {
            let price = $(this).data('price');
            let id = $(this).data('id');
            let userId = $(this).data('user');
            const result = confirm('Ви вивели '+price+' грн. поточному користувачеві?');
            if (result) {
                //Сохраняем вывод
                $.ajax({
                    type: "POST",
                    url: '/ajax/generatePartnerAdmin.php',
                    data: {"user":userId,"save":"Y","id":id},
                    success: function (data) {
                        // Вывод текста результата отправки
                        $('.bonus-info-list').remove();
                        $('#tr_cedit1_csection2').parent().append(data);
                    }
                });
                alert('Гроші списані з рахунку користувача!!!');
                $(this).prop('checked', false);
            }
        })
    });
</script>