$(document).ready(function() {
    //Фиксируем шапку на сайте
    // $(document).scroll(function () {
    //     if ($(this).scrollTop() > 0) {
    //         $('.header').css("position","fixed");
    //         $('.header').css("border-bottom","1px solid hsla(0,0%,89.8%,.5)");
    //     } else {
    //         $('.header').css("position","relative");
    //         $('.header').css("border-bottom","none");
    //     }
    // });
    //Делаем шапку постоянно fixed в стилях,
    // а отступ делаем блоком высота которого будет изменять после загрузки или ресайза
    // let headerHeight = $('header').height();
    // $('.header-fix').css('height', headerHeight);
    // $(window).resize(function() {
    //     let headerHeight = $('header').height();
    //     $('.header-fix').css('height', headerHeight);
    // });
    //Добавил маски телефона, емейла и карты
    $("input[name='ORDER[PROPS][PHONE]']").inputmask("+38 (999) 999-99-99",{ showMaskOnHover: true });
    $("input[name='USER[PERSONAL_PHONE]']").inputmask("+38 (999) 999-99-99",{ showMaskOnHover: true });
    $("input[name='form_text_86']").inputmask("+38 (999) 999-99-99",{ showMaskOnHover: true });
    //открытие модалки истории заказа
    $('.delete-order').click(function (){
        let id = $(this).data('id');
        $.ajax({
            type: "POST",
            url: "/ajax/сancel_order.php",
            data: {id:id},
            success: function (data) {
                $(".bx-catalog-subscribe-alert-popup").show('fast');
                window.location.replace(window.location.href);
            }
        });
        return false;
    });
    //Загрузка видео на странице сотрудничества
    $('.cooperation-slide.youtube .overflow').click(function (){
        $('#itemproYoutube').remove();
        $('.cooperation-slide.youtube').find('div').show();
        $('.cooperation-slide.youtube').find('img').show();
        onYouTubePlayerAPIReady = null;
        let id = $(this).data('id-video'),
            name = $(this).data('name-video'),
            text = $(this).data('text-video');
            block = $(this).parent('.cooperation-slide.youtube');
            height = $(this).height();
        $.ajax({
            type: "POST",
            url: "/ajax/video-gallery.php",
            data: {id:id, name:name, text:text, height:height },
            success: function (data) {
                block.find('div').hide();
                block.find('img').hide();
                block.append(data);
            }
        });
        return false;
    });

    //Удаление из куков не авторизованых пользователей
    function delFavNoAut(){
        $('.product-item--remove').click(function () {
            let id = $(this).parent('.favorite-item_block').data('id');
            $.ajax({
                type: "POST",
                url: "/ajax/favourite_quantity.php",
                data: {itemId: id},
                success: function (data) {
                    $(".product-model-block").load("/favourite/index.php .product-model-block");
                }
            });
            return false;
        });
    }
    delFavNoAut();
    $(document).ajaxStop(function() {
        delFavNoAut();
    });
    //Блок заказов в личном кабинете
     $('.collapse.status-canceled').click(function (){
         if ($(this).hasClass('active')){
             $(this).removeClass('active');
             $(this).parent('.order__item').find('.collapse-content-new-order').removeClass('show');
         }else{
             $(this).addClass('active').animate( {display: 'block'}, {duration:1500});
             $(this).parent('.order__item').find('.collapse-content-new-order').addClass('show');
         }
     })
    //Блок доставки в личном кабинете
    $('#user-delivery .form-check.deliv-type input').click(function (){
        let id = $(this).data('target');
        $('.collapse.show').removeClass('show');
        $(id).addClass('show');
    });
    //Показ фильтров в каталоге
    function fullModalFilter(){
        $('#modalFilters').click(function (){
            $('#filterModal').addClass('active');
        });
        $('#ajax-container button.close').click(function (){
            $('#filterModal').removeClass('active');
        });
    }
    fullModalFilter();
    //Перезагрузка модалки после применения фильтра
    BX.addCustomEvent('onAjaxSuccessFinish', function(){
        fullModalFilter();
    })
    //Смена урлов в личном кабинете
    if(window.location.pathname=='/personal/' || window.location.pathname=='/ru/personal/' || window.location.pathname=='/ua/personal/'){
        $(window).resize(function() {
            $('.lk-content .preloader').hide();
        });
        $('.lk-content .preloader').hide();

        function setLocation(curLoc){
            try {
                history.pushState(null, null, curLoc);
                return;
            } catch(e) {}
            location.hash = '#' + curLoc;
        }
        let url = new URL(window.location.href),
            searchParams = new URLSearchParams(url.search.substring(1)),
            tabGET  = searchParams.get("tab"),
            loginGET = searchParams.get("login");

        if (tabGET == '' || tabGET == undefined || loginGET == 'yes'){
            tabGET = 'profil';
            setLocation('?tab='+tabGET+'');
        }
        personalShow = $('.lk-content-modal.d-flex');
        personalShow.removeClass('d-flex show');
        $('header.header').addClass('hide');
        $('.lk-content').find( ".lk-content-modal[data-show$='"+tabGET.split('&')[0]+"']").addClass('d-flex show');
        $('.list-group-item.list-group-item-action').click(function (){
            link = $(this).data('link');
            if (link == undefined ){
                link = 'profil';
            }
                setLocation('?tab='+link+'');
                personalShow = $('.lk-content-modal.d-flex');
                personalShow.removeClass('d-flex show');
                $('.lk-content').find( ".lk-content-modal[data-show$='"+link+"']").addClass('d-flex show');
                $('.lk-content').addClass('active');
                $('header.header').addClass('hide');
                $('.lk-content .preloader').hide();
        });
    }
    //закрытие мобильной модалки личного кабинета
    $('.lk-content button.close').click(function (){
        $('.lk-content.active').removeClass('active');
        $('.lk-content-modal.d-flex').removeClass('show');
        $('header.header').removeClass('hide');
    });
    //Аккордион FAQ (личный кабинет)
    $('.lk-content-modal__body .collapse-question').click(function (){
        $('.lk-content-modal__body .collapse-content-question.active').removeClass('active');
        $(this).parent('span').find('.collapse-content-question').addClass('active');
    });
    $('.order-tab-payment-nav__item').click(function (){
        payment = $(this).data('payment');
        $('.order-tab-payment-nav__item').removeClass('active');
        $(this).addClass('active');
        $('.order-tab-payment__content').removeClass('active');
        $('#'+payment).addClass('active');
    });
    $('.header-category-app').click(function (){
        category = $(this).data('tab');
       if($('.header-tab-content__list__'+category).hasClass('hide')){
            $('.header-tab-content__item').css('visibility','hidden');
            $('.header-tab-content__list').addClass('hide');
            $('.header-tab-content__list__'+category).removeClass('hide');
            $('.header-content__wrap').addClass('theme-shadow');
            $('.bg-shadow').removeClass('hide');
            $('.header-tab__wrapper').addClass('show').animate( {display: 'block'}, {duration:1500});
            $('.header-tab-content__list__'+category+' li:eq(0)').css('visibility','visible').hide().fadeIn(300, function(){
               $(this).next().css('visibility','visible').hide().fadeIn(300, arguments.callee);
            });
       }else{
           $('.header-tab__wrapper').removeClass('show');
           $('.header-tab-content__list__'+category).addClass('hide');
           $('.bg-shadow').addClass('hide');
           $('.header-content__wrap').removeClass('theme-shadow');
       }
    });
    //Переключение языка в футере
    $('.select.language').click(function (){
        if ($(this).find('.select-items').hasClass('select-hide')){
            $(this).find('.select-items').removeClass('select-hide');
        }else{
            $(this).find('.select-items').addClass('select-hide');
        }
    });
    $('.bg-shadow').click(function (){
        $('.header-tab__wrapper').removeClass('show');
        $('.header-tab-content__list').addClass('hide');
        $('.bg-shadow').addClass('hide');
        $('.header-content__wrap').removeClass('theme-shadow');
    });
    //Показ и скрытие персональной модалки
    $(document).mouseup(function (e){
        if ($('.basket-aside').hasClass('show')) {
            var div = $("#basket");
            var btn = $("#header-basket-btn-app");
            if (!div.is(e.target)
                && div.has(e.target).length === 0
                && !btn.is(e.target)
                && btn.has(e.target).length === 0) {
                div.removeClass('show');
                $('.basket-aside__wrap').removeClass('show');
            }
        }
    });

    $('#header-basket-btn-app').click(function (){
        if (screen.width > 992) {
            $('.lk-content .preloader').hide();
            if ($('.basket-aside__wrap').hasClass('show')){
                $('.basket-aside__wrap .basket-aside').removeClass('show');
                $('.basket-aside__wrap').removeClass('show');
            }else{
                $('.basket-aside__wrap .basket-aside').addClass('show').animate( {display: 'block'}, {duration:1500});
                $('.basket-aside__wrap').addClass('show');
                if ($('.header-content__wrap').hasClass('theme-shadow')){
                    $('.header-tab__wrapper').removeClass('show');
                    $('.header-tab-content__list__'+category).addClass('hide');
                    $('.bg-shadow').addClass('hide');
                }
            }
        }
        else {
                location.href = '/personal/';
            }

    });
    $('#header-search-btn-app').click(function (){
        if ($('.header-content__wrap').hasClass('theme-shadow')){
            $('.header-tab__wrapper').removeClass('show');
            $('.header-tab-content__list__'+category).addClass('hide');
            $('.bg-shadow').addClass('hide');
            $('.header-content__wrap').removeClass('theme-shadow');
        }
        $('#header-search-block').removeClass('hide');
        $('#header-search-block').parents('.header-content-wrapper').addClass('show');
        $('#header-search-block').addClass('show').animate( {display: 'block'}, {duration:1500});
        $('#header-nav-info').removeClass('show');
        $('#header-nav-info').addClass('hide');
        $('#header-search').focus();
    });
    $('#header-search-reset').click(function (){
        $('#header-search-block').addClass('hide');
        $('#header-search-block').parents('.header-content-wrapper').removeClass('show');
        $('#header-search-block').removeClass('show');
        $('#header-nav-info').addClass('show');
        $('#header-nav-info').removeClass('hide');
        if(window.location.pathname=='/' || window.location.pathname=='/ru/' || window.location.pathname=='/ua/') {
            $('.header-content__wrap').addClass('dark-main-desktop');
        }
    });
    //открытие модалки хедера с телефонами
    $('.header-phone-app').click(function (){
        $('.lk-content .preloader').hide();
        if ($('#phoneModal').hasClass('active')){
            $('#phoneModal').removeClass('active');
        }else{
            $('#phoneModal').addClass('active');
        }
    });
    //открытие модалки видео
    $('.product-gallery-thumbs__item.youtube').click(function (){
        if ($('#modalYoutube').hasClass('active')){
            $('#modalYoutube').removeClass('active');
        }else{
            $('#modalYoutube').addClass('active');
        }
    });
    //При клике вне блока с телефоном
    $(document).mouseup(function (e) {
        var container = $(".lk-content-modal.show");
        if (container.has(e.target).length === 0){
            container.parent('.lk-content').removeClass('active');
            container.removeClass('show');
        }
    });
    //При клике вне блока личного кабинета на мобильно
    $(document).mouseup(function (e) {
        var container = $("#phoneModal .modal-content");
        if (container.has(e.target).length === 0){
            container.parent('#phoneModal').removeClass('active');
        }
    });
    //открытие модалки истории заказа
    $('.modal-info__icon').click(function (){
        let id = $(this).data('id');
        let info = $(this).data('info');
        if(info=='history'){
            $.ajax({
                type: "POST",
                url: "/ajax/order_status.php",
                data: {id:id},
                success: function (data) {
                    // Вывод текста результата отправки
                    $("#modalInfo").find('.history-list-order').html(data);
                    if ($('#modalInfo').hasClass('active')){
                        $('#modalInfo').removeClass('active');
                    }else{
                        $('#modalInfo').addClass('active');
                    }
                }
            });
            return false;
        }else if(info=='withdrawal'){
            $.ajax({
                type: "POST",
                url: "/ajax/withdrawal_bonuses.php",
                data: {id:id},
                success: function (data) {
                    // Вывод текста результата отправки
                    $("#modalBonus").find('.col-12').html(data);
                    if ($('#modalBonus').hasClass('active')){
                        $('#modalBonus').removeClass('active');
                    }else{
                        $('#modalBonus').addClass('active');
                    }
                }
            });
            return false;
        }
    });
    //закрытие модалок телефона и истории заказа
    $('.modal-header .close').click(function (){
        $('#phoneModal').removeClass('active');
        $('#modalInfo').removeClass('active');
        $('#modalBonus').removeClass('active');
        $('#modalYoutube').removeClass('active');
    });
    $('.order-aside.modal .close').click(function (){
        $('.order-aside.modal').removeClass('show');
    });
    //Вывод мышки вне селекта фильтра
    $(document).mouseup(function (e) {
        var container = $(".select-selected.select-arrow-active");
        if (container.has(e.target).length === 0){
            container.removeClass('select-arrow-active');
        }
    });
    //Вывод кастомной сортировки
    $('.select.sort').click(function (){
        if($(this).hasClass('select-arrow-active')) {
            $(this).removeClass('select-arrow-active');
            $(this).parent('.select.sort').find('.select-items').addClass('select-hide');
        }else{
            $(this).addClass('select-arrow-active');
            $(this).parent('.select.sort').find('.select-items').removeClass('select-hide');
        }
    })

    $('#burger').click(function (){
        if ($(this).hasClass('active')){
            $(this).removeClass('active');
            $('.menu-mobile-parrent li').show();

            $('.menu-wrapper').removeClass('show');
            $('.menu-wrapper').addClass('hide');
            $('.lang-block').addClass('hide');
            $('.header').removeClass('show-burger');
            $('.header-nav-wrapper').removeClass('show-menu');
            $('#header-basket-btn-app').show(); //??
        }else{
            $('.menu-wrapper').removeClass('hide');
            $('.lang-block').removeClass('hide');
            $(this).addClass('active').animate( {display: 'block'}, {duration:1500});
            $('.menu-wrapper').addClass('show').animate( {display: 'block'}, {duration:1500});
            $('.header').addClass('show-burger');
            $('.header-nav-wrapper').addClass('show-menu');
            $('#header-basket-btn-app').hide(); //??
            $('.menu-item-category').removeClass('active').animate( {display: 'block'}, {duration:1500});
            $('.menu-category').removeClass('active').animate( {display: 'block'}, {duration:1500});
        }
    });
    //Показать страницы личного кабинета в мобильном меню
    $('.menu-item-category').click(function (){
        let id = $(this).data('id');
        if ($(this).hasClass('active')){
            $('.menu-mobile-parrent li').show();
            $(this).removeClass('active').animate( {display: 'block'}, {duration:1500});
            $('#'+id).removeClass('active');
        }else{
            //отключаем меню каталога
            $('.menu-mobile-parrent li').hide();
            $('.menu-item-category').removeClass('active').animate( {display: 'block'}, {duration:1500});
            $('#'+id).removeClass('active').animate( {display: 'block'}, {duration:1500});
            $(this).addClass('active').animate( {display: 'block'}, {duration:1500});
            $('#'+id).addClass('active').animate( {display: 'block'}, {duration:1500});
        }
    });
    $('.menu-item.arrow').click(function (){
        if($(this).hasClass('active')){
        $('.menu-item.arrow').removeClass('active');
        $('.menu-item.arrow').find('.menu-collapse').css('max-height','0');
        }else{
            $(this).addClass('active').animate({display: 'block'}, {duration: 1500});
            $(this).find('.menu-collapse').css('max-height', '184px').animate({display: 'block'}, {duration: 1500});
        }
    });
        $(".product-gallery__wrapper").not('.slick-initialized').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            fade: true,
            prevArrow: "<button class=\"product-gallery-button product-gallery-button-prev\">&#8249;</button>",
            nextArrow: " <button class=\"product-gallery-button product-gallery-button-next\">&#8250;</button>",
            asNavFor: ".product-gallery-thumbs__wrapper",
        });
        $(".product-gallery-thumbs__wrapper").not('.slick-initialized').slick({
            slidesToShow: 8,
            asNavFor: ".product-gallery__wrapper",
            dots: false,
            arrows: false,
            focusOnSelect: true,
            responsive: [
                {
                    breakpoint: 1300,
                    settings: {
                        slidesToShow: 5
                    }
                },
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 4
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        settings: "unslick"
                    }
                }
            ]
        });
        $('.category-nav__wrapper').not('.slick-initialized').slick({
            arrows: false,
            centerPadding: '0px',
            slidesToShow: 7,
            responsive: [
                {
                    breakpoint: 1300,
                    settings: {
                        slidesToShow: 5
                    }
                },
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        settings: "unslick"
                    }
                }
            ]
        });
    $('.products-slider__wrapper').not('.slick-initialized').slick({
        arrows: false,
        centerPadding: '0px',
        slidesToShow: 8,
        responsive: [
            {
                breakpoint: 1300,
                settings: {
                    slidesToShow: 4
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    settings: "unslick"
                }
            }
        ]
    });
   $('.main-slider__wrapper').not('.slick-initialized').slick({
        arrows: true,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 3000,
        slidesToScroll: 1,
       prevArrow: "<button class=\"product-gallery-button product-gallery-button-prev\">&#8249;</button>",
       nextArrow: " <button class=\"product-gallery-button product-gallery-button-next\">&#8250;</button>",
    });
    $('.cooperation-slider').not('.slick-initialized').slick({
        arrows: true,
        infinite: true,
        // autoplay: true,
        // autoplaySpeed: 3000,
        slidesToShow: 2,
        slidesToScroll: 1,
        prevArrow: "<button class=\"product-gallery-button product-gallery-button-prev\">&#8249;</button>",
        nextArrow: " <button class=\"product-gallery-button product-gallery-button-next\">&#8250;</button>",
        responsive: [
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 1,
                    settings: "unslick"
                }
            }
        ]
    });
    //Отключение видео при переключении слайдера галереи сотрудничества
    $('.cooperation-slider .product-gallery-button').click(function (){
        $('#itemproYoutube').remove();
        $('.cooperation-slide.youtube').find('div').show();
        $('.cooperation-slide.youtube').find('img').show();
    });
    //Выравневаем по высоте превью видео и картинок в слайдере сотрудничества
    let height = null;
    $('.cooperation-slide').each(function (i) {
        let item = $(this).css("height");
        if (height === null || height < item) {
            height = item;
        }
    });
    $('.cooperation-slide').css('height', height);
    $('.cooperation-slide img').css('height', height);
});
//Навигация по способам доставки на странице оформления заказа + заполнение скрытых полей
function selectDelivery(){
    $('.order-tab-delivery-nav__item').click(function () {
        delivery = $(this).data('delivery');
        console.log(delivery);
        $('.order-tab-delivery-nav__item').removeClass('active');
        $(this).addClass('active');
        $('.order-tab-delivery__content').removeClass('active');
        $('.order-tab-delivery__content-city').addClass('active');
        $('#' + delivery).addClass('active');
        $('.order-payment').removeClass('d-none');
        $('.checkbox.delivery-val.delivery-val-'+delivery).trigger('click');
    });
}
//Удаление товаров из оформления заказов
function changeBasket(){
    $('#cart-change-form #control').click(function (){
        if (!$(this).hasClass('hide')){
            $('.order-product__item').addClass('visible');
            $(this).addClass('hide');
            $('#control-remove').removeClass('hide');
            $('#control-cancel').removeClass('hide');
            $('.order-product__item .checkbox').addClass('visible');
        }
    })
    $('#cart-change-form #control-cancel').click(function (){
        if (!$(this).hasClass('hide')){
            $('.order-product__item').removeClass('visible');
            $(this).addClass('hide');
            $('#control-remove').addClass('hide');
            $('#control').removeClass('hide');
            $('.order-product__item .checkbox').removeClass('visible');

        }
    })
    $("#cart-change-form").submit(function () {
        let formID = $(this).attr('id');
        let formNm = $('#' + formID);
        let cityId = $('.bx-ui-sls-input-block').data('id');
        let npName = $('#npoffice-container .selectize-input .item').text();
        $('.bx-ui-sls-container #autocompleteCity').val();
        $.ajax({
            type: "POST",
            url: '/ajax/order-change-basket.php',
            data: formNm.serialize(),
            success: function (data) {
                window.location.reload();
            }
        });
        return false;
    });
}
changeBasket();
selectDelivery();
$(document).ajaxStop(function() {
    changeBasket();
    selectDelivery();
});