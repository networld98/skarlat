const MOB_FILTER = document.getElementById('mobileFilter');
const CLOSE_FILTER = document.getElementById('closeFilter');
const BTN_SHOW_FILTER = document.getElementById('btnFilter');
const BTN_CHOICE = document.getElementById('choice-btn');

function ToggleFilter() {
    if (BTN_SHOW_FILTER) {
        BTN_SHOW_FILTER.addEventListener('click', function () {
            MOB_FILTER
                .classList
                .add('show');
            MOB_FILTER
                .classList
                .remove('d-none');
        });
    }
    if (CLOSE_FILTER) {
        CLOSE_FILTER.addEventListener('click', function () {
            MOB_FILTER
                .classList
                .remove('show');
            if (document.innerWidth > 500) {
                setTimeout(function remClass() {
                    MOB_FILTER
                        .classList
                        .add('d-none')
                }, 500)
            } else {
                MOB_FILTER
                    .classList
                    .add('d-none');
            }

        })
        MOB_FILTER.addEventListener('click', function (e) {
            if (!e.target.closest('#FilterForm')) {
                MOB_FILTER
                    .classList
                    .remove('show');
                setTimeout(function remClass() {
                    MOB_FILTER
                        .classList
                        .add('d-none')
                }, 400)
            }
        })
        BTN_CHOICE.addEventListener('click', function (e) {
            MOB_FILTER
                .classList
                .remove('show');
            setTimeout(function remClass() {
                MOB_FILTER
                    .classList
                    .add('d-none')
            }, 400)
        })
    }
}
ToggleFilter();