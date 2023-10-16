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
$this->setFrameMode(true);

$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/colors.css',
	'TEMPLATE_CLASS' => 'bx-'.$arParams['TEMPLATE_THEME']
);

if (isset($templateData['TEMPLATE_THEME']))
{
	$this->addExternalCss($templateData['TEMPLATE_THEME']);
}
?>
<script>
		window.onload=function(t, e) {
			var i = document.getElementById("mobileFilter"),
				n = document.getElementById("closeFilter"),
				o = document.getElementById("btnFilter"),
				s = document.getElementById("set_filter");
			var queri=$("#mobileFilter");
			o && o.addEventListener("click", (function() {
				queri.addClass("show"), queri.removeClass("d-none");
			})), n && (n.addEventListener("click", (function() {
				queri.removeClass("show"), document.innerWidth > 500 ? setTimeout((function() {
					queri.addClass("d-none")
				}), 500) : queri.addClass("d-none")
			})), i.addEventListener("click", (function(t) {
				t.target.closest("#FilterForm") || (i.classList.remove("show"), setTimeout((function() {
					queri.addClass("d-none")
				}), 400))
			})), s.addEventListener("click", (function(t) {
				queri.removeClass("show"), setTimeout((function() {
					queri.addClass("d-none")
				}), 400)
			})));
			var t = document.getElementsByClassName("filter__item-group"),
            e = document.querySelectorAll(".filter-all--show");
			if (t && e)
				for (var j in e.forEach((function(t) {
						t.addEventListener("click", (function() {
							t.classList.toggle("show");
							for (var e = this.parentElement.children, j = 0; j < e.length - 1; j++) j > 4 && e[j].classList.toggle("filter__item--hiden")
						}))
				})), t)
				for (var n in t[j].children) n > 4 && n < t[j].children.length - 1 && t[j].children[n].classList.add("filter__item--hiden")
		}
