<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */

//one css for all system.auth.* forms
$APPLICATION->SetAdditionalCSS("/bitrix/css/main/system.auth/flat/style.css");
?>
<section class="bg-lightgrey">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="block-head">
                    <h1><?=GetMessage("AUTH_GET_CHECK_STRING")?></h1>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="container  block-mb">
    <div class="row">
        <div class="col-12 d-flex justify-content-center">

            <?
            if(!empty($arParams["~AUTH_RESULT"])):
                $text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);
            ?>
                <div class="alert <?=($arParams["~AUTH_RESULT"]["TYPE"] == "OK"? "alert-success":"alert-danger")?>"><?=nl2br(htmlspecialcharsbx($text))?></div>
            <?endif?>
                <form class="order-form-callback auth-reg-wrapp" name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
                    <p class="bx-authform-content-container"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></p>
                    <?if($arResult["BACKURL"] <> ''):?>
                        <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
                    <?endif?>
                    <input type="hidden" name="AUTH_FORM" value="Y">
                    <input type="hidden" name="TYPE" value="SEND_PWD">
                    <div class="form-group">
                        <label for="name-user"><?echo GetMessage("AUTH_LOGIN_EMAIL")?>:</label>
                        <?if($_SESSION['email']){?>
                            <input type="text" name="USER_LOGIN" maxlength="255" disabled value="<?=$_SESSION['email']?>" />
                        <?}else{?>
                            <input type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["USER_LOGIN"]?>" />
                        <?}?>
                            <input type="hidden" name="USER_EMAIL" />
                        <div class="bx-authform-note-container"><?echo GetMessage("forgot_pass_email_note")?></div>
                    </div>
                    <?if($arResult["PHONE_REGISTRATION"]):?>
                        <div class="bx-authform-formgroup-container">
                            <div class="bx-authform-label-container"><?echo GetMessage("forgot_pass_phone_number")?></div>
                            <div class="bx-authform-input-container">
                                <input type="text" name="USER_PHONE_NUMBER" maxlength="255" value="<?=$arResult["USER_PHONE_NUMBER"]?>" />
                            </div>
                        </div>
                    <?endif?>
                    <?if ($arResult["USE_CAPTCHA"]):?>
                        <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
                        <div class="bx-authform-formgroup-container">
                            <div class="bx-authform-label-container"><?echo GetMessage("system_auth_captcha")?></div>
                            <div class="bx-captcha"><img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /></div>
                            <div class="bx-authform-input-container">
                                <input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off"/>
                            </div>
                        </div>
                    <?endif?>
                        <input type="submit" class="primary send-form" name="send_account_info" value="<?=GetMessage("AUTH_SEND")?>" />
                        <noindex>
                            <a href="<?=$arResult["AUTH_AUTH_URL"]?>"><?=GetMessage("AUTH_AUTH")?></a>
                        <noindex>
                </form>
        </div>
    </div>
</div>


<script type="text/javascript">
document.bform.onsubmit = function(){document.bform.USER_EMAIL.value = document.bform.USER_LOGIN.value;};
document.bform.USER_LOGIN.focus();
</script>
