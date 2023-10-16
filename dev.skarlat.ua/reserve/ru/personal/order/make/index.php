<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказы");

use Bitrix\Main\Loader,
    Bitrix\Main\Config\Option,
    Bitrix\Sale,
    Bitrix\Sale\Order,
    Bitrix\Main\Application,
    Bitrix\Sale\DiscountCouponsManager;

	CModule::IncludeModule("catalog");
	CModule::IncludeModule("sale");
	CModule::IncludeModule("iblock");
if(basketItemsCount()>0):
	if($_POST["ordered"]=='Y' && check_bitrix_sessid()){
		$registeredUserID=$USER->getId();

		$request = Application::getInstance()->getContext()->getRequest();
		$siteId = \Bitrix\Main\Context::getCurrent()->getSite();
		$currencyCode = Option::get('sale', 'default_currency', 'UAH');
		DiscountCouponsManager::init();

		$basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
		$basket->save();

		$order = Order::create($siteId, $registeredUserID);
		\Bitrix\Sale\Compatible\DiscountCompatibility::stopUsageCompatible();
		$order->setPersonTypeId(3);

		$basket = Sale\Basket::loadItemsForFUser(\CSaleBasket::GetBasketUserID(), Bitrix\Main\Context::getCurrent()->getSite())->getOrderableItems();
		$order->setBasket($basket);
		$order->doFinalAction(true);
		$fullprice = $basket->getPrice();

		/*Shipment*/
		$db_dtype = CSaleDelivery::GetList(array("SORT" => "ASC","NAME" => "ASC"),array("LID" => SITE_ID,"ACTIVE" => "Y",),	false,false,array());
		while ($ptype = $db_dtype->Fetch()){
			$name_delivery[$ptype['ID']]=$ptype['NAME'];
			$deliv_price[$ptype['ID']]=$ptype['PRICE'];
		}

		$shipmentCollection = $order->getShipmentCollection();
		$shipment = $shipmentCollection->createItem();
		$shipment->setFields(array(
			'DELIVERY_ID' => $_POST['ORDER']['DELIVERY']['TYPE'],
			'DELIVERY_NAME' => $name_delivery[$_POST['ORDER']['DELIVERY']['TYPE']],
		));
		$shipmentItemCollection = $shipment->getShipmentItemCollection();
		foreach ($order->getBasket() as $item)
		{
			$shipmentItem = $shipmentItemCollection->createItem($item);
			$shipmentItem->setQuantity($item->getQuantity());

			$shipmentItemStoreCollection = $shipmentItem->getShipmentItemStoreCollection();
			$basketItem = $shipmentItem->getBasketItem();

			$shipmentItemStore = $shipmentItemStoreCollection->createItem($basketItem);

			$barcode = array(
				'ORDER_DELIVERY_BASKET_ID' => $shipmentItem->getId(),
				'STORE_ID' => STORAGE_STORE_MAIN_ID,
				'QUANTITY' => $item->getQuantity()
			);
			$setFieldResult = $shipmentItemStore->setFields($barcode);
		}

		$db_ptype = CSalePaySystem::GetList($arOrder = Array("SORT"=>"ASC", "PSA_NAME"=>"ASC"), Array("LID"=>SITE_ID, "ACTIVE"=>"Y", "PERSON_TYPE_ID"=>1));
		while ($ptype = $db_ptype->Fetch()){
			$name_pay[$ptype["ID"]]=$ptype["PSA_NAME"];
		}
		$paymentCollection = $order->getPaymentCollection();
		$extPayment = $paymentCollection->createItem();
			
			$basket = \Bitrix\Sale\Basket::loadItemsForFUser(
				   \Bitrix\Sale\Fuser::getId(),
				   \Bitrix\Main\Context::getCurrent()->getSite()
				);
				
				foreach ($basket as $item){
					$bitems[]=$item->getField('PRODUCT_ID');
				}
				$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", "PROPERTY_WAY_FOR_PAY");
				$arFilter = Array("IBLOCK_ID"=>29, "PROPERTY_WAY_FOR_PAY_VALUE"=>"Y", "ID"=>$bitems);
				$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
				while($ob = $res->fetch())
				{
					$bitemsAllowed[]=$ob['ID'];
				}
				if(count($bitemsAllowed)==count($bitems))
					$paysys=$_POST['ORDER']['PAYMENT'];
				else
					$paysys=5;
			
			$extPayment->setFields(array(
				'PAY_SYSTEM_ID' => $paysys,
				'PAY_SYSTEM_NAME' => $name_pay[$paysys],
				'SUM' => $order->getPrice()
			));

		$oprice=$order->getPrice();
		/**/
		$order->doFinalAction(true);
		$propertyCollection = $order->getPropertyCollection();

		foreach ($propertyCollection->getGroups() as $group)
		{
			foreach ($propertyCollection->getGroupProperties($group['ID']) as $property)
			{
				$p = $property->getProperty();
				if($_POST['ORDER']['DELIVERY']['TYPE']!=18):
					switch ($p["CODE"]) {
						case "STREET":
							$property->setValue(htmlspecialcharsEx($_POST['ORDER']['DELIVERY'][$_POST['ORDER']['DELIVERY']['TYPE']]["STREET"]));
							break;
						case "HOUSE":
							$property->setValue(htmlspecialcharsEx($_POST['ORDER']['DELIVERY'][$_POST['ORDER']['DELIVERY']['TYPE']]["HOUSE"]));
							break;
						case "FLAT":
							$property->setValue(htmlspecialcharsEx($_POST['ORDER']['DELIVERY'][$_POST['ORDER']['DELIVERY']['TYPE']]["FLAT"]));
							break;
						case "NP_OFFICE":
							break;
						default:

							$property->setValue(htmlspecialcharsEx($_POST['ORDER']['PROPS'][$p["CODE"]]));
							break;
					}
				else:
					switch ($p["CODE"]) {
						case "NP_OFFICE":
							$property->setValue(htmlspecialcharsEx($_POST['ORDER']['PROPS']["NP_OFFICE"]));
							break;
						case "STREET":
							break;
						case "FLAT":
							break;
						case "HOUSE":
							break;
						default:

							$property->setValue(htmlspecialcharsEx($_POST['ORDER']['PROPS'][$p["CODE"]]));
							break;
					}
				endif;
			}
		}



		$comment = $request["ORDER"]['COMMENT'];
		if ($comment):
			$order->setField('USER_DESCRIPTION', $comment); // Устанавливаем поля комментария покупателя
		endif;

		$order->save();
		$orderId = $order->GetId();
		LocalRedirect('/ru/personal/order/result/?ORDER='.$orderId);
	}

