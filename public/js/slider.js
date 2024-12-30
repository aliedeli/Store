const slider = document.querySelector('.slider');
const images= slider.querySelector('.images');
const img = images.querySelectorAll('img');
const butNext=slider.querySelector('.next');
const butBefore=slider.querySelector('.before')
 let getImgOFarryr=[];
 let index=0
getImgOFarryr.push(...img)


// images.innerHTML="";

// 
addFromImg(index)
butNext.addEventListener('click',e=>{
        if(  index < getImgOFarryr.length -1 ) {
            
            index++
            addFromImg(index)
        }
        

})

butBefore.addEventListener('click',e=>{
    if(0 != index){
        index--
        addFromImg(index)
    }
    

})



function addFromImg(index){
    images.innerHTML="";
    images.appendChild(getImgOFarryr[index])

}
setInterval(e=>{
    if(index < getImgOFarryr.length -1){
        addFromImg(index++)
    }else{
        index=0;
    }
   

},1000)