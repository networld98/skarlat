<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
?>
<style>
    .bx-sbb-empty-cart-image {
        margin: 50px auto 42px;
        width: 131px;
        height: 116px;
        background: url('/local/templates/skarlat_redesing/components/bitrix/sale.basket.basket/redesign/images/empty_cart.svg') no-repeat center;
        background-size: contain;
        -webkit-background-size: contain;
    }

    .bx-sbb-empty-cart-text {
        margin-bottom: 42px;
        color: #bababa;
        text-align: center;
        font-size: 36px;
    }

    .bx-sbb-empty-cart-desc {
        margin-bottom: 42px;
        color: #000;
        text-align: center;
        font-size: 16px;
    }

</style>
<div class="bx-sbb-empty-cart-container 1111">
    <div class="bx-sbb-empty-cart-image">
        <img src="" alt="">
    </div>
    <div class="bx-sbb-empty-cart-text"><?=Loc::getMessage("SBB_EMPTY_BASKET_TITLE")?></div>
    <?
    if (!empty($arParams['EMPTY_BASKET_HINT_PATH']))
    {
        ?>
        <div class="bx-sbb-empty-cart-desc">
            <?=Loc::getMessage(
                'SBB_EMPTY_BASKET_HINT',
                [
                    '#A1#' => '<a href="'.$arParams['EMPTY_BASKET_HINT_PATH'].'">',
                    '#A2#' => '</a>',
                ]
            )?>
        </div>
        <?
    }
    ?>
</div>