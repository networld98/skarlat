const SHADOWBLOCK = document.createElement('div');
      SHADOWBLOCK.classList.add('shadow', 'fade', 'show');

function hoverCatalog(item) {
    for (let i of item) {
        if (document.body.getBoundingClientRect().width >= 1200) {
            alert();
            i.addEventListener('mouseenter', function () {
                SHADOWBLOCK.style.zIndex = "3";
                document
                    .body
                    .append(SHADOWBLOCK)
            });

            i.addEventListener('mouseleave', function () {
                if (document.body.lastChild == SHADOWBLOCK) {
                    SHADOWBLOCK.remove();
                }
            });
        }
    }
}

window.addEventListener('resize', (e) => {
    hoverCatalog(document.getElementsByClassName('cat_btn-hover'));
});

hoverCatalog(document.getElementsByClassName('cat_btn-hover'));
