<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */
$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();
$pos = strpos($arResult['PROPERTIES']['VIDEOS']['VALUE'],'VALUE');
if($arResult['PROPERTIES']['VIDEOS']['VALUE']!=NULL && $pos === false){
    if($arResult['PREVIEW_TEXT']==''){
        $arResult['PREVIEW_TEXT'] = $arResult['DETAIL_TEXT'];
    }
    $arResult['PROPERTIES']['VIDEOS']['VALUE'] = str_replace('https://youtu.be/', '', $arResult['PROPERTIES']['VIDEOS']['VALUE']);
    $videos = str_replace('https://www.youtube.com/embed/','', $arResult['PROPERTIES']['VIDEOS']['VALUE']);?>
    <div id="modalYoutube" data-close="true" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><?=$arResult['PROPERTIES']['SHORT_CATEGORY_NAME']['VALUE']?> <?=$arResult['NAME']?></h2>
                <button class="close" id="pauseYoutube" data-close="true">
                    <svg x="0px" y="0px" viewBox="0 0 30 30">
                        <path d="M25,6.2L23.8,5L15,13.8L6.2,5L5,6.2l8.8,8.8L5,23.8L6.2,25l8.8-8.8l8.8,8.8l1.2-1.2L16.2,15L25,6.2z"></path>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="row pb-4">
                    <div class="col-12">
                        <div id="video-schema" itemprop="video" itemscope itemtype="http://schema.org/VideoObject">
                            <div id="video-schema-meta">
                                <meta itemprop="description" content="<?=$arResult['PREVIEW_TEXT']?>"/>
                                <link itemprop="url" href="https://youtu.be/<?=$videos?>"/>
                                <link itemprop="thumbnailUrl" href="https://img.youtube.com/vi/<?=$videos?>/maxresdefault.jpg"/>
                                <meta itemprop="name" content="<?=$arResult['NAME']?>"/>
                                <meta itemprop="embedUrl" content="https://youtu.be/<?=$videos?>"/>
                                <meta itemprop="uploadDate" content="<? echo PHPFormatDateTime($arResult["DATE_CREATE"], "d-m-Y");?>"/>
                                <meta itemprop="isFamilyFriendly" content="true"/>
                                <span itemprop="thumbnail" itemscope itemtype="https://schema.org/ImageObject" >
                            <meta itemprop="width" content="1920"/>
                            <meta itemprop="height" content="1080"/>
                            </span>
                            </div>
                            <iframe width="100%" height="310px"  src="https://www.youtube.com/embed/<?=$videos?>?rel=0&enablejsapi=1" frameborder="0" allowfullscreen id="Youtube"></iframe>
                        </div>
                        <script src="//www.youtube.com/player_api"></script>
                        <script>
                            function onYouTubePlayerAPIReady() {
                                player = new YT.Player('Youtube', {
                                    events: {'onReady': onPlayerReady}
                                });
                            }
                            function onPlayerReady(event) {
                                document.getElementById("pauseYoutube").addEventListener("click", function() {player.pauseVideo();});
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?}?>
