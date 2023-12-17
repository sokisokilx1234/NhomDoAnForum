let thisPage=1;
let limit =6;
let list = document.querySelectorAll('.list.item');
function loadItem()
{
    let beginGet = limit * (thisPage-1);
    let endGet = limit * thisPage -1;
    list.forEach((item,key)=>
    {
        if(key >=beginGet && key <= endGet)
        {
            item.style.display='block';
        }else{
            item.style.display='none';
        }
    })
    listPage();
}
loadItem();
function listPage(){
    let count = Math.ceil(list.length/limit);
    document.querySelectorAll('.listPage').innerHTML=' ';
    if(thisPage !=1){
        let prev = document.createElement('li');
        prev.innerText="PREV";
        prev.setAttribute('oclick',"changePage("+ (thisPage -1)+")");
        document.querySelector('.listPage').appendChild(newPage);
    }
    for(i=1;1<= count;i++){
        let newPage = document.createElement('li');
        newPage.innerText=i;
        if(i==thisPage){
            newPage.classList.add('acctive');
        }
        newPage.setAttribute('onclick',"changePage(" + i + ")")
        document.querySelector('.listPage').appendChild(newPage);
    }
    if(thisPage !=count){
        let next = document.createElement('li');
        next.innerText='NEXT';
        next.setAttribute('onclick',"changePage("+(thisPage+1)+")")
        document.querySelector('.listPage').appendChild(next);
    }
}
function changePage(i){
    thisPage=i;
    loadItem();
}