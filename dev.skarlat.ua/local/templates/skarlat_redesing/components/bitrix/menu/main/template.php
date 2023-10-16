<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<nav class="category-menu-nav w-100">
	<ul class="category-menu">
<?
$previousLevel = 0;
foreach($arResult as $arItem):?>
	<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
		<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
	<?endif?>

	<?if ($arItem["IS_PARENT"]):?>

		<?if ($arItem["DEPTH_LEVEL"] == 1):?>
			<li class="category-menu__item">
				<a href="<?=($arItem["LINK"]!='') ? $arItem["LINK"] : $arItem["ADDITIONAL_LINKS"][0];?>" class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?>">
					<?if($arItem["PARAMS"]['SVG']!='') echo $arItem["PARAMS"]['SVG'];?>
					<?=$arItem["TEXT"]?>
					<svg viewbox="0 0 6 9">
                        <path d="M0 0.7L3.5 4.4L0 8.4L0.8 9L5 4.4L0.8 0L0 0.7Z"></path>
                    </svg>
				</a>
				<ul class="category-menu-second">
		<?else:?>
			<li class="category-menu<?=checkSectLevel($arItem["DEPTH_LEVEL"])?>__item">
				<a href="<?=($arItem["LINK"]!='') ? $arItem["LINK"] : $arItem["ADDITIONAL_LINKS"][0];?>" class="parent">
					<?if($arItem["PARAMS"]['SVG']!='') echo $arItem["PARAMS"]['SVG'];?>
					<?=$arItem["TEXT"]?>
					<svg viewbox="0 0 6 9">
                        <path d="M0 0.7L3.5 4.4L0 8.4L0.8 9L5 4.4L0.8 0L0 0.7Z"></path>
                    </svg>
				</a>
				<ul class="category-menu<?=checkSectLevel($arItem["DEPTH_LEVEL"]+1)?>">
		<?endif?>

	<?else:?>

			<?if ($arItem["DEPTH_LEVEL"] == 1):?>
				<li class="category-menu__item">
					<a href="<?=($arItem["LINK"]!='') ? $arItem["LINK"] : $arItem["ADDITIONAL_LINKS"][0];?>" class="<?if ($arItem["SELECTED"]):?>root-item-selected<?else:?>root-item<?endif?>">
						<?if($arItem["PARAMS"]['SVG']!='') echo $arItem["PARAMS"]['SVG'];?>
						<?=$arItem["TEXT"]?>
					</a>
				</li>
			<?else:?>
				<li class="category-menu<?=checkSectLevel($arItem["DEPTH_LEVEL"])?>__item <?if ($arItem["SELECTED"]):?> item-selected<?endif?>">
					<a href="<?=($arItem["LINK"]!='') ? $arItem["LINK"] : $arItem["ADDITIONAL_LINKS"][0];?>">
						<?if($arItem["PARAMS"]['SVG']!='') echo $arItem["PARAMS"]['SVG'];?>
						<?=$arItem["TEXT"]?>
					</a>
				</li>
			<?endif?>
	<?endif?>
	<?$previousLevel = $arItem["DEPTH_LEVEL"];?>
<?endforeach?>

<?if ($previousLevel > 1)://close last item tags?>
	<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
<?endif?>
	</ul>
</nav>
<?endif?>