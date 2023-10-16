<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
?>
<div class="modal-body modal-body-basket">
    <div class="basket-empty" id="basket-empty">
        <h2 style="margin-top: 25px;"><?=GetMessage("EMPTY_BASKET")?></h2>
        <span><?=GetMessage("CORRECT_IT")?></span>
        <p><?=GetMessage("LOOK_AROUND")?></p>
        <img src="/images/shopping-basket.png" style="max-width: 170px;">
    </div>
</div>
