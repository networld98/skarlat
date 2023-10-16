<?
if($_POST['id']!=NULL){
    $videos = $_POST['id'];?>
    <div id="itemproYoutube">
        <div itemprop="video" itemscope itemtype="http://schema.org/VideoObject">
            <?if($_POST['text']!=NULL){?>
                <meta itemprop="description" content="<?=$_POST['text']?>"/>
            <?}?>
            <link itemprop="url" href="https://youtu.be/<?=$videos?>"/>
            <link itemprop="thumbnailUrl" href="https://img.youtube.com/vi/<?=$videos?>/maxresdefault.jpg"/>
            <meta itemprop="name" content="<?=$_POST['name']?>"/>
            <meta itemprop="embedUrl" content="https://youtu.be/<?=$videos?>"/>
            <meta itemprop="uploadDate" content="<? echo date("d-m-Y");?>"/>
            <meta itemprop="isFamilyFriendly" content="true"/>
            <span itemprop="thumbnail" itemscope itemtype="https://schema.org/ImageObject" >
            <meta itemprop="width" content="1920"/>
            <meta itemprop="height" content="1080"/>
            </span>
        </div>
        <iframe width="100%" height="<?=$_POST['height']?>" src="https://www.youtube.com/embed/<?=$videos?>?rel=0&autoplay=1&enablejsapi=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
<?}?>