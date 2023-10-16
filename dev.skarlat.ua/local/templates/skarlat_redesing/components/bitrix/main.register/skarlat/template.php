<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();
?>

<?if($USER->IsAuthorized()):?>

<p><?echo GetMessage("MAIN_REGISTER_AUTH")?></p>

<?else:?>
<?
if (count($arResult["ERRORS"]) > 0):
	foreach ($arResult["ERRORS"] as $key => $error)
		if (intval($key) == 0 && $key !== 0) 
			$arResult["ERRORS"][$key] = str_replace("#FIELD_NAME#", "&quot;".GetMessage("REGISTER_FIELD_".$key)."&quot;", $error);

	ShowError(implode("<br />", $arResult["ERRORS"]));

elseif($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):
?>
<p><?echo GetMessage("REGISTER_EMAIL_WILL_BE_SENT")?></p>
<?endif?>

    <form method="post" action="<?=POST_FORM_ACTION_URI?>" name="regform" enctype="multipart/form-data">
		<input type="hidden" name="SIGNED_DATA" value="<?=htmlspecialcharsbx($arResult["SIGNED_DATA"])?>" />
        <div class="form-block">
            <div class="form-group">
                <label for="InputName"><?=GetMessage("NAME")?></label>
                <input type="text" class="form-control" name="REGISTER[NAME]" id="InputName" placeholder="<?=GetMessage("ENTER_NAME")?>" />
            </div>

            <div class="form-group">
                <label for="InputTel"><?=GetMessage("PHONE")?></label>
                <input type="text" class="form-control" name="REGISTER[PERSONAL_PHONE]" id="InputTel" placeholder="<?=GetMessage("ENTER_PHONE")?>" />
            </div>

            <div class="form-group">
                <label for="InputEmail"><?=GetMessage("EMAIL")?></label>
                <input type="email" class="form-control" name="REGISTER[EMAIL]" id="InputEmail" placeholder="<?=GetMessage("ENTER_EMAIL")?>" />
                <small id="emailHelp-forms" class="form-text text-muted"
                ><?=GetMessage("SAFE_EMAIL")?></small>
            </div>
            <div class="form-group">
                <label for="InputPassword-modal-new"><?=GetMessage("PASSWORD")?></label>
                <input
                        type="password"
                        class="form-control"
                        id="InputPassword-modal-new"
                        name="REGISTER[PASSWORD]"
                        autocomplete="off"
                        placeholder="<?=GetMessage("ENTER_PASSWORD")?>"
                />
            </div>

            <div class="form-group">
                <label for="InputPassword-repeat"><?=GetMessage("CONFIRM_PASSWORD")?></label>
                <input
                        type="password"
                        class="form-control"
                        id="InputPassword-repeat"
                        name="REGISTER[CONFIRM_PASSWORD]"
                        autocomplete="off"
                        placeholder="<?=GetMessage("ENTER_PASSWORD")?>"
                />
            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="checkbox" id="rememberMeReg" />
                <label class="form-check-label" for="rememberMeReg"><?=GetMessage("REMEMBER_ME")?></label>
            </div>
            <div class="form-group form-group-center">
                <button type="submit" name="register_submit_button" class="btn-main"><?=GetMessage("REGISTER")?></button>
            </div>
        </div>
    </form>
<?endif;?>