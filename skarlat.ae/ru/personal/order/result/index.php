<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказ");
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
                        <h2><strong><?=$_SESSION['email']?></strong>&nbsp;вже зареєстрований,</h2>
                        <h3>авторизуйтесь для оформлення замовлення</h3>
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
                        <h2>Дякуємо за ваше замовлення!</h2>
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
                        Номер Вашого замовлення <strong>№<?=$order->getId();?></strong>
                    </h4>
                    <?
                    $propertyCollection = $order->getPropertyCollection();
                    $paymentCollection = $order->getPaymentCollection();
                    $phone = $propertyCollection->getPhone();
                    $resultPrice = $order->getPrice()-$paymentCollection->getPaidSum();
                    ?>
                    <ul class="thanks-page__order-data">
                        <li class="thanks-page__order-data_item">
                            Вы оформили заказ на номер<strong class="ml-2"><?=$phone->getValue()?></strong>
                        </li>
                        <li class="thanks-page__order-data_item thanks-page__order-data_item-price">
                            Всего к уплате — <strong><?= $resultPrice?> AED.</strong>
                        </li>

                        <li class="thanks-page__order-data_item thanks-page__order-data_item-lk">
                            Статус вашего заказа вы можете отследить в
                            <strong><a href="<?=SITE_DIR?>personal/"> личном кабинете</a></strong>
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
                            header('Location: https://'.$_SERVER['SERVER_NAME'].SITE_DIR.'personal/order/result/payment.php?ORDER_ID='.$_GET['ORDER']);
                            if($lastPay!=''){
                                $diff=date_diff(new DateTime(), new DateTime($lastPay))->i;
                            }else{
                                $diff=99;
                            }
                            if($diff>5){
                                ?>
                                    <a class="product-detail__btn-buy btn-main cart-button primary" style="height:auto;" href="<?=SITE_DIR?>personal/order/result/payment.php?ORDER_ID=<?=$_GET['ORDER']?>">Оплатити</a>
                            <?}else{?>
                                <span style="color:red;">
                                    Ожидаем подтверждения оплаты
                                </span>
                            <?}?>
                        <?endif;?>
                        <a class="primary" href="<?=SITE_DIR?>catalog/">Продолжить покупки</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?endif;?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
