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

if($arResult["SHOW_SMS_FIELD"] == true)
{
	CJSCore::Init('phone_auth');
}
?>
<?if($USER->IsAuthorized()):?>
<script>
	$(document).mouseup(function (e){
		var div = $("#pills-tabContent");
		if (!div.is(e.target) && div.has(e.target).length === 0){
			window.location.reload();
		}
	});
	setTimeout(function(){window.location.reload();},3000);
</script>
<p><?echo GetMessage("MAIN_REGISTER_AUTH")?></p>

<?else:?>
<?
if (count($arResult["ERRORS"]) > 0):
	foreach ($arResult["ERRORS"] as $key => $error){
		if (intval($key) == 0 && $key !== 0)
			$arResult["ERRORS"][$key] = str_replace('Пользователь с логином "'.$_REQUEST['REGISTER']['LOGIN'].'" уже существует.', "", str_replace("#FIELD_NAME#", "&quot;".GetMessage("REGISTER_FIELD_".$key)."&quot;", $error));
		else
			$arResult["ERRORS"][$key] = str_replace('<br>', "", str_replace('Пользователь с логином "'.$_REQUEST['REGISTER']['LOGIN'].'" уже существует.', "", str_replace("#FIELD_NAME#", "&quot;".GetMessage("REGISTER_FIELD_".$key)."&quot;", $error)));
	}
	ShowError(implode("<br />", $arResult["ERRORS"]));

elseif($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):
?>
<p><?echo GetMessage("REGISTER_EMAIL_WILL_BE_SENT")?></p>
<?endif?>

<?if($arResult["SHOW_SMS_FIELD"] == true):?>
<?else:?>

<form method="post" action="<?=POST_FORM_ACTION_URI?>" id="modalRegister" name="regform" enctype="multipart/form-data">
<?
if($arResult["BACKURL"] <> ''):
?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?
endif;
?>
<?
	$arResult["SHOW_FIELDS"]=array("LOGIN","NAME","PERSONAL_PHONE","EMAIL","PASSWORD","CONFIRM_PASSWORD");
?>
<div class="form-block">
<?foreach ($arResult["SHOW_FIELDS"] as $FIELD):?>
	<?if($FIELD == "AUTO_TIME_ZONE" && $arResult["TIME_ZONE_ENABLED"] == true):?>
	<?else:?>
		<div class="form-group" <?=($FIELD=='LOGIN') ? 'style="display:none;"' : "";?>>
            <label for="InputName">
				<?=GetMessage("REGISTER_FIELD_".$FIELD)?>
			</label>
			<?
				switch ($FIELD)
				{
					case "PASSWORD":
						?><input required="required" size="30" type="password" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" placeholder="<?=GetMessage("REGISTER_FIELD_".$FIELD)?>" autocomplete="off" class="form-control" />

			<?
						break;
					case "CONFIRM_PASSWORD":
						?><input required="required" size="30" type="password" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" placeholder="<?=GetMessage("REGISTER_FIELD_".$FIELD)?>" autocomplete="off" class="form-control" /><?
						break;

					case "PERSONAL_GENDER":
						?><select name="REGISTER[<?=$FIELD?>]" class="form-control">
							<option value=""><?=GetMessage("USER_DONT_KNOW")?></option>
							<option value="M"<?=$arResult["VALUES"][$FIELD] == "M" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_MALE")?></option>
							<option value="F"<?=$arResult["VALUES"][$FIELD] == "F" ? " selected=\"selected\"" : ""?>><?=GetMessage("USER_FEMALE")?></option>
						</select><?
						break;

					case "PERSONAL_COUNTRY":
					case "WORK_COUNTRY":
						?><select name="REGISTER[<?=$FIELD?>]" class="form-control"><?
						foreach ($arResult["COUNTRIES"]["reference_id"] as $key => $value)
						{
							?><option value="<?=$value?>"<?if ($value == $arResult["VALUES"][$FIELD]):?> selected="selected"<?endif?>><?=$arResult["COUNTRIES"]["reference"][$key]?></option>
						<?
						}
						?></select><?
						break;

					case "PERSONAL_PHOTO":
					case "WORK_LOGO":
						?><input size="30" type="file" name="REGISTER_FILES_<?=$FIELD?>" class="form-control" /><?
						break;

					case "PERSONAL_NOTES":
					case "WORK_NOTES":
						?><textarea cols="30" rows="5" name="REGISTER[<?=$FIELD?>]" class="form-control"><?=$arResult["VALUES"][$FIELD]?></textarea><?
						break;
					default:
						if ($FIELD == "PERSONAL_BIRTHDAY"):?><small><?=$arResult["DATE_FORMAT"]?></small><br /><?endif;
						?>
						<input required="required" size="30" type="text" id="REGISTER_<?=$FIELD?>" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult["VALUES"][$FIELD]?>" placeholder="<?=GetMessage("REGISTER_FIELD_".$FIELD)?>" class="form-control" />
						<?if($FIELD=='EMAIL'):?><small id="emailHelp-forms" class="form-text text-muted">Мы никогда не передадим вашу электронную почту кому-либо еще.</small><?endif;?>
						<?
							if ($FIELD == "PERSONAL_BIRTHDAY")
								$APPLICATION->IncludeComponent(
									'bitrix:main.calendar',
									'',
									array(
										'SHOW_INPUT' => 'N',
										'FORM_NAME' => 'regform',
										'INPUT_NAME' => 'REGISTER[PERSONAL_BIRTHDAY]',
										'SHOW_TIME' => 'N'
									),
									null,
									array("HIDE_ICONS"=>"Y")
								);
							?><?
				}?>
		</div>
	<?endif?>
<?endforeach?>
	<div class="form-group form-check">
        <input type="checkbox" class="checkbox" id="rememberMeReg" />
        <label class="form-check-label" for="rememberMeReg"><?=GetMessage("REMEMBER_ME")?></label>
    </div>
    <div class="form-group form-group-center">
        <button type="submit" onclick="registerUser('modalRegister'); return false;" name="register_submit_button" value="Y" class="btn-main"><?=GetMessage("AUTH_REGISTER")?></button>
    </div>
</div>
</form>
<?endif?>
<?endif?>
