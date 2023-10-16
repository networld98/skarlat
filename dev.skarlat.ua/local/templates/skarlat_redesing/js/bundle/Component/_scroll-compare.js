
function scrollCompare() {
    const COMPARE_SCROLL_LEFT = document.getElementById('compare-table__scroll-left');
    const COMPARE_SCROLL_RIGHT = document.getElementById('compare-table__scroll-right');
    let COMPARE_TABLE_HEADER = document.getElementById('compare-table__header');
    let COMPARE_TABLE_BODY = document.getElementById('compare-table__body');
    let COMPARE_TABLE_CONTROLL = document.getElementById('compare-table__control');
    
    if (COMPARE_TABLE_HEADER && COMPARE_TABLE_CONTROLL && COMPARE_TABLE_BODY) {
        COMPARE_TABLE_HEADER = COMPARE_TABLE_HEADER.children[0];
        COMPARE_TABLE_CONTROLL = COMPARE_TABLE_CONTROLL.children[0];
        COMPARE_TABLE_BODY= COMPARE_TABLE_BODY.children;
        COMPARE_TABLE_HEADER.addEventListener('scroll', function (event) {
            COMPARE_TABLE_CONTROLL.scrollLeft = COMPARE_TABLE_HEADER.scrollLeft;

            for (let i = 0; i < COMPARE_TABLE_BODY.length; i++) {
                let item = COMPARE_TABLE_BODY[i].children
                for (let j = 0; j < item.length; j++) {

                    item[j].scrollLeft = COMPARE_TABLE_HEADER.scrollLeft;
                }
            }
        });

        COMPARE_TABLE_CONTROLL.addEventListener('scroll', function (event) {
            COMPARE_TABLE_HEADER.scrollLeft = COMPARE_TABLE_CONTROLL.scrollLeft;

            let item = '';

            for (let i = 0; i < COMPARE_TABLE_BODY.length; i++) {
                item = COMPARE_TABLE_BODY[i].children
                for (let j = 0; j < item.length; j++) {

                    item[j].scrollLeft = COMPARE_TABLE_CONTROLL.scrollLeft;
                }
            }

        });

        for (let i = 0; i < COMPARE_TABLE_BODY.length; i++) {
            let item = COMPARE_TABLE_BODY[i].children;

            for (let j = 0; j < item.length; j++) {

                item[j].addEventListener('scroll', function (event) {
                    COMPARE_TABLE_HEADER.scrollLeft = item[j].scrollLeft;
                    COMPARE_TABLE_CONTROLL.scrollLeft = item[j].scrollLeft;
                });

            }

        }

        COMPARE_SCROLL_RIGHT.addEventListener('click', function (event) {
            COMPARE_TABLE_HEADER.scrollLeft += 100;

        });

        COMPARE_SCROLL_LEFT.addEventListener('click', function (event) {
            COMPARE_TABLE_HEADER.scrollLeft -= 100;

        });
    }

}
scrollCompare()