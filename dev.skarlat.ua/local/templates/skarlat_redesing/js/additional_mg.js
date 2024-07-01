

var loader;
$(document).ready(function(){
	setTimeout(function(){
		$('.product-section').parent().attr('id','');
	},1000);
	$('#stars .award-list__item').on('click',function(){
		$('#ratingfield').val($(this).data('value'));
	});
	$('#product_review').on('submit',function(){
		var data=$(this).serialize();
		$.ajax({
			type: "POST",
			url: "/ajax/leave_review.php",
			data: data,
			async:false,
			success: function(response){
				$('#product_review').html(response);
			}
		});
		return false;
	});
	$('#review_comment').on('submit',function(){
		var data=$(this).serialize();
		$.ajax({
			type: "POST",
			url: "/ajax/leave_review.php",
			data: data,
			async:false,
			success: function(response){
				$('#review_comment').html(response);
			}
		});
		return false;
	});
	$(document).ajaxStart(function(e) {
		if(!loader){
			aminateAjax();
		}
    }).ajaxSuccess(function(e) {
		setTimeout(function(){
			clearInterval(loader);
			$('.progress-bar').removeClass('active');
			$('.progress-bar').attr('aria-valuenow', 0).css('width', 0);
			},1500
		);
    });
	$('body').delegate('#findProducts .search-btn','click',function(){
		if($('#compareAddResult').length>0)
			comparePopupFill($('#compareAddResult .search-place').val());
	});
	$('body').delegate('#REGISTER_EMAIL','change',function(){
		$('#REGISTER_LOGIN').val($(this).val());
	});
	$('body').delegate('.modal-body.modal-body-add-compare #compareAddResult','keydown',function(e){
		 if(event.keyCode == 13) {
          event.preventDefault();
          return false;
		 }
	});
	$('body').delegate('.modal-body.modal-body-add-compare #compareAddResult','submit',function(){
		return false;
	});
	$('#autocompleteCity.order-block__delivery-autocomplete').change(function(){
		let city = $(this).val();
		$('#selectCity').val(city);
	})
});
function aminateAjax(){
	var step=0.5;
	var nowstep=0;
	$('.progress-bar').addClass('active');
	loader=setInterval(function(){
		nowstep+=step;
		if(nowstep>=100){
			clearInterval(loader);
			loader=false;
		}
		$('.progress-bar').attr('aria-valuenow', nowstep).css('width', nowstep+'%');
	},step);
}
function changeSort(val){
	$.ajax({
		type: "POST",
		url: "/ajax/change_sort.php",
		data: {sort:val},
		async:false,
		success: function(response){
			$('#product_review').html(response);
			setTimeout(function(){
				$('.progress-bar').hide();
			},100);
		}
	});
}
function sendToCompare(productId,item){
	$.ajax({
		type: "POST",
		url: "/ajax/compare.php",
		data: {id:productId},
		async:false,
		success: function(response){
			if(response=='added'){
				item.addClass('active');
			}
			if(response=='removed'){
				item.removeClass('active');
			}
			$.ajax({
				type: "POST",
				url: "/ajax/compare_quantity.php",
				success: function(response){
					$('#compare-quan .marker-block-counter, #marker-block-counter-compare').html(response);
				}
			});
		}
	});
}
function searchToCompare(productId,item){
	$.ajax({
		type: "POST",
		url: "/ajax/compare.php",
		data: {id:productId},
		async:false,
		success: function(response){
			if(response=='added'){
				item.addClass('checked');
			}
			if(response=='removed'){
				item.removeClass('checked');
			}
			$.ajax({
				type: "POST",
				url: "/ajax/compare_quantity.php",
				success: function(response){
					$('#compare-quan .marker-block-counter, #marker-block-counter-compare').html(response);
				}
			});
		}
	});
}
function usefullReview(product){
	$.ajax({
		type: "POST",
		url: "/ajax/setReview.php",
		data: {id:product,review:'good',sessid:BX.bitrix_sessid()},
		async:false,
		success: function(response){
			$('.voteplus'+product).html(response);
			$('.voteplus'+product).parent().attr('title',"Ви вже голосували");
		}
	});
}
function uselessReview(product){
	$.ajax({
		type: "POST",
		url: "/ajax/setReview.php",
		data: {id:product,review:'bad',sessid:BX.bitrix_sessid()},
		async:false,
		success: function(response){
			$('.voteminus'+product).html(response);
			$('.voteminus'+product).parent().attr('title',"Ви вже голосували");
		}
	});
}
function sendToCompareDetail(productId){
	$.ajax({
		type: "POST",
		url: "/ajax/compare.php",
		data: {id:productId},
		success: function(response){
			if(response=='added'){
				$('.balance-button').addClass('active');
				$('.balance-button.texted').addClass('disabled');
				$('.balance-button.texted').html('До порівняння');
			}
			if(response=='removed'){
				$('.balance-button').removeClass('active');
				$('.balance-button.texted').removeClass('disabled');
				$('.balance-button.texted').html('Порівняння');
			}
			$.ajax({
				type: "POST",
				url: "/ajax/compare_quantity.php",
				success: function(response){
					$('#compare-quan .marker-block-counter, #marker-block-counter-compare').html(response);
				}
			});
		}
	});
}
function changeActiveOffer(id,item){
	if(item.hasClass('active')) return false;
	$('.product-color__item a').removeClass('active');
	item.addClass('active');
	$('#productData').val(id);
	$('.product-detail__price').removeClass('active');
	$('.basket-item__info_price').removeClass('active');
	$('.offer-'+id).addClass('active');
};
function sendToBasket(productId,productMinOrder){
	if($('#cardButton'+productId).hasClass('active')) return false;
	$.ajax({
		type: "POST",
		url: "/ajax/basket.php",
		data: {id:productId, count:productMinOrder},
		async:false,
		success: function(response){
			if(response=='added'){
				updateBasketQuantity();
				setTimeout(function(){
					$('#basketModalButtonHeader').click();
				},700);
			}
		}
	});
}
function sendToBasketCard(productId,productMinOrder){
	$.ajax({
		type: "POST",
		url: "/ajax/basket.php",
		data: {id:productId, count:productMinOrder},
		async:false,
		success: function(response){
			if(response=='added'){
				$('.order-aside.modal').addClass('show');
				$('.primary.cart-button').text('Додати ще');
				$(".basket-aside__nav").load('/index.php .basket-aside__nav');
			}
		}
	});
	$.ajax({
		type: "POST",
		url: "/ajax/modal-add-cart-catalog.php",
		success: function (data) {
			$(".order-aside.modal.show").find('.modal-body').html(data);
		}
	});
	fbq('track', 'ViewContent');
}
function openModal(txt){
	$.fancybox.open(txt);
}
function subscribe(productId,itemClass,listSubscribeId){
	var item=$(itemClass);
	console.log(listSubscribeId);
	if(item.hasClass('active')){
		var listid = new Map([[0, $(listSubscribeId).val()]]);
		let dataArrayListSubscribeId = [$(listSubscribeId).val()];

		$.ajax({
			type: "POST",
			data:{deleteSubscribe:'Y', itemId: productId, listSubscribeId:dataArrayListSubscribeId, sessid:BX.bitrix_sessid(),siteId:'mg'},
			url: "/bitrix/components/bitrix/catalog.product.subscribe.list/ajax.php",
			success: function(response){
				$(itemClass).removeClass('active');
				$(itemClass+".texted").removeClass('disabled').html('Обране');
				$.ajax({
					type: "POST",
					data:{itemId: productId},
					url: "/ajax/favourite_quantity.php",
					success: function(response){
						var responseparce = JSON.parse(response);
						$('#favourite .marker-block-counter, #marker-block-counter-favourite').html(responseparce.quantity);
					}
				});
			}
		});
	}else{
		$.ajax({
			type: "POST",
			data:{subscribe:'Y',itemId: productId,landingId:0,sessid:BX.bitrix_sessid(),siteId:'mg'},
			url: "/bitrix/components/bitrix/catalog.product.subscribe/ajax.php",
			success: function(response){
				$(itemClass).addClass('active');
				$(itemClass+".texted").addClass('disabled').html('В обраному');
				$.ajax({
					type: "POST",
					url: "/ajax/favourite_quantity.php",
					data:{itemId: productId},
					success: function(response){
						var responseparce = JSON.parse(response);
						$('#favourite .marker-block-counter, #marker-block-counter-favourite').html(responseparce.quantity);
						$(listSubscribeId).val(responseparce.item);
					}
				});
			}
		});
	}
}
function showLazyPics(){
	var lazyImages = [].slice.call(document.querySelectorAll('img.lazy'));
	var lazyBackgrounds = [].slice.call(document.querySelectorAll('.lazy-background'));
	var lazyBackgroundsData = [].slice.call(document.querySelectorAll('[data-bg]'));
	if ('IntersectionObserver' in window) {
		let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
			entries.forEach(function(entry) {
				if (entry.isIntersecting) {
					let lazyImage = entry.target;
					lazyImage.src = lazyImage.dataset.src;
					lazyImage.srcset = lazyImage.dataset.srcset;
					lazyImage.classList.remove('lazy');
					lazyImageObserver.unobserve(lazyImage);
				}
			});
		});
		lazyImages.forEach(function(lazyImage) {
			lazyImageObserver.observe(lazyImage);
		});
	let lazyBackgroundObserver = new IntersectionObserver(function(entries, observer) {
		entries.forEach(function(entry) {
			if (entry.isIntersecting) {
				entry.target.classList.add('visible');
				lazyBackgroundObserver.unobserve(entry.target);
			}
		});
	});
	lazyBackgrounds.forEach(function(lazyBackground) {
		lazyBackgroundObserver.observe(lazyBackground);
	});
	let lazyBackgroundDataObserver = new IntersectionObserver(function(entries, observer) {
		entries.forEach(function(entry) {
			if (entry.isIntersecting) {
				let lazyBackgroundData = entry.target;
				lazyBackgroundData.style.backgroundImage = 'url(' + lazyBackgroundData.dataset.bg + ')';
				lazyBackgroundDataObserver.unobserve(lazyBackgroundData);
			}
		});
	});
	lazyBackgroundsData.forEach(function(lazyBackgroundData) {
		lazyBackgroundDataObserver.observe(lazyBackgroundData);
	});
	} else {
		lazyImages.forEach(function(lazyImage) {
			lazyImage.src = lazyImage.dataset.src;
			lazyImage.srcset = lazyImage.dataset.srcset;
		});
		lazyBackgrounds.forEach(function(lazyBackground) {
			lazyBackground.classList.add('visible');
		});
		lazyBackgroundsData.forEach(function(lazyBackgroundData) {
			lazyBackgroundData.style.backgroundImage = 'url(' + lazyBackgroundData.dataset.bg + ')';
		});
	}
}
function updateBasketQuantity(){
	$.ajax({
		type: "POST",
		url: "/ajax/basket_quantity.php",
		success: function(response){
			$('#basketModalButtonHeader .marker-block-counter, #marker-block-counter-basket').html(response);
			updateFullBasket();
			if($('#jumboAjaxWrapper').length>0) updateJumbo();
		}
	});
}
function updateJumbo(){
	$.ajax({
		type: "POST",
		url: "/ajax/jumbotron.php",
		success: function(response){
			$('#jumboAjaxWrapper').html(response);
		}
	});
}
function updateFullBasket(){
	$.ajax({
		type: "POST",
		url: "/ajax/fullbasket.php",
		success: function(response){
			$('#modalAjaxBasketContainer').html(response);
		}
	});
}
function registerUser(formname){
	var data=$('#'+formname).serialize();
	$.ajax({
		type: "POST",
		data:data,
		url: "/ajax/register_form.php?register_submit_button=Y",
		success: function(response){
			$('#pills-registration').html(response);
		}
	});
}
function loginUser(formname){
	var data=$('#'+formname).serialize();
	$.ajax({
		type: "POST",
		data:data,
		url: "/ajax/login_form.php?AUTH_ACTION=Войти",
		success: function(response){
			$('#pills-enter').html(response);
		}
	});
}
function compareFull(different) {
	$.ajax({
		type: "POST",
		url: "/ajax/compare_list.php?DIFFERENT="+different,
		success: function(response) {
			$('#compare_list').html(response);
		}
	});
}
function setCompareMainItem(itemId) {
	$.ajax({
		type: "POST",
		data: {itemId:itemId},
		url: "/ajax/set_main_compare.php",
		success: function(response) {
			$.ajax({
				type: "POST",
				url: "/ajax/compare_list.php",
				success: function(response) {
					$('#compare_list').html(response);
				}
			});
		}
	});
}
function addTab(tabtame,tab){
	var result = null,
		tmp = [];
	var items = location.search.substr(1).split("&");
	var search="";
	var tabstatus=0;
	for (var index = 0; index < items.length; index++) {
		tmp = items[index].split("=");
		if (tmp[0] === tabtame){
			if(index>0)
				search+="&"+tabtame+"="+tab;
			else
				search+="?"+tabtame+"="+tab;
			tabstatus=1;
		}else if(tmp[0]!=''){
			if(index>0)
				search+="&"+items[index];
			else
				search+="?"+items[index];
			console.log(tmp[0]);
		}
	}
	if(tabstatus<1 && !search) search+="?"+tabtame+"="+tab;
	else if(tabstatus<1) search+="&"+tabtame+"="+tab;
	urlPath=document.location.pathname+search;
	window.history.replaceState({},"", urlPath);
}
function comparePopupFill(data){
	$.ajax({
		type: "GET",
		data: {q:data,compare_small:"Y"},
		url: "/ajax/compare_add.php",
		success: function(response) {
			$('#compareAddResult').html(response);
		}
	});
}
function clearModalCompare(){
	$('#compareAddResult .checked').removeClass('checked');
}
function addModalCompare(){
	var compare_arr=[];
	$('#compareAddResult .checked').each(function(){
		compare_arr.push($(this).data('item'));
	});
	$.ajax({
		type: "POST",
		data: {array:compare_arr,isArray:"Y"},
		url: "/ajax/compare.php",
		success: function(response) {
			$('#compareAddResult').html("Додаємо ...");
			window.location.reload();
		}
	});
}
function setDevCity(city){
	$('#selectCity').val(city);
	$('#autocompleteCity.bx-ui-sls-fake').val(city);
	$('.bx-ui-sls-route').val('');
	getNPOffices(city);

}
function setCity(id){
	let div = $('.select-city.form-group');
	$.ajax({
		type: "POST",
		url: '/ajax/changeCity.php',
		data: {id: id},
		success: function (data) {
			$(div).html(data);
		}
	});
}
function checkCour(city){
	if(city!='Киев'){
		$('#delivery-np-cur-input-20').removeAttr('checked').addClass('disabled').attr('disabled',true);
		$('#delivery-np-cur-input-21').removeAttr('checked').addClass('disabled').attr('disabled',true);
		$('#delivery-np-cur-description-21').removeClass('show');
		$('#delivery-np-cur-description-20').removeClass('show');
		$('#delivery-np-cur-input-21').parent().find('.not-allowed').addClass('show');
		$('#delivery-np-cur-input-20').parent().find('.not-allowed').addClass('show');
	}else{
		$('#delivery-np-cur-input-20').removeClass('disabled').removeAttr('disabled');
		$('#delivery-np-cur-input-21').removeClass('disabled').removeAttr('disabled');
		$('#delivery-np-cur-input-21').parent().find('.not-allowed').removeClass('show');
		$('#delivery-np-cur-input-20').parent().find('.not-allowed').removeClass('show');
	}
}
function getNPOffices(city,set=""){
	var required=$('#selectPost').attr('required');
	$.ajax({
		type: "POST",
		url: "/ajax/npoffices.php",
		data: {city:city,required:required,set:set},
		async:false,
		success: function(response){
			$('#npoffice-container').html(response);
		}
	});
	checkCour(city);
}
function changeDelivery(delivery){
	$('.delivery-unstable').removeAttr('required');
	$('#selectPost').removeAttr('required');
	if(delivery!=18){
		$('[data-delivery='+delivery+']').attr('required','required');
	}
	else{
		$('#selectPost').attr('required','required');
	}
}
