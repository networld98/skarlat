<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказы");
use Bitrix\Sale;
CModule::IncludeModule('sale');
if($_GET['ORDER']>0):
	$order = Sale\Order::load($_GET['ORDER']);
endif;
?>
<?
if(!$order):
	?>
			<div class="thanks-section">
				<div class="container">
					<div class="row">
						<div class="col-12 col-sm-10 offset-sm-1 col-lg-8 offset-lg-2">
							<div class="thanks-page__wrapper">
								<h1 class="thanks-page__title">Некорректный номер заказа</h1>
							</div>
						</div>
					</div>
				</div>
			</div>
	<?
elseif($order->getUserId()!=$USER->getId()):
	?>
			<div class="thanks-section">
				<div class="container">
					<div class="row">
						<div class="col-12 col-sm-10 offset-sm-1 col-lg-8 offset-lg-2">
							<div class="thanks-page__wrapper">
								<h1 class="thanks-page__title">У Вас нет прав на просмотр данного заказа.</h1>
							</div>
						</div>
					</div>
				</div>
			</div>
	<?
else:
?>
	<div class="thanks-section">
        <div class="container">
          <div class="row">
            <div class="col-12 col-sm-10 offset-sm-1 col-lg-8 offset-lg-2">
              <div class="thanks-page__wrapper">
                <h1 class="thanks-page__title">Спасибо за ваш заказ!</h1>
                <h4 class="thanks-page__subtitle">
                  Номер Вашего заказа
                  <strong>№<?=$order->getId();?></strong>
                </h4>
                <div class="thanks-page__order-detail">
					<?
						$basket = Sale\Order::load($order->getId())->getBasket();
						$basketItems = $basket->getBasketItems();
						foreach ($basket as $basketItem) {
							$ids[]=$basketItem->getField('PRODUCT_ID');
						}
						
						/*$arSelect = Array("ID", "IBLOCK_ID", "NAME", "DETAIL_PICTURE", "PROPERTY_CML2_LINK");
						$arFilter = Array("IBLOCK_ID"=>OFFERS_IBLOCK_ID, "ID"=>$ids);
						$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
						while($ob = $res->fetch()){ 
							$offersId[]=$ob['PROPERTY_CML2_LINK_VALUE'];
							$offerInfo[$ob['ID']]=$ob;
						}*/
						
						$arSelect = Array("ID", "IBLOCK_ID", "NAME", "DETAIL_PICTURE", "PREVIEW_PICTURE", "IBLOCK_SECTION_ID");
						$arFilter = Array("IBLOCK_ID"=>CATALOG_IBLOCK_ID, "ID"=>$offersId);
						$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
						while($ob = $res->fetch()){
							$productInfo[$ob['ID']]=$ob;
							$sects[]=$ob['IBLOCK_SECTION_ID'];
							
						}
						
						$arFilter = array('IBLOCK_ID' => CATALOG_IBLOCK_ID, "ID"=>$sects);
						$rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilter,false,array("ID", "DEPTH_LEVEL", "SECTION_PAGE_URL", "UF_SUBTITLE"));
						while ($arSect = $rsSect->fetch()){
							$sectInfo[$arSect['ID']]=$arSect;
						}
						foreach ($basket as $basketItem):
					?>
						<div class="thanks-page__order_item">
							<div class="thanks-page__order_img">
							  <div class="thanks-page__order_img-wrapper">
								<?
								/*if($offerInfo[$basketItem->getField('PRODUCT_ID')]['DETAIL_PICTURE']>0)
									$pict=$offerInfo[$basketItem->getField('PRODUCT_ID')]['DETAIL_PICTURE'];*/
								if($productInfo[$basketItem->getField('PRODUCT_ID')]['PREVIEW_PICTURE']>0)
									$pict=$productInfo[$basketItem->getField('PRODUCT_ID')]['PREVIEW_PICTURE'];
								elseif($productInfo[$basketItem->getField('PRODUCT_ID')]['DETAIL_PICTURE']>0)
									$pict=$productInfo[$basketItem->getField('PRODUCT_ID')]['DETAIL_PICTURE'];
									
								//printer($productInfo);
								$arFileTmp = CFile::ResizeImageGet(
									$pict,
									array("width" => 80, "height" => 80),
									BX_RESIZE_IMAGE_PROPORTIONAL,
									true
								);
								
								?>
								<img
								  alt="image"
								  class="lazy"
								  src="data:image/gif;base64,R0lGODlhFAAHAIAAAP///wAAACH5BAEAAAEALAAAAAAUAAcAAAIKjI+py+0Po5wUFQA7"
								  data-src="<?=$arFileTmp['src']?>"
								  data-srcset="<?=$arFileTmp['src']?> 1x, <?=$arFileTmp['src']?> 2x"
								  srcset="<?=$arFileTmp['src']?> 1x, <?=$arFileTmp['src']?> 2x"
								/>
							  </div>
							</div>
							<div class="thanks-page__order-description">
							  <p class="thanks-page__order_title-cat"><?=$sectInfo[$productInfo[$offerInfo[$basketItem->getField('PRODUCT_ID')]['PROPERTY_CML2_LINK_VALUE']]['IBLOCK_SECTION_ID']]['UF_SUBTITLE']?></p>
							  <a href="<?=$basketItem->getField("DETAIL_PAGE_URL");?>" class="thanks-page__order_title"><?=$basketItem->getField('NAME')?></a>
							  <div class="thanks-page__order-price-new">
								<?=$basketItem->getQuantity()?> x <?=$basketItem->getPrice();?>
								<div class="thanks-page__order-price-new_currency">грн</div>
							  </div>
							</div>
						</div>
					<?endforeach;?>
                </div>
				<?
					$propertyCollection = $order->getPropertyCollection();
					$phone = $propertyCollection->getPhone();
				?>
                <ul class="thanks-page__order-data">
                  <li class="thanks-page__order-data_item">
                    Вы успешно оформили заказ на номер<strong class="ml-2"><?=$phone->getValue()?></strong>
                  </li>

                  <li class="thanks-page__order-data_item thanks-page__order-data_item-price">
                    Итого к оплате —
                    <div class="thanks-page__order-data_item-price_new">
						<?=$order->getPrice();?>
						<div class="thanks-page__order-data_item-price_new-currency">грн</div>
                    </div>
                  </li>

                  <li class="thanks-page__order-data_item thanks-page__order-data_item-lk">
                    Статус вашего заказа вы можете отслеживать в
                    <a href="/ru/personal/"> личном кабинетe</a>
                  </li>

					<?
					$somePropValue = $propertyCollection->getItemByOrderPropertyId(45);
					$lastPay=$somePropValue->getValue();
					
					$paymentCollection = $order->getPaymentCollection();
					$onePayment = $paymentCollection[0];
					$psID = $order->getField('PAY_SYSTEM_ID');
					if($psID=='7'):
						
						if($lastPay!=''){
							$diff=date_diff(new DateTime(), new DateTime($lastPay))->i;
						}else{
							$diff=99;
						}
						if($diff>5){
					?>
							<li>
								<a class="product-detail__btn-buy btn-main cart-button" style="height:auto;" href="/personal/order/result/payment.php?ORDER_ID=<?=$_GET['ORDER']?>">Оплатить</a>
							</li>
						<?}else{?>
							<li style="color:red;">
								Ожидаем подтверждения оплаты
							</li>
						<?}?>
					<?endif;?>
                </ul>
				
               
					
				
                <div class="thanks-page__order-btn-by">
                  <a class="next-buy" href="/ru/catalog/">Продолжить покупки</a>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
<?endif;?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>