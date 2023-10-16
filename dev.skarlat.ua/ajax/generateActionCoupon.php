<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Config\Option;

$sms_login = COption::GetOptionString('imaginweb.sms', 'username2');
$sms_pass =  COption::GetOptionString('imaginweb.sms', 'password2');
$sms_originator = COption::GetOptionString('imaginweb.sms', 'originator2');
$sms_gate = COption::GetOptionString('imaginweb.sms', 'gate');
$action_sms_send = Option::get("maycat.d7dull", "action_sms_send");

$COUPON = CatalogGenerateCoupon();
$addDb = \Bitrix\Sale\Internals\DiscountCouponTable::add(array(
    'DISCOUNT_ID' => $_POST['id'],
    'COUPON' => $COUPON,
    'TYPE' => \Bitrix\Sale\Internals\DiscountCouponTable::TYPE_ONE_ORDER,
    'USER_ID' => 0,
    'DESCRIPTION' => $_POST['phone']
));
?>
<p style="font-size: 16px;">Ви отримуєте:</p>
<?echo $_POST["name"][$_POST['id']];?>

<?
if($action_sms_send == "Y") {
    if(CModule::IncludeModule("imaginweb.sms")) {
        $arParams = array(
            'GATE' 		=> $sms_gate,
            'LOGIN'		=> $sms_login,
            'PASSWORD'	=> $sms_pass,
            'ORIGINATOR' => $sms_originator
        );
        $sms = new CIWebSMS;
        $phone = $_POST['phone'];
        $message = 'Your promo code: ' . $COUPON;
        $sms->Send($phone, $message, $arParams);
        print_r($sms->return_mess);
    }
  ?>
    <p style="font-size: 16px;margin-top:20px;">На ваш номер телефону було надіслано<br>SMS-повідомлення з промокод</p>
<?}else{?>
    <p style="font-size: 16px;">Ваш промокод:</p>
    <span id="copyTarget"><?echo $COUPON;?></span>
<?}?>