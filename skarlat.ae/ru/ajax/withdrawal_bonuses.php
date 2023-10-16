<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Config\Option;

$describe = Option::get("maycat.d7dull", "describe");

global $USER;?>
<?if($_POST['way'] == 2507) {
    $way = 'Готівка';
}elseif($_POST['way'] == 2508) {
    $way = 'На карту';
} ?>
<?if(empty($_POST['sum'])){?>

    <div class="info">
        <span>У вас на балансі</span>
        <h4><?echo round(CSaleUserAccount::GetByUserID($USER->GetID(), "UAH")['CURRENT_BUDGET'],0);?></h4>
    </div>
    <form id="form_clinic" name="form_clinic" action="" method="post">
        <input type="hidden" name="userId" value="<?=$USER->GetID() ?>">
        <div class="row">
            <div class="col-lg-6">
                <label for="sum">Сума:</label>
                <input type="number" min="100" max="<?echo round(CSaleUserAccount::GetByUserID($USER->GetID(), "UAH")['CURRENT_BUDGET'],0);?>"  name="sum">
            </div>
            <div class="col-lg-6">
                <label>Спосіб виведення:</label>
                <div class="radio-block">
                    <label for="way"><input type="radio" name="way" checked value="2508"/><span>На карту</span></label>
                    <label for="way"><input type="radio" name="way" value="2507"/><span>Готівка</span></label>
                </div>
            </div>
            <div class="col-lg-12 card-client-block">
                <label for="sum">Номер карти:</label>
                <input type="text" name="clientCard">
            </div>
        </div>
        <button class="primary" type="submit" name="saveProfile">Запросить</button>
    </form>
    <script>
        $(document).ready(function() {
            $("input[name='clientCard']").inputmask("9999-9999-9999-9999");
            $(".radio-block input").change(function (){
                if ($(this).val() == 2508){
                    $(".card-client-block").show();
                }else{
                    $(".card-client-block").hide();
                }
            });
            $("#form_clinic").submit(function () {
                let formID = $(this).attr('id');
                let formNm = $('#' + formID);
                let formMs = $("#modalBonus .modal-body");
                $.ajax({
                    type: "POST",
                    url: '/ajax/withdrawal_bonuses.php',
                    data: formNm.serialize(),
                    success: function (data) {
                        // Вывод текста результата отправки
                        $('button.modal-info__icon').remove();
                        $('.modal-header h2').remove();
                        $(formMs).html(data);
                    }
                });
                return false;
            });
        });
    </script>
<?}else {
    $el = new CIBlockElement;
    $PROP = array();
    $PROP['USER_ID'] = $_POST['userId'];
    $PROP['SUMM'] = $_POST['sum'];
    $PROP['METHOD'] = $_POST['way'];
    $PROP['CARD'] = $_POST['clientCard'];

    $arLoadProductArray = array(
        "MODIFIED_BY" => $USER->GetID(),
        "IBLOCK_SECTION_ID" => false,
        "IBLOCK_ID" => $describe,
        "PROPERTY_VALUES" => $PROP,
        "NAME" => "Запит на списання (" . $_POST['userId'] . ") " . date("d.m.y"),
        "ACTIVE" => "N",
    );
    $el->Add($arLoadProductArray);

    $rsUser = CUser::GetByID($_POST['userId']);
    $arUser = $rsUser->Fetch();

    $arEventFields= array(
        "ID" => $_POST['userId'],
        "NAME" => $arUser['NAME'],
        "LAST_NAME" => $arUser['LAST_NAME'],
        "EMAIL" => $arUser['EMAIL'],
        "BONUS" => round($_POST['sum'],0),
        "METHOD" => $way,
        "CARD" => $_POST['clientCard'],
        "SERVER_NAME" => "dev.skarlat.ua"
    );
    CEvent::Send("REQUEST_TO_DELETE_BONUSES", $arUser['LID'], $arEventFields, "N");

    //Списание суммы с личного счёта
    if (!CSaleUserAccount::UpdateAccount(
        $_POST['userId'],
        (-$_POST['sum']),
        "UAH",
        "MANUAL",
        $_POST['userId']
    ));
    ?>
    <div class="info" style="padding: 10px 10px 40px;line-height: 1.5;">
        <h6>
            Запит на виведення <?=$_POST['sum'];?>грн. (<?=$way?>) надіслано менеджеру.
        </h6>
    </div>
<?}?>