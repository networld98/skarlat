;(function () {
	function initBinking () {
		// Choose strategy:

		/**
		// Api strategy examaple settings:
		binking.setDefaultOptions({
			strategy: 'api',
			apiKey: 'cbc67c2bdcead308498918a694bb8d77' // Replace it with your API key
			// sandbox: true
		})
		/**/

		/**/
		// Archive strategy example settings:
		binking.setDefaultOptions({
			strategy: "archive",
			banksLogosPath: 'banks-logos/',
			brandsLogosPath: 'brands-logos/',
		});
		
		binking.addBanks({
			"ru-sberbank": {
				bankAlias: "ru-sberbank",
				bankName: "Sberbank",
				bankLocalName: "Сбербанк",
				bankColor: "#1a9f29",
				bankColors: ["#1a9f29"],
				bankCountry: "ru",
				bankSite: "https:www.sberbank.ru",
				bankPhone: "8 800 555-55-50",
				formBackgroundColor: "#1a9f29",
				formBackgroundColors: ["#1a9f29", "#0d7518"],
				formBackgroundLightness: "dark",
				formTextColor: "#ffffff",
				formLogoScheme: "inverted",
				formBorderColor: "#ffffff"
			},
			
			"ru-alfa": {
				bankAlias: "ru-alfa",
				bankName: "Alfa-Bank",
				bankLocalName: "Альфа-Банк",
				bankColor: "#f80000",
				bankColors: ["#f80000"],
				bankCountry: "ru",
				bankSite: "https://alfabank.ru/",
				bankPhone: "--//-",
				formBackgroundColor: "#ef3124",
				formBackgroundColors: ["#ef3124", "#d6180b"],
				formBackgroundLightness: "dark",
				formTextColor: "#fff",
				formLogoScheme: "inverted",
				formBorderColor: "#ffffff"
			},
			"ru-raiffeisen": {
				bankAlias: "ru-raiffeisen",
				bankName: "Raiffeisenbank bank",
				bankLocalName: "Райффайзенбанк",
				bankColor: "#ffed00",
				bankColors: ["#ffed00", "#000000"],
				bankCountry: "",
				bankSite: "https://www.raiffeisen.ru/",
				bankPhone: "--//-",
				formBackgroundColor: "#ffed00",
				formBackgroundColors: ["#ffed00", "#dfbb00"],
				formBackgroundLightness: "light",
				formTextColor: "#000",
				formLogoScheme: "original",
				formBorderColor: "#000000"
			},
			"ru-tinkoff": {
				bankAlias: "ru-tinkoff",
				bankName: "Tinkoff Bank",
				bankLocalName: "Тинькофф Банк",
				bankColor: "#1d1d1b",
				bankColors: ["#1d1d1b", "#ffe400"],
				bankCountry: "ru",
				bankSite: "https://www.tinkoff.ru/",
				bankPhone: "--//-",
				formBackgroundColor: "#333",
				formBackgroundColors: ["#444", "#222"],
				formBackgroundLightness: "dark",
				formTextColor: "#fff",
				formLogoScheme: "inverted",
				formBorderColor: "#ffffff"
			},
			
			
			"ru-qiwi": {
				bankAlias: "ru-qiwi",
				bankName: "Qiwi Bank",
				bankLocalName: "Киви Банк",
				bankColor: null,
				bankColors: null,
				bankCountry: "ru",
				bankSite: "https://qiwi.com/",
				bankPhone: "--//-",
				formBackgroundColor: '#eeeeee',
				formBackgroundColors: ['#eeeeee', '#dddddd'],
				formBackgroundLightness: null,
				formTextColor: "#000",
				formLogoScheme: "original",
				formBorderColor: "#000000",
			},
			
		});
		
		
	}

	
	function validate () {
		var validationResult = binking.validate($cardNumberField.value, $monthField.value, $yearField.value, $codeField.value)
		
		return validationResult
	}
	
	function cardNumberChangeHandler () {
		binking($cardNumberField.value, function (result) {
			newCardInfo = result
			
			if (typeof result.bankAlias !== "undefined" && result.bankAlias) {
				$("#bank_alias").val(result.bankAlias.replace("ru-", ""));
			} else {
				$("#bank_alias").val("");
			}
			
			$frontPanel.style.background = result.formBackgroundColor
			$frontPanel.style.color = result.formTextColor
			$frontFields.forEach(function (field) {
				field.style.borderColor = result.formBorderColor
			})
			$codeField.placeholder = result.codeName || ''
			if (result.formBankLogoBigSvg) {
				$bankLogo.src = result.formBankLogoBigSvg
				$bankLogo.classList.remove('binking__hide')
			} else {
				$bankLogo.classList.add('binking__hide')
			}
			if (result.formBrandLogoSvg) {
				$brandLogo.src = result.formBrandLogoSvg
				$brandLogo.classList.remove('binking__hide')
			} else {
				$brandLogo.classList.add('binking__hide')
			}
			var validationResult = validate()
			var isFulfilled = result.cardNumberNormalized.length >= result.cardNumberMinLength
			var isChanged = prevNumberValue !== $cardNumberField.value
			if (isChanged && isFulfilled) {
				if (validationResult.errors.cardNumber) {
					cardNumberTouched = true
					validate()
				} else {
					$monthField.focus()
				}
			}
			prevNumberValue = $cardNumberField.value
		})
	}
	
	function cardNumberBlurHandler () {
		cardNumberTouched = true
		validate()
	}
	
	

	var $form = document.querySelector('.binking__form')
	var $success = document.querySelector('.binking__success')
	var $submitButton = document.querySelector('.binking__submit-button')
	var $resetButton = document.querySelector('.binking__reset-button')
	var $frontPanel = document.querySelector('.binking__front-panel')
	var $bankLogo = document.querySelector('.binking__form-bank-logo')
	var $brandLogo = document.querySelector('.binking__form-brand-logo')
	var $cardNumberField = document.querySelector('.binking__number-field')
	var $codeField = document.querySelector('.binking__code-field')
	var $monthField = document.querySelector('.binking__month-field')
	var $yearField = document.querySelector('.binking__year-field')
	var $saveCardField = document.querySelector('.binking__save-card-checkbox')
	var $frontFields = document.querySelectorAll('.binking__front-fields .binking__field')
	var $savedCardsSection = document.querySelector('.binking__saved-cards')
	var $savedCardsList = document.querySelector('.binking__cards')
	var $error = document.querySelector('.binking__error')
	var prevNumberValue = $cardNumberField.value
	var prevMonthValue = $monthField.value
	var prevYearValue = $yearField.value
	var selectedCardIndex = null
	var cardNumberTouched = false
	var monthTouched = false
	var yearTouched = false
	var codeTouched = false
	var sending = false
	var savedCardsBanks
	var newCardInfo
	var cardNumberTip
	var monthTip
	var yearTip
	var codeTip
	var cardNumberMask
	var monthMask
	var yearMask
	var codeMask
	var savedCards = [{
		last4: 4421,
		bankAlias: 'ru-sberbank',
		brandAlias: 'mastercard'
	}, {
		last4: 8917,
		bankAlias: 'ru-rosbank',
		brandAlias: 'visa'
	}, {
		last4: 7712,
		brandAlias: 'mastercard' // Example of card, where bank is undefined
	}]
	
	
	initBinking()

	$cardNumberField.addEventListener('input', cardNumberChangeHandler)
	$cardNumberField.addEventListener('blur', cardNumberBlurHandler)
	
	CLIENT.getBins();
	
})();