?>
		<div class="row">

          <!-- LEFT BLOCK START -->
          <div class="col-12 col-lg-6 col-xl-7 order-column">
			<form method="POST" action="" id="order-form">

			<?=bitrix_sessid_post()?>
            <h1 class="order-column-title">Оформление заказа</h1>

            <!-- ORDER BLOCK USER INFO START -->
            <div class="order-block order-block__info">
              <div class="order-block__title">
                <h3>Контактные данные</h3>
              </div>
              <div class="order-block__info-body">
				<?if(!$USER->isAuthorized()):?>
					<ul class="nav nav-pills order-block__info-body_user" id="pills-tab" role="tablist">
					  <li class="order-block__info-body_user-item">
						<a
						  class="nav-link active order-block__info-body_user-link"
						  id="pills-new-user-tab"
						  data-toggle="pill"
						  href="#pills-new-user"
						  role="tab"
						  aria-controls="pills-new-user"
						  aria-selected="true"
						  >Я новый покупатель</a
						>
					  </li>
					  <li class="order-block__info-body_user-item">
						<a
						  class="nav-link order-block__info-body_user-link"
						  id="pills-user-tab"
						  data-toggle="pill"
						  href="#pills-user"
						  role="tab"
						  aria-controls="pills-user"
						  aria-selected="false"
						  >Я постоянный клиент</a
						>
					  </li>
					</ul>
				<?endif;?>
                <div class="tab-content order-block__info-tab-content" id="pills-tabContent">
                  <div
                    class="tab-pane fade show active"
                    id="pills-new-user"
                    role="tabpanel"
                    aria-labelledby="pills-new-user-tab"
                  >
					<?if($USER->isAuthorized()):?>
						<?
							$order = array('sort' => 'asc');
							$tmp = 'sort';
							$filter = array('ID' => $USER->getId());
							$select = array("SELECT" => array("UF_PUSH_TOKEN", "UF_SEND_EMAIL", "UF_SEND_SMS", "UF_SEND_PUSH","NAME","SECOND_NAME","LAST_NAME","PERSONAL_PHONE"));
							$rsUsers = CUser::GetList($order, $tmp, $filter, $select);
							while ($arUser = $rsUsers->Fetch()) {
								$arResult['USER_DATA']=$arUser;
								$ufio=$arUser['LAST_NAME']." ".$arUser['NAME']." ".$arUser['SECOND_NAME'];
								$uphone=$arUser['PERSONAL_PHONE'];
								$uemail=$arUser['EMAIL'];
							}

						?>
						<div class="form-group">
							<label for="InputName-reg-order">Имя</label>
							<input type="text" class="form-control" name="ORDER[PROPS][FIO]" required="required" id="InputName-reg-order" value="<?=$ufio?>" placeholder="Введите имя" />
						</div>
						<div class="form-group">
							<label for="InputTel-reg-order">Телефон</label>
							<input type="text" class="form-control" name="ORDER[PROPS][PHONE]" required="required" id="InputTel-reg-order" value="<?=$uphone?>" placeholder="Введите телефон" />
						</div>
						<div class="form-group">
							<label for="InputEmail-reg-order">Email</label>
							<input
							  type="email"
							  name="ORDER[PROPS][EMAIL]"
							  class="form-control"
							  id="InputEmail-reg-order"
							  placeholder="Введите email"
							  value="<?=$uemail?>"
							  required="required"
							/>
						</div>
					<?else:?>
							<?$APPLICATION->IncludeComponent(
								"bitrix:main.register",
								"",
								Array(
									"AUTH" => "Y",
									"REQUIRED_FIELDS" => array("EMAIL", "NAME", "PERSONAL_PHONE"),
									"SET_TITLE" => "N",
									"SHOW_FIELDS" => array("EMAIL", "NAME", "PERSONAL_PHONE"),
									"SUCCESS_PAGE" => "/ru/personal/order/make/",
									"USER_PROPERTY" => array(),
									"USER_PROPERTY_NAME" => "",
									"USE_BACKURL" => "Y"
								)
							);?>
					<?endif;?>
                  </div>
					<?if(!$USER->isAuthorized()):?>
						<div class="tab-pane fade" id="pills-user" role="tabpanel" aria-labelledby="pills-user-tab">
							 <?$APPLICATION->IncludeComponent(
								"bitrix:main.auth.form",
								"skarlat",
								Array(
									"AUTH_FORGOT_PASSWORD_URL" => "",
									"AUTH_REGISTER_URL" => "",
									"AUTH_SUCCESS_URL" => "/ru/personal/order/make/"
								)
							);?>
						</div>
					<?endif;?>
                </div>
              </div>
            </div>
            <!-- ORDER BLOCK USER INFO END -->
            <?if($USER->isAuthorized()):?>
            <!-- ORDER BLOCK DELIVERY INFO START -->
            <div class="order-block order-block__delivery">
              <div class="order-block__title">
                <h3>Доставка</h3>
              </div>
                <div class="accordion" id="delivery-acardion">
                  <div class="order-block__delivery-item">
                    <label for="autocompleteCity" class="order-block__delivery-autocomplete-label">Ваш город</label>
                      <div class="select-city form-group">
                          <?$APPLICATION->IncludeComponent(
                              "bitrix:sale.location.selector.search",
                              "custom",
                              Array(
                                  "COMPONENT_TEMPLATE" => ".default",
                                  "ID" => "18",
                                  "CODE" => "",
                                  "INPUT_NAME" => "ORDER[PROPS][CITY]",
                                  "PROVIDE_LINK_BY" => "id",
                                  "JSCONTROL_GLOBAL_ID" => "",
                                  "JS_CALLBACK" => "",
                                  "FILTER_BY_SITE" => "Y",
                                  "SHOW_DEFAULT_LOCATIONS" => "Y",
                                  "CACHE_TYPE" => "A",
                                  "CACHE_TIME" => "36000000",
                                  "FILTER_SITE_ID" => "s1",
                                  "INITIALIZE_BY_GLOBAL_EVENT" => "",
                                  "SUPPRESS_ERRORS" => "N"
                              )
                          );?>
                      </div>
					<input type="hidden" value="Y" name="ordered">
                    <div class="order-block__delivery-way-group" id="ajaxHelpCities">
                      <a href="javascript:void(0)" onclick="setCity(18);" class="order-block__delivery-way">Киев</a>
                      <a href="javascript:void(0)" onclick="setCity(2256);" class="order-block__delivery-way">Одесса</a>
                      <a href="javascript:void(0)" onclick="setCity(25736);" class="order-block__delivery-way">Харьков</a>
                      <a href="javascript:void(0)" onclick="setCity(20724);" class="order-block__delivery-way">Днепр</a>
                      <a href="javascript:void(0)" onclick="setCity(6746);" class="order-block__delivery-way">Львов</a>
                    </div>
                  </div>
				<?
					$db_dtype = CSaleDelivery::GetList(
						array(
							"SORT" => "ASC",
							"NAME" => "ASC"
						),
						array(
							"LID" => SITE_ID,
							"ACTIVE" => "Y",
						),
						false,
						false,
						array()
					);
					if ($ar_dtype = $db_dtype->Fetch()){
						do{?>
							<?if($ar_dtype['ID']==18):?>
								<div class="order-block__delivery-item">
									<div class="order-block__delivery-item-header">
									  <input
										class="checkbox delivery-val"
										type="radio"
										name="ORDER[DELIVERY][TYPE]"
										id="order-block__delivery-item-<?=$ar_dtype['ID']?>"
										data-toggle="collapse"
										data-target="#order-block__delivery-item-<?=$ar_dtype['ID']?>-description"
										aria-controls="order-block__delivery-item-<?=$ar_dtype['ID']?>-description"
										value="<?=$ar_dtype['ID']?>"
										required="required"
										onclick="changeDelivery(<?=$ar_dtype['ID']?>);"
										data-price="<?=$ar_dtype['PRICE']?>"
									  />
									  <label for="order-block__delivery-item-<?=$ar_dtype['ID']?>">
										<?=$ar_dtype['NAME']?> <span class="not-allowed">(не доступно)</span>
									  </label>
									</div>
									<div
									  class="collapse order-block__delivery-item-description"
									  id="order-block__delivery-item-<?=$ar_dtype['ID']?>-description"
									  data-parent="#delivery-acardion"
									>
									  <div class="form-group">
										<label for="selectPost">Выберите отделение</label>
										<div id="npoffice-container">
											<select class="form-control" name="ORDER[DELIVERY][NP_OFFICE]" id="selectPost">
												<option>Укажите город</option>
											</select>
										</div>
									  </div>
									  <small>
										<?=$ar_dtype['DESCRIPTION']?>
									  </small>
									</div>
								</div>
							<?else:?>
								<div class="order-block__delivery-item">
									<div class="order-block__delivery-item-header">
									  <input
										class="checkbox delivery-val"
										type="radio"
										name="ORDER[DELIVERY][TYPE]"
										id="order-block__delivery-item-<?=$ar_dtype['ID']?>-cur"
										data-toggle="collapse"
										data-target="#order-block__delivery-item-<?=$ar_dtype['ID']?>-cur-description"
										aria-controls="order-block__delivery-item-<?=$ar_dtype['ID']?>-cur-description"
										value="<?=$ar_dtype['ID']?>"
										required="required"
										onclick="changeDelivery(<?=$ar_dtype['ID']?>);"
										data-price="<?=$ar_dtype['PRICE']?>"
									  />
									  <label for="order-block__delivery-item-<?=$ar_dtype['ID']?>-cur">
										<?=$ar_dtype['NAME']?> <span class="not-allowed">(не доступно)</span>
									  </label>
									</div>

									<div
									  id="order-block__delivery-item-<?=$ar_dtype['ID']?>-cur-description"
									  class="collapse order-block__delivery-item-description"
									  data-parent="#delivery-acardion"
									>
									  <div class="form-group">
										<input type="text" class="form-control delivery-unstable" <?if($arResult['USER_DATA']['WORK_ZIP']==$ar_dtype['ID']):?>value="<?=$arResult['USER_DATA']['PERSONAL_STREET']?>"<?endif;?> data-delivery="<?=$ar_dtype['ID']?>" name="ORDER[DELIVERY][<?=$ar_dtype['ID']?>][STREET]"  placeholder="Введите улицу" />
									  </div>

									  <div class="form-group form-group-row">
										<div class="form-group w-50 mr-2">
										  <input type="text" class="form-control delivery-unstable" <?if($arResult['USER_DATA']['WORK_ZIP']==$ar_dtype['ID']):?>value="<?=$arResult['USER_DATA']['PERSONAL_STATE']?>"<?endif;?> data-delivery="<?=$ar_dtype['ID']?>" name="ORDER[DELIVERY][<?=$ar_dtype['ID']?>][HOUSE]" placeholder="№ дома" />
										</div>

										<div class="form-group w-50 ">
										  <input type="text" class="form-control delivery-unstable" <?if($arResult['USER_DATA']['WORK_ZIP']==$ar_dtype['ID']):?>value="<?=$arResult['USER_DATA']['PERSONAL_ZIP']?>"<?endif;?> data-delivery="<?=$ar_dtype['ID']?>" name="ORDER[DELIVERY][<?=$ar_dtype['ID']?>][FLAT]" placeholder="№ квартиры" />
										</div>
									  </div>
									  <small>
										<?=$ar_dtype['DESCRIPTION']?>
									  </small>
									</div>
								</div>
								<?endif;?>
								<?
						}
						while ($ar_dtype = $db_dtype->Fetch());
					}
					else{
						echo "Доступных способов доставки не найдено<br>";
					}
					?>
					<?if($arResult['USER_DATA']['WORK_ZIP']>0 && $arResult['USER_DATA']['WORK_ZIP']!=18):?>
							<script>
								$(document).ready(function(){
									$('#order-block__delivery-item-<?=$arResult["USER_DATA"]["WORK_ZIP"]?>-cur').click();
									$('#order-block__delivery-item-<?=$arResult["USER_DATA"]["WORK_ZIP"]?>-cur-description').addClass('show');
									$('#selectCity').change();
								});
							</script>
						<?elseif($arResult['USER_DATA']['PERSONAL_NOTES']!=''):?>
							<script>
								$(document).ready(function(){
									$('#order-block__delivery-item-<?=$arResult["USER_DATA"]["WORK_ZIP"]?>').click();
									$('#order-block__delivery-item-<?=$arResult["USER_DATA"]["WORK_ZIP"]?>-description').addClass('show');
									getNPOffices($('#autocompleteCity').val(),"<?=$arResult['USER_DATA']['PERSONAL_NOTES']?>");
								});
							</script>
						<?endif;?>
                </div>
            </div>
            <!-- ORDER BLOCK DELIVERY INFO END -->
            <!-- ORDER BLOCK PAY INFO START -->
            <div class="order-block order-block__pay">
              <div class="order-block__title">
                <h3>Оплата</h3>
              </div>
                <div class="form-group">
                  <input class="checkbox" required="required" type="radio" name="ORDER[PAYMENT]" id="pay-cash" value="5" />
                  <label for="pay-cash">
                    Наличными
                  </label>
                </div>
                <?/*<div class="form-group">
                  <input class="checkbox" required="required" type="radio" name="ORDER[PAYMENT]" id="pay-online" value="6" />
                  <label for="pay-online">
                    Оплата картой
                  </label>
                </div>*/?>
				<?
				$basket = \Bitrix\Sale\Basket::loadItemsForFUser(
				   \Bitrix\Sale\Fuser::getId(),
				   \Bitrix\Main\Context::getCurrent()->getSite()
				);
				
				foreach ($basket as $item){
					$bitems[]=$item->getField('PRODUCT_ID');
				}
				$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", "PROPERTY_WAY_FOR_PAY");
				$arFilter = Array("IBLOCK_ID"=>29, "PROPERTY_WAY_FOR_PAY_VALUE"=>"Y", "ID"=>$bitems);
				$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
				while($ob = $res->fetch())
				{
					$bitemsAllowed[]=$ob['ID'];
				}
				if(count($bitemsAllowed)==count($bitems))
					$allowwfp=true;
				else
					$allowwfp=false;
				?>
				<?//if($allowwfp && $USER->isAdmin()):?>
					<div class="form-group">
						<input class="checkbox" required="required" type="radio" name="ORDER[PAYMENT]" id="pay-forway" value="7" />
						<label for="pay-forway">
							<?/*WayForPay*/?>Оплата картой
						</label>
					</div>
				<?//endif;?>
            </div>
            <!-- ORDER BLOCK PAY INFO END -->
            <!-- ORDER BLOCK DETAIL INFO START -->
            <div class="order-block order-block__pay">
              <div class="order-block__title">
                <h3>Детали заказа</h3>
              </div>

                <div class="form-group">
                  <input type="checkbox" class="checkbox" id="add-coment" />
                  <label for="add-coment">Добавить комментарий к заказу</label>
                </div>

                <textarea
                  class="form-control"
                  id="add-coment-place"
                  rows="3"
                  placeholder="Примечания к заказу"
                  disabled="disabled"
				  name="ORDER[COMMENT]"
                ></textarea>

                <div class="form-group">
                  <input type="checkbox" class="checkbox" name="ORDER[PROPS][NO_CALL]" value="Y" id="no-recall" />
                  <label for="no-recall">Не звонить для подтверждения заказа</label>
                </div>

            </div>
            <!-- ORDER BLOCK DETAIL INFO END -->
            <?endif;?>
			<button type="submit" id="falseButton"></button>
			</form>
          </div>

          <!-- LEFT BLOCK END -->
          <!-- RIGHT BLOCK START -->
          <div class="col-12 col-lg-6 col-xl-5 order-column">
            <h2 class="order-column-title">Ваша покупка</h2>
