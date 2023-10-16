<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Персональный раздел");
if(check_bitrix_sessid()){
	if($_POST['save_profile']=='Y'){
		$user = new CUser;
		$user->Update($USER->getId(), $_POST['USER']);
		$errors['USER']=$user->LAST_ERROR;
		unset($_POST['USER']);
		LocalRedirect("");
	}
	if($_POST['change_password']=='Y'){
		if(isUserPassword($USER->getId(),$_POST['PASSWD']['OLD'])){
			$user = new CUser;
			$fields = Array(
                "PASSWORD"          => $_POST['PASSWD']['NEW'],
                "CONFIRM_PASSWORD"  => $_POST['PASSWD']['CONFIRM'],
            );
            $user->Update($USER->GetID(), $fields);
			$errors['PASSWD'][]=$user->LAST_ERROR;
		}else{
			$errors['PASSWD'][]="Неверный пароль!";
		}
		unset($_POST['PASSWD']);
	}
	if($_POST['save_delivery']=='Y'){
		if($_POST['DELIVERY']['TYPE']==18):
			$usr = new CUser();
			$usr->Update($USER->getId(), ["PERSONAL_CITY"=>$_POST['DELIVERY']['cityName'],'PERSONAL_NOTES'=>$_POST['ORDER']['PROPS']['NP_OFFICE'],'WORK_ZIP'=>$_POST['DELIVERY']['TYPE']]);
		else:
			$usr = new CUser();
			$usr->Update($USER->getId(), [
				"PERSONAL_CITY"=>$_POST['DELIVERY']['cityName'],
				'WORK_ZIP'=>$_POST['DELIVERY']['TYPE'],
				'PERSONAL_STREET'=>$_POST['DELIVERY'][$_POST['DELIVERY']['TYPE']]['STREET'],
				'PERSONAL_STATE'=>$_POST['DELIVERY'][$_POST['DELIVERY']['TYPE']]['HOUSE'],
				'PERSONAL_ZIP'=>$_POST['DELIVERY'][$_POST['DELIVERY']['TYPE']]['FLAT']
				]
			);
		endif;
		LocalRedirect("?tab=delivery");
	}
}
if($USER->isAuthorized()):
	$arResult['NO_ACCESS']=false;
	global $USER;
	$filter = Array("ID" => $USER->getId());
	$rsUsers = CUser::GetList(($by = "NAME"), ($order = "desc"), $filter);
	while ($arUser = $rsUsers->Fetch()) {
		$arResult['USER_DATA']=$arUser;
	}

	$arSelect = Array("ID", "IBLOCK_ID", "NAME", "PREVIEW_TEXT", "CODE");
	$arFilter = Array("IBLOCK_ID"=>35,"ACTIVE"=>"Y");
	$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, $arSelect);
	while($ob = $res->fetch()){
		$arResult['QUESTIONS'][]=$ob;
	}
