function updateProductInBasket() {
        let jumbotronBasketItem = document.querySelectorAll('.jumbotron-basket-item');
        let jumbotronBasketList = document.querySelector('.jumbotron-basket-list');
        let viewPort = window.innerWidth;
    
        if(jumbotronBasketItem && jumbotronBasketList){
            for (let i = 0; i < jumbotronBasketItem.length - 1; i++) {
                jumbotronBasketList.style.display = 'flex';
                if (window.matchMedia('screen and (min-width: 1420px)').matches && (viewPort >= 1420)) {
                    jumbotronBasketItem[i].style.display = "flex";
                    if (i > 4) {
                        jumbotronBasketItem[i].style.display = "none";
                    }
                } else if (window.matchMedia('screen and (min-width: 1232px) and (max-width: 1419px)').matches && (viewPort < 1420 && viewPort >= 1232)) {
                    jumbotronBasketItem[i].style.display = "flex";
                    if (i > 2) {
                        jumbotronBasketItem[i].style.display = "none";
                    }
                } else if (window.matchMedia('screen and (min-width: 934px) and (max-width: 1231px)').matches && (viewPort <= 1232 && viewPort >= 934)) {
                    jumbotronBasketItem[i].style.display = "flex";
                    if (i > 1) {
                        jumbotronBasketItem[i].style.display = "none";
                    }
                } else if (window.matchMedia('screen and (min-width: 768px) and (max-width: 933px)').matches && (viewPort <= 934 && viewPort >= 768)) {
                    jumbotronBasketItem[i].style.display = "flex";
                    if (i > 0) {
                        jumbotronBasketItem[i].style.display = "none";
                    }
                } else if (window.matchMedia('screen and (min-width: 700px) and (max-width: 767px)').matches && (viewPort <= 768 && viewPort >= 700)) {
                    jumbotronBasketItem[i].style.display = "flex";
                    if (i > 6) {
                        jumbotronBasketItem[i].style.display = "none";
                    }
                } else if (window.matchMedia('screen and (min-width: 620px) and (max-width: 699px)').matches && (viewPort <= 764 && viewPort >= 620)) {
                    jumbotronBasketItem[i].style.display = "flex";
                    if (i > 4) {
                        jumbotronBasketItem[i].style.display = "none";
                    }
                } else if (window.matchMedia('screen and (min-width: 570px) and (max-width: 619px)').matches && (viewPort <= 620 && viewPort >= 570)) {
                    jumbotronBasketItem[i].style.display = "flex";
                    if (i > 3) {
                        jumbotronBasketItem[i].style.display = "none";
                    }
                } else if (window.matchMedia('screen and (min-width: 530px) and (max-width: 569px)').matches && (viewPort <= 570 && viewPort >= 530)) {
                    jumbotronBasketItem[i].style.display = "flex";
                    if (i > 2) {
                        jumbotronBasketItem[i].style.display = "none";
                    }
                } else if (window.matchMedia('screen and (min-width: 490px) and (max-width: 529px)').matches && (viewPort <= 530 && viewPort >= 490)) {
                    jumbotronBasketItem[i].style.display = "flex";
                    if (i > 1) {
                        jumbotronBasketItem[i].style.display = "none";
                    }
                } else if (window.matchMedia('screen and (min-width: 430px) and (max-width: 489px)').matches && (viewPort <= 490 && viewPort >= 430)) {
                    jumbotronBasketItem[i].style.display = "flex";
                    if (i > 0) {
                        jumbotronBasketItem[i].style.display = "none";
                    }
                } else if (window.matchMedia('screen and (max-width: 400px)').matches && (viewPort <= 400)) {
                    jumbotronBasketList.style.display = 'none';
        
                }
            }
        }
}
updateProductInBasket();