<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$frame = $this->createFrame()->begin("");?>
    <? foreach($arResult["BANNERS"] as $k => $banner):?>
        <?=$banner;?>
    <?endforeach;?>
<? $frame->end();?>