<?
use Bitrix\Sale;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
if($_REQUEST['ORDER_ID']>0){
    $order = Sale\Order::load($_REQUEST['ORDER_ID']);
    $propertyCollection = $order->getPropertyCollection();
    $paymentCollection = $order->getPaymentCollection();
    $somePropValue = $propertyCollection->getItemByOrderPropertyId(45);
    $somePropValue->setValue(date("d.m.Y H:i:s"));
    foreach ($paymentCollection as $key => $payment) {
        $sum = $payment->getSum(); // сумма к оплате
        if (count($paymentCollection) > 1 && $key == 1) {
            $order->setFieldNoDemand('PRICE', $sum);
        }
    }
    $order->save();
}
$APPLICATION->IncludeComponent(
    "bitrix:sale.order.payment",
    "",
    Array(
    )
);
if($_REQUEST['ORDER_ID']>0) {
    $order = Sale\Order::load($_REQUEST['ORDER_ID']);
    $order->doFinalAction(true);
    $order->save();
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>