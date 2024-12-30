const BoxItems=document.querySelector(".box-itmes");

GetData()
window.document.onblur=()=>{
    console.log(onblur)
}

class card{
    constructor(data){
        this.ID=data.itemID
        this.name=data.itemName
        this.price=data.itemPrice
        this.purPrice=data.purchasePrice
        this.discount=data.discount
        this.quantity=data.itemQuant
        this.discount=data.discount
        this.note=data.note
        this.images= JSON.parse(data.images)
        this.view=data.show

    }
    CreateInnerHTML(){
        const card=document.createElement("div");
        card.classList.add("card");
        const face=document.createElement("div");
        face.classList.add("face");
        const back=document.createElement("div");
        back.classList.add("back");
        const discount=document.createElement("div");
        discount.classList.add("discount");
        discount.innerHTML=this.discount + "%";
        const view=document.createElement("div");
        view.classList.add("view");
        view.innerHTML=`
        <i class="fa-solid fa-eye"></i>
         <samp id="view">${this.view}</samp>
        `;
        const name=document.createElement("div");
        name.classList.add("name");
        name.innerHTML=`${this.name}`
        const price=document.createElement("div");
        price.classList.add("price");
        price.innerHTML=`<h2>$ ${this.price}</h2>`
        const details=document.createElement("div");
        details.classList.add("details");
        details.innerHTML=`<p>${this.note}</p>`
        const img=document.createElement("img");
        img.src='../php/products/'+ this.images[0];
        let length= this.images.length
            let index=0
        setInterval(e=>{
          
            if( index < length -1 )
            {
                img.src='../php/products/'+ this.images[index++];
            }else{
                index=0
            }
           
        },2000)

        face.appendChild(discount)
        face.appendChild(view)
        face.appendChild(img)
        back.appendChild(name)
        back.appendChild(details)
        back.appendChild(price)
        card.appendChild(face)
        card.appendChild(back)
        BoxItems.appendChild(card)
        
       
    }
}

let add=[]
add.length
function GetData(){
    let myPromise = new Promise((r,j)=>{
        let xhr= new XMLHttpRequest();
            xhr.open("POST","../php/api/Get_Items.php",true)
            // xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded")
            xhr.onload=function(){
                if(xhr.status==200 && xhr.readyState == 4){
                    console.log(xhr.responseText)
                    // let data=JSON.parse(xhr.responseText)
                        if( JSON.parse(xhr.response)){
                            r(JSON.parse(xhr.response))
                        }else{
                            j("error")
                        }
                    
                }
            }
            xhr.send(new FormData)

    })
    myPromise.then(
        (data)=>{
            data.forEach(e=>{
                let BoxItem = new card(e)
                BoxItem.CreateInnerHTML()
            })
        }
    )
}



// class BoxItems extends HTMLElement {
//     constructor() {
//         super();
//         this.attachShadow({mode: 'open'});
//         this.BoxItems=document.createElement("div");
//         this.BoxItems.classList.add("box-items");

// }