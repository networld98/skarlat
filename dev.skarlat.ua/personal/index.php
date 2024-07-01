<?
define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
use Bitrix\Main\Localization\Loc,
    Bitrix\Sale\Location\LocationTable,
    Bitrix\Main\Loader,
    Bitrix\Main\Config\Option,
    Bitrix\Sale;
$APPLICATION->SetTitle(GetMessage('ORDER_TITLE'));
global $USER;
if(check_bitrix_sessid()){
    if($_POST['save_profile']=='Y'){
        $user = new CUser;
        $user->Update($USER->getId(), $_POST['USER']);
        $errors['USER']=$user->LAST_ERROR;
        unset($_POST['USER']);
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
            $errors['PASSWD'][]="<?=GetMessage('ORDER_ERROR_PASSWORD')?>";
        }
        unset($_POST['PASSWD']);
    }
    if($_POST['save_delivery']=='Y'){
        if($_POST['DELIVERY']['TYPE']==18):
            $usr = new CUser();
            $usr->Update($USER->getId(), ["PERSONAL_CITY"=>$_POST['DELIVERY']['cityName'],'PERSONAL_NOTES'=>$_POST['ORDER']['PROPS']['NP_OFFICE'],'WORK_ZIP'=>$_POST['DELIVERY']['TYPE'],'PERSONAL_MAILBOX'=>'nova']);
        else:
            $usr = new CUser();
            $usr->Update($USER->getId(), [
                    "PERSONAL_CITY"=>$_POST['DELIVERY']['cityName'],
                    'WORK_ZIP'=>$_POST['DELIVERY']['TYPE'],
                    'PERSONAL_STREET'=>$_POST['DELIVERY'][$_POST['DELIVERY']['TYPE']]['STREET'],
                    'PERSONAL_STATE'=>$_POST['DELIVERY'][$_POST['DELIVERY']['TYPE']]['HOUSE'],
                    'PERSONAL_ZIP'=>$_POST['DELIVERY'][$_POST['DELIVERY']['TYPE']]['FLAT'],
                    'PERSONAL_MAILBOX'=>'curier'
                ]
            );
        endif;
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
<section class="lk" id="lk">
    <div class="lk-container">
        <div class="lk-nav">
            <div class="lk-nav__title welcome">
                <span><?=GetMessage('PERSONAL_WELCOME')?>, <?echo \Bitrix\Main\Engine\CurrentUser::get()->getFullName();?></span>
                <a href="/?logout=yes"><?=GetMessage('PERSONAL_EXIT')?></a>
            </div>
            <?$APPLICATION->IncludeComponent("bitrix:menu", "personal_left_menu", array(
                "ROOT_MENU_TYPE" => "personal-left",
                "MAX_LEVEL" => "2",
                "MENU_CACHE_TYPE" => "N",
                "CACHE_SELECTED_ITEMS" => "N",
                "MENU_CACHE_TIME" => "36000000",
                "MENU_CACHE_USE_GROUPS" => "Y",
                "MENU_CACHE_GET_VARS" => array(),
            ),
                false
            );?>
            <a href="/?logout=yes" class="lk-nav_logout"><?=GetMessage('PERSONAL_EXIT_LEFT')?></a>
        </div>
        <div class="lk-content active" data-close="true">
            <img class="preloader" src="<?=SITE_TEMPLATE_PATH?>/img/preloader.gif" alt="Loading">
            <div class="lk-content-modal" data-show="profil">
                <div class="lk-content-modal__header">
                    <span class="title"><?=GetMessage('PERSONAL_PROFILE')?></span>
                    <button class="close" data-close="true">
                        <svg x="0px" y="0px" viewBox="0 0 30 30">
                            <path d="M25,6.2L23.8,5L15,13.8L6.2,5L5,6.2l8.8,8.8L5,23.8L6.2,25l8.8-8.8l8.8,8.8l1.2-1.2L16.2,15L25,6.2z"/>
                        </svg>
                    </button>
                </div>
                <div class="lk-content-modal__body">
                    <div class="container">
                        <div class="row">
                                <div class="col-12 col-md-6 ">
                                    <?if(is_array($errors['USER'])) ShowError(implode('<br>',$errors['USER']));?>
                                    <form id="pesonal_form" class="change-user" action="" method="POST">
                                        <?=bitrix_sessid_post()?>
                                        <div class="form-group">
                                            <label class="nav-content-tab__pills-label" for="surname"><?=GetMessage('PERSONAL_LAST_NAME')?></label>
                                            <input name="USER[LAST_NAME]" type="text" class="form-control" value="<?=$arResult['USER_DATA']['LAST_NAME']?>" id="surname" placeholder="<?=GetMessage('PERSONAL_LAST_NAME')?>" />
                                        </div>

                                        <div class="form-group">
                                            <label class="nav-content-tab__pills-label" for="name"><?=GetMessage('ORDER_NAME')?>*</label>
                                            <input name="USER[NAME]" type="text" required="required" value="<?=$arResult['USER_DATA']['NAME']?>" class="form-control" id="name" placeholder="<?=GetMessage('ORDER_NAME')?>" />
                                        </div>
                                        <?if(SITE_ID == 'mg'){?>
                                            <div class="form-group">
                                                <label class="nav-content-tab__pills-label" for="last-name"><?=GetMessage('PERSONAL_SECOND_NAME')?></label>
                                                <input name="USER[SECOND_NAME]" type="text" value="<?=$arResult['USER_DATA']['SECOND_NAME']?>" class="form-control" id="last-name" placeholder="<?=GetMessage('PERSONAL_SECOND_NAME')?>" />
                                            </div>
                                        <?}?>
                                        <div class="form-group">
                                            <label class="nav-content-tab__pills-label" for="phone"><?=GetMessage('ORDER_PHONE')?> *</label>
                                            <input name="USER[PERSONAL_PHONE]" required="required" type="text" class="form-control" value="<?=$arResult['USER_DATA']['PERSONAL_PHONE']?>" id="phone" placeholder="+380" />
                                        </div>
                                        <div class="form-group">
                                            <label class="nav-content-tab__pills-label" for="email"><?=GetMessage('ORDER_EMAIL')?> *</label>
                                            <input name="USER[EMAIL]" required="required" type="text" class="form-control" value="<?=$arResult['USER_DATA']['EMAIL']?>" id="email" placeholder="example@example.com" />
                                        </div>
                                        <button class="outline"  type="submit" name="save_profile" value="Y"><?=GetMessage('PERSONAL_SAVE')?></button>
                                    </form>
                                </div>
                                <div class="col-12 col-md-6 ">
                                    <?if(is_array($errors['PASSWD'])) ShowError(implode('<br>',$errors['PASSWD']));?>
                                    <form action="" class="change-user" method="POST">
                                        <?=bitrix_sessid_post()?>
                                        <div class="form-group">
                                            <label class="nav-content-tab__pills-label" for="password"><?=GetMessage('PERSONAL_PASSWORD_OLD')?></label>
                                            <input type="password" required="required" class="form-control" name="PASSWD[OLD]" id="password" placeholder="" />
                                        </div>
                                        <div class="form-group">
                                            <label class="nav-content-tab__pills-label" for="new-password"><?=GetMessage('PERSONAL_PASSWORD_NEW')?></label>
                                            <input type="password" class="form-control" required="required" name="PASSWD[NEW]" id="new-password" placeholder="" />
                                        </div>
                                        <div class="form-group">
                                            <label class="nav-content-tab__pills-label" for="new-acsses-password"><?=GetMessage('PERSONAL_PASSWORD')?></label>
                                            <input type="password" class="form-control" name="PASSWD[CONFIRM]" required="required" id="new-acsses-password" placeholder="" />
                                        </div>
                                        <button class="outline" name="change_password" value="Y"><?=GetMessage('PERSONAL_SAVE')?></button>
                                    </form>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lk-content-modal" data-show="delivery" id="user-delivery">
                <div class="lk-content-modal__header">
                    <span class="title"><?=GetMessage('PERSONAL_DELIVERY')?></span>
                    <button class="close" data-close="true">
                        <svg x="0px" y="0px" viewBox="0 0 30 30">
                            <path d="M25,6.2L23.8,5L15,13.8L6.2,5L5,6.2l8.8,8.8L5,23.8L6.2,25l8.8-8.8l8.8,8.8l1.2-1.2L16.2,15L25,6.2z"/>
                        </svg>
                    </button>
                </div>
                <div class="lk-content-modal__body">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <form method="POST" action="">
                                    <?=bitrix_sessid_post()?>
                                    <input type="hidden" value="Y" name="save_delivery">
                                    <div class="nav-content-tab__pills">
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
                                            <div class="select-city form-group">
                                                <label for="selectCity" class="nav-content-tab__pills-label"><?=GetMessage('ORDER_YOU_CITY')?>:</label>
                                                <div class="select-city form-group">
                                                    <?
                                                    Loader::includeModule('sale');
                                                    $cityName =  $arResult['USER_DATA']['PERSONAL_CITY'];

                                                    $parameters = [
                                                        'filter' => ['=NAME.NAME' => $cityName, '=TYPE.CODE' => 'CITY'],
                                                        'select' => ['ID'],
                                                        'limit' => 1,
                                                    ];
                                                    $dbLocations = LocationTable::getList($parameters);

                                                    if ($location = $dbLocations->fetch()) {
                                                    }else {
                                                        $location['ID'] = 18;
                                                    }

                                                    $APPLICATION->IncludeComponent(
                                                        "bitrix:sale.location.selector.search",
                                                        "custom",
                                                        array(
                                                            "COMPONENT_TEMPLATE" => ".default",
                                                            "ID" => $location['ID'],
                                                            "NP" => $arResult['USER_DATA']['PERSONAL_NOTES'],
                                                            "CODE" => "",
                                                            "INPUT_NAME" => "DELIVERY[cityName]",
                                                            "INPUT_VALUE" => $arResult['USER_DATA']['PERSONAL_CITY'],
                                                            "PROVIDE_LINK_BY" => "id",
                                                            "JSCONTROL_GLOBAL_ID" => "",
                                                            "JS_CALLBACK" => "",
                                                            "FILTER_BY_SITE" => "Y",
                                                            "SHOW_DEFAULT_LOCATIONS" => "Y",
                                                            "CACHE_TYPE" => "A",
                                                            "CACHE_TIME" => "36000000",
                                                            "FILTER_SITE_ID" => "mg",
                                                            "INITIALIZE_BY_GLOBAL_EVENT" => "",
                                                            "SUPPRESS_ERRORS" => "N"
                                                        )
                                                    ); ?>
                                                    <input type="hidden" class="form-control" value="<?=$arResult['USER_DATA']['PERSONAL_CITY']?>" name="DELIVERY[cityName]" id="selectCity" onchange="getNPOffices($(this).val());" required="required" />
                                                </div>

                                                <div class="order-block__delivery-way-group">
                                                    <a href="javascript:void(0)" onclick="setDevCity('Київ');" class="nav-content-tab__pills-way"><?=GetMessage('ORDER_CITY_KYIV')?></a>
                                                    <a href="javascript:void(0)" onclick="setDevCity('Одеса');" class="nav-content-tab__pills-way"><?=GetMessage('ORDER_CITY_ODESA')?>  </a>
                                                    <a href="javascript:void(0)" onclick="setDevCity('Харків');" class="nav-content-tab__pills-way"><?=GetMessage('ORDER_CITY_KHARKIV')?></a>
                                                    <a href="javascript:void(0)" onclick="setDevCity('Дніпро');" class="nav-content-tab__pills-way"><?=GetMessage('ORDER_CITY_DNIPRO')?></a>
                                                    <a href="javascript:void(0)" onclick="setDevCity('Львів');" class="nav-content-tab__pills-way"><?=GetMessage('ORDER_CITY_LVIV')?></a>
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
                                                        <div class="form-check deliv-type">
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
                                                                <?=GetMessage('ORDER_NP')?> <?if($arResult['USER_DATA']['PERSONAL_MAILBOX']=='nova'){?><span>(<?=GetMessage('DEFAULT')?>)</span><?}?>
                                                            </label>
                                                        </div>
                                                        <div class="collapse" id="delivery-np-branch-description" data-parent="#delivery-method-acard">
                                                            <div class="deliv-settings">
                                                                <div class="form-group">
                                                                    <label for="selectPost"><?=GetMessage('ORDER_VIDDILENYA')?>:</label>
                                                                    <div id="npoffice-container">
                                                                        <select class="form-control" name="ORDER[DELIVERY][NP_OFFICE]"  id="selectPost">
                                                                            <option><?=GetMessage('ORDER_YOU_CITY')?></option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="deliv-about">
                                                                <h4><?=GetMessage('ORDER_NP')?></h4>
                                                                <?=GetMessage('ORDER_OPIS_NP')?>
                                                            </div>
                                                        </div>
                                                    <?else:?>
                                                        <div class="form-check deliv-type">
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
                                                                <?=GetMessage('ORDER_DK')?> <?if($arResult['USER_DATA']['PERSONAL_MAILBOX']=='curier'){?><span>(<?=GetMessage('DEFAULT')?>)</span><?}?>
                                                            </label>
                                                        </div>
                                                        <div id="delivery-np-cur-description-<?=$ar_dtype['ID']?>" class="collapse" data-parent="#delivery-method-acard">
                                                            <div class="form-group">
                                                                <label for="curier-street"><?=GetMessage('ORDER_STREET')?>:</label>
                                                                <input
                                                                        type="text"
                                                                        class="form-control delivery-unstable"
                                                                        id="InputName-delivery-street-<?=$ar_dtype['ID']?>"
                                                                        placeholder="<?=GetMessage('ORDER_STREET_PLACE')?>"
                                                                        name="DELIVERY[<?=$ar_dtype['ID']?>][STREET]"
                                                                        data-delivery="<?=$ar_dtype['ID']?>"
                                                                        value="<?=$arResult['USER_DATA']['PERSONAL_STREET']?>"
                                                                />
                                                            </div>
                                                            <div class="deliv-settings">
                                                                <div class="form-group-row">
                                                                    <div class="form-group">
                                                                        <label for="curier-house"><?=GetMessage('ORDER_HOUSE')?>:</label>
                                                                        <input
                                                                                type="text"
                                                                                class="form-control delivery-unstable"
                                                                                id="InputName-delivery-hous-<?=$ar_dtype['ID']?>"
                                                                                placeholder="<?=GetMessage('ORDER_HOUSE_PLACE')?>"
                                                                                name="DELIVERY[<?=$ar_dtype['ID']?>][HOUSE]"
                                                                                data-delivery="<?=$ar_dtype['ID']?>"
                                                                                value="<?=$arResult['USER_DATA']['PERSONAL_STATE']?>"
                                                                        />
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="curier-house-numb" disabled=""><?=GetMessage('ORDER_FLAT')?>:</label>
                                                                        <input
                                                                                type="text"
                                                                                class="form-control delivery-unstable"
                                                                                id="InputName-delivery-room-<?=$ar_dtype['ID']?>"
                                                                                placeholder="<?=GetMessage('ORDER_FLAT_PLACE')?>"
                                                                                name="DELIVERY[<?=$ar_dtype['ID']?>][FLAT]"
                                                                                data-delivery="<?=$ar_dtype['ID']?>"
                                                                                value="<?=$arResult['USER_DATA']['PERSONAL_ZIP']?>"
                                                                        />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="deliv-about">
                                                                <h4><?=GetMessage('ORDER_DK')?></h4>
                                                                <?=GetMessage('ORDER_OPIS_DK')?>
                                                            </div>
                                                        </div>
                                                    <?endif;?>
                                                    <?
                                                }
                                                while ($ar_dtype = $db_dtype->Fetch());
                                            }
                                            else{
                                                echo GetMessage('ORDER_NO_NP')."<br>";
                                            }
                                            ?>
                                            <script>
                                                $(document).ready(function(){
                                                    $('#selectCity').change();
                                                    getNPOffices($('#selectCity').val(),"<?=$arResult['USER_DATA']['PERSONAL_NOTES']?>")
                                                });
                                            </script>
                                            <?if($arResult['USER_DATA']['PERSONAL_MAILBOX']=='curier'):?>
                                                <script>
                                                    $(document).ready(function(){
                                                        $('#delivery-np-cur-input-<?=$arResult["USER_DATA"]["WORK_ZIP"]?>').click();
                                                        $('#delivery-np-cur-description-<?=$arResult["USER_DATA"]["WORK_ZIP"]?>').addClass('show');
                                                    });
                                                </script>
                                            <?elseif($arResult['USER_DATA']['PERSONAL_MAILBOX']=='nova'):?>
                                                <script>
                                                    $(document).ready(function(){
                                                        $('#delivery-np-input-<?=$arResult["USER_DATA"]["WORK_ZIP"]?>').click();
                                                        $('#delivery-np-branch-description').addClass('show');
                                                    });
                                                </script>
                                            <?endif;?>
                                            <button class="delivery-save outline"><?=GetMessage('PERSONAL_SAVE')?></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lk-content-modal" data-show="question">
                <div class="lk-content-modal__header">
                    <span class="title"><?=GetMessage('PERSONAL_FAQ')?></span>
                    <button class="close" data-close="true">
                        <svg x="0px" y="0px" viewBox="0 0 30 30">
                            <path d="M25,6.2L23.8,5L15,13.8L6.2,5L5,6.2l8.8,8.8L5,23.8L6.2,25l8.8-8.8l8.8,8.8l1.2-1.2L16.2,15L25,6.2z"/>
                        </svg>
                    </button>
                </div>
                <div class="lk-content-modal__body">
                    <div class="col-12">
                        <?
                        CModule::IncludeModule('iblock');
                        $arSelect = Array("ID", "IBLOCK_ID", "NAME", "PREVIEW_TEXT");
                        $arFilter = Array("IBLOCK_ID"=>46);
                        $res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false, false, $arSelect);
                        while($ob = $res->fetch()){
                            ?>
                                <span>
                                    <h2 class="collapse-question"><?=$ob['NAME']?></h2>
                                    <div class="collapse-content-question">
                                        <p><?=$ob['PREVIEW_TEXT']?></p>
                                    </div>
                                </span>
                            <?} ?>
                    </div>
                </div>
            </div>
            <div class="lk-content-modal" data-show="new-order">
                <div class="lk-content-modal__header">
                    <span class="title"><?=GetMessage('PERSONAL_ORDERS')?></span>
                    <button class="close" data-close="true">
                        <svg x="0px" y="0px" viewBox="0 0 30 30">
                            <path d="M25,6.2L23.8,5L15,13.8L6.2,5L5,6.2l8.8,8.8L5,23.8L6.2,25l8.8-8.8l8.8,8.8l1.2-1.2L16.2,15L25,6.2z"
                            />
                        </svg>
                    </button>
                </div>
                <div class="lk-content-modal__body">
                    <div class="col-12">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:sale.personal.order.list",
                            "custom",
                            Array(
                                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                                "ALLOW_INNER" => "N",
                                "CACHE_GROUPS" => "Y",
                                "CACHE_TIME" => "3600",
                                "CACHE_TYPE" => "A",
                                "DEFAULT_SORT" => "STATUS",
                                "DISALLOW_CANCEL" => "N",
                                "HISTORIC_STATUSES" => array("D","DD","DF","F"),
                                "NAV_TEMPLATE" => "skarlat_custom",
                                "ONLY_INNER_FULL" => "N",
                                "ORDERS_PER_PAGE" => "5",
                                "PATH_TO_BASKET" => SITE_DIR."personal/cart/",
                                "PATH_TO_CANCEL" => "",
                                "PATH_TO_CATALOG" => SITE_DIR."catalog/",
                                "PATH_TO_COPY" => "",
                                "PATH_TO_DETAIL" => "",
                                "PATH_TO_PAYMENT" => SITE_DIR."personal/order/result/payment.php",
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
            <div class="lk-content-modal" data-show="history">
                <div class="lk-content-modal__header">
                    <span class="title"><?=GetMessage('PERSONAL_HISTORY')?></span>
                    <button class="close" data-close="true">
                        <svg x="0px" y="0px" viewBox="0 0 30 30">
                            <path d="M25,6.2L23.8,5L15,13.8L6.2,5L5,6.2l8.8,8.8L5,23.8L6.2,25l8.8-8.8l8.8,8.8l1.2-1.2L16.2,15L25,6.2z"/>
                        </svg>
                    </button>
                </div>
                <div class="lk-content-modal__body">
                    <div class="col-12">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:sale.personal.order.list",
                            "custom",
                            Array(
                                "ACTIVE_DATE_FORMAT" => "d.m.Y",
                                "ALLOW_INNER" => "N",
                                "CACHE_GROUPS" => "Y",
                                "CACHE_TIME" => "3600",
                                "CACHE_TYPE" => "A",
                                "DEFAULT_SORT" => "STATUS",
                                "DISALLOW_CANCEL" => "N",
                                "HISTORIC_STATUSES" => array("N","S","W","X"),
                                "NAV_TEMPLATE" => "skarlat_custom",
                                "ONLY_INNER_FULL" => "N",
                                "ORDERS_PER_PAGE" => "5",
                                "PATH_TO_BASKET" => SITE_DIR."personal/cart/",
                                "PATH_TO_CANCEL" => "",
                                "PATH_TO_CATALOG" => SITE_DIR."catalog/",
                                "PATH_TO_COPY" => "",
                                "PATH_TO_DETAIL" => "",
                                "PATH_TO_PAYMENT" => SITE_DIR."personal/order/result/payment.php",
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
            <?
            $dbUser = \Bitrix\Main\UserTable::getList(array(
                'select' => array('ID', 'UF_AFFILIATE', 'UF_COUPON'),
                'filter' => array('ID' => $USER->GetID())
            ));
            $arUser = $dbUser->fetch();
            if($arUser['UF_AFFILIATE']==1){?>
                <div class="lk-content-modal" data-show="partner">
                    <div class="lk-content-modal__header">
                        <span class="title"><?=GetMessage('PERSONAL_PARTNER')?></span>
                        <button class="close" data-close="true">
                            <svg x="0px" y="0px" viewBox="0 0 30 30">
                                <path
                                        d="M25,6.2L23.8,5L15,13.8L6.2,5L5,6.2l8.8,8.8L5,23.8L6.2,25l8.8-8.8l8.8,8.8l1.2-1.2L16.2,15L25,6.2z"
                                />
                            </svg>
                        </button>
                    </div>
                    <div class="lk-content-modal__body">
                        <div class="col-12">
                            <?
                            $count = NULL;
                            if (CModule::IncludeModule("sale")):
                                $arFilter = array(
                                 "BASKET_DISCOUNT_COUPON" => $arUser['UF_COUPON'],
                                  "@STATUS_ID" => array("F")
                                );
                                $db_sales = CSaleOrder::GetList(array("DATE_INSERT" => "DESC"),  $arFilter, false, array("nPageSize" =>5),  false);
                                $res->NavStart(0);
                                while ($arSales = $db_sales->Fetch())
                                {
                                      $count = 'Y';
                                      $arDeliv = CSaleDelivery::GetByID($arSales['DELIVERY_ID']);
                                      $arPaySys = CSalePaySystem::GetByID($arSales['PAY_SYSTEM_ID']);
                                      $arStatus = CSaleStatus::GetByID($arSales['STATUS_ID']); ?>
                                      <div class="order">
                                          <div class="order__item">
                                              <div class="collapse status-canceled">
                                                  <div class="short-info">
                                                      <small>№<?=$arSales['ID']?> от <?=$arSales['DATE_INSERT_FORMAT']?></small>
                                                      <span><?=$arStatus['NAME']?></span>
                                                  </div>
                                                  <div class="order__cost">
                                                      <span><?=round($arSales['PRICE'],0)?></span>
                                                      <span><?=Loc::getMessage('SPOL_TPL_CURENCY')?></span>
                                                  </div>
                                                  <div class="arrow"></div>
                                              </div>
                                              <div class="collapse-content-new-order" style="">
                                                  <button class="modal-info__icon"></button>
                                                  <div class="info-order">
                                                      <p><?=Loc::getMessage('SPOL_TPL_INFO')?></p>
                                                      <ul>
                                                          <li><?=$arSales['USER_LAST_NAME']?> <?=$arSales['USER_NAME']?></li>
                                                      </ul>
                                                  </div>
                                                  <div class="product-list">
                                                      <?
                                                      $arFilterBasket = Array(
                                                          "ORDER_ID" => $arSales['ID'],
                                                      );
                                                      $dbBasketItems = \CSaleBasket::GetList(
                                                          array("ID" => "ASC"),
                                                          $arFilterBasket,
                                                          false,
                                                          false,
                                                          array("ID", "NAME", "PRICE", "CURRENCY", "QUANTITY", "PREVIEW_PICTURE", "PRODUCT_ID", "DETAIL_PAGE_URL")
                                                      );
                                                      while ($item = $dbBasketItems->fetch()) {
                                                          $arFilter = Array( "ID"=> $item['PRODUCT_ID']);
                                                          $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>1), Array());
                                                          while($ob = $res->GetNextElement())
                                                          {
                                                              $imgId = $ob->GetFields()['PREVIEW_PICTURE'];
                                                              $shortName = $ob->GetProperties()['SHORT_CATEGORY_NAME']['VALUE'];
                                                          }
                                                          $file = CFile::ResizeImageGet($imgId, array('width'=>100, 'height'=>100), BX_RESIZE_IMAGE_EXACT, true);
                                                          ?>
                                                          <div class="product-item">
                                                              <div class="product-item__info">
                                                                  <div class="product-item__img">
                                                                      <img src="<?=$file['src']?>" alt="<?=$item['NAME']?>">
                                                                  </div>
                                                                  <div class="product-item__name">
                                                                      <p><?=$shortName?></p>
                                                                      <a href="<?=$item['DETAIL_PAGE_URL']?>">
                                                                          <span><?=$item['NAME']?></span>
                                                                      </a>
                                                                  </div>
                                                              </div>
                                                              <div class="product-item__order">
                                                                  <div class="coll">
                                                                      <div class="title">
                                                                          <?=Loc::getMessage('SPOL_TPL_CNT')?>
                                                                      </div>
                                                                      <div class="product-item__count">
                                                                          <?=$item['QUANTITY']?>x
                                                                      </div>
                                                                  </div>
                                                                  <div class="coll">
                                                                      <div class="title">
                                                                          <?=Loc::getMessage('SPOL_TPL_SUMOF')?>
                                                                      </div>
                                                                      <div class="product-item__price"><?=round($item['PRICE'],0)?><span><?=Loc::getMessage('SPOL_TPL_CURENCY')?></span></div>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                      <?}?>
                                                  </div>
                                                  <ul class="order-total-list">
                                                      <li class="order-total__item">
                                                          <div class="order-total__item-title"><?=Loc::getMessage('SPOL_TPL_PAYMENT')?></div>
                                                          <div class="order-total__value"><?=$arPaySys['NAME']?></div>
                                                      </li>
                                                      <li class="order-total__item">
                                                          <div class="order-total__item-title"><?=Loc::getMessage('SPOL_TPL_DELIVERY')?></div>
                                                          <div class="order-total__value"><?=$arDeliv['NAME']?></div>
                                                      </li>
                                                      <li class="order-total__item">
                                                          <div class="order-total__item-title"><?=Loc::getMessage('SPOL_TPL_FULL')?></div>
                                                          <div class="order-total__value cost"><?=round($arSales['PRICE'],0)?><span><?=Loc::getMessage('SPOL_TPL_CURENCY')?></span></div>
                                                      </li>
                                                  </ul>
                                              </div>
                                          </div>
                                      </div>
                                  <?}
                                $navStr = $db_sales->GetPageNavStringEx($navComponentObject, "Страницы:", "skarlat_custom");
                                echo $navStr;
                            endif;
                            if (empty($count)){?>
                                <h6><?=Loc::getMessage('SPOL_TPL_NOT_ORDERS')?></h6>
                            <?}?>
                        </div>
                    </div>
                </div>
                <div class="lk-content-modal" data-show="bonus">
                    <div class="lk-content-modal__header">
                        <span class="title"><?=GetMessage('PERSONAL_BONUS')?></span>
                        <button class="close" data-close="true">
                            <svg x="0px" y="0px" viewBox="0 0 30 30">
                                <path
                                        d="M25,6.2L23.8,5L15,13.8L6.2,5L5,6.2l8.8,8.8L5,23.8L6.2,25l8.8-8.8l8.8,8.8l1.2-1.2L16.2,15L25,6.2z"
                                />
                            </svg>
                        </button>
                    </div>
                    <div class="lk-content-modal__body">
                        <div class="col-12">
                            <ul class="bonus-info-list">
                                <?
                                $describe = Option::get("maycat.d7dull", "describe");
                                $accrued = Option::get("maycat.d7dull", "accrued");

                                //получаем начисление
                                $arSelect = array("PROPERTY_SUMA_DISCONT","TIMESTAMP_X","ACTIVE");
                                $arFilter = array("IBLOCK_ID"=>$accrued, "PROPERTY_USER_ID" => $USER->GetID());
                                $res = CIBlockElement::GetList(Array("TIMESTAMP_X" => "asc"), $arFilter, false, Array(), $arSelect);
                                while($ob = $res->GetNextElement())
                                {$arFields = $ob->GetFields();
                                    $arFieldsFull[] = array("TIMESTAMP_X" => $arFields["TIMESTAMP_X"], "ACTIVE" => $arFields["ACTIVE"] ,"PROPERTY_SUMA_DISCONT" => $arFields["PROPERTY_SUMA_DISCONT_VALUE"],'TYPE' => 'bonus-status-new');
                                }
                                //получаем списание
                                $arSelect = array("PROPERTY_SUMM","TIMESTAMP_X","ACTIVE");
                                $arFilter = array("IBLOCK_ID"=>$describe, "PROPERTY_USER_ID" => $USER->GetID());
                                $res = CIBlockElement::GetList(Array("TIMESTAMP_X" => "asc"), $arFilter, false, Array(), $arSelect);
                                while($ob = $res->GetNextElement())
                                {$arFields = $ob->GetFields();
                                    $arFieldsFull[] = array("TIMESTAMP_X" => $arFields["TIMESTAMP_X"], "ACTIVE" => $arFields["ACTIVE"] ,"PROPERTY_SUMA_DISCONT" => $arFields["PROPERTY_SUMM_VALUE"],'TYPE' => 'bonus-status-canceled');
                                    if($arFields["ACTIVE"]=="N"){
                                        $buttonHide = "Y";
                                    }
                                }
                                ?>
                                <li>
                                    <?=GetMessage('PERSONAL_BONUS_AVAILABLE')?>:<span><?echo round(CSaleUserAccount::GetByUserID($USER->GetID(), "UAH")['CURRENT_BUDGET'],0);?></span>
                                    <?if(empty($buttonHide)){?>
                                        <button class="modal-info__icon" data-url="<?=$url?>"  data-info="withdrawal" data-id="<?=$USER->GetID()?>"><?=GetMessage('PERSONAL_BONUS_REQUEST_DRAW')?></button>
                                    <?}else{?>
                                        <span><?=GetMessage('PERSONAL_BONUS_ACTIVE_REQUEST')?></span>
                                    <?}?>
                                </li>
                                <?
                                $dbUser = \Bitrix\Main\UserTable::getList(array(
                                    'select' => array('ID', 'UF_AFFILIATE', 'UF_COUPON'),
                                    'filter' => array('ID' => $USER->GetID())
                                ));
                                if ($arUser = $dbUser->fetch())?>
                                <li><?=GetMessage('PERSONAL_BONUS_PROMO')?>:<span><?if($arUser['UF_COUPON']!=NULL) echo $arUser['UF_COUPON']; else echo GetMessage('PERSONAL_BONUS_PROMO_REQUEST');?></span></li>
                            </ul>
                            <div class="bonus-list">
                                <div class="bonus-list__title"><?=GetMessage('PERSONAL_BONUS_HISTORY')?>:</div>
                                <?
                                usort($arFieldsFull, function($a, $b){
                                    return ($a['TIMESTAMP_X'] - $b['TIMESTAMP_X']);
                                });
                                foreach (array_reverse((array)$arFieldsFull) as $key => $arFields){?>
                                    <div class="bonus-wrap">
                                        <div class="bonus-item">
                                            <div class="bonus-status <?=$arFields['TYPE']?>"></div>
                                            <div class="bonus-item__header">
                                                <small><?=GetMessage('PERSONAL_BONUS_SUM')?></small>
                                                <small><?=GetMessage('PERSONAL_BONUS_STATUS')?></small>
                                            </div>
                                            <div class="bonus-item__body">
                                                <div class="bonus-short-info">
                                                    <small>№<?=count($arFieldsFull)-$key?> <?=GetMessage('PERSONAL_BONUS_FROM')?> <?= FormatDate("d.m.Y",MakeTimeStamp($arFields["TIMESTAMP_X"]));?></small>
                                                    <?if($arFields['TYPE'] == 'bonus-status-new'){?>
                                                        <span><?=GetMessage('PERSONAL_BONUS_ACCRUAL')?></span>
                                                    <?}else{?>
                                                        <span><?=GetMessage('PERSONAL_BONUS_WRITE_OFF')?></span>
                                                    <?}?>
                                                </div>
                                                <div class="bonus__operation">
                                                    <span>
                                                         <?if($arFields['TYPE'] == 'bonus-status-new'){?>
                                                             +
                                                         <?}else{?>
                                                             -
                                                         <?}?>
                                                        <?=round($arFields['PROPERTY_SUMA_DISCONT'],0)?>
                                                    </span>
                                                </div>
                                                <div class="bonus__balance">
                                                    <?if($arFields['ACTIVE']=='Y'){?>
                                                        <span class="status status-success"><?=GetMessage('PERSONAL_BONUS_SUCCESS')?></span>
                                                    <?}else{?>
                                                        <span class="status status-pending"><?=GetMessage('PERSONAL_BONUS_PENDING')?></span>
                                                    <?}?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?}?>
                            </div>
                        </div>
                    </div>
                </div>
            <?}?>
        </div>
    </div>
</section>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