endif;
?>
	 <div class="container">
		<div class="row no-gutters">
		<?if($USER->isAuthorized()):

		?>
			<div class="col-xl-2 col-lg-3 col-md-12 ">
				<!-- NAV LK START -->
				<div class="nav-lk__wrapper">
				  <!-- AVATAR USER STATRT -->
				  <div class="nav-lk__avatar">
					<div class="nav-lk__avatar-wrapper">
					  <svg viewBox="0 0 20 20">
						<path
						  fill-rule="evenodd"
						  d="M10 0c2.7 0 5.2 1.1 7 2.9s3 4.3 3 7.1c0 2.7-1.1 5.2-2.9 7s-4.3 3-7.1 3-5.3-1.1-7.1-2.9S0 12.8 0 10s1.1-5.3 2.9-7.1S7.2 0 10 0zm4.5 13c-.6-.6-1.5-1.1-2.4-1.5.9-.6 1.6-1.7 1.6-3 0-2-1.6-3.7-3.7-3.7-2 .1-3.7 1.7-3.7 3.7 0 1.3.6 2.4 1.6 3-.9.4-1.7.9-2.4 1.5-.9 1-1.5 2.2-1.8 3.4 0 0 0-.1-.1-.1C2 14.7 1 12.4 1 10c0-2.5 1-4.7 2.6-6.4C5.3 2.1 7.5 1.1 10 1.1c2.4 0 4.7 1 6.3 2.6C18 5.3 19 7.5 19 10c0 2.4-1 4.7-2.7 6.3l-.1.1c-.1-1.2-.8-2.4-1.7-3.4zm-9.8 4.2c.2-2.8 2.5-5 5.4-5 2.8 0 5.1 2.2 5.3 5C13.8 18.3 12 19 10 19s-3.8-.7-5.3-1.8zm5.3-5.9c-1.5 0-2.7-1.2-2.7-2.7S8.5 5.9 10 5.9c1.4 0 2.7 1.1 2.7 2.7s-1.2 2.7-2.7 2.7z"
						/>
					  </svg>
					</div>
					<div class="nav-lk__avatar-name">
						<?=$arResult['USER_DATA']['LAST_NAME']." ".$arResult['USER_DATA']['NAME']." ".$arResult['USER_DATA']['SECOND_NAME']?>
					</div>
				  </div>
				  <!-- AVATAR USER END -->
				  <!-- NAV STATRT -->
				  <ul class="nav nav-pills nav-lk__pills" id="nav-pills-tab" role="tablist">
					<li class="nav-lk__pills-item">
					  <a
						class="nav-lk__pills-link <?if($_GET['tab']=="" || $_GET['tab']=="profile"):?>active<?endif;?>"
						id="pills-info-tab"
						data-toggle="pill"
						href="#pills-info"
						role="tab"
						aria-controls="pills-info"
						aria-selected="true"
						onclick="addTab('tab','profile');"
					  >
						<p>Профиль</p>
						<div class="nav-lk__pills-item-icon">
						  <svg viewBox="0 0 20 20">
							<path
							  fill-rule="evenodd"
							  d="M10 0c2.7 0 5.2 1.1 7 2.9s3 4.3 3 7.1c0 2.7-1.1 5.2-2.9 7s-4.3 3-7.1 3-5.3-1.1-7.1-2.9S0 12.8 0 10s1.1-5.3 2.9-7.1S7.2 0 10 0zm4.5 13c-.6-.6-1.5-1.1-2.4-1.5.9-.6 1.6-1.7 1.6-3 0-2-1.6-3.7-3.7-3.7-2 .1-3.7 1.7-3.7 3.7 0 1.3.6 2.4 1.6 3-.9.4-1.7.9-2.4 1.5-.9 1-1.5 2.2-1.8 3.4 0 0 0-.1-.1-.1C2 14.7 1 12.4 1 10c0-2.5 1-4.7 2.6-6.4C5.3 2.1 7.5 1.1 10 1.1c2.4 0 4.7 1 6.3 2.6C18 5.3 19 7.5 19 10c0 2.4-1 4.7-2.7 6.3l-.1.1c-.1-1.2-.8-2.4-1.7-3.4zm-9.8 4.2c.2-2.8 2.5-5 5.4-5 2.8 0 5.1 2.2 5.3 5C13.8 18.3 12 19 10 19s-3.8-.7-5.3-1.8zm5.3-5.9c-1.5 0-2.7-1.2-2.7-2.7S8.5 5.9 10 5.9c1.4 0 2.7 1.1 2.7 2.7s-1.2 2.7-2.7 2.7z"
							/>
						  </svg>
						</div>
					  </a>
					</li>
					<li class="nav-lk__pills-item">
					  <a
						class="nav-lk__pills-link <?if($_GET['tab']=="delivery"):?>active<?endif;?>"
						id="pills-delivery-tab"
						data-toggle="pill"
						href="#pills-delivery"
						role="tab"
						aria-controls="pills-delivery"
						aria-selected="false"
						onclick="addTab('tab','delivery');"
					  >
						<p>Доставка</p>
						<div class="nav-lk__pills-item-icon">
						  <svg viewBox="0 0 20 20">
							<path
							  fill-rule="evenodd"
							  d="M3.7 12.9c.3-.3.7-.5 1.3-.5.5 0 .9.2 1.3.5.3.3.6.7.7 1.2h5.7V4.5H1.2v9.6H3c0-.5.3-.9.7-1.2zm0 3.1c-.4-.2-.7-.7-.7-1.1H.7c-.1 0-.2-.1-.3-.1-.1-.1-.1-.2-.1-.3V4.1c0-.1.1-.2.1-.3.1-.1.1-.1.3-.1h12.4c.1 0 .2.1.3.1.1.1.1.1.1.3V6H16.8l.1.1 2.9 4.5v.1l.1.1v3.6c0 .1-.1.2-.1.3-.1.1-.2.1-.3.1H18c-.1.4-.3.8-.7 1.1-.3.3-.8.5-1.3.5s-.9-.1-1.3-.5c-.3-.3-.6-.7-.6-1.1H6.9c-.1.4-.3.8-.7 1.1-.3.3-.8.5-1.3.5-.5.1-.9 0-1.2-.4zm11.1-7.9v2.1h3.8l-1.3-2.1h-2.5zm-.5-.9h2.3l-.3-.4h-2.9v7.3h.6c.1-.5.3-.9.6-1.2.4-.3.8-.5 1.3-.5.6 0 1 .2 1.3.5.3.3.6.7.7 1.2H19V11h-4.7c-.1 0-.2 0-.3-.1-.1-.1-.1-.1-.1-.3V7.7c0-.1.1-.2.1-.3.1-.1.2-.2.3-.2zm.8 8.1c.2.2.6.3.8.3.3 0 .6-.1.8-.3.3-.2.3-.6.3-.8 0-.3-.1-.6-.3-.8-.2-.2-.5-.3-.8-.3-.3 0-.6.1-.8.3-.2.2-.3.5-.3.8 0 .3.1.6.3.8zm-10.9 0c.2.2.5.3.8.3.3 0 .6-.1.8-.3.2-.2.3-.6.3-.8 0-.3-.1-.6-.3-.8-.2-.2-.6-.3-.8-.3-.3 0-.6.1-.8.3-.3.2-.3.5-.3.8-.1.3 0 .6.3.8z"
							/>
						  </svg>
						</div>
					  </a>
					</li>
					<li class="nav-lk__pills-item">
					  <a
						class="nav-lk__pills-link <?if($_GET['tab']=="orders"):?>active<?endif;?>"
						id="pills-order-tab"
						data-toggle="pill"
						href="#pills-order"
						role="tab"
						aria-controls="pills-order"
						aria-selected="false"
						onclick="addTab('tab','orders');"
					  >
						<p>Заказы</p>
						<div class="nav-lk__pills-item-icon">
						  <svg viewBox="0 0 20 20">
							<path
							  fill-rule="evenodd"
							  d="M19.5 3.9c-.4-.4-.9-.7-1.5-.7H3.7l-.1-1.1C3.4.9 2.6 0 1.7 0h-1C.4 0 .1.3.1.6s.3.6.6.6h1c.2 0 .6.4.7 1l1.7 12.7c.1.5.4 1 .8 1.4.4.3.7.5 1.1.6-.1.3-.2.7-.2 1 0 1.2 1 2.1 2.1 2.1s2.2-1 2.2-2.1c0-.4-.1-.7-.3-1h3.1c-.1.3-.2.6-.2 1 0 1.2 1 2.1 2.1 2.1s2.2-1 2.2-2.1c0-.4-.1-.7-.3-1h1.5c.4 0 .6-.3.6-.6 0-.4-.2-.6-.6-.6H6.5c-.5 0-1.1-.5-1.2-1.1l-.1-.9h11.7c.6 0 1.1-.2 1.5-.6.4-.4.7-1 .8-1.5l.8-6.2c.1-.6-.1-1.2-.5-1.5zM9 18c0 .5-.4 1-1 1-.5 0-1-.4-1-1 0-.5.4-1 1-1 .5 0 1 .4 1 1zm6.9 0c0 .5-.4 1-1 1-.5 0-1-.4-1-1 0-.5.4-1 1-1s1 .4 1 1zm2.9-12.7l-.8 6.3c-.1.5-.6 1-1.2 1H5L3.9 4.4h14.2c.2 0 .4.1.6.2.1.2.1.5.1.7z"
							/>
						  </svg>
						</div>
					  </a>
					</li>
					<li class="nav-lk__pills-item">
					  <a
						class="nav-lk__pills-link <?if($_GET['tab']=="favorite"):?>active<?endif;?>"
						id="pills-favorite-tab"
						data-toggle="pill"
						href="#pills-favorite"
						role="tab"
						aria-controls="pills-favorite"
						aria-selected="false"
						onclick="addTab('tab','favorite');"
					  >
						<p>
						  Избранное
						</p>
						<div class="nav-lk__pills-item-icon">
						  <svg viewBox="0 0 20 20">
							<path
							  fill-rule="evenodd"
							  d="M18.5 2.9c-.9-1.1-2.3-1.7-3.8-1.7-2.1 0-3.5 1.3-4.2 2.3-.2.3-.4.5-.5.8-.1-.3-.3-.5-.5-.8-.7-1-2.1-2.3-4.2-2.3-1.5 0-2.9.6-3.9 1.7C.5 4 0 5.4 0 7c0 1.6.6 3.2 2.1 4.9 1.2 1.5 3 3 5.1 4.8.8.6 1.6 1.3 2.4 2.1h.1c.1.1.2.1.4.1s.3 0 .4-.1h.1c.9-.8 1.6-1.4 2.4-2.1 2.1-1.8 3.9-3.3 5.1-4.8C19.4 10.2 20 8.6 20 7c0-1.6-.5-3-1.5-4.1zm-6.4 12.8c-.6.6-1.4 1.1-2.1 1.8l-2.1-1.8C3.9 12.3 1.1 10 1.1 7c0-1.3.4-2.4 1.2-3.3.7-.9 1.8-1.4 2.9-1.4 1.6 0 2.6 1 3.3 1.9.6.7.9 1.5.9 1.8.1.2.3.3.6.3.2 0 .5-.1.6-.4.1-.3.4-1.1.9-1.8.6-.9 1.6-1.9 3.3-1.9 1.1 0 2.2.5 2.9 1.4.8.9 1.1 2 1.1 3.3 0 3.1-2.7 5.4-6.7 8.8z"
							/>
						  </svg>
						</div>
					  </a>
					</li>
					<li class="nav-lk__pills-item">
					  <a
						class="nav-lk__pills-link <?if($_GET['tab']=="faq"):?>active<?endif;?>"
						id="pills-question-tab"
						data-toggle="pill"
						href="#pills-question"
						role="tab"
						aria-controls="pills-question"
						aria-selected="false"
						onclick="addTab('tab','faq');"
					  >
						<p>FAQ</p>
						<div class="nav-lk__pills-item-icon">
						  <svg viewBox="0 0 20 20">
							<path
							  fill="#2B2A29"
							  fill-rule="evenodd"
							  d="M15.4 5.3c0 .6-.4 1-.8 1.3-.1.1-.4.3-.4.4 0 .3-.2.5-.5.5s-.5-.2-.5-.5c0-.6.4-.8.7-1.1.3-.2.4-.4.4-.5 0-.2-.2-.5-.5-.5s-.5.3-.5.5c0 .3-.2.5-.5.5s-.5-.2-.5-.5c0-.8.7-1.4 1.5-1.4.9-.1 1.6.6 1.6 1.3zm-1.7 2.6c-.2 0-.4.2-.4.5s.2.5.4.5c.3 0 .5-.2.5-.5s-.2-.5-.5-.5zM20 3.4V9c0 1.3-1.1 2.3-2.4 2.3H10.7c0 .1-.1.1-.2.2l-.1.1-1.8 1.6c-.1.1-.4.2-.6.1-.1-.1-.3-.3-.3-.5V7.7H2.6c-.8 0-1.4.6-1.4 1.4v5.5c0 .8.6 1.4 1.4 1.4h7.1c.1 0 .2.1.3.1l1.5 1.3v-4.6c0-.3.2-.5.5-.5s.5.2.5.5v5.8c0 .2-.1.4-.3.4-.1.1-.1.1-.2.1s-.2-.1-.4-.1l-2.1-2H2.6C1.3 17 .2 15.9.2 14.6V9.1c0-1.3 1.1-2.4 2.4-2.4h5.1V3.4c0-1.3 1.1-2.3 2.4-2.3h7.5c1.3 0 2.4 1.1 2.4 2.3zm-1 0c0-.7-.6-1.3-1.4-1.3h-7.5c-.8 0-1.4.6-1.4 1.3V11.8l1-.8c0-.1.1-.1.1-.1.4-.4.6-.5 1.1-.5h6.6c.8 0 1.4-.6 1.4-1.3V3.4z"
							/>
						  </svg>
						</div>
					  </a>
					</li>
					<li class="nav-lk__pills-item">
					  <a class="nav-lk__pills-link" href="/?logout=yes">
						<p>Выход</p>
						<div class="nav-lk__pills-item-icon">
						  <svg viewBox="0 0 20 20">
							<path
							  fill-rule="evenodd"
							  d="M.2 9.7v.1s-.1 0-.1.1v.5h.1v.1s0 .1 0 0c0 .1.1.1.1.1v.1L3 13.3c.1.1.3.1.4.1.1 0 .3-.1.4-.1.2-.2.2-.6 0-.8L2 10.6h11.8c.3 0 .6-.3.6-.6s-.3-.6-.6-.6H2l1.8-1.8c.2-.2.2-.6 0-.8s-.5-.2-.8.1L.2 9.7zm12.4-7c-2.3 0-4.7 1.3-6 3.3-.2.2-.1.6.2.8.2.1.6.1.7-.2 1.2-1.7 3.1-2.7 5.1-2.7 3.5 0 6.2 2.7 6.2 6.1s-2.7 6.2-6.2 6.2c-2 0-4-1-5.1-2.7-.1-.3-.5-.4-.7-.1-.3.1-.4.5-.1.8 1.3 2 3.6 3.2 6 3.2 4 0 7.4-3.2 7.4-7.3s-3.4-7.4-7.5-7.4z"
							/>
						  </svg>
						</div>
					  </a>
					</li>
				  </ul>
				  <!-- NAV END -->
				</div>
				<!-- NAV LK END -->
			  </div>
			  <div class="col-xl-10 col-lg-9 col-md-12">
				<!-- NAV LK CONTENT START -->

				<div class="nav-content-tab tab-content" id="nav-pills-tab-content">
				  <!-- BLOCK INFO START -->
				  <div class="tab-pane fade <?if($_GET['tab']=="profile" || $_GET['tab']==""):?>show active<?endif;?>" id="pills-info" role="tabpanel" aria-labelledby="pills-info-tab">
					<div class="nav-content-tab__pills">
					  <div class="row">
						<div class="col-12 col-md-6 ">
						  <h4 class="nav-content-tab__pills-title">Контактная информация</h4>
						  <?if(is_array($errors['USER'])) ShowError(implode('<br>',$errors['USER']));?>
						  <form id="pesonal_form" action="" method="POST">
							<?=bitrix_sessid_post()?>
							<div class="nav-content-tab__pills-form-group">
							  <label class="nav-content-tab__pills-label" for="surname">Фамилия</label>
							  <input name="USER[LAST_NAME]" type="text" class="form-control" value="<?=$arResult['USER_DATA']['LAST_NAME']?>" id="surname" placeholder="Фамилия" />
							</div>

							<div class="nav-content-tab__pills-form-group">
							  <label class="nav-content-tab__pills-label" for="name">Имя *</label>
							  <input name="USER[NAME]" type="text" required="required" value="<?=$arResult['USER_DATA']['NAME']?>" class="form-control" id="name" placeholder="Имя" />
							</div>

							<div class="nav-content-tab__pills-form-group">
							  <label class="nav-content-tab__pills-label" for="last-name">Отчество</label>
							  <input name="USER[SECOND_NAME]" type="text" value="<?=$arResult['USER_DATA']['SECOND_NAME']?>" class="form-control" id="last-name" placeholder="Отчество" />
							</div>

							<div class="nav-content-tab__pills-form-group">
							  <label class="nav-content-tab__pills-label" for="phone">
								<svg class="tel-lk nav-content-tab__pills-input-icon" viewbox="0 0 10 10">
								  <path
									d="M9.8 7.9L8.2 6.4c-.3-.3-.8-.3-1.1 0l-.8.8s-.1-.1-.2-.1c-.4-.3-1.1-.7-1.8-1.4S3.2 4.3 2.9 3.8c0-.1-.1-.1-.1-.2l.5-.5.3-.3c.4-.2.4-.7.1-1L2.1.2c-.3-.3-.8-.3-1.1 0L.5.7l-.3.6c-.1.3-.1.5-.2.7-.2 1.7.6 3.2 2.7 5.3C5.6 10.2 7.9 10 8 10c.2 0 .4-.1.6-.2.2-.1.4-.2.6-.4l.6-.4c.3-.3.3-.8 0-1.1z"
								  ></path>
								</svg>
								Телефон *
								</label>
								<input name="USER[PERSONAL_PHONE]" required="required" type="text" class="form-control" value="<?=$arResult['USER_DATA']['PERSONAL_PHONE']?>" id="phone" placeholder="+380" />
							</div>

							<div class="nav-content-tab__pills-form-group">
							  <label class="nav-content-tab__pills-label" for="email">
								<svg viewbox="0 0 10 10" class="email-lk nav-content-tab__pills-input-icon">
								  <path
									d="M10 2.3c0-.3-.2-.6-.5-.6h-9c-.1 0-.3.1-.4.2 0 .1-.1.2-.1.4v5c0 .1.1.3.2.4.1.1.2.1.4.1h9c.3 0 .5-.2.5-.5l-.1-5zm-1.1 0L5 5 1.1 2.3h7.8zM6.7 5.5L9 7.3H1l2.3-1.8c.1-.1.1-.2 0-.4 0-.1-.2-.1-.3 0L.5 7V2.5l4.3 3H5l4.3-3v4.6L7 5.1c-.1-.1-.3-.1-.4 0-.1.1-.1.3.1.4z"
								  ></path>
								</svg>
								E-mail *</label
							  >
							  <input name="USER[EMAIL]" required="required" type="text" class="form-control" value="<?=$arResult['USER_DATA']['EMAIL']?>" id="email" placeholder="example@example.com" />
							</div>

							<button class="nav-content-tab__pills-btn" type="submit" name="save_profile" value="Y">Сохранить</button>
						  </form>
						</div>

						<div class="col-12 col-md-6 ">
						  <h4 class="nav-content-tab__pills-title">Смена пароля</h4>
						  <?if(is_array($errors['PASSWD'])) ShowError(implode('<br>',$errors['PASSWD']));?>
						  <form action="" method="POST">
							<?=bitrix_sessid_post()?>
							<div class="nav-content-tab__pills-form-group">
							  <label class="nav-content-tab__pills-label" for="password">
								<svg viewbox="0 0 10 10" class="nav-content-tab__pills-input-icon">
								  <path
									d="M2 3v1h-.1c-.4 0-.8.3-.8.8v4.3c0 .4.4.8.8.8h6c.4 0 .8-.4.8-.8V4.8c0-.5-.3-.8-.8-.8V3c0-1.6-1.3-3-3-3C3.3 0 2 1.3 2 3zm3.4 4.1c-.1 0-.1.1-.1.2v.9c0 .1-.1.3-.2.3-.2.2-.5 0-.5-.3v-1c0-.1 0-.1-.1-.1-.3-.2-.4-.5-.2-.9.1-.3.5-.5.8-.4.4.1.6.4.6.7 0 .3-.1.5-.3.6zM3.3 3C3.3 2 4 1.3 5 1.3c.9 0 1.6.7 1.6 1.7v1H3.3V3z"
								  />
								</svg>
								Текущий пароль
							  </label>
							  <input type="password" required="required" class="form-control" name="PASSWD[OLD]" id="password" placeholder="" />
							</div>

							<div class="nav-content-tab__pills-form-group">
							  <label class="nav-content-tab__pills-label" for="new-password">
								<svg viewbox="0 0 10 10" class="nav-content-tab__pills-input-icon">
								  <path
									d="M2 3v1h-.1c-.4 0-.8.3-.8.8v4.3c0 .4.4.8.8.8h6c.4 0 .8-.4.8-.8V4.8c0-.5-.3-.8-.8-.8V3c0-1.6-1.3-3-3-3C3.3 0 2 1.3 2 3zm3.4 4.1c-.1 0-.1.1-.1.2v.9c0 .1-.1.3-.2.3-.2.2-.5 0-.5-.3v-1c0-.1 0-.1-.1-.1-.3-.2-.4-.5-.2-.9.1-.3.5-.5.8-.4.4.1.6.4.6.7 0 .3-.1.5-.3.6zM3.3 3C3.3 2 4 1.3 5 1.3c.9 0 1.6.7 1.6 1.7v1H3.3V3z"
								  />
								</svg>
								Новый пароль</label
							  >
							  <input type="password" class="form-control" required="required" name="PASSWD[NEW]" id="new-password" placeholder="" />
							</div>

							<div class="nav-content-tab__pills-form-group">
							  <label class="nav-content-tab__pills-label" for="new-acsses-password">
								<svg viewbox="0 0 10 10" class="nav-content-tab__pills-input-icon">
								  <path
									d="M2 3v1h-.1c-.4 0-.8.3-.8.8v4.3c0 .4.4.8.8.8h6c.4 0 .8-.4.8-.8V4.8c0-.5-.3-.8-.8-.8V3c0-1.6-1.3-3-3-3C3.3 0 2 1.3 2 3zm3.4 4.1c-.1 0-.1.1-.1.2v.9c0 .1-.1.3-.2.3-.2.2-.5 0-.5-.3v-1c0-.1 0-.1-.1-.1-.3-.2-.4-.5-.2-.9.1-.3.5-.5.8-.4.4.1.6.4.6.7 0 .3-.1.5-.3.6zM3.3 3C3.3 2 4 1.3 5 1.3c.9 0 1.6.7 1.6 1.7v1H3.3V3z"
								  />
								</svg>
								Подтвердить пароль</label
							  >
							  <input type="password" class="form-control" name="PASSWD[CONFIRM]" required="required" id="new-acsses-password" placeholder="" />
							</div>

							<button class="nav-content-tab__pills-btn" name="change_password" value="Y">Сохранить</button>
						  </form>
						</div>
					  </div>
					</div>
				  </div>
				  <!-- BLOCK INFO END -->
				  <!-- BLOCK DELIVERY START -->
				  <div class="tab-pane fade <?if($_GET['tab']=="delivery"):?>show active<?endif;?>" id="pills-delivery" role="tabpanel" aria-labelledby="pills-delivery-tab">
				  <form method="POST" action="">
					<?=bitrix_sessid_post()?>
					<input type="hidden" value="Y" name="save_delivery">
					<div class="nav-content-tab__pills">
					  <h4 class="nav-content-tab__pills-title">Доставка</h4>
					<script>
						$(document).ready(function(){
							var availableplaces = [
								<?
									CModule::IncludeModule('iblock');
									$refId=34;
									$arFilter = array('IBLOCK_ID' => $refId);
									$rsSect = CIBlockSection::GetList(array('left_margin' => 'asc'),$arFilter);
									while ($arSect = $rsSect->fetch()){
										echo '"'.$arSect['NAME'].'",';
									}
								?>
							];
							$("#selectCity").autocomplete({
								source : availableplaces
							});
						});
					</script>
					  <div class="accordion nav-content-accordion" id="delivery-method-acard">
						<div class="nav-content-tab__pills-form-group nav-content-tab__pills-delivery">
						  <label for="selectCity" class="nav-content-tab__pills-label">Ваш город</label>
						  <div class="select-city">
							<input type="text" class="form-control" value="<?=$arResult['USER_DATA']['PERSONAL_CITY']?>" name="DELIVERY[cityName]" id="selectCity" onchange="getNPOffices($(this).val());" required="required" />
						  </div>

						  <div class="nav-content-tab__pills-group-way">
							<a href="javascript:void(0)" onclick="setDevCity('Киев');" class="nav-content-tab__pills-way">Киев</a>
							<a href="javascript:void(0)" onclick="setDevCity('Одесса');" class="nav-content-tab__pills-way">Одесса</a>
							<a href="javascript:void(0)" onclick="setDevCity('Харьков');" class="nav-content-tab__pills-way">Харьков</a>
							<a href="javascript:void(0)" onclick="setDevCity('Днепр');" class="nav-content-tab__pills-way">Днепр</a>
							<a href="javascript:void(0)" onclick="setDevCity('Львов');" class="nav-content-tab__pills-way">Львов</a>
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
										<div class="row no-gutters">
										  <div class="col-12">
											<div class="nav-content-accordion__item">
											  <input
												class="checkbox"
												type="radio"
												name="DELIVERY[TYPE]"
												id="delivery-np-input-<?=$ar_dtype['ID']?>"
												data-toggle="collapse"
												data-target="#delivery-np-branch-description"
												aria-controls="delivery-np-branch-description"
												onclick="changeDelivery(<?=$ar_dtype['ID']?>);"
												required
												value="<?=$ar_dtype['ID']?>"
											  />
											  <label class="nav-content-accordion__item-label" for="delivery-np-input-<?=$ar_dtype['ID']?>">
												<?=$ar_dtype['NAME']?>
											  </label>
											</div>
										  </div>

										  <div class="col-12">
											<div class="collapse" id="delivery-np-branch-description" data-parent="#delivery-method-acard">
											  <div class="row mt-3 mb-3">
												<div class="col-12 col-md-6">
												  <div class="form-group">
													<label for="selectPost">Выберите отделение</label>
													<div id="npoffice-container">
														<select class="form-control" name="ORDER[DELIVERY][NP_OFFICE]"  id="selectPost">
															<option>Укажите город</option>
														</select>
													</div>
												  </div>
												</div>
												<div class="col-12">
												  <small>
													<?=$ar_dtype['DESCRIPTION']?>
												  </small>
												</div>
											  </div>
											</div>
										  </div>
										</div>
									<?else:?>
										<div class="row no-gutters">
										  <div class="col-12">
											<div class="nav-content-accordion__item">
											  <input
												class="checkbox"
												type="radio"
												name="DELIVERY[TYPE]"
												id="delivery-np-cur-input-<?=$ar_dtype['ID']?>"
												data-toggle="collapse"
												data-target="#delivery-np-cur-description-<?=$ar_dtype['ID']?>"
												aria-controls="delivery-np-cur-description-<?=$ar_dtype['ID']?>"
												onclick="changeDelivery(<?=$ar_dtype['ID']?>);"
												required
												value="<?=$ar_dtype['ID']?>"
											  />
											  <label class="nav-content-accordion__item-label" for="delivery-np-cur-input-<?=$ar_dtype['ID']?>">
												<?=$ar_dtype['NAME']?> <span class="not-allowed">(не доступно)</span>
											  </label>
											</div>
										  </div>

										  <div class="col-12">
											<div id="delivery-np-cur-description-<?=$ar_dtype['ID']?>" class="collapse" data-parent="#delivery-method-acard">
											  <div class="row mt-3 mb-3">
												<div class="col-12 col-md-6">
												  <div class="form-group form-group">
													<input
													  type="text"
													  class="form-control delivery-unstable"
													  id="InputName-delivery-street-<?=$ar_dtype['ID']?>"
													  placeholder="Введите улицу"
													  name="DELIVERY[<?=$ar_dtype['ID']?>][STREET]"
													  data-delivery="<?=$ar_dtype['ID']?>"
													  <?if($arResult['USER_DATA']['WORK_ZIP']==$ar_dtype['ID']):?>
															value="<?=$arResult['USER_DATA']['PERSONAL_STREET']?>"
													  <?endif;?>
													/>
												  </div>

												  <div class="form-group form-group-row">
													<div class=" w-50 mr-1">
													  <input
														type="text"
														class="form-control delivery-unstable"
														id="InputName-delivery-hous-<?=$ar_dtype['ID']?>"
														placeholder="№ дома"
														name="DELIVERY[<?=$ar_dtype['ID']?>][HOUSE]"
														data-delivery="<?=$ar_dtype['ID']?>"
														 <?if($arResult['USER_DATA']['WORK_ZIP']==$ar_dtype['ID']):?>
															value="<?=$arResult['USER_DATA']['PERSONAL_STATE']?>"
													  <?endif;?>
													  />
													</div>

													<div class=" w-50 ml-1">
													  <input
														type="text"
														class="form-control delivery-unstable"
														id="InputName-delivery-room-<?=$ar_dtype['ID']?>"
														placeholder="№ квартиры"
														name="DELIVERY[<?=$ar_dtype['ID']?>][FLAT]"
														data-delivery="<?=$ar_dtype['ID']?>"
														<?if($arResult['USER_DATA']['WORK_ZIP']==$ar_dtype['ID']):?>
															value="<?=$arResult['USER_DATA']['PERSONAL_ZIP']?>"
														<?endif;?>
													  />
													</div>
												  </div>
												</div>
												<div class="col-12">
												  <small>
													<?=$ar_dtype['DESCRIPTION']?>
												  </small>
												</div>
											  </div>
											</div>
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
									$('#delivery-np-cur-input-<?=$arResult["USER_DATA"]["WORK_ZIP"]?>').click();
									$('#delivery-np-cur-description-<?=$arResult["USER_DATA"]["WORK_ZIP"]?>').addClass('show');
									$('#selectCity').change();
								});
							</script>
						<?elseif($arResult['USER_DATA']['PERSONAL_NOTES']!=''):?>
							<script>
								$(document).ready(function(){
									$('#delivery-np-input-<?=$arResult["USER_DATA"]["WORK_ZIP"]?>').click();
									$('#delivery-np-branch-description').addClass('show');
									getNPOffices($('#selectCity').val(),"<?=$arResult['USER_DATA']['PERSONAL_NOTES']?>")
								});
							</script>
						<?endif;?>
						<button class="delivery-save">Сохранить</button>
					  </div>
					</div>
					</form>
				  </div>
				  <!-- BLOCK DELIVERY END -->
				  <!-- BLOCK ORDER START -->
				  <div class="tab-pane fade <?if($_GET['tab']=="orders"):?>show active<?endif;?>" id="pills-order" role="tabpanel" aria-labelledby="pills-order-tab">
					<div class="nav-content-tab__pills">
					  <ul class="nav nav-pills nav-content-tab__pills-order" id="pills-tab-status" role="tablist">
						<li class="nav-content-tab__pills-order-item">
						  <a
							class="nav-content-tab__pills-order-link <?if($_GET['orderstatus']=='all' || $_GET['orderstatus']==''):?>active<?endif;?>"
							id="pills-all-tab"
							data-toggle="pill"
							href="#pills-ALL"
							role="tab"
							aria-controls="pills-all"
							aria-selected="true"
							onclick="addTab('orderstatus','all');"
							>Все</a
						  >
						</li>
						<li class="nav-content-tab__pills-order-item">
						  <a
							class="nav-content-tab__pills-order-link <?if($_GET['orderstatus']=='inprocess'):?>active<?endif;?>"
							id="pills-processing-tab"
							data-toggle="pill"
							href="#pills-N"
							role="tab"
							aria-controls="pills-N"
							aria-selected="false"
							onclick="addTab('orderstatus','inprocess');"
							>В обработке</a
						  >
						</li>
						<li class="nav-content-tab__pills-order-item">
						  <a
							class="nav-content-tab__pills-order-link <?if($_GET['orderstatus']=='finished'):?>active<?endif;?>"
							id="pills-done-tab"
							data-toggle="pill"
							href="#pills-F"
							role="tab"
							aria-controls="pills-F"
							aria-selected="false"
							onclick="addTab('orderstatus','finished');"
							>Завершенные</a
						  >
						</li>
						<li class="nav-content-tab__pills-order-item">
						  <a
							class="nav-content-tab__pills-order-link <?if($_GET['orderstatus']=='canceled'):?>active<?endif;?>"
							id="pills-canseled-tab"
							data-toggle="pill"
							href="#pills-D"
							role="tab"
							aria-controls="pills-D"
							aria-selected="false"
							onclick="addTab('orderstatus','canceled');"
							>Отмененные</a
						  >
						</li>
					  </ul>

					  <div class="tab-content nav-content-tab__order" id="pills-tab-content">
						<?$APPLICATION->IncludeComponent(
							"bitrix:sale.personal.order.list",
							"skarlat",
							Array(
								"ACTIVE_DATE_FORMAT" => "d.m.Y",
								"ALLOW_INNER" => "N",
								"CACHE_GROUPS" => "Y",
								"CACHE_TIME" => "3600",
								"CACHE_TYPE" => "A",
								"DEFAULT_SORT" => "STATUS",
								"DISALLOW_CANCEL" => "N",
								"HISTORIC_STATUSES" => array("ALL"),
								"ID" => $ID,
								"NAV_TEMPLATE" => "order",
								"ONLY_INNER_FULL" => "N",
								"ORDERS_PER_PAGE" => "10",
								"PATH_TO_BASKET" => "",
								"PATH_TO_CANCEL" => "",
								"PATH_TO_CATALOG" => "/catalog/",
								"PATH_TO_COPY" => "",
								"PATH_TO_DETAIL" => "",
								"PATH_TO_PAYMENT" => "payment.php",
								"REFRESH_PRICES" => "N",
								"RESTRICT_CHANGE_PAYSYSTEM" => array("0"),
								"SAVE_IN_SESSION" => "Y",
								"SET_TITLE" => "Y",
								"STATUS_COLOR_D" => "gray",
								"STATUS_COLOR_F" => "gray",
								"STATUS_COLOR_N" => "green",
								"STATUS_COLOR_P" => "yellow",
								"STATUS_COLOR_PSEUDO_CANCELLED" => "red",
								"STATUS_COLOR_S" => "gray"
							)
						);?>
						<?$APPLICATION->IncludeComponent(
							"bitrix:sale.personal.order.list",
							"skarlat",
							Array(
								"ACTIVE_DATE_FORMAT" => "d.m.Y",
								"ALLOW_INNER" => "N",
								"CACHE_GROUPS" => "Y",
								"CACHE_TIME" => "3600",
								"CACHE_TYPE" => "A",
								"DEFAULT_SORT" => "STATUS",
								"DISALLOW_CANCEL" => "N",
								"HISTORIC_STATUSES" => array("F","D"),
								"ID" => $ID,
								"NAV_TEMPLATE" => "order",
								"ONLY_INNER_FULL" => "N",
								"ORDERS_PER_PAGE" => "10",
								"PATH_TO_BASKET" => "",
								"PATH_TO_CANCEL" => "",
								"PATH_TO_CATALOG" => "/catalog/",
								"PATH_TO_COPY" => "",
								"PATH_TO_DETAIL" => "",
								"PATH_TO_PAYMENT" => "payment.php",
								"REFRESH_PRICES" => "N",
								"RESTRICT_CHANGE_PAYSYSTEM" => array("0"),
								"SAVE_IN_SESSION" => "Y",
								"SET_TITLE" => "Y",
								"STATUS_COLOR_D" => "gray",
								"STATUS_COLOR_F" => "gray",
								"STATUS_COLOR_N" => "green",
								"STATUS_COLOR_P" => "yellow",
								"STATUS_COLOR_PSEUDO_CANCELLED" => "red",
								"STATUS_COLOR_S" => "gray"
							)
						);?>
						<?$APPLICATION->IncludeComponent(
							"bitrix:sale.personal.order.list",
							"skarlat",
							Array(
								"ACTIVE_DATE_FORMAT" => "d.m.Y",
								"ALLOW_INNER" => "N",
								"CACHE_GROUPS" => "Y",
								"CACHE_TIME" => "3600",
								"CACHE_TYPE" => "A",
								"DEFAULT_SORT" => "STATUS",
								"DISALLOW_CANCEL" => "N",
								"HISTORIC_STATUSES" => array("N","P","S","D"),
								"ID" => $ID,
								"NAV_TEMPLATE" => "order",
								"ONLY_INNER_FULL" => "N",
								"ORDERS_PER_PAGE" => "10",
								"PATH_TO_BASKET" => "",
								"PATH_TO_CANCEL" => "",
								"PATH_TO_CATALOG" => "/catalog/",
								"PATH_TO_COPY" => "",
								"PATH_TO_DETAIL" => "",
								"PATH_TO_PAYMENT" => "payment.php",
								"REFRESH_PRICES" => "N",
								"RESTRICT_CHANGE_PAYSYSTEM" => array("0"),
								"SAVE_IN_SESSION" => "Y",
								"SET_TITLE" => "Y",
								"STATUS_COLOR_D" => "gray",
								"STATUS_COLOR_F" => "gray",
								"STATUS_COLOR_N" => "green",
								"STATUS_COLOR_P" => "yellow",
								"STATUS_COLOR_PSEUDO_CANCELLED" => "red",
								"STATUS_COLOR_S" => "gray"
							)
						);?>
						<?$APPLICATION->IncludeComponent(
							"bitrix:sale.personal.order.list",
							"skarlat",
							Array(
								"ACTIVE_DATE_FORMAT" => "d.m.Y",
								"ALLOW_INNER" => "N",
								"CACHE_GROUPS" => "Y",
								"CACHE_TIME" => "3600",
								"CACHE_TYPE" => "A",
								"DEFAULT_SORT" => "STATUS",
								"DISALLOW_CANCEL" => "Y",
								"HISTORIC_STATUSES" => array("N","P","S","F"),
								"ID" => $ID,
								"NAV_TEMPLATE" => "order",
								"ONLY_INNER_FULL" => "N",
								"ORDERS_PER_PAGE" => "10",
								"PATH_TO_BASKET" => "",
								"PATH_TO_CANCEL" => "",
								"PATH_TO_CATALOG" => "/catalog/",
								"PATH_TO_COPY" => "",
								"PATH_TO_DETAIL" => "",
								"PATH_TO_PAYMENT" => "payment.php",
								"REFRESH_PRICES" => "N",
								"RESTRICT_CHANGE_PAYSYSTEM" => array("0"),
								"SAVE_IN_SESSION" => "Y",
								"SET_TITLE" => "Y",
								"STATUS_COLOR_D" => "gray",
								"STATUS_COLOR_F" => "gray",
								"STATUS_COLOR_N" => "green",
								"STATUS_COLOR_P" => "yellow",
								"STATUS_COLOR_PSEUDO_CANCELLED" => "red",
								"STATUS_COLOR_S" => "gray"
							)
						);?>
					  </div>
					</div>
				  </div>
				  <!-- BLOCK ORDER END -->
				  <!-- BLOCK FAVORITE START -->
				  <div class="tab-pane fade <?if($_GET['tab']=="favorite"):?>show active<?endif;?>" id="pills-favorite" role="tabpanel" aria-labelledby="pills-favorite-tab">
					<div class="nav-content-tab__pills">
					  <?$APPLICATION->IncludeComponent(
							"bitrix:catalog.product.subscribe.list",
							"skarlat",
							Array(
                                "SITE_ID" => "sh",
								"CACHE_TIME" => "3600",
								"CACHE_TYPE" => "A",
								"LINE_ELEMENT_COUNT" => "6"
							)
						);?>
					</div>
				  </div>

				  <!-- BLOCK FAVORITE END -->
				  <!-- BLOCK QUESTION START -->
				  <div class="tab-pane fade  <?if($_GET['tab']=="faq"):?>show active<?endif;?>" id="pills-question" role="tabpanel" aria-labelledby="pills-question-tab">
					<div class="nav-content-tab__pills">
					  <div class="row">
						<div class="col-12">
						  <h4 class="nav-content-tab__pills-title">Вопрос - ответ</h4>
						  <div class="accordion nav-content-accordion__question" id="questions">
							<?
								CModule::IncludeModule('iblock');
								$arSelect = Array("ID", "IBLOCK_ID", "NAME", "PREVIEW_TEXT");
								$arFilter = Array("IBLOCK_ID"=>35);
								$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, $arSelect);
								while($ob = $res->fetch()){
									?>
										<div id="question-<?=$ob['ID']?>" class="nav-content-accordion__question-item">
											<h4 class="mb-0" data-toggle="collapse" data-target="#question-descr-<?=$ob['ID']?>">
												<?=$ob['NAME']?>
											</h4>
										</div>
										<div
										  id="question-descr-<?=$ob['ID']?>"
										  class="collapse"
										  aria-labelledby="question-<?=$ob['ID']?>"
										  data-parent="#questions"
										>
											<?=$ob['PREVIEW_TEXT']?>
										</div>
									<?
								}
							?>
						  </div>
						</div>
					  </div>
					</div>
				  </div>
				  <!-- BLOCK QUESTION END -->
				</div>
				<!-- NAV LK CONTENT END -->
          </div>
		<?else:?>
			Для доступа к личному кабинету необходима авторизация.
		<?endif;?>
        </div>
    </div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
