<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>
<?if ($arResult["isFormErrors"] == "Y"):?><?=$arResult["FORM_ERRORS_TEXT"];?><?endif;?>
<?=$arResult["FORM_NOTE"]?>
<?if ($arResult["isFormNote"] != "Y"):?>
<form class="w-100" name="subscribe_main_form" action="" method="POST" enctype="multipart/form-data">
    <?=bitrix_sessid_post()?>
	<input type="hidden" name="WEB_FORM_ID" value="12">
    <? foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion): ?>
        <div class="form-group">

            <?switch ($FIELD_SID) {

                case (in_array($FIELD_SID, ['name', 'email'])):?>
                    <input type="<?=$arQuestion['STRUCTURE']['0']['FIELD_TYPE']?>"
                           class="form-control"
                        <?if ($FIELD_SID === 'name') :?>
                            name="form_text_71"
                        <?else:?>
                            name="form_email_72"
                        <?endif;?>
                           placeholder="<?=GetMessage($FIELD_SID)?>"
                           <?if ($arQuestion['REQUIRED'] == 'Y'):?>required<?endif;?>
                    />
                    <?break;

                case 'field_of_activity':?>
                    <select class="form-control" name="form_dropdown_field_of_activity" id="form_dropdown_field_of_activity" <?if ($arQuestion['REQUIRED'] == 'Y'):?>required<?endif;?>>
                        <? foreach ($arQuestion['STRUCTURE'] as $key => $field):?>
                            <option value="<?=$field['ID']?>" <?if ($key === 0): ?>selected disabled<? endif;?>><?=GetMessage('field_of_activity_'.$field['ID'])?></option>
                        <?endforeach; ?>
                    </select>
                    <?break;

                case 'another_information':?>
                    <textarea class="form-control"
                              name="form_textarea_83"
                              placeholder="<?=GetMessage($FIELD_SID)?>"
                              <?if ($arQuestion['REQUIRED'] == 'Y'):?>required<?endif;?>
                        ></textarea>
                    <?break;
            }?>
        </div>

    <? endforeach; ?>
    <label for="save_inform">
        <input type="checkbox" class="checkbox mr-2" required />
        <small><?=GetMessage("SAFE_DATA")?></small>
    </label>

    <input type="hidden" name="web_form_submit" value="Сохранить" />
    <button class="subscribe-btn"><?=GetMessage("SUBSCRIBE")?></button>
</form>
<?endif;?>
