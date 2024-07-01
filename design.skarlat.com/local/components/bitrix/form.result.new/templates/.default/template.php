<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if ($arResult["isFormErrors"] == "Y"):?><?= $arResult["FORM_ERRORS_TEXT"]; ?><? endif; ?>
<?= $arResult["FORM_NOTE"] ?>
<? if ($arResult["isFormNote"] != "Y") {
    ?>
    <?= $arResult["FORM_HEADER"] ?>
    <?
    if ($arResult["isFormDescription"] == "Y" || $arResult["isFormTitle"] == "Y" || $arResult["isFormImage"] == "Y") {

        if ($arResult["isFormImage"] == "Y") {
            ?>
            <a href="<?= $arResult["FORM_IMAGE"]["URL"] ?>" target="_blank" alt="<?= GetMessage("FORM_ENLARGE") ?>"><img
                        src="<?= $arResult["FORM_IMAGE"]["URL"] ?>"
                        <? if ($arResult["FORM_IMAGE"]["WIDTH"] > 300): ?>width="300"
                        <? elseif ($arResult["FORM_IMAGE"]["HEIGHT"] > 200): ?>height="200"<? else:?><?= $arResult["FORM_IMAGE"]["ATTR"] ?><? endif;
                ?> hspace="3" vscape="3" border="0"/></a>
            <? //=$arResult["FORM_IMAGE"]["HTML_CODE"]
            ?>
            <?
        } //endif
        ?>

        <p><?= $arResult["FORM_DESCRIPTION"] ?></p>
        <?
    } // endif
    ?>

    <?
    foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) {
        if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden') {
            echo $arQuestion["HTML_CODE"];
        } else {
            ?>
            <? if (is_array($arResult["FORM_ERRORS"]) && array_key_exists($FIELD_SID, $arResult['FORM_ERRORS'])):?>
                <span class="error-fld" title="<?= htmlspecialcharsbx($arResult["FORM_ERRORS"][$FIELD_SID]) ?>"></span>
            <?endif; ?>
            <?if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'file') {?>
                <label class="button-upload">
            <?}?>
                <?= $arQuestion["HTML_CODE"] ?>
            <?if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'file') {?>
                    upload any of your sketches and brief's that you think might be helpfull
                </label>
            <?}?>
            <?
        }
    } //endwhile
    ?>
    <input type="submit" class="btn" name="web_form_apply" value="Send a message"/>
    <?= $arResult["FORM_FOOTER"] ?>
    <?
} //endif (isFormNote)