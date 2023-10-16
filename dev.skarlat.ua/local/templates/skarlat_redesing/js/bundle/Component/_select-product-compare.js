function selectProduct(){
    let container = document.getElementById('product-array');
    let findForm = document.getElementById("findProducts");
    let arrProd = [];
    if(findForm){
        findForm.addEventListener('change', ()=>{
            if(container){
                Array.from(container.children).map(item => arrProd.push(item.children[0]));
                arrProd.map(item => {
                    item.addEventListener('click', ()=>{
                       item.classList.toggle('checked');
                    }, false)
                })
            }
        })   
    }
     
}

selectProduct();