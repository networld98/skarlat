<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)
{
	die();
}

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);


if ($arResult['AUTHORIZED'])
{
	?>
	<script>
		$(document).mouseup(function (e){
			var div = $("#pills-enter");
			if (!div.is(e.target) && div.has(e.target).length === 0){
				window.location.reload();
			}
		});
	</script>
	<?
	echo Loc::getMessage('MAIN_AUTH_FORM_SUCCESS');
	return;
}
?>

<div class="bx-authform 111">
<?if($USER->isAuthorized()):?>
	<script>
		$(document).mouseup(function (e){
			var div = $("#pills-enter");
			if (!div.is(e.target) && div.has(e.target).length === 0){
				window.location.reload();
			}
		});
		setTimeout(function(){window.location.reload();},3000);
	</script>
    <?=GetMessage("SUCCESSFULL_AUTH")?>
<?else:?>
	<?if ($arResult['ERRORS']):?>
	<div class="alert alert-danger">
		<? foreach ($arResult['ERRORS'] as $error)
		{
			ShowError($error);
		}
		?>
	</div>
	<?endif;?>

	<form name="<?= $arResult['FORM_ID'];?>" id="loginUserAjax" method="post" action="">
        <div class="form-block">
            <div class="form-group">
                <label for="InputEmail-modal"><?=GetMessage("EMAIL")?></label>
                <input
                        type="email"
                        name="<?= $arResult['FIELDS']['login'];?>"
                        value="<?= \htmlspecialcharsbx($arResult['LAST_LOGIN']);?>"
                        class="form-control"
                        id="InputEmail-modal"
                        aria-describedby="emailHelp-modal"
                        placeholder="<?=GetMessage("ENTER_EMAIL")?>"
						required="required"
                />
                <small id="emailHelp-modal" class="form-text text-muted">
                    <?=GetMessage("SAFE_EMAIL")?>
                </small>
            </div>
            <div class="form-group">
                <label for="InputPassword-modal"><?=GetMessage("PASSWORD")?></label>
                <input
                        type="password"
                        name="<?= $arResult['FIELDS']['password'];?>"
                        autocomplete="off"
                        class="form-control"
                        id="InputPassword-modal"
                        placeholder="<?=GetMessage("ENTER_PASSWORD")?>"
						required="required"
                />
            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="checkbox"  id="USER_REMEMBER" name="<?= $arResult['FIELDS']['remember'];?>" />
                <label class="form-check-label" for="rememberMeEnter"><?=GetMessage("REMEMBER_ME")?></label>
            </div>
            <div class="form-group form-group-center">
                <button type="submit" class="btn-main" onclick="loginUser('loginUserAjax'); return false;" name="<?= $arResult['FIELDS']['action'];?>" value="<?= Loc::getMessage('MAIN_AUTH_FORM_FIELD_SUBMIT');?>"><?=GetMessage("ENTER")?></button>
            </div>
        </div>

        <div class="line"><?=GetMessage("OR")?></div>

        <div class="form-block another-autr">
            <span class="mt-3 mb-3 d-flex"><?=GetMessage("ENTER_LIKE_USER")?></span>
            <?$APPLICATION->IncludeComponent('bitrix:socserv.auth.form',
                'skarlat',
                array(
                    'AUTH_SERVICES' => $arResult['AUTH_SERVICES'],
                    'AUTH_URL' => $arResult['CURR_URI']
                ),
                $component,
                array('HIDE_ICONS' => 'Y')
            );
            ?>
        </div>
    </form>
<?endif;?>
</div>
