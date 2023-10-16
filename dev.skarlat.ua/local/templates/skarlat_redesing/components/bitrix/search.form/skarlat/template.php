<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);?>
<form action="<?=$arResult["FORM_ACTION"]?>" class="header-search__wrapper hide" id="header-search-block">
    <label class="header-search__label" for="header-search"><?=GetMessage("BSF_T_SEARCH_BUTTON")?>:</label>
    <input type="text" class="header-search" id="header-search" name="q" placeholder="<?=GetMessage("SEARCH")?>" value="<?=$_GET['q']?>">
    <div class="header-search__form-btn">
        <button class="header-btn" type="submit" name="s" class="search-btn">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 viewBox="0 0 55 55" xml:space="preserve">
                    <path class="st1" d="M25.7,9.2c9,0,16.4,7.3,16.4,16.4c0,9-7.3,16.4-16.4,16.4S9.3,34.6,9.3,25.5C9.3,16.5,16.6,9.2,25.7,9.2z"/>
                    <line class="st2" x1="37" y1="37.3" x2="49.7" y2="49.8"/>
            </svg>
        </button>
        <button class="header-btn hide" id="header-search-reset" data-reset="true" type="reset">
            <svg x="0px" y="0px" viewBox="0 0 30 30">
                <path d="M25,6.2L23.8,5L15,13.8L6.2,5L5,6.2l8.8,8.8L5,23.8L6.2,25l8.8-8.8l8.8,8.8l1.2-1.2L16.2,15L25,6.2z"></path>
            </svg>
        </button>
    </div>
</form>