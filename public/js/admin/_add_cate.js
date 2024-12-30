const FromItemsAdd=document.querySelector("#FormItems")

const additemName=FromItemsAdd.querySelector('#additemName');
const additemCode=FromItemsAdd.querySelector('#additemCode');
const additemPurchase=FromItemsAdd.querySelector('#additemPurchase');
const additemprice=FromItemsAdd.querySelector('#addprice');
const additemDiscount=FromItemsAdd.querySelector('#addDiscount');
const addafterprice=FromItemsAdd.querySelector('#addafterprice');
const addquantity=FromItemsAdd.querySelector('#qadduantity');
const addtolat=FromItemsAdd.querySelector('#tolat');
const addCategory=FromItemsAdd.querySelector('#Category');
const images= FromItemsAdd.querySelectorAll('.img');
const shoeimg=FromItemsAdd.getElementById("shoeimg");
const boxImg=FromItemsAdd.querySelector('.box-img')


function  uintID(){
    let id= new Date().getTime()
       newid=id.toString().slice(7)
       
        
    return newid
  

}


function count(){
    let conut = (( itemDiscount.value * itemprice.value ) / 100 ) 
    let tota = ( itemprice.value - conut ) * quantity.value
    afterprice.value= ( itemprice.value - conut )
    tolat.innerText =  tota.toFixed(2)
}

quantity.addEventListener('input', (e)=>{
    count()

})
itemDiscount.addEventListener('input', (e)=>{
    count()

})

 GetCategorys("/App/Category")

class Categorys{
    constructor(date){
        this.ID=date.catID
        this.CatName=date.catName;

    }
    cerateinnerHTML(){
        Category.innerHTML +=  `<option value="${this.ID}">${this.CatName}</option>`
    }
}

images.forEach(e=>{
    e.addEventListener("input",event=>{
        let file= event.target.files[0]
        let reader = new FileReader();
        reader.onload = function(e) {
            boxImg.classList.add('active')
            shoeimg.src=e.target.result;
            setTimeout(e=>{
                boxImg.classList.remove('active')
                },1000)

            }
            reader.readAsDataURL(file);
        
    })
   
})
onmousedown

images.forEach(e=>{
    e.addEventListener("mouseenter",event=>{
        let file= event.target.files[0]
            if(file){
                let reader = new FileReader();
                reader.onload = function(e) {
                    if(e.target.result != "" ){
                        boxImg.classList.add('active')
                        shoeimg.src=e.target.result;
                        setTimeout(e=>{
                            boxImg.classList.remove('active')
                            },1000)

                    
                    }else{
                        console.log("no file")
                    }
                    // console.log(e.target.result) 
                    }
                    reader.readAsDataURL(file);
            }
       

    })
})


function GetCategorys(urlData){
    let myPromise = new Promise((r,j) =>{
        let xhr= new XMLHttpRequest()
            xhr.open("POST", urlData,true)
            xhr.onload = function(){
                if(xhr.status == 200 && xhr.readyState == 4){
                 console.log(xhr.responseText)
                    r( JSON.parse(xhr.response))
            }
            else{
                j("error")
                 
            }
        }
        data = new FormData()
        data.append('type','read')
        xhr.send()

    })
    myPromise.then(data=>{
        Category.innerHTML = `<option value="">Select Category</option>`;
        data.forEach(row=>{
         
            let mycategory = new Categorys(row)
                mycategory.cerateinnerHTML()
           
        })
     
    }).catch(error=>{
        console.log(error)
    })
}
let sendData=true
FromItemsAdd.addEventListener("submit" , e=>{
    e.preventDefault()
        if(sendData){
            let myPromise = new Promise((r,j)=>{
                let xhr = new XMLHttpRequest()
                    xhr.open("POST", "/App/items",true)
                    xhr.onload = ()=>{
                        if(xhr.status == 200 && xhr.readyState == 4){
                            console.log(xhr.responseText)
                           r(JSON.parse(xhr.response))
                           
                        }
                    }
                    let data= new FormData(FromItemsAdd)
                        data.append("itemID",parseInt(uintID()))
                        data.append('type','insert')
                     xhr.send(data)
            })
            myPromise.then(data=>{
                    if(data.status){
                        document.querySelectorAll("input").forEach(e=>e.value="")
                        
                        sendData=false

                    }else{

                        sendData=true
                    }
            })
        }
  
})
