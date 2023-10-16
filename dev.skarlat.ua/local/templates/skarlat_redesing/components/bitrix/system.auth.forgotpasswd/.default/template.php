<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?><?
?>
<section class="bg-lightgrey">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="block-head">
                    <h1><?= GetMessage("AUTH_GET_CHECK_STRING") ?></h1>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="container eng-forgot block-mb">
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            <?
            if (!empty($arParams["~AUTH_RESULT"])):
                $text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);
                ?>
                <div class="alert <?= ($arParams["~AUTH_RESULT"]["TYPE"] == "OK" ? "alert-success" : "alert-danger") ?>"><?= nl2br(htmlspecialcharsbx($text)) ?></div>
            <? endif ?>
            <form class="order-form-callback auth-reg-wrapp" name="bform" method="post" target="_top"
                  action="<?= $arResult["AUTH_URL"] ?>">
                <?
                if ($arResult["BACKURL"] <> '') {
                    ?>
                    <input type="hidden" name="backurl" value="<?= $arResult["BACKURL"] ?>"/>
                    <?
                }
                ?>
                <input type="hidden" name="AUTH_FORM" value="Y">
                <input type="hidden" name="TYPE" value="SEND_PWD">

                <p class="bx-authform-content-container"><? echo GetMessage("sys_forgot_pass_label") ?></p>
                <?if($arResult["BACKURL"] <> ''):?>
                    <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
                <?endif?>
                <div class="form-group">
                    <label for="name-user"><?= GetMessage("sys_forgot_pass_login1") ?></label>
                    <input type="text" name="USER_LOGIN" value="<?= $arResult["USER_LOGIN"] ?>"/>
                    <input type="hidden" name="USER_EMAIL"/>
                    <div class="bx-authform-note-container"><? echo GetMessage("sys_forgot_pass_note_email") ?></div>
                </div>

                <? if ($arResult["PHONE_REGISTRATION"]): ?>
                    <div class="bx-authform-formgroup-container">
                        <div class="bx-authform-label-container"><?= GetMessage("sys_forgot_pass_phone") ?></b></div>
                        <div><input type="text" name="USER_PHONE_NUMBER" value="<?= $arResult["USER_PHONE_NUMBER"] ?>"/>
                        </div>
                        <div><? echo GetMessage("sys_forgot_pass_note_phone") ?></div>
                    </div>
                <? endif; ?>
                <? if ($arResult["USE_CAPTCHA"]): ?>
                    <div class="bx-authform-formgroup-container">
                        <div>
                            <input type="hidden" name="captcha_sid" value="<?= $arResult["CAPTCHA_CODE"] ?>"/>
                            <img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult["CAPTCHA_CODE"] ?>"
                                 width="180" height="40" alt="CAPTCHA"/>
                        </div>
                        <div><? echo GetMessage("system_auth_captcha") ?></div>
                        <div><input type="text" name="captcha_word" maxlength="50" value=""/></div>
                    </div>
                <? endif ?>
                <input class="primary send-form" type="submit" name="send_account_info"
                       value="<?= GetMessage("AUTH_SEND") ?>"/>
                <noindex>
                    <a href="<?= $arResult["AUTH_AUTH_URL"] ?>"><?= GetMessage("AUTH_AUTH") ?></a>
                    <noindex>
            </form>


        </div>
    </div>
</div>
<script type="text/javascript">
    document.bform.onsubmit = function () {
        document.bform.USER_EMAIL.value = document.bform.USER_LOGIN.value;
    };
    document.bform.USER_LOGIN.focus();
</script>
