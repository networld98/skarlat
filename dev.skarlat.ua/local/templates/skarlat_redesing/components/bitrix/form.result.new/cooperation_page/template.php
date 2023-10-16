<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>
<?if ($arResult["isFormErrors"] == "Y"):?><?=$arResult["FORM_ERRORS_TEXT"];?>
<? elseif ($arResult["isFormNote"] == "Y") : //иначе если форма успешно отправлена?>
    <div class="valid-feedback">
        <h5><?=GetMessage("THANK_TEXT_1")?></h5>
        <p><?=GetMessage("THANK_TEXT_2")?></p>
    </div>
<? endif; ?>
<?if ($arResult["isFormNote"] != "Y"):?>
<form class="w-100" name="subscribe_main_form" action="" method="POST" enctype="multipart/form-data">
    <?=bitrix_sessid_post()?>
	<input type="hidden" name="WEB_FORM_ID" value="13">
    <? foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion): ?>
        <div class="form-check">
            <?switch ($FIELD_SID) {
                case (in_array($FIELD_SID, ['name', 'email', 'phone', 'type', 'know'])):?>
                    <label for="pass-user-repeat"><?=GetMessage($FIELD_SID)?>:</label>
                    <input type="<?=$arQuestion['STRUCTURE']['0']['FIELD_TYPE']?>"
                           class="form-control"
                        <?if ($FIELD_SID === 'name') :?>
                            name="form_text_84"
                        <?elseif ($FIELD_SID === 'type') :?>
                            name="form_text_87"
                        <?elseif ($FIELD_SID === 'know') :?>
                            name="form_text_88"
                        <?elseif ($FIELD_SID === 'email') :?>
							name="form_email_85"
                        <?elseif ($FIELD_SID === 'phone') :?>
                            name="form_text_86"
                        <?endif;?>
                           <?if ($arQuestion['REQUIRED'] == 'Y'):?>required<?endif;?>
                    />
                    <?break;

                case 'data':?>
                    <input type="checkbox" class="checkbox" checked="checked" name="form_checkbox_89">
                    <label for="form_checkbox_89" class="nav-content-accordion__item-label"><?=GetMessage($FIELD_SID)?></label>
                    <?break;
            }?>
        </div>

    <? endforeach; ?>
    <div class="form-check">
        <input type="hidden" name="web_form_submit" value="Сохранить" />
        <button class="btn-main primary send-form"><?=GetMessage("SUBSCRIBE")?></button>
    </div>
</form>
<?endif;?>