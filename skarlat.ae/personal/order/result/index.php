<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Order");
use Bitrix\Sale;
CModule::IncludeModule('sale');
if($_GET['ORDER']>0):
    $order = Sale\Order::load($_GET['ORDER']);
endif;
if(!$order):
    global $USER;
    if ($USER->IsAuthorized()){
        header('Location: /personal/cart/');
    }else{?>
        <div class="order-block-head-wrap">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="order-block-head">
                            <h2><strong><?=$_SESSION['email']?></strong>&nbsp;already registered,</h2>
                            <h3>log in to place an order</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?$APPLICATION->IncludeComponent("bitrix:system.auth.authorize", "order", array(
            "REGISTER_URL" => "register.php",
            "FORGOT_PASSWORD_URL" => "change.php",
            "PROFILE_URL" => "profile.php",
            "SHOW_ERRORS" => "Y"
        ));
    }?>
<?
else:
    ?>
    <div class="order-block-head-wrap">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="order-block-head">
                        <h2>Thank you for your order!</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?
    ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="thanks-block justify-content-center ptb">
                    <h4 class="thanks-page__subtitle">
                        Your order number <strong>#<?=$order->getId();?></strong>
                    </h4>
                    <?
                    $propertyCollection = $order->getPropertyCollection();
                    $paymentCollection = $order->getPaymentCollection();
                    $phone = $propertyCollection->getPhone();
                    $resultPrice = $order->getPrice()-$paymentCollection->getPaidSum();
                    ?>
                    <ul class="thanks-page__order-data">
                        <li class="thanks-page__order-data_item">
                            You have successfully placed an order for the number<strong class="ml-2"><?=$phone->getValue()?></strong>
                        </li>
                        <li class="thanks-page__order-data_item thanks-page__order-data_item-price">
                            The total to be paid is <strong><?= $resultPrice?> EUR</strong>
                        </li>

                        <li class="thanks-page__order-data_item thanks-page__order-data_item-lk">
                            You can track the status of your order at
                            <strong><a href="<?=SITE_DIR?>personal/"> personal account</a></strong>
                        </li>
                    </ul>

                    <div class="controls">
                        <?
                        $somePropValue = $propertyCollection->getItemByOrderPropertyId(45);
                        $lastPay=$somePropValue->getValue();

                        $paymentCollection = $order->getPaymentCollection();
                        $onePayment = $paymentCollection[0];
                        $psID = $order->getField('PAY_SYSTEM_ID');
                        if($psID=='7' && $resultPrice>0):
                            header('Location: https://'.$_SERVER['SERVER_NAME'].SITE_DIR.'/personal/order/result/payment.php?ORDER_ID='.$_GET['ORDER']);
                            if($lastPay!=''){
                                $diff=date_diff(new DateTime(), new DateTime($lastPay))->i;
                            }else{
                                $diff=99;
                            }
                            if($diff>5){
                                ?>
                                <a class="product-detail__btn-buy btn-main cart-button primary" style="height:auto;" href="/personal/order/result/payment.php?ORDER_ID=<?=$_GET['ORDER']?>">Оплатити</a>
                            <?}else{?>
                                <span style="color:red;">
                                We are waiting for payment confirmation
                                </span>
                            <?}?>
                        <?endif;?>
                        <a class="primary" href="/catalog/">Сontinue shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?endif;?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