</script>
<div class="col-12">
	<?
	if($_REQUEST['SALE']!=''){
		$site=SITE_ID;
		$arSelect = Array("ID", "IBLOCK_ID", "CODE", "NAME", "DETAIL_TEXT",'ACTIVE_FROM','ACTIVE_TO','DETAIL_PICTURE');//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
		$arFilter = Array("IBLOCK_ID"=>49, "CODE"=>$_REQUEST['SALE'], "ACTIVE"=>"Y",'PROPERTY_SITE'=>SITE_ID);
		$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
		while($ob = $res->GetNextElement()){ 
			$arSaleFields = $ob->GetFields(); 
			$arSaleProps = $ob->GetProperties(); 
			$arProdFilter=$arSaleProps['PRODUCTS_'.$site]['VALUE'];
				$arSelect = Array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID");//IBLOCK_ID и ID обязательно должны быть указаны, см. описание arSelectFields выше
				$arFilter = Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'],"ACTIVE"=>"Y","ID"=>$arProdFilter);
				$res = CIBlockElement::GetList(Array(), $arFilter, array("IBLOCK_SECTION_ID"), false, $arSelect);
				while($ob = $res->fetch()){
					$arSaleProps['SECTIONS_'.$site]['VALUE'][]=$ob['IBLOCK_SECTION_ID'];
				}
			
		}
		?>
		<script>
			$(document).ready(function(){
				if($('#timer').length>0){
					setInterval(function(){
						$.ajax({
							type: "POST",
							url: "/ajax/sale_timer.php",
							data: {'SALE':'<?=$arSaleFields["CODE"]?>'},
							async:true,
							success: function(response){
								$('#timer').html(response);
							}
						});
					},1000);
				}
			});
		</script>
		<?
	
	$start_date = new \DateTime($arSaleFields['ACTIVE_FROM']);
	$end_date=new \DateTime($arSaleFields['ACTIVE_TO']);
	$now_date=new \DateTime();
	?>
	<div class="container">
	<div class="row">
		<div class="col-lg-3 col-12 col-xl-2">
			<div class="filter-category">
                      <span class="filter-title-block">
                        <svg viewBox="0 0 20 20">
                          <path
                            fill-rule="evenodd"
                            d="M19 6H1c-.6 0-1-.5-1-1 0-.6.4-1 1-1h18c.6 0 1 .4 1 1 0 .5-.4 1-1 1zM19 11H1c-.6 0-1-.4-1-1s.4-1 1-1h18c.6 0 1 .4 1 1s-.4 1-1 1zM19 16H1c-.6 0-1-.4-1-1s.4-1 1-1h18c.6 0 1 .4 1 1s-.4 1-1 1z"
                          />
                        </svg>
                        Категории
                      </span>

                      <div class="filter filter-all">
                        <div class="filter__item">
                          <a target="_self" href="/catalog/sale/?SALE=<?=$arSaleFields['CODE']?>" class="filter__item-head link">Все категории</a>
                        </div>
                      </div>
						<?
							$arFilter = array('IBLOCK_ID' => $arParams['IBLOCK_ID'],'ACTIVE' => 'Y','!CODE'=>'sale'); 
							$arSelect = array('ID', 'NAME','DEPTH_LEVEL','SECTION_ID','SECTION_PAGE_URL');
							$rsSection = CIBlockSection::GetTreeList($arFilter, $arSelect, true); 
							$i=0;
							$site=SITE_ID;
							$noany[$lastitem]=true;
							while($arOneSection = $rsSection->getNext()) {
								$i++;
								if($i==1):
                                    $prop=CIBlockElement::GetByID($arSaleFields['ID'])->GetNextElement()->GetProperties();
									$arChildFilter = Array('IBLOCK_ID'=>$arParams['IBLOCK_ID'], 'ACTIVE'=>'Y','SECTION_ID'=>$arOneSection['ID']);
									$db_list = CIBlockSection::GetList(Array($by=>$order), $arChildFilter);
									$lastitem=$arOneSection['ID'];
								?>
									<div class="filter">
										<div class="filter__item">
											<?if($db_list->SelectedRowsCount()>0):
												$lastopen=3;
											?>
												<div class="filter__item-head <?if((in_array($arOneSection['ID'],$arSaleProps['SECTIONS_'.$site]['VALUE']) && $arParams['SECTION_ID']=="56439")|| $arParams['SECTION_ID']==$arOneSection['ID']) echo 'active';?>" data-toggle="collapse" data-target="#el<?=$arOneSection['ID']?>"><?=$arOneSection['NAME']?></div>
												<div class="collapse filter__item-group" id="el<?=$arOneSection['ID']?>">
											<?else:
                                                $cont=0;
												$lastopen=1;
												$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM");
												$arFilter = Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y","SECTION_ID"=>$arOneSection['ID']);
												$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
                                                while($ob = $res->GetNextElement()){
                                                    $arFields = $ob->GetFields();
                                                  if(in_array($arFields['ID'], $prop['PRODUCTS_mg']['VALUE']) || in_array($arFields['ID'], $prop['PRODUCTS_mg']['VALUE']) ){
                                                      $cont++;
                                                  }
                                                }
												$count=$res->SelectedRowsCount();
												if(in_array($arOneSection['ID'],$arSaleProps['SECTIONS_'.$site]['VALUE'])) $noany[$lastitem]=false;
												else $noany[$lastitem]=true;
											?>
												<a id="el<?=$arOneSection['ID']?>" href="<?=$arOneSection['SECTION_PAGE_URL']?>?SALE=<?=$arSaleFields['CODE']?>" class="filter__item-head link <?if((in_array($arOneSection['ID'],$arSaleProps['SECTIONS_'.$site]['VALUE']) && $arParams['SECTION_ID']=="56439")|| $arParams['SECTION_ID']==$arOneSection['ID']) echo 'active';?>"
													><?=$arOneSection['NAME']?><label class="marker"><?=$cont?></label></a
												  >
											<?endif;?>
								<?elseif($arOneSection['DEPTH_LEVEL']==1):
									
									$arChildFilter = Array('IBLOCK_ID'=>$arParams['IBLOCK_ID'], 'ACTIVE'=>'Y','SECTION_ID'=>$arOneSection['ID']);
									$db_list = CIBlockSection::GetList(Array($by=>$order), $arChildFilter);
								?>
									<?if($lastitem>0 && $noany[$lastitem]==true):?>
											<script>
												$(document).ready(function(){
													$('#el<?=$lastitem?>').closest('.filter').remove();
												});
											</script>
									<?endif;
									$lastitem=$arOneSection['ID'];
									
									?>
									<?if($lastopen==3):?>
											</div>
										</div>
									</div>
									<?else:?>
											</div>
										</div>
									<?endif;?>
									<div class="filter">
										<div class="filter__item">
										<?if($db_list->SelectedRowsCount()>0):
											$lastopen=3;
											$noany[$lastitem]=true;
										?>
											<div class="filter__item-head <?if((in_array($arOneSection['ID'],$arSaleProps['SECTIONS_'.$site]['VALUE']) && $arParams['SECTION_ID']=="56439")|| $arParams['SECTION_ID']==$arOneSection['ID']) echo 'active';?>" data-toggle="collapse" data-target="#el<?=$arOneSection['ID']?>"><?=$arOneSection['NAME']?></div>
											<div class="collapse filter__item-group" id="el<?=$arOneSection['ID']?>">
										<?else:
											$lastopen=1;
											$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM");
											$arFilter = Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y","SECTION_ID"=>$arOneSection['ID']);
											$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
											$count=$res->SelectedRowsCount();
											if(in_array($arOneSection['ID'],$arSaleProps['SECTIONS_'.$site]['VALUE'])) $noany[$lastitem]=false;
											else $noany[$lastitem]=true;
										?>
											<a id="el<?=$arOneSection['ID']?>" href="<?=$arOneSection['SECTION_PAGE_URL']?>?SALE=<?=$arSaleFields['CODE']?>" class="filter__item-head link <?if((in_array($arOneSection['ID'],$arSaleProps['SECTIONS_'.$site]['VALUE']) && $arParams['SECTION_ID']=="56439")|| $arParams['SECTION_ID']==$arOneSection['ID']) echo 'active';?>"
												><?=$arOneSection['NAME']?><label class="marker"><?=$count?></label></a
											>
										<?endif;?>
								<?else:?>
									<?
										$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM");
										$arFilter = Array("IBLOCK_ID"=>$arParams['IBLOCK_ID'], "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y","SECTION_ID"=>$arOneSection['ID']);
										$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
										$count=$res->SelectedRowsCount();
										if(in_array($arOneSection['ID'],$arSaleProps['SECTIONS_'.$site]['VALUE'])) $noany[$lastitem]=false;
									?>
									
										<a href="<?=$arOneSection['SECTION_PAGE_URL']?>?SALE=<?=$arSaleFields['CODE']?>" class="<?='sect-act-'.$arOneSection['ID']?> label <?if((in_array($arOneSection['ID'],$arSaleProps['SECTIONS_'.$site]['VALUE']) && $arParams['SECTION_ID']=="56439")|| $arParams['SECTION_ID']==$arOneSection['ID']) echo 'active';?>"><?=$arOneSection['NAME']?><label class="marker"><?=$count?></label></a>
										
								<?endif;?>
									  
									
								<?
							}
						?>
						<?if($arParams['SECTION_ID']>0):?>
							<script>
								$(document).ready(function(){
									console.log($('.<?="sect-act-".$arParams["SECTION_ID"]?>'));
									$('.<?="sect-act-".$arParams["SECTION_ID"]?>').parent().prev().click();
								});
							</script>
						<?endif;?>
						<?if($lastitem>0 && $noany[$lastitem]==true):?>
								<script>
									$(document).ready(function(){
										$('#el<?=$lastitem?>').closest('.filter').remove();
									});
								</script>
						<?endif;?>
						<?if($lastopen==3):?>
								</div>
							</div>
						</div>
						<?else:?>
								</div>
							</div>
						<?endif;?>

                    </div>
		</div>
		<div class="col-lg-9 col-12 col-xl-10">
			<!-- Promo block start -->
    <div class="promo">
      <a href="<?=SITE_DIR?>catalog/sale/?SALE=<?=$arSaleFields['CODE']?>" class="promo__img">
		<?
			$arFileTmp = CFile::ResizeImageGet(
				$arSaleFields['DETAIL_PICTURE'],
				array("width" => 1024, "height" => 1024),
				BX_RESIZE_IMAGE_PROPORTIONAL,
				true
			);
		?>
        <img src="<?=$arFileTmp['src'];?>" alt="" />
      </a>

      <div class="promo-info">
        <div class="promo-info__head">
          <a href="<?=SITE_DIR?>catalog/sale/?SALE=<?=$arSaleFields['CODE']?>" class="promo-info__title">
			<?=$arSaleFields['NAME']?>
          </a>
			<?if($now_date<$end_date && $now_date>$start_date):?>
			  <div class="promo-info__timer" id="timer">
					<?
						echo downcounter($arSaleFields['ACTIVE_TO']);
					?>
			  </div>
			<?elseif($now_date<$start_date):?>
				<a href="javascript:void(0);" style="color:red;">НАЧНЕТСЯ <?=$arSaleFields['ACTIVE_FROM']?></a>
			<?else:?>
				<a href="javascript:void(0);" style="color:red;">АКЦИЯ ЗАКОНЧИЛАСЬ</a>
			<?endif;?>
        </div>

        <div class="promo-info__desc">
         <?=$arSaleFields['DETAIL_TEXT']?>
        </div>
      </div>
    </div>
    <!-- Promo block end -->
		</div>
	</div>
	</div>
	
    <?}?>    
	
    <!-- WAY CLIENT IN FILTER START -->
    <div class="way">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 col-6 d-none d-lg-flex">
              <!-- WAY BLOCK START-->
              <div class="way-wrapper">
                <span class="way-count"><?echo GetMessage("SELECTED")?> <?$APPLICATION->ShowViewContent('filter_count');?></span>
                <div class="way-filter">


				<?
				$count=0;
				foreach($arResult['ITEMS'] as $arItem):?>
					<?foreach($arItem['VALUES'] as  $key=>$arValue):
						if($key!='MIN' && $key!='MAX' &&  $arValue['CHECKED']!=1) continue;
						?>
						<?if($key!='MIN' && $key!='MAX'):?>
							<?
							$count++;
							if($count==1):
							?>
								<button class="way-filter__item way-filter__item-clear" aria-label="Close" onclick="$('[name=del_filter]').click();">
									<span class="way-filter__item-title"><?echo GetMessage("CLEAR")?> </span>
								</button>
							<?endif;?>
							<button class="way-filter__item" aria-label="Close" onclick="$('#<?=$arValue['CONTROL_ID']?>').click();">
								<span aria-hidden="true" class="way-filter__item-icon">&times;</span>
								<span class="way-filter__item-title"><?=$arValue['VALUE']?></span>
							</button>
						<?else:?>
							<?if($key=='MIN' && $arValue['VALUE']!=$arValue['HTML_VALUE'] && $arValue['HTML_VALUE']>0):?>
								<?
								$count++;
								if($count==1):
								?>
									<button class="way-filter__item way-filter__item-clear" aria-label="Close" onclick="$('[name=del_filter]').click();">
										<span class="way-filter__item-title"><?echo GetMessage("CLEAR")?> </span>
									</button>
								<?endif;?>
								<button class="way-filter__item" aria-label="Close" onclick="$('#<?=$arValue['CONTROL_ID']?>').val('<?=$arValue['VALUE']?>'); smartFilter.keyup(BX('<?=$arValue['CONTROL_ID']?>'));">
									<span aria-hidden="true" class="way-filter__item-icon">&times;</span>
									<span class="way-filter__item-title">Цена от: <?=$arValue['HTML_VALUE']?> грн</span>
								</button>
							<?elseif($key=='MAX' && $arValue['VALUE']!=$arValue['HTML_VALUE'] && $arValue['HTML_VALUE']>0):?>
								<?
								$count++;
								if($count==1):
								?>
									<button class="way-filter__item way-filter__item-clear" aria-label="Close" onclick="$('[name=del_filter]').click();">
										<span class="way-filter__item-title"><?echo GetMessage("CLEAR")?> </span>
									</button>
								<?endif;?>
								<button class="way-filter__item" aria-label="Close" onclick="$('#<?=$arValue['CONTROL_ID']?>').val('<?=$arValue['VALUE']?>'); smartFilter.keyup(BX('<?=$arValue['CONTROL_ID']?>'));">
									<span aria-hidden="true" class="way-filter__item-icon">&times;</span>
									<span class="way-filter__item-title">Цена до: <?=$arValue['HTML_VALUE']?> грн</span>
								</button>
							<?endif;?>
						<?endif;?>
					<?endforeach;?>
				<?endforeach;?>
                </div>
              </div>
              <!-- WAY BLOCK END-->
            </div>

            <div class="col-lg-6 col-12">
              <div class="sort-download__wrapper">
                <button id="btnFilter" class="d-flex d-lg-none btn filter-cat-mob">
                    <?echo GetMessage("CT_BCSF_FILTER_TITLE")?>
                  <svg viewBox="0 0 20 20">
                    <path
                      d="M8 10.9c.1.1.2.2.2.4v8.4l3.6-3.1v-5.3c0-.1.1-.3.2-.4l6-6.7H2l6 6.7zM1.2.3h17.6V3H1.2z"
                    ></path>
                  </svg>
                </button>

                <?$APPLICATION->ShowViewContent('catalog_download');?>

                <!-- SORT CATEGORY BLOCK START -->
                <div class="sort-cat__wrapper">

					  <div class="sort-cat__title-block d-none d-lg-flex">
						<label class="sort-cat__title-block_label" for="sort_cat"><?echo GetMessage("SORT")?>:</label>
					  </div>
                        <select class="sort-cat__title-block_select" onchange="changeSort($(this).val()); if($(window).width() >991) smartFilter.keyup(BX('arrFilter_P1_MIN')); else location.reload();" name="sort_by" id="sort_cat">
                            <option value="DATE_CREATED|DESC" <?if($_SESSION['SORT']=="DATE_CREATED"):?> selected="selected" <?endif;?>><?echo GetMessage("NEW")?></option>
                            <option value="catalog_PRICE_1|ASC" <?if($_SESSION['SORT']=="catalog_PRICE_1" && $_SESSION['SORT_BY']=='ASC'):?> selected="selected" <?endif;?>><?echo GetMessage("FROM_LOW")?></option>
                            <option value="catalog_PRICE_1|DESC" <?if($_SESSION['SORT']=="catalog_PRICE_1" && $_SESSION['SORT_BY']=='DESC'):?> selected="selected" <?endif;?>><?echo GetMessage("FROM_EXPENSIVE")?></option>
                            <option value="SHOW_COUNTER|DESC" <?if($_SESSION['SORT']=="SHOW_COUNTER"):?> selected="selected" <?endif;?>><?echo GetMessage("BY_POPULAR")?></option>
                        </select>
				</div>
                <!-- SORT CATEGORY BLOCK END -->
              </div>
            </div>
          </div>
        </div>
    </div>
    <!-- WAY CLIENT IN FILTER END -->