<?else:?>
	<div class="row">
	<div class="col-12 order-column">
<?endif;?>
				<?$APPLICATION->IncludeComponent(
					"bitrix:sale.basket.basket",
					"sticky",
					Array(
						"ACTION_VARIABLE" => "basketAction",
						"ADDITIONAL_PICT_PROP_26" => "-",
						"ADDITIONAL_PICT_PROP_27" => "-",
						"ADDITIONAL_PICT_PROP_29" => "-",
						"ADDITIONAL_PICT_PROP_30" => "-",
						"AUTO_CALCULATION" => "Y",
						"BASKET_IMAGES_SCALING" => "adaptive",
						"COLUMNS_LIST_EXT" => array("PREVIEW_PICTURE","DELETE","SUM","PROPERTY_ARTNUMBER"),
						"COLUMNS_LIST_MOBILE" => array("PREVIEW_PICTURE","DELETE","SUM","PROPERTY_ARTNUMBER"),
						"COMPATIBLE_MODE" => "Y",
						"CORRECT_RATIO" => "Y",
						"DEFERRED_REFRESH" => "N",
						"DISCOUNT_PERCENT_POSITION" => "bottom-right",
						"DISPLAY_MODE" => "extended",
						"EMPTY_BASKET_HINT_PATH" => "/catalog/",
						"GIFTS_BLOCK_TITLE" => "Выберите один из подарков",
						"GIFTS_CONVERT_CURRENCY" => "N",
						"GIFTS_HIDE_BLOCK_TITLE" => "N",
						"GIFTS_HIDE_NOT_AVAILABLE" => "N",
						"GIFTS_MESS_BTN_BUY" => "Выбрать",
						"GIFTS_MESS_BTN_DETAIL" => "Подробнее",
						"GIFTS_PAGE_ELEMENT_COUNT" => "4",
						"GIFTS_PLACE" => "BOTTOM",
						"GIFTS_PRODUCT_PROPS_VARIABLE" => "prop",
						"GIFTS_PRODUCT_QUANTITY_VARIABLE" => "quantity",
						"GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
						"GIFTS_SHOW_OLD_PRICE" => "N",
						"GIFTS_TEXT_LABEL_GIFT" => "Подарок",
						"HIDE_COUPON" => "Y",
						"LABEL_PROP" => array(),
						"PATH_TO_ORDER" => "/ru/personal/order/make/",
						"PRICE_DISPLAY_MODE" => "Y",
						"PRICE_VAT_SHOW_VALUE" => "N",
						"PRODUCT_BLOCKS_ORDER" => "props,sku,columns",
						"QUANTITY_FLOAT" => "N",
						"SET_TITLE" => "Y",
						"SHOW_DISCOUNT_PERCENT" => "Y",
						"SHOW_FILTER" => "N",
						"SHOW_RESTORE" => "N",
						"TEMPLATE_THEME" => "blue",
						"TOTAL_BLOCK_DISPLAY" => array("bottom"),
						"USE_DYNAMIC_SCROLL" => "Y",
						"USE_ENHANCED_ECOMMERCE" => "Y",
						"USE_GIFTS" => "N",
						"USE_PREPAYMENT" => "N",
						"USE_PRICE_ANIMATION" => "Y"
					)
				);?>
          </div>
          <!-- RIGHT BLOCK END -->
        </div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
