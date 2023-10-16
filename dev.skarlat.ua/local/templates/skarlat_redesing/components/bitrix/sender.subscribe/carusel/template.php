<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

use Bitrix\Main\Config\Option;

$action_on = Option::get("maycat.d7dull", "action_on");
$action_sms_send = Option::get("maycat.d7dull", "action_sms_send");
$action_color = Option::get("maycat.d7dull", "action_color");
$action_start = Option::get("maycat.d7dull", "action_start_date");
$action_stop = Option::get("maycat.d7dull", "action_stop_date");
$action_color_1 = Option::get("maycat.d7dull", "action_color_1");
$action_color_2 = Option::get("maycat.d7dull", "action_color_2");
$action_color_3 = Option::get("maycat.d7dull", "action_color_3");
$action_modal_title = Option::get("maycat.d7dull", "action_modal_title");
$action_modal_subtitle = Option::get("maycat.d7dull", "action_modal_subtitle");
$action_modal_text = Option::get("maycat.d7dull", "action_modal_text");
$action_modal_btn = Option::get("maycat.d7dull", "action_modal_btn");
$action_prefix = Option::get("maycat.d7dull", "action_prefix");
$action_picture_baraban = Option::get("maycat.d7dull", "action_picture_baraban");
$action_icon_baraban[1] = Option::get("maycat.d7dull", "action_icon_baraban_1");
$action_icon_baraban[2] = Option::get("maycat.d7dull", "action_icon_baraban_2");
$action_icon_baraban[3] = Option::get("maycat.d7dull", "action_icon_baraban_3");
$action_icon_baraban[4]= Option::get("maycat.d7dull", "action_icon_baraban_4");
$action_icon_baraban[5] = Option::get("maycat.d7dull", "action_icon_baraban_5");
$action_icon_baraban[6] = Option::get("maycat.d7dull", "action_icon_baraban_6");
$action_icon_baraban[7] = Option::get("maycat.d7dull", "action_icon_baraban_7");
$action_icon_baraban[8] = Option::get("maycat.d7dull", "action_icon_baraban_8");
$action_icon_baraban[9] = Option::get("maycat.d7dull", "action_icon_baraban_9");
$action_icon_baraban[10] = Option::get("maycat.d7dull", "action_icon_baraban_10");
$action_icon_baraban[11] = Option::get("maycat.d7dull", "action_icon_baraban_11");
$action_icon_baraban[12] = Option::get("maycat.d7dull", "action_icon_baraban_12");
$action_icon_baraban[13] = Option::get("maycat.d7dull", "action_icon_baraban_13");
$action_icon_baraban[14] = Option::get("maycat.d7dull", "action_icon_baraban_14");
$action_icon_baraban[15] = Option::get("maycat.d7dull", "action_icon_baraban_15");
foreach ($action_icon_baraban as $key => $icon){
    $arFile = CFile::ResizeImageGet($icon, array('width'=>75, 'height'=>75), BX_RESIZE_IMAGE_PROPORTIONAL, true);
    $action_icon_baraban[$key] = $arFile['src'];
}
$jsonIcon = json_encode($action_icon_baraban);

$buttonId = $this->randString();

\Bitrix\Main\UI\Extension::load('ui.fonts.opensans');

