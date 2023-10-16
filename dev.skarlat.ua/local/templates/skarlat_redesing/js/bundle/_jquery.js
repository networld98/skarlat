
$(document).ready(function () {


    $('.tooltips').tooltip({boundary: 'window'});

    //MODAL
    $('#basketModalButtonHeader').on('click', function () {
        alert();
        $("#basketModal").modal();
    });

    $("#subscribeBtn").click(function () {
        $("#subscribeModal").modal();
    });

    $('.in-basket').on('click', function () {
        $("#basketModal").modal();
    });

    $('#add-products-compare').on('click', function () {
        $("#addProductCompareModal").modal();
    });
    $('#add-products-compare-to').on('click', function () {
        $("#addProductCompareModal").modal();
    });

    $('#enterModalButton').on('click', function () {
        $("#enterModal").modal();
    });

    $('.mob-menu-header__button').on('click', function () {

        $('.mob-menu').removeClass('mob-menu--active');
        $('body')
            .last()
            .children(".shadow.fade.show")
            .remove();
        $("#enterModal").modal();
    });

    $('#btnFilter').on('click', function () {
        $("#filterModal").modal();
    });

    //FANCYBOX

    $('[data-fancybox="gallery-product"]').fancybox({

    });



    //Range

        // $("#range-ion").ionRangeSlider({
        //     skin: "flat",
        //     type: "double",
        //     min: 0,
        //     max: 50000,
        //     from: 12050,
        //     to: 37500,
        //     postfix: "грн"
        // });

    //OTHER



    $('.mob-menu-header__button-lk').click(function () {
        $('.mob-nav-lk').toggleClass('active');
        $('.mob-menu-header__button-lk').toggleClass('active');
    })


    $('.burger_menu').click(function () {
        $('.mob-menu').toggleClass('mob-menu--active');
        $('<div class="shadow fade show"></div>').appendTo('body');
    });

    $(document).mouseup(function (e) {
        const mobmenu = $(".mob-menu");
        const modalWindow = $(".modal");
        const btnSkarlat = $('.btn-vidget-skarlat');

        if (!btnSkarlat.is(e.target) && btnSkarlat.has(e.target) && !mobmenu.is(e.target) && mobmenu.has(e.target).length === 0 && !modalWindow.is(e.target) && modalWindow.has(e.target).length === 0) {

            mobmenu.removeClass('mob-menu--active');
            btnSkarlat
                .children('.vidget-content')
                .removeClass('active');

            if ($(".shadow.fade.show")) {
                $('body')
                    .last()
                    .children(".shadow.fade.show")
                    .remove();
            }
        }
    });

    $('.mob-menu-catalog').click(function () {
        $('.mob-nav-main-second').toggleClass('active');
    });

    $('.btn-vidget-skarlat').click(function () {
        $('.vidget-content').toggleClass('active');
    });

    $('.mob-menu-catalog-back').click(function () {
        $(this)
            .parent()
            .removeClass("active");
        $('.mob-menu-header__button-lk').removeClass('active');
    });

    $('.mob-nav-main-second li a').click(function () {
        $(this)
            .parent()
            .children('.mob-nav-main-third')
            .toggleClass('active');
    });

    $('.mob-nav-main-third li a').click(function () {
        $(this)
            .parent()
            .children('.mob-nav-main-fourth')
            .toggleClass('active');
    });

});
