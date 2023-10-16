<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $component
 */

//one css for all system.auth.* forms
$APPLICATION->SetAdditionalCSS("/bitrix/css/main/system.auth/flat/style.css");
?>
    <div class="container block-mb">
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <?
                if(!empty($arParams["~AUTH_RESULT"])):
                    $text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);
                    ?>
                    <div class="alert alert-danger"><?=nl2br(htmlspecialcharsbx($text))?></div>
                <?endif?>

                <?
                if($arResult['ERROR_MESSAGE'] <> ''):
                    $text = str_replace(array("<br>", "<br />"), "\n", $arResult['ERROR_MESSAGE']);
                    ?>
                    <div class="alert alert-danger"><?=nl2br(htmlspecialcharsbx($text))?></div>
                <?endif?>
                <form class="order-form-auth auth-reg-wrapp" name="form_auth" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
                    <input type="hidden" name="AUTH_FORM" value="Y" />
                    <input type="hidden" name="TYPE" value="AUTH" />
                    <?if ($arResult["BACKURL"] <> ''):?>
                        <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
                    <?endif?>
                    <?foreach ($arResult["POST"] as $key => $value):?>
                        <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
                    <?endforeach?>
                    <div class="form-group">
                        <label for="email-user"><?=GetMessage("AUTH_LOGIN")?>:</label>
                        <input type="text" autocomplete="off" name="USER_LOGIN" maxlength="255" value="<?=$_SESSION['email']?>" />
                    </div>
                    <div class="form-group">
                        <label for="pass-user"><?=GetMessage("AUTH_PASSWORD")?>:</label>
                        <?if($arResult["SECURE_AUTH"]):?>
                            <div class="bx-authform-psw-protected" id="bx_auth_secure" style="display:none"><div class="bx-authform-psw-protected-desc"><span></span><?echo GetMessage("AUTH_SECURE_NOTE")?></div></div>

                            <script type="text/javascript">
                                document.getElementById('bx_auth_secure').style.display = '';
                            </script>
                        <?endif?>
                        <input type="password" name="USER_PASSWORD" maxlength="255" autocomplete="off" />
                    </div>
                    <input type="submit" class="primary send-form" name="Login" value="<?=GetMessage("AUTH_AUTHORIZE")?>" />
                    <?if ($arParams["NOT_SHOW_LINKS"] != "Y"):?>
                        <noindex>
                            <a href="/en/personal/order/result/change.php?forgot_password=yes" rel="nofollow"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a>
                        </noindex>
                    <?endif?>
                </form>
            </div>
        </div>
    </div>

<script type="text/javascript">
<?if ($arResult["LAST_LOGIN"] <> ''):?>
try{document.form_auth.USER_PASSWORD.focus();}catch(e){}
<?else:?>
try{document.form_auth.USER_LOGIN.focus();}catch(e){}
<?endif?>
</script>