if($action_on == 'Y' && $action_start <= date('d.m.Y') && $action_stop >= date('d.m.Y')){
?>
<div class="bx-subscribe"  id="sender-subscribe">
    <?
    $frame = $this->createFrame("sender-subscribe", false)->begin();

    //Собираем список скидок
    if(CModule::IncludeModule('sale')){
        $result = Bitrix\Sale\Internals\DiscountTable::getList(
            array(
                'filter' => array(
                    "LID" => 'mg',
                    'ACTIVE' => 'Y',
                    array(
                        "LOGIC" => "OR",
                        "<=ACTIVE_FROM" => $DB->FormatDate(date("Y-m-d H:i:s"), "YYYY-MM-DD HH:MI:SS", CSite::GetDateFormat("FULL")),
                        "ACTIVE_FROM" => false,
                    ),
                    array(
                        "LOGIC" => "OR",
                        ">=ACTIVE_TO" => $DB->FormatDate(date("Y-m-d H:i:s"), "YYYY-MM-DD HH:MI:SS", CSite::GetDateFormat("FULL")),
                        "ACTIVE_TO" => false,
                    ),
                ), // фильтр
            ));
        while ($data = $result->fetch()){

            if (strpos($data['NAME'], $action_prefix) !== false) {
                $discountArray[] = $data['ID'];
                $discountArrayName[$data['ID']] = $data['NAME'];
            }


        }
    }
    $discountArray = json_encode($discountArray);
    $discountArrayName = json_encode(str_replace($action_prefix, "", $discountArrayName));
    ?>

    <script>
        $(document).ready(function() {
            $("input[name='SENDER_SUBSCRIBE_EMAIL']").inputmask("+389999999999",{ showMaskOnHover: true });
            let items = <?=$discountArray?>;
            let arrayIcon = JSON.parse('<?php echo $jsonIcon; ?>');
            let r1 = 0, r2 = 35, sectors = "", texts = "", spins = 0;
            with (Math) for (var i = 0; i <= items.length; i++) {
                let a = 2 * PI / items.length * i, x = cos(a), y = sin(a);
                if (i > 0)
                    sectors += `L${x * r2},${y * r2}L${x * r1},${y * r1}Z"></path>`
                if (i < items.length) {
                    sectors += `<path fill="${i ? i % 2 ? '<?=$action_color_1?>' : '<?=$action_color_2?>' : '<?=$action_color_3?>'}" d="M${x * r1},${y * r1}L${x * r2},${y * r2}`;
                    a += PI / items.length, x = cos(a), y = sin(a), r3 = (r1 + r2) / 2 - 0.5;
                    texts += `<text id="${a}" x="${x * r3}" y="${y * r3}" transform="rotate(${a / PI * 180} ${x * r3} ${y * r3})">${items[i]}</text><image xlink:href="${arrayIcon[i + 1]}" width="15%" height="15%" id="${a}" x="${x * r3 - 3}" y="${y * r3 + 8}" transform="rotate(${a / PI * 180} ${x * r3} ${y * r3})" />`
                }
            }
            roulette.innerHTML = sectors + texts;
            $('#crazyrocket-launch-icon').click(function (){
                $('.carusel-modal').addClass('active');
                $('#roulette').addClass('active');
                let r1 = 0, r2 = 35, sectors = "", texts = "", spins = 0;
                spins += 2;
                let c1= Math.floor(Math.random()*items.length);
                var c = items[c1];
                let cell = roulette.querySelectorAll('text')[items.indexOf(c)];
                roulette.setAttribute('transform', `rotate(${spins*360-cell.id/Math.PI*180})`)
                roulette.timeout && clearTimeout(roulette.timeout);
            })
            $('.carusel-modal .close').click(function (){
                $('.carusel-modal').removeClass('active');
                $('#roulette').removeClass('active');
            })

        });
    </script>
    <?if(isset($arResult['MESSAGE'])): CJSCore::Init(array("popup"));
    if($arResult['MESSAGE']['TYPE']=='NOTE'){?>
        <script>
            BX.ready(function() {
                $('.carusel-modal').addClass('active');
                $('#roulette').addClass('active');
                function carusel(items) {
                    let r1 = 0, r2 = 35, sectors = "", texts = "", spins = 0;
                    spins += 5;
                    let c1 = Math.floor(Math.random()*items.length);
                    var c = items[c1];
                    $.ajax({
                        type: "POST",
                        url: "/ajax/generateActionCoupon.php",
                        data: {id:c,phone:<?=$arResult['EMAIL']?>,name:<?=$discountArrayName?>},
                        success: function (data) {
                            $('#val').html(data);
                        }
                    });
                    let cell = roulette.querySelectorAll('text')[items.indexOf(c)];
                    let cellId = cell.id;
                    roulette.setAttribute('transform', `rotate(${spins * 360 - cellId / Math.PI * 180})`)
                    roulette.timeout && clearTimeout(roulette.timeout);
                }
                $('#copyBtn').click(function(){
                    var el = $("#copyTarget");
                    var $tmp = $("<textarea>");
                    $("body").append($tmp);
                    $tmp.val($(el).text()).select();
                    document.execCommand("copy");
                    $tmp.remove();
                    alert('промокод скопійовано в буфер обміну')
                })
                let items = <?=$discountArray?>;
                carusel(items);
                $("input[name='SENDER_SUBSCRIBE_EMAIL']").inputmask("+389999999999", {showMaskOnHover: true});
            });
        </script>
    <?}?>
        <div id="sender-subscribe-response-cont" style="display: none;">
            <div class="bx_subscribe_response_container">
                <table>
                    <tr>
                        <td style="padding-right: 40px; padding-bottom: 0px;"><img src="<?=($this->GetFolder().'/images/'.($arResult['MESSAGE']['TYPE']=='ERROR' ? 'icon-alert.png' : 'icon-ok.png'))?>" alt=""></td>
                        <td>
                            <div style="font-size: 22px;"><?=GetMessage('subscr_form_response_TEXT_'.$arResult['MESSAGE']['TYPE'])?></div>
                            <text id="val"></text>
                            <?if($arResult['MESSAGE']['TYPE']=='NOTE' && $action_sms_send != "Y"){?>
                                <div class="sender-btn btn-subscribe copy-btn" id="copyBtn"><span>Скопіювати</span></div>
                            <?}?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <script>
            BX.ready(function(){
                var oPopup = BX.PopupWindowManager.create('sender_subscribe_component', window.body, {
                    autoHide: true,
                    offsetTop: 1,
                    offsetLeft: 0,
                    lightShadow: true,
                    closeIcon: true,
                    closeByEsc: true,
                    overlay: {
                        backgroundColor: 'rgba(57,60,67,0.82)', opacity: '80'
                    }
                });
                oPopup.setContent(BX('sender-subscribe-response-cont'));
                oPopup.show();
            });
        </script>
    <?endif;?>
    <script>
        (function () {
            var btn = BX('bx_subscribe_btn_<?=$buttonId?>');
            var form = BX('bx_subscribe_subform_<?=$buttonId?>');

            if(!btn)
            {
                return;
            }
            function mailSender()
            {
                setTimeout(function() {
                    if(!btn)
                    {
                        return;
                    }

                    var btn_span = btn.querySelector("span");
                    var btn_subscribe_width = btn_span.style.width;
                    BX.addClass(btn, "send");
                    btn_span.outterHTML = "<span><i class='fa fa-check'></i> <?=GetMessage("subscr_form_button_sent")?></span>";
                    if(btn_subscribe_width)
                    {
                        btn.querySelector("span").style["min-width"] = btn_subscribe_width+"px";
                    }
                }, 400);
            }
            BX.ready(function()
            {
                BX.bind(btn, 'click', function() {
                    setTimeout(mailSender, 250);
                    return false;
                });
            });

            BX.bind(form, 'submit', function () {
                btn.disabled=true;
                setTimeout(function () {
                    btn.disabled=false;
                }, 2000);

                return true;
            });
        })();
    </script>
    <div id="crazyrocket-launch-icon" style="background-color:<?=$action_color?>;">
        <div class="ls-font-icon ls-font-gift-box">
            <svg version="1.1" id="Layer_2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 width="50px" height="100px" viewBox="-914 246 150 50" xml:space="preserve">
        <path d="M-812.5,249.8h-26.1c5.7-1.9,10.5-4.4,12.3-7.5l0.1-0.1c0.9-1.8,1.5-4.2-1.2-8.5c-2.7-4.3-5.2-4.8-6.9-4.8
            c-7.8,0-19.1,14.4-23.5,20.6l-0.2,0.3h-2.1l-0.2-0.2c-4.4-6.2-15.6-20.7-23.5-20.7c-2.3,0-4.6,1.6-6.7,4.8c-0.8,1.4-3.2,5.5-1.1,8.6
            l0.2,0.2c1.9,3.2,6.6,5.6,11.7,7.3h-25.8c-1.4,0-2.5,1.1-2.5,2.5v16.5c0,1.4,1.1,2.5,2.5,2.5h2.8v49.2c0,1.4,1.1,2.5,2.5,2.5h82.4
            c1.4,0,2.5-1.1,2.5-2.5v-49.2h2.8c1.4,0,2.5-1.1,2.5-2.5v-16.5C-810,251-811.1,249.8-812.5,249.8z M-834.3,234c0.3,0,1.2,0,2.7,2.4
            c1.4,2.3,1.2,3,1,3.5c-1.5,2.5-8.9,5.7-19.4,7.7C-842.7,238.3-836.9,234-834.3,234z M-887.2,239.9l-0.2-0.3l-0.1-0.1
            c0-0.3,0.1-1.2,1.2-3.1c1.3-2,2.2-2.4,2.4-2.4c2.6,0,8.4,4.3,15.8,13.8C-879.1,245.6-885.9,242.4-887.2,239.9z M-903,265.9v-10.5
            c0-0.3,0.2-0.5,0.5-0.5h41v11.5h-41C-902.8,266.4-903,266.2-903,265.9z M-897.7,271.4h36.2v46.7h-36.2V271.4z M-820.3,318.1h-36.2
            v-46.7h36.2V318.1z M-815.5,266.4h-41.1v-11.5h41.1c0.3,0,0.5,0.2,0.5,0.5v10.5C-815,266.2-815.2,266.4-815.5,266.4z"/>
        </svg>
        </div>
    </div>
    <div class="carusel-modal">
        <? $arFile = CFile::ResizeImageGet($action_picture_baraban, array('width'=>1000, 'height'=>1000), BX_RESIZE_IMAGE_PROPORTIONAL, true); ?>
        <div class="carusel-content" style="background: #fff url('<?=$arFile['src']?>') no-repeat top right;">
            <button class="close" data-close="true">
                <svg x="0px" y="0px" viewBox="0 0 30 30">
                    <path d="M25,6.2L23.8,5L15,13.8L6.2,5L5,6.2l8.8,8.8L5,23.8L6.2,25l8.8-8.8l8.8,8.8l1.2-1.2L16.2,15L25,6.2z"></path>
                </svg>
            </button>
            <div class="row">
                <div class="col-lg-3 col-sm-3 d-none d-sm-none d-md-block d-lg-block">
                    <svg class="carusel" viewBox="0 -38 35 75">
                        <g id="roulette"></g>
                        <path d="M30, 0L33,2L33,-2Z" fill="<?=$action_color?>"></path>
                        <circle cx="0" cy="0" r="5" stroke="<?=$action_color?>" stroke-width="1" fill="<?=$action_color?>" />
                        <circle cx="0" cy="0" r="34" stroke="<?=$action_color?>" stroke-width="2" fill="transparent"></circle>
                    </svg>
                </div>
                <div class="col-lg-4 col-sm-8 text-content-carusel">
                    <h3 style="color:<?=$action_color?>;"><?=$action_modal_title?></h3>
                    <p class="subtitle"><?=$action_modal_subtitle?></p>
                    <?=$action_modal_text?>
                    <form id="bx_subscribe_subform_<?=$buttonId?>" role="form" method="post" action="<?=$arResult["FORM_ACTION"]?>">
                        <?=bitrix_sessid_post()?>
                        <input type="hidden" name="sender_subscription" value="add">

                        <div class="bx-input-group">
                            <input class="bx-form-control" type="tel" name="SENDER_SUBSCRIBE_EMAIL" value="<?=$arResult["PHONE"]?>" title="<?=GetMessage("subscr_form_phone_title")?>" placeholder="<?=htmlspecialcharsbx(GetMessage('subscr_form_phone_title'))?>">
                        </div>

                        <div style="<?=(($arParams['HIDE_MAILINGS'] ?? '') <> 'Y' ? '' : 'display: none;')?>">
                            <?if(count($arResult["RUBRICS"])>0):?>
                                <div class="bx-subscribe-desc"><?=GetMessage("subscr_form_title_desc")?></div>
                            <?endif;?>
                            <?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
                                <div class="bx_subscribe_checkbox_container">
                                    <input type="checkbox" name="SENDER_SUBSCRIBE_RUB_ID[]" id="SENDER_SUBSCRIBE_RUB_ID_<?=$itemValue["ID"]?>" value="<?=$itemValue["ID"]?>"<?if($itemValue["CHECKED"]) echo " checked"?>>
                                    <label for="SENDER_SUBSCRIBE_RUB_ID_<?=$itemValue["ID"]?>"><?=htmlspecialcharsbx($itemValue["NAME"])?></label>
                                </div>
                            <?endforeach;?>
                        </div>

                        <?if (($arParams['USER_CONSENT'] ?? '') == 'Y'  && $arParams['AJAX_MODE'] <> 'Y'):?>
                            <div class="bx_subscribe_checkbox_container bx-sender-subscribe-agreement">
                                <?$APPLICATION->IncludeComponent(
                                    "bitrix:main.userconsent.request",
                                    "",
                                    array(
                                        "ID" => $arParams["USER_CONSENT_ID"],
                                        "IS_CHECKED" => $arParams["USER_CONSENT_IS_CHECKED"],
                                        "AUTO_SAVE" => "Y",
                                        "IS_LOADED" => $arParams["USER_CONSENT_IS_LOADED"],
                                        "ORIGIN_ID" => "sender/sub",
                                        "ORIGINATOR_ID" => "",
                                        "REPLACE" => array(
                                            "button_caption" => GetMessage("subscr_form_button"),
                                            "fields" => array(GetMessage("subscr_form_email_title"))
                                        ),
                                    )
                                );?>
                            </div>
                        <?endif;?>

                        <div class="bx_subscribe_submit_container">
                            <button class="sender-btn btn-subscribe" style="background-color:<?=$action_color?>;" id="bx_subscribe_btn_<?=$buttonId?>"><span><?=$action_modal_btn?></span></button>
                            <div class="close">Ні, дякую</div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <?
    $frame->beginStub();
    ?>
    <?if(isset($arResult['MESSAGE'])): CJSCore::Init(array("popup"));?>
        <div id="sender-subscribe-response-cont" style="display: none;">
            <div class="bx_subscribe_response_container">
                <table>
                    <tr>
                        <td style="padding-right: 40px; padding-bottom: 0px;"><img src="<?=($this->GetFolder().'/images/'.($arResult['MESSAGE']['TYPE']=='ERROR' ? 'icon-alert.png' : 'icon-ok.png'))?>" alt=""></td>
                        <td>
                            <div style="font-size: 22px;"><?=GetMessage('subscr_form_response_'.$arResult['MESSAGE']['TYPE'])?></div>
                            <div style="font-size: 16px;"><p><?=GetMessage('subscr_form_response_TEXT_'.$arResult['MESSAGE']['TYPE'])?></p></div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <script>
            BX.ready(function(){
                var oPopup = BX.PopupWindowManager.create('sender_subscribe_component', window.body, {
                    autoHide: true,
                    offsetTop: 1,
                    offsetLeft: 0,
                    lightShadow: true,
                    closeIcon: true,
                    closeByEsc: true,
                    overlay: {
                        backgroundColor: 'rgba(57,60,67,0.82)', opacity: '80'
                    }
                });
                oPopup.setContent(BX('sender-subscribe-response-cont'));
                oPopup.show();
            });
        </script>
    <?endif;?>

    <script>
        (function () {
            var btn = BX('bx_subscribe_btn_<?=$buttonId?>');
            var form = BX('bx_subscribe_subform_<?=$buttonId?>');
            if(!btn)
            {
                return;
            }

            function mailSender()
            {
                setTimeout(function() {
                    if(!btn)
                    {
                        return;
                    }

                    var btn_span = btn.querySelector("span");
                    var btn_subscribe_width = btn_span.style.width;
                    BX.addClass(btn, "send");
                    btn_span.outterHTML = "<span><i class='fa fa-check 2'></i> <?=GetMessage("subscr_form_button_sent")?></span>";
                    if(btn_subscribe_width)
                    {
                        btn.querySelector("span").style["min-width"] = btn_subscribe_width+"px";
                    }
                }, 400);
            }

            BX.ready(function()
            {
                BX.bind(btn, 'click', function() {
                    setTimeout(mailSender, 250);
                    return false;
                });
            });

            BX.bind(form, 'submit', function () {
                btn.disabled=true;
                setTimeout(function () {
                    btn.disabled=false;
                }, 2000);

                return true;
            });
        })();
    </script>

    <form id="bx_subscribe_subform_<?=$buttonId?>" role="form" method="post" action="<?=$arResult["FORM_ACTION"]?>">
        <?=bitrix_sessid_post()?>
        <input type="hidden" name="sender_subscription" value="add">

        <div class="bx-input-group">
            <input class="bx-form-control" type="tel" name="SENDER_SUBSCRIBE_EMAIL" value="" title="<?=GetMessage("subscr_form_email_title")?>" placeholder="<?=htmlspecialcharsbx(GetMessage('subscr_form_email_title'))?>">
        </div>

        <div style="<?=(($arParams['HIDE_MAILINGS'] ?? '') <> 'Y' ? '' : 'display: none;')?>">
            <?if(count($arResult["RUBRICS"])>0):?>
                <div class="bx-subscribe-desc"><?=GetMessage("subscr_form_title_desc")?></div>
            <?endif;?>
            <?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
                <div class="bx_subscribe_checkbox_container">
                    <input type="checkbox" name="SENDER_SUBSCRIBE_RUB_ID[]" id="SENDER_SUBSCRIBE_RUB_ID_<?=$itemValue["ID"]?>" value="<?=$itemValue["ID"]?>">
                    <label for="SENDER_SUBSCRIBE_RUB_ID_<?=$itemValue["ID"]?>"><?=htmlspecialcharsbx($itemValue["NAME"])?></label>
                </div>
            <?endforeach;?>
        </div>

        <?if (($arParams['USER_CONSENT_USE'] ?? '') == 'Y' && $arParams['AJAX_MODE'] <> 'Y'):?>
            <div class="bx_subscribe_checkbox_container bx-sender-subscribe-agreement">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.userconsent.request",
                    "",
                    array(
                        "ID" => $arParams["USER_CONSENT_ID"],
                        "IS_CHECKED" => $arParams["USER_CONSENT_IS_CHECKED"],
                        "AUTO_SAVE" => "Y",
                        "IS_LOADED" => "N",
                        "ORIGIN_ID" => "sender/sub",
                        "ORIGINATOR_ID" => "",
                        "REPLACE" => array(
                            "button_caption" => GetMessage("subscr_form_button"),
                            "fields" => array(GetMessage("subscr_form_email_title"))
                        ),
                    )
                );?>
            </div>
        <?endif;?>

        <div class="bx_subscribe_submit_container">
            <button class="sender-btn btn-subscribe" id="bx_subscribe_btn_<?=$buttonId?>"><span><?=GetMessage("subscr_form_button")?></span></button>
        </div>
    </form>
    <?
    $frame->end();
    ?>
</div>
<?}