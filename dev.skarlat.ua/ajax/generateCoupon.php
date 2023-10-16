<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("sale");
CModule::IncludeModule("catalog");

$USER_ID = $GLOBALS["USER"]->GetID();
$groupDiscountIterator = Bitrix\Sale\Internals\DiscountGroupTable::getList(array(
    'select' => array('DISCOUNT_ID'),
    'filter' => array('@GROUP_ID' => CUser::GetUserGroup($USER_ID), '=ACTIVE' => 'Y')
));
while ($groupDiscount = $groupDiscountIterator->fetch()) {
    $groupDiscount['DISCOUNT_ID'] = (int)$groupDiscount['DISCOUNT_ID'];
    if ($groupDiscount['DISCOUNT_ID'] > 0){
        $arIDS[] = $groupDiscount['DISCOUNT_ID'];
    }
}
if ($arIDS) {
    $discountIterator = Bitrix\Sale\Internals\DiscountTable::getList(array(
        'select' => array(
            "ID", "NAME", "PRIORITY", "SORT", "LAST_DISCOUNT", "UNPACK", "APPLICATION", "USE_COUPONS", "DISCOUNT_VALUE"
        ),
        'filter' => array(
            '@ID' => $arIDS
        ),
        'order' => array(
            "PRIORITY" => "DESC",
            "SORT" => "ASC",
            "ID" => "ASC"
        )
    ));
    while ($discount = $discountIterator->fetch()) {
        if (stripos($discount['NAME'], 'Промокод') !== false) {
            $arIDSFinal[] = $discount['ID'];
        }
    }
}
if($_POST['discountList']=='Y'){?>
    <td width="60%" class="adm-detail-content-cell-l" style="text-align: left">
        <a id="affiliate" <?if($_POST['coupon']!=NULL){?>disabled="" <?}?> class="adm-btn <?if($_POST['coupon']!=NULL){?>disabled<?}?>" title="Сгенерировать партнерский код">Сгенерировать партнерский код</a>
    </td>
    <?if($_POST['coupon']==NULL){?>
        <script>
            $(function() {
                $('#affiliate').click(function (){
                    let discountVal = $("select[name='UF_CLIENT_DISCONT']").val();
                    let userId = <?=$_POST['user']?>;
                    $.ajax({
                        type: "POST",
                        url: '/ajax/generateCoupon.php',
                        data: {"discountList":"N","discountValue":discountVal,"user":userId},
                        success: function (data) {
                            // Вывод текста результата отправки
                            $("input[name='UF_COUPON']").val(data);
                            $("#affiliate").addClass('disabled');
                        }
                    });
                })
            })
        </script>
    <?}
}elseif($_POST['discountList']=='N'){
    $COUPON = CatalogGenerateCoupon();
    foreach ($arIDSFinal as $discountId) {
        $addDb = \Bitrix\Sale\Internals\DiscountCouponTable::add(array(
            'DISCOUNT_ID' => $discountId,
            'COUPON' => $COUPON,
            'TYPE' => \Bitrix\Sale\Internals\DiscountCouponTable::TYPE_MULTI_ORDER,
            'USER_ID' => 0,
            'DESCRIPTION' => $_POST['user']
        ));
    }
//Привязываем промокод к пользователю
    $user = new CUser;
    $fields = array(
        "UF_COUPON" => $COUPON,
    );
    $user->Update($USER_ID, $fields);
    echo $COUPON;

    //Создание внутреннего счета для партнера
    $arFields = Array("USER_ID" => $_POST['user'], "CURRENCY" => 'UAH', "CURRENT_BUDGET" => 0, "NOTES" => $COUPON);
    $accountID = CSaleUserAccount::Add($arFields);
}