</div>
	<div class="product-section">
        <div class="container">
			<div class="row">
				<div class="col-lg-3 col-12 col-xl-2">
					<div id="mobileFilter" class="d-none d-lg-flex">
						<!--<form name="<?/*echo $arResult["FILTER_NAME"]."_form"*/?>" action="<?/*echo $arResult["FORM_ACTION"]*/?>" method="get" class="smartfilter" id="mobileFilter">-->
						<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" class="smartfilter" id="FilterForm">
							<div class="filter-form-wrapper">
									<div class="d-lg-none filter-form__header">
										<h5 class="h5"><?echo GetMessage("CT_BCSF_FILTER_TITLE")?></h5>
										<button type="button" class="close" id="closeFilter" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&larr; <?echo GetMessage("BACK")?></span>
										</button>
									</div>
									<?foreach($arResult["HIDDEN"] as $arItem):?>
										<input type="hidden" name="<?echo $arItem["CONTROL_NAME"]?>" id="<?echo $arItem["CONTROL_ID"]?>" value="<?echo $arItem["HTML_VALUE"]?>" />
									<?endforeach;?>
									<div id="collapse-group" class="filter-form__body">
										<span class="filter-title-block">
											<svg viewBox="0 0 20 20">
												  <path
													d="M8 10.9c.1.1.2.2.2.4v8.4l3.6-3.1v-5.3c0-.1.1-.3.2-.4l6-6.7H2l6 6.7zM1.2.3h17.6V3H1.2z"
												  />
											</svg>
											<?echo GetMessage("CT_BCSF_FILTER_TITLE")?>
										</span>
									<?foreach($arResult["ITEMS"] as $key=>$arItem)//prices
									{
										$key = $arItem["ENCODED_ID"];
										if(isset($arItem["PRICE"])):
											if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
												continue;

											$step_num = 4;
											$step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / $step_num;
											$prices = array();
											if (Bitrix\Main\Loader::includeModule("currency"))
											{
												for ($i = 0; $i < $step_num; $i++)
												{
													$prices[$i] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MIN"]["VALUE"] + $step*$i, $arItem["VALUES"]["MIN"]["CURRENCY"], false);
												}
												$prices[$step_num] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MAX"]["VALUE"], $arItem["VALUES"]["MAX"]["CURRENCY"], false);
											}
											else
											{
												$precision = $arItem["DECIMALS"]? $arItem["DECIMALS"]: 0;
												for ($i = 0; $i < $step_num; $i++)
												{
													$prices[$i] = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step*$i, $precision, ".", "");
												}
												$prices[$step_num] = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");
											}
											?>
											<div class="filter__item">
												<div class="filter__item-head" data-toggle="collapse" data-target="#el001"><?echo GetMessage("PRICE")?></div>
													<div id="el001">
														<input type="text" id="range-ion" class="js-range-slider" name="range" value="" />
													</div>
											</div>

											<script>
												$(document).ready(function(){
													if($("#range-ion").length>0){
														$("#range-ion").ionRangeSlider({
															skin:"flat",
															type:"double",
															min:<?=$arItem["VALUES"]["MIN"]["VALUE"]?>,
															max:<?=$arItem["VALUES"]["MAX"]["VALUE"]?>,
															from:<?= ($arItem["VALUES"]["MIN"]["HTML_VALUE"]!='' ? $arItem["VALUES"]["MIN"]["HTML_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"])?>,
															to:<?= ($arItem["VALUES"]["MAX"]["HTML_VALUE"]!='' ? $arItem["VALUES"]["MAX"]["HTML_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"])?>,
															postfix:" грн",
															onChange: function (data) {
																$('#arrFilter_P1_MIN').val(data.from);
																$('#arrFilter_P1_MAX').val(data.to);
																$('#arrFilter_P1_MAX').keyup();
															},
														});
													}
												});
											</script>
											<?/*?>
											<div class="<?if ($arParams["FILTER_VIEW_MODE"] == "HORIZONTAL"):?>col-sm-6 col-md-4<?else:?>col-lg-12<?endif?> bx-filter-parameters-box bx-active">
												<span class="bx-filter-container-modef"></span>
												<div class="bx-filter-parameters-box-title" onclick="smartFilter.hideFilterProps(this)"><span><?=$arItem["NAME"]?> <i data-role="prop_angle" class="fa fa-angle-<?if ($arItem["DISPLAY_EXPANDED"]== "Y"):?>up<?else:?>down<?endif?>"></i></span></div>
												<div class="bx-filter-block" data-role="bx_filter_block">
													<div class="row bx-filter-parameters-box-container">
														<div class="col-xs-6 bx-filter-parameters-box-container-block bx-left">
															<i class="bx-ft-sub"><?=GetMessage("CT_BCSF_FILTER_FROM")?></i>
															<div class="bx-filter-input-container">*/?>
																<input
																	class="min-price"
																	type="hidden"
																	name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
																	id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
																	value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
																	size="5"
																	onkeyup="smartFilter.keyup(this)"
																/><?/*
															</div>
														</div>
														<div class="col-xs-6 bx-filter-parameters-box-container-block bx-right">
															<i class="bx-ft-sub"><?=GetMessage("CT_BCSF_FILTER_TO")?></i>
															<div class="bx-filter-input-container">*/?>
																<input
																	class="max-price"
																	type="hidden"
																	name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
																	id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
																	value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
																	size="5"
																	onkeyup="smartFilter.keyup(this)"
																/><?/*
															</div>
														</div>

														<div class="col-xs-10 col-xs-offset-1 bx-ui-slider-track-container">
															<div class="bx-ui-slider-track" id="drag_track_<?=$key?>">
																<?for($i = 0; $i <= $step_num; $i++):?>
																<div class="bx-ui-slider-part p<?=$i+1?>"><span><?=$prices[$i]?></span></div>
																<?endfor;?>

																<div class="bx-ui-slider-pricebar-vd" style="left: 0;right: 0;" id="colorUnavailableActive_<?=$key?>"></div>
																<div class="bx-ui-slider-pricebar-vn" style="left: 0;right: 0;" id="colorAvailableInactive_<?=$key?>"></div>
																<div class="bx-ui-slider-pricebar-v"  style="left: 0;right: 0;" id="colorAvailableActive_<?=$key?>"></div>
																<div class="bx-ui-slider-range" id="drag_tracker_<?=$key?>"  style="left: 0%; right: 0%;">
																	<a class="bx-ui-slider-handle left"  style="left:0;" href="javascript:void(0)" id="left_slider_<?=$key?>"></a>
																	<a class="bx-ui-slider-handle right" style="right:0;" href="javascript:void(0)" id="right_slider_<?=$key?>"></a>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<?*/
											$arJsParams = array(
												"leftSlider" => 'left_slider_'.$key,
												"rightSlider" => 'right_slider_'.$key,
												"tracker" => "drag_tracker_".$key,
												"trackerWrap" => "drag_track_".$key,
												"minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
												"maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
												"minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
												"maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
												"curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
												"curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
												"fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"] ,
												"fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
												"precision" => $precision,
												"colorUnavailableActive" => 'colorUnavailableActive_'.$key,
												"colorAvailableActive" => 'colorAvailableActive_'.$key,
												"colorAvailableInactive" => 'colorAvailableInactive_'.$key,
											);
											?>
											<script type="text/javascript">
												BX.ready(function(){
													window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
												});
											</script>
										<?endif;
									}

									//not prices
									foreach($arResult["ITEMS"] as $key=>$arItem)
									{
										if(
											empty($arItem["VALUES"])
											|| isset($arItem["PRICE"])
										)
											continue;

										if (
											$arItem["DISPLAY_TYPE"] == "A"
											&& (
												$arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0
											)
										)
											continue;
										?>
										<div class="filter">
											<div class="filter__item" data-role="bx_filter_block">
												<div class="filter__item-head" data-toggle="collapse" data-target="#el<?=$key?>">
													<?=$arItem["NAME"]?>
												</div>
												<div class="collapse filter__item-group <?if ($arItem["DISPLAY_EXPANDED"]== "Y"):?>collapse show<?endif?>" id="el<?=$key?>">
												<?
												$arCur = current($arItem["VALUES"]);
												switch ($arItem["DISPLAY_TYPE"])
												{
													case "A"://NUMBERS_WITH_SLIDER
														?>
														<div class="col-xs-6 bx-filter-parameters-box-container-block bx-left">
															<i class="bx-ft-sub"><?=GetMessage("CT_BCSF_FILTER_FROM")?></i>
															<div class="bx-filter-input-container">
																<input
																	class="min-price"
																	type="text"
																	name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
																	id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
																	value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
																	size="5"
																	onkeyup="smartFilter.keyup(this)"
																/>
															</div>
														</div>
														<div class="col-xs-6 bx-filter-parameters-box-container-block bx-right">
															<i class="bx-ft-sub"><?=GetMessage("CT_BCSF_FILTER_TO")?></i>
															<div class="bx-filter-input-container">
																<input
																	class="max-price"
																	type="text"
																	name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
																	id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
																	value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
																	size="5"
																	onkeyup="smartFilter.keyup(this)"
																/>
															</div>
														</div>

														<div class="col-xs-10 col-xs-offset-1 bx-ui-slider-track-container">
															<div class="bx-ui-slider-track" id="drag_track_<?=$key?>">
																<?
																$precision = $arItem["DECIMALS"]? $arItem["DECIMALS"]: 0;
																$step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / 4;
																$value1 = number_format($arItem["VALUES"]["MIN"]["VALUE"], $precision, ".", "");
																$value2 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step, $precision, ".", "");
																$value3 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * 2, $precision, ".", "");
																$value4 = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step * 3, $precision, ".", "");
																$value5 = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");
																?>
																<div class="bx-ui-slider-part p1"><span><?=$value1?></span></div>
																<div class="bx-ui-slider-part p2"><span><?=$value2?></span></div>
																<div class="bx-ui-slider-part p3"><span><?=$value3?></span></div>
																<div class="bx-ui-slider-part p4"><span><?=$value4?></span></div>
																<div class="bx-ui-slider-part p5"><span><?=$value5?></span></div>

																<div class="bx-ui-slider-pricebar-vd" style="left: 0;right: 0;" id="colorUnavailableActive_<?=$key?>"></div>
																<div class="bx-ui-slider-pricebar-vn" style="left: 0;right: 0;" id="colorAvailableInactive_<?=$key?>"></div>
																<div class="bx-ui-slider-pricebar-v"  style="left: 0;right: 0;" id="colorAvailableActive_<?=$key?>"></div>
																<div class="bx-ui-slider-range" 	id="drag_tracker_<?=$key?>"  style="left: 0;right: 0;">
																	<a class="bx-ui-slider-handle left"  style="left:0;" href="javascript:void(0)" id="left_slider_<?=$key?>"></a>
																	<a class="bx-ui-slider-handle right" style="right:0;" href="javascript:void(0)" id="right_slider_<?=$key?>"></a>
																</div>
															</div>
														</div>
														<?
														$arJsParams = array(
															"leftSlider" => 'left_slider_'.$key,
															"rightSlider" => 'right_slider_'.$key,
															"tracker" => "drag_tracker_".$key,
															"trackerWrap" => "drag_track_".$key,
															"minInputId" => $arItem["VALUES"]["MIN"]["CONTROL_ID"],
															"maxInputId" => $arItem["VALUES"]["MAX"]["CONTROL_ID"],
															"minPrice" => $arItem["VALUES"]["MIN"]["VALUE"],
															"maxPrice" => $arItem["VALUES"]["MAX"]["VALUE"],
															"curMinPrice" => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
															"curMaxPrice" => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
															"fltMinPrice" => intval($arItem["VALUES"]["MIN"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MIN"]["FILTERED_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"] ,
															"fltMaxPrice" => intval($arItem["VALUES"]["MAX"]["FILTERED_VALUE"]) ? $arItem["VALUES"]["MAX"]["FILTERED_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"],
															"precision" => $arItem["DECIMALS"]? $arItem["DECIMALS"]: 0,
															"colorUnavailableActive" => 'colorUnavailableActive_'.$key,
															"colorAvailableActive" => 'colorAvailableActive_'.$key,
															"colorAvailableInactive" => 'colorAvailableInactive_'.$key,
														);
														?>
														<script type="text/javascript">
															BX.ready(function(){
																window['trackBar<?=$key?>'] = new BX.Iblock.SmartFilter(<?=CUtil::PhpToJSObject($arJsParams)?>);
															});
														</script>
														<?
														break;
													case "B"://NUMBERS
														?>
														<div class="col-xs-6 bx-filter-parameters-box-container-block bx-left">
															<i class="bx-ft-sub"><?=GetMessage("CT_BCSF_FILTER_FROM")?></i>
															<div class="bx-filter-input-container">
																<input
																	class="min-price"
																	type="text"
																	name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
																	id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
																	value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"]?>"
																	size="5"
																	onkeyup="smartFilter.keyup(this)"
																	/>
															</div>
														</div>
														<div class="col-xs-6 bx-filter-parameters-box-container-block bx-right">
															<i class="bx-ft-sub"><?=GetMessage("CT_BCSF_FILTER_TO")?></i>
															<div class="bx-filter-input-container">
																<input
																	class="max-price"
																	type="text"
																	name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
																	id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
																	value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"]?>"
																	size="5"
																	onkeyup="smartFilter.keyup(this)"
																	/>
															</div>
														</div>
														<?
														break;
													case "G"://CHECKBOXES_WITH_PICTURES
														?>
														<?foreach($arItem["VALUES"] as $val => $ar):?>
																	<label onclick="smartFilter.keyup(BX('<?=CUtil::JSEscape($ar["CONTROL_ID"])?>'));" data-role="label_<?=$ar["CONTROL_ID"]?>" for="<? echo $ar["CONTROL_ID"] ?>">
																			<input
																				class="checkbox"
																				type="checkbox"
																				value="<? echo $ar["HTML_VALUE"] ?>"
																				name="<? echo $ar["CONTROL_NAME"] ?>"
																				id="<? echo $ar["CONTROL_ID"] ?>"
																				<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
																				<? echo $ar["DISABLED"] ? 'disabled="disabled"': '' ?>
																			/>

																			<span class="bx-filter-param-text" title="<?=$ar["VALUE"];?>"><?=$ar["VALUE"];?><?
																			if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
																				?>&nbsp;(<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
																			endif;?></span>
																			<span class="bx-filter-param-btn bx-color-sl">
																				<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
																				<span class="bx-filter-btn-color-icon" style="background-image:url('<?=$ar["FILE"]["SRC"]?>'); width:12px; height:12px; display:inline-block;"></span>
																				<?endif?>
																			</span>
																	</label>
															<?endforeach;?>
															<?if(count($arItem["VALUES"])>5):?>
																<span class="filter-all--show ">
																	<span class="filter-all--show-icon"></span>
																</span>
															<?endif;?>
														<?
														break;
													case "H"://CHECKBOXES_WITH_PICTURES_AND_LABELS
														?>
														<div class="col-xs-12">
															<div class="bx-filter-param-btn-block">
															<?foreach ($arItem["VALUES"] as $val => $ar):?>
																<input
																	style="display: none"
																	type="checkbox"
																	name="<?=$ar["CONTROL_NAME"]?>"
																	id="<?=$ar["CONTROL_ID"]?>"
																	value="<?=$ar["HTML_VALUE"]?>"
																	<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>

																/>
																<?
																$class = "";
																if ($ar["CHECKED"])
																	$class.= " bx-active";
																if ($ar["DISABLED"])
																	$class.= " disabled";
																?>
																<label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx-filter-param-label<?=$class?>" onclick="smartFilter.keyup(BX('<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')); BX.toggleClass(this, 'bx-active');">
																	<span class="bx-filter-param-btn bx-color-sl">
																		<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
																			<span class="bx-filter-btn-color-icon" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
																		<?endif?>
																	</span>
																	<span class="bx-filter-param-text" title="<?=$ar["VALUE"];?>"><?=$ar["VALUE"];?><?
																	if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
																		?> (<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
																	endif;?></span>
																</label>
															<?endforeach?>
															</div>
														</div>
														<?
														break;
													case "P"://DROPDOWN
														$checkedItemExist = false;
														?>
														<div class="col-xs-12">
															<div class="bx-filter-select-container">
																<div class="bx-filter-select-block" onclick="smartFilter.showDropDownPopup(this, '<?=CUtil::JSEscape($key)?>')">
																	<div class="bx-filter-select-text" data-role="currentOption">
																		<?
																		foreach ($arItem["VALUES"] as $val => $ar)
																		{
																			if ($ar["CHECKED"])
																			{
																				echo $ar["VALUE"];
																				$checkedItemExist = true;
																			}
																		}
																		if (!$checkedItemExist)
																		{
																			echo GetMessage("CT_BCSF_FILTER_ALL");
																		}
																		?>
																	</div>
																	<div class="bx-filter-select-arrow"></div>
																	<input
																		style="display: none"
																		type="radio"
																		name="<?=$arCur["CONTROL_NAME_ALT"]?>"
																		id="<? echo "all_".$arCur["CONTROL_ID"] ?>"
																		value=""
																	/>
																	<?foreach ($arItem["VALUES"] as $val => $ar):?>
																		<input
																			style="display: none"
																			type="radio"
																			name="<?=$ar["CONTROL_NAME_ALT"]?>"
																			id="<?=$ar["CONTROL_ID"]?>"
																			value="<? echo $ar["HTML_VALUE_ALT"] ?>"
																			<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
																		/>
																	<?endforeach?>
																	<div class="bx-filter-select-popup" data-role="dropdownContent" style="display: none;">
																		<ul>
																			<li>
																				<label for="<?="all_".$arCur["CONTROL_ID"]?>" class="bx-filter-param-label" data-role="label_<?="all_".$arCur["CONTROL_ID"]?>" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape("all_".$arCur["CONTROL_ID"])?>')">
																					<? echo GetMessage("CT_BCSF_FILTER_ALL"); ?>
																				</label>
																			</li>
																		<?
																		foreach ($arItem["VALUES"] as $val => $ar):
																			$class = "";
																			if ($ar["CHECKED"])
																				$class.= " selected";
																			if ($ar["DISABLED"])
																				$class.= " disabled";
																		?>
																			<li>
																				<label for="<?=$ar["CONTROL_ID"]?>" class="bx-filter-param-label<?=$class?>" data-role="label_<?=$ar["CONTROL_ID"]?>" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')"><?=$ar["VALUE"]?></label>
																			</li>
																		<?endforeach?>
																		</ul>
																	</div>
																</div>
															</div>
														</div>
														<?
														break;
													case "R"://DROPDOWN_WITH_PICTURES_AND_LABELS
														?>
														<div class="col-xs-12">
															<div class="bx-filter-select-container">
																<div class="bx-filter-select-block" onclick="smartFilter.showDropDownPopup(this, '<?=CUtil::JSEscape($key)?>')">
																	<div class="bx-filter-select-text fix" data-role="currentOption">
																		<?
																		$checkedItemExist = false;
																		foreach ($arItem["VALUES"] as $val => $ar):
																			if ($ar["CHECKED"])
																			{
																			?>
																				<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
																					<span class="bx-filter-btn-color-icon" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
																				<?endif?>
																				<span class="bx-filter-param-text">
																					<?=$ar["VALUE"]?>
																				</span>
																			<?
																				$checkedItemExist = true;
																			}
																		endforeach;
																		if (!$checkedItemExist)
																		{
																			?><span class="bx-filter-btn-color-icon all"></span> <?
																			echo GetMessage("CT_BCSF_FILTER_ALL");
																		}
																		?>
																	</div>
																	<div class="bx-filter-select-arrow"></div>
																	<input
																		style="display: none"
																		type="radio"
																		name="<?=$arCur["CONTROL_NAME_ALT"]?>"
																		id="<? echo "all_".$arCur["CONTROL_ID"] ?>"
																		value=""
																	/>
																	<?foreach ($arItem["VALUES"] as $val => $ar):?>
																		<input
																			style="display: none"
																			type="radio"
																			name="<?=$ar["CONTROL_NAME_ALT"]?>"
																			id="<?=$ar["CONTROL_ID"]?>"
																			value="<?=$ar["HTML_VALUE_ALT"]?>"
																			<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
																		/>
																	<?endforeach?>
																	<div class="bx-filter-select-popup" data-role="dropdownContent" style="display: none">
																		<ul>
																			<li style="border-bottom: 1px solid #e5e5e5;padding-bottom: 5px;margin-bottom: 5px;">
																				<label for="<?="all_".$arCur["CONTROL_ID"]?>" class="bx-filter-param-label" data-role="label_<?="all_".$arCur["CONTROL_ID"]?>" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape("all_".$arCur["CONTROL_ID"])?>')">
																					<span class="bx-filter-btn-color-icon all"></span>
																					<? echo GetMessage("CT_BCSF_FILTER_ALL"); ?>
																				</label>
																			</li>
																		<?
																		foreach ($arItem["VALUES"] as $val => $ar):
																			$class = "";
																			if ($ar["CHECKED"])
																				$class.= " selected";
																			if ($ar["DISABLED"])
																				$class.= " disabled";
																		?>
																			<li>
																				<label for="<?=$ar["CONTROL_ID"]?>" data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx-filter-param-label<?=$class?>" onclick="smartFilter.selectDropDownItem(this, '<?=CUtil::JSEscape($ar["CONTROL_ID"])?>')">
																					<?if (isset($ar["FILE"]) && !empty($ar["FILE"]["SRC"])):?>
																						<span class="bx-filter-btn-color-icon" style="background-image:url('<?=$ar["FILE"]["SRC"]?>');"></span>
																					<?endif?>
																					<span class="bx-filter-param-text">
																						<?=$ar["VALUE"]?>
																					</span>
																				</label>
																			</li>
																		<?endforeach?>
																		</ul>
																	</div>
																</div>
															</div>
														</div>
														<?
														break;
													case "K"://RADIO_BUTTONS
														?>
														<div class="col-xs-12">
															<div class="radio">
																<label class="bx-filter-param-label" for="<? echo "all_".$arCur["CONTROL_ID"] ?>">
																	<span class="bx-filter-input-checkbox">
																		<input
																			type="radio"
																			value=""
																			name="<? echo $arCur["CONTROL_NAME_ALT"] ?>"
																			id="<? echo "all_".$arCur["CONTROL_ID"] ?>"
																			onclick="smartFilter.click(this)"
																		/>
																		<span class="bx-filter-param-text"><? echo GetMessage("CT_BCSF_FILTER_ALL"); ?></span>
																	</span>
																</label>
															</div>
															<?foreach($arItem["VALUES"] as $val => $ar):?>
																<div class="radio">
																	<label data-role="label_<?=$ar["CONTROL_ID"]?>" class="bx-filter-param-label" for="<? echo $ar["CONTROL_ID"] ?>">
																		<span class="bx-filter-input-checkbox <? echo $ar["DISABLED"] ? 'disabled': '' ?>">
																			<input
																				type="radio"
																				value="<? echo $ar["HTML_VALUE_ALT"] ?>"
																				name="<? echo $ar["CONTROL_NAME_ALT"] ?>"
																				id="<? echo $ar["CONTROL_ID"] ?>"
																				<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
																				onclick="smartFilter.click(this)"
																			/>
																			<span class="bx-filter-param-text" title="<?=$ar["VALUE"];?>"><?=$ar["VALUE"];?><?
																			if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
																				?>&nbsp;(<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
																			endif;?></span>
																		</span>
																	</label>
																</div>
															<?endforeach;?>
														</div>
														<?
														break;
													case "U"://CALENDAR
														?>
														<div class="col-xs-12">
															<div class="bx-filter-parameters-box-container-block"><div class="bx-filter-input-container bx-filter-calendar-container">
																<?$APPLICATION->IncludeComponent(
																	'bitrix:main.calendar',
																	'',
																	array(
																		'FORM_NAME' => $arResult["FILTER_NAME"]."_form",
																		'SHOW_INPUT' => 'Y',
																		'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="'.FormatDate("SHORT", $arItem["VALUES"]["MIN"]["VALUE"]).'" onkeyup="smartFilter.keyup(this)" onchange="smartFilter.keyup(this)"',
																		'INPUT_NAME' => $arItem["VALUES"]["MIN"]["CONTROL_NAME"],
																		'INPUT_VALUE' => $arItem["VALUES"]["MIN"]["HTML_VALUE"],
																		'SHOW_TIME' => 'N',
																		'HIDE_TIMEBAR' => 'Y',
																	),
																	null,
																	array('HIDE_ICONS' => 'Y')
																);?>
															</div></div>
															<div class="bx-filter-parameters-box-container-block"><div class="bx-filter-input-container bx-filter-calendar-container">
																<?$APPLICATION->IncludeComponent(
																	'bitrix:main.calendar',
																	'',
																	array(
																		'FORM_NAME' => $arResult["FILTER_NAME"]."_form",
																		'SHOW_INPUT' => 'Y',
																		'INPUT_ADDITIONAL_ATTR' => 'class="calendar" placeholder="'.FormatDate("SHORT", $arItem["VALUES"]["MAX"]["VALUE"]).'" onkeyup="smartFilter.keyup(this)" onchange="smartFilter.keyup(this)"',
																		'INPUT_NAME' => $arItem["VALUES"]["MAX"]["CONTROL_NAME"],
																		'INPUT_VALUE' => $arItem["VALUES"]["MAX"]["HTML_VALUE"],
																		'SHOW_TIME' => 'N',
																		'HIDE_TIMEBAR' => 'Y',
																	),
																	null,
																	array('HIDE_ICONS' => 'Y')
																);?>
															</div></div>
														</div>
														<?
														break;
													default://CHECKBOXES
														?>
															<?foreach($arItem["VALUES"] as $val => $ar):?>
																	<label data-role="label_<?=$ar["CONTROL_ID"]?>"<? echo $ar["DISABLED"] ? 'disabled="disabled"': '' ?> for="<? echo $ar["CONTROL_ID"] ?>">
																			<input
																				class="checkbox"
																				type="checkbox"
																				value="<? echo $ar["HTML_VALUE"] ?>"
																				name="<? echo $ar["CONTROL_NAME"] ?>"
																				id="<? echo $ar["CONTROL_ID"] ?>"
																				<? echo $ar["CHECKED"]? 'checked="checked"': '' ?>
																				onclick="smartFilter.click(this)"
																				<? echo $ar["DISABLED"] ? 'disabled="disabled"': '' ?>
																			/>
																			<span class="bx-filter-param-text" title="<?=$ar["VALUE"];?>"><?=$ar["VALUE"];?><?

																			if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
																				?>&nbsp;(<span data-role="count_<?=$ar["CONTROL_ID"]?>"><? echo $ar["ELEMENT_COUNT"]; ?></span>)<?
																			endif;?></span>

																	</label>
															<?endforeach;?>
															<?if(count($arItem["VALUES"])>5):?>
																<span class="filter-all--show ">
																	<span class="filter-all--show-icon"></span>
																</span>
															<?endif;?>
												<?
												}
												?>
												</div>
											</div>
										</div>
									<?
									}
									?>
									<div class="filter-form__footer d-lg-none">
											<button id="set_filter" type="submit" name="set_filter" class="btn-main"><?=GetMessage("CT_BCSF_SET_FILTER")?></button>
											<button type="reset" id="del_filter" value="<?=GetMessage("CT_BCSF_DEL_FILTER")?>" name="del_filter"  class="filter-form__clear btn-outline">
												<?=GetMessage("CT_BCSF_DEL_FILTER")?>
											</button>
									</div>
									<div class="row" style="display:none;">
										<div class="col-xs-12 bx-filter-button-box">
											<div class="bx-filter-block">
												<div class="bx-filter-parameters-box-container">
													<?/*<input
														class="btn btn-themes"
														type="submit"
														id="set_filter"
														name="set_filter"
														value="<?=GetMessage("CT_BCSF_SET_FILTER")?>"
													/>
													<input
														class="btn btn-link"
														type="submit"
														id="del_filter"
														name="del_filter"
														value="<?=GetMessage("CT_BCSF_DEL_FILTER")?>"
													/>*/?>
													<div class="bx-filter-popup-result <?if ($arParams["FILTER_VIEW_MODE"] == "VERTICAL") echo $arParams["POPUP_POSITION"]?>" id="modef" <?if(!isset($arResult["ELEMENT_COUNT"])) echo 'style="display:none"';?> style="display: inline-block;">
														<?echo GetMessage("CT_BCSF_FILTER_COUNT", array("#ELEMENT_COUNT#" => '<span id="modef_num">'.intval($arResult["ELEMENT_COUNT"]).'</span>'));?>
														<span class="arrow"></span>
														<br/>
														<a class="hidden" href="<?echo $arResult["FILTER_URL"]?>" target=""><?echo GetMessage("CT_BCSF_FILTER_SHOW")?></a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
					<script type="text/javascript">
						var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
					</script>
				</div>
