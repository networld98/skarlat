function raiting() {
    let raiting = document.getElementById('stars');


    let  setRaiting =  function(e){
    let arr = Array.from(this.children);
    let toggle= true;
    arr.map(item => {
        if(toggle && raiting != e.target){
            item.classList.add('active');
    } else{
        item.classList.remove('active');
    }
        if(e.target === item){
            toggle = false;
    }})
    };

if(raiting){

    raiting.addEventListener('click', setRaiting, false);
    raiting.addEventListener('touch', setRaiting, false);

}


}
raiting();
