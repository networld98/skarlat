const sliderNav = document.getElementById('product-slider-nav');

// kick off the polyfill!
//smoothscroll.polyfill();
//RESIZE WINDOW


window.addEventListener('resize', (e) => {
    updateProductInBasket();
    productPills();
});

//COMMENT TO ORDER
function AddComent(){
    const toggleComment = document.getElementById('add-coment');
    const placeComment = document.getElementById('add-coment-place');

    if(toggleComment){
        toggleComment.addEventListener('click', () => {
            toggleComment.checked ? placeComment.disabled = false: placeComment.disabled = true;
        });
    }
}

AddComent();

//BASKET REMOVE PRODUCT ITEM IN ORDER PAGE
function basketRemoveProductItem(){
    let btnClose = document.getElementsByClassName('basket-item__close close');
    if(btnClose){
        for(let item of btnClose){
            item.addEventListener('click', function (e){
                this.parentElement.remove()
                emptyBasket(ItemProdBasket);
            }, false);
        }
    }

}
basketRemoveProductItem();

//empty basket
function emptyBasket(items){

    let paragraph = document.createElement('p');
    let selectText = document.createElement('span');
    let title = document.createElement('h2');
    let img = document.createElement('img');
    let div = document.createElement('div');

    if(Array.from(items.children).length < 1){
        document.getElementsByClassName('modal-footer modal-footer-basket')[0].classList.add('d-none');
        div.classList.add('basket-empty');
        div.id = 'basket-empty';
        title.textContent = 'Ваша корзина пуста :(';
        title.style.marginTop = '25px'
        selectText.textContent = 'Давайте это исправим?!';
        paragraph.textContent = 'Посмотрите в акциях, загляньте в один из разделов.';
        img.setAttribute('src', './img/shopping-basket.png');
        img.style.maxWidth = '170px';
        div.append(title, selectText, paragraph, img);
        items.append(div);
    } else return null;
}
// let ItemProdBasket = document.getElementsByClassName('basket-item');
let ItemProdBasket = document.getElementById('modal-body-basket');
if(ItemProdBasket){
    emptyBasket(ItemProdBasket);
}



//SCROLL PAGE IN UP
function scrollPageUp(toggle){
    const arrowTop = document.getElementById('btn-up');

    if(arrowTop){
        arrowTop.addEventListener('click', function(e){
                 window.scroll({ top: 0, left: 0, behavior: 'smooth' });
        })


            arrowTop.hidden = toggle;

    }
}

//CARD PRODUCT BUTTON FAVORITE|BUY|BALANCE
function addProductInAction(){
    const btnFavorite = document.getElementsByClassName('product-item__wrapper-block-btn_favorite');
    const btnBalance = document.getElementsByClassName('product-item__wrapper-block-btn_balance');
    const btnBuy = document.getElementsByClassName('product-item__wrapper-block-btn_buy');
    const btnProdDetailFavor = document.getElementsByClassName('product-detail__btn-favorite');
    const btnProdDetailBalance = document.getElementsByClassName('product-detail__btn-balance');
    const btnProdDetailShare = document.getElementsByClassName('product-detail__btn-share');

    function activeBtn(...arr){
        for(let element of arr){
            for(let item of element){
                item.addEventListener('click', function (e){
                    this.classList.toggle('active');
                });
            }
        }
    }

    activeBtn(btnFavorite ? btnFavorite:[] , btnBalance ? btnBalance:[], btnBuy ? btnBuy:[], btnProdDetailFavor ? btnProdDetailFavor : [], btnProdDetailBalance ? btnProdDetailBalance : [], btnProdDetailShare ? btnProdDetailShare : []);
}
addProductInAction();

//PAGE WISH LIST REMOVE PRODUCT
function removeProductWishList(){
    let productRemove = document.getElementsByClassName('product-item--remove');

    for(let item of productRemove){
        item.addEventListener('click', function (e){
            this.parentElement.parentElement.remove();
            favoriteProdLk(rowfavoriteProd);
        });
    }
}
removeProductWishList();

//lk favorite
function favoriteProdLk(container){
    if(Array.from(container.children).length < 1){
            let div = document.createElement('div');
            let title = document.createElement('h3');
            let span = document.createElement('span');
            let link = document.createElement('a');
            title.textContent = 'К сожалению ваш список понравившихся товаров пуст.';
            span.textContent = 'Для того что бы исправить это посетите один из разделов ';
            link.textContent = 'Каталога';
            link.style.color = 'red';
            link.setAttribute('href', 'javascript:void(0)');
            div.classList.add('empty-favorite-lk')
            div.append(title, span, link);
            container.append(div);
    } else return null;
}

let rowfavoriteProd = document.getElementById('row-favotrite-product');

if(rowfavoriteProd){
    favoriteProdLk(rowfavoriteProd);
}


//PAGE CATALOG_PRODUCT REMOVE WAY
function removeFilterWay(){
    let arrWayItem = document.getElementsByClassName('way-filter__item');

    for(let item of arrWayItem){
        item.addEventListener('click', function (e){
            if(this.className.trim('') == 'way-filter__item way-filter__item-clear'){
                console.log(document.getElementsByClassName('way-wrapper')[0].remove());
                return
            }
            this.remove();
        });
    }
}
removeFilterWay();

function removeButronBasket(){
    const closeButron = document.getElementsByClassName('jumbotron-basket-close')[0];
    if(closeButron){
    closeButron.addEventListener('click', function(e){
        closeButron.parentElement.parentElement.parentElement.remove();
    })
}
}
removeButronBasket()


function toggleSeo(item){
    if(item){ item.addEventListener('click', function(){
        this.remove();
        document.getElementsByClassName('seo-content-prev')[0].classList.remove('seo-content-prev');
    })

}
}

toggleSeo(document.getElementById('seo-collapse-btn'));

function flipSocial(){
    let socialBlock = document.getElementsByClassName('product-detail__btn-support')[0];
    if(socialBlock){
    document.addEventListener('click', function(e){
        if(e.target.className == 'product-detail__btn-share active'){
                socialBlock.classList.add('active');
            }else {
                document.getElementsByClassName('product-detail__btn-share')[0].classList.remove('active');
                socialBlock.classList.remove('active');
            }
    });
}

}

flipSocial();

function copyrightTime(){
    const TAGTIMENOW = document.getElementById('time-now');
    let content = TAGTIMENOW.textContent;
    if(TAGTIMENOW){
        let nowYear = new Date().getFullYear();
        return TAGTIMENOW.textContent = `${content}${nowYear}`;
    }
}

//copyrightTime();

function scrollChangeColorViget(scrollTop){
    const bvs = document.getElementById('bvs');

    if(bvs){
        let scrollHeight = Math.max(
            document.body.scrollHeight, document.documentElement.scrollHeight,
            document.body.offsetHeight, document.documentElement.offsetHeight,
            document.body.clientHeight, document.documentElement.clientHeight
          );



            if(scrollHeight - 1400 >= scrollTop){
                bvs.classList.add('btn-vidget-skarlat-black')
            } else{
                bvs.classList.remove('btn-vidget-skarlat-black')
            }

    }
}


function scrollPage(){
    window.addEventListener('scroll', function(e){
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        let toggle = pageYOffset < document.documentElement.clientHeight / 2;

        scrollChangeColorViget(scrollTop);
        scrollPageUp(toggle);
    },false)
}
scrollPage()
