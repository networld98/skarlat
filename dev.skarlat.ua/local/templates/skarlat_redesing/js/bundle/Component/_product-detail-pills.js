
    const PRODUCT_NAV = document.getElementById('product-detail-pills-tab');
    const PRODUCT_MINI = document.getElementById('product-mini');

function productPills(){

    if(PRODUCT_NAV && PRODUCT_MINI){
        if(window.matchMedia('all and (max-width: 991px)').matches){
            PRODUCT_NAV.parentElement.parentElement.classList.remove('col-lg-7', 'col-xl-8');
            PRODUCT_NAV.parentElement.parentElement.classList.add('col-12');
        } else{
            
            if(document.getElementById('product-detail-pills-allInform-tab').classList.contains('active')){
                PRODUCT_NAV.parentElement.parentElement.classList.remove('col-lg-7', 'col-xl-8');
                PRODUCT_NAV.parentElement.parentElement.classList.add('col-12');
                PRODUCT_MINI.classList.remove('d-lg-block');
            } else{
                PRODUCT_NAV.parentElement.parentElement.classList.add('col-lg-7', 'col-xl-8');
                PRODUCT_MINI.classList.add('d-lg-block');
            }
        }
            

    }
    
    

}

if(PRODUCT_NAV && PRODUCT_MINI){
productPills();


PRODUCT_NAV.addEventListener('click', function(e){
    e.currentTarget.scroll({
        top:0,
        left: + e.target.getBoundingClientRect().left,
        behavior: 'smooth'
    });
      
        if(e.target.id == 'product-detail-pills-allInform-tab' ){
            PRODUCT_NAV.parentElement.parentElement.classList.remove('col-lg-7', 'col-xl-8');
            PRODUCT_NAV.parentElement.parentElement.classList.add('col-12');
            PRODUCT_MINI.classList.remove('d-lg-block');
        } else{
            PRODUCT_NAV.parentElement.parentElement.classList.add('col-lg-7', 'col-xl-8');
            PRODUCT_MINI.classList.add('d-lg-block');
        }
    
}, false);


PRODUCT_NAV.addEventListener('touchend', function(e){

let a = window.innerWidth/2 >e.changedTouches[0].pageX? e.currentTarget.scrollLeft -e.target.getBoundingClientRect().left: e.currentTarget.scrollLeft + e.target.getBoundingClientRect().left

e.currentTarget.scroll({
    top:0,
    left: a,
    behavior: 'smooth'
});

productPills();

}, false);
}   

