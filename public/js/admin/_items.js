  let table= document.querySelector(".table")
  let body= document.getElementById("box-body")
//
let butAddItems = document.getElementById("AppItems")
let butClose = document.getElementById("AddCloes")
let boxitems = document.querySelector(".box-Add-items")
let FromItems = boxitems.querySelector("#FormItem");
let itemsCategory= boxitems.querySelector("#Category");
const itemName=document.getElementById('itemName');
const itemCode=document.getElementById('itemCode');
const itemPurchase=document.getElementById('itemPurchase');
const itemprice=document.getElementById('price');
const itemDiscount=document.getElementById('Discount');
const afterprice=document.getElementById('afterprice');
const quantity=document.getElementById('quantity');
const tolat=document.getElementById('tolat');
const searchinput=document.getElementById("search")
const images= document.querySelectorAll('.img');
const shoeimg=document.getElementById("shoeimg");
const boxImg=document.querySelector('.box-img')
const searchDate=document.getElementById('date')
const Brands=document.getElementById('Brands')
const UrlIems="/App/items"
GET_Items()
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
                        
                    }
                    // console.log(e.target.result) 
                    }
                    reader.readAsDataURL(file);
            }
       

    })
})
searchDate.addEventListener("input",e=>{
    e.preventDefault()

    let myPromise= new Promise((r,j)=>{
        let xhr= new XMLHttpRequest()
        xhr.open("POST", UrlIems,true)
        xhr.onload=()=>{
            if(xhr.status==200 && xhr.readyState == 4){
             
                r(JSON.parse(xhr.response))
        }else{
            j("Error")
        }
       
    }
    let data= new FormData()
    data.append("search",e.target.value )
    data.append("type","searchDate")

    xhr.send(data)
})


 myPromise.then(data=>{
        if(data)
        {
            body.innerHTML="";
            data.forEach(row => {
        
                let item=new items(row);
                item.CearteHTML();
                
            });

        }else{
            GET_Items()
        }
   
})
})

let  myCategory=new Promise((r,j)=>{
    let xhr= new XMLHttpRequest();
    xhr.open("POST",'/App/Category',true)
    xhr.onload = function(){
        if(xhr.status === 200 && xhr.readyState){
          
            r(  JSON.parse(xhr.response))
        }else{
           
            j("Error");
        }
    }
    let data = new FormData()
    data.append("type",'read')
    xhr.send(data)
})
myCategory.then(data=>{
    itemsCategory.innerHTML=`<option selected value="">Select Category</option>`;
    data.forEach(cat=>{
        let option = document.createElement("option");
        option.value = cat.catID;
        option.text = cat.catName;
        itemsCategory.appendChild(option)
    })
})
let  myBrands=new Promise((r,j)=>{
    let xhr= new XMLHttpRequest();
    xhr.open("POST",'/App/brand',true)
    xhr.onload = function(){
        if(xhr.status === 200 && xhr.readyState){
          
            r(  JSON.parse(xhr.response))
        }else{
           
            j("Error");
        }
    }
    let data = new FormData()
    data.append("type",'read')
    xhr.send(data)
})
myBrands.then(data=>{
    Brands.innerHTML=`<option selected value="">Select Brands</option>`;
    data.forEach(Brand=>{
        let option = document.createElement("option");
        option.value = Brand.branID;
        option.text = Brand.brandName;
        Brands.appendChild(option)
    })
})


FromItems.addEventListener('submit',e=>{
    e.preventDefault()
    myPromiseItems= new Promise((r,j)=>{
        let xhr=new XMLHttpRequest();
        xhr.open('POST', '/App/items', true);
        // xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onload = ()=>{
            if(xhr.status === 200 && xhr.readyState){
                console.log(xhr.responseText)
                 r(JSON.parse(xhr.response))
            }else{
                j('Error')
            }
        }
        let data=new FormData(FromItems)
        data.append('type','insert' )
        data.append('itemID',  uintID() )
        xhr.send(data);
    })
    myPromiseItems.then(data=>{
       
            if(data.status)
            {
                GET_Items()
                boxitems.classList.remove("active")
                
            }else{

            }
      
    })
})
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

butAddItems.addEventListener("click",()=>{
   
    boxitems.classList.add("active")
})
butClose.addEventListener("click",_=>{
    boxitems.classList.remove("active")
})

class items{
    constructor(data){
        this.id=data.itemID
        this.name=data.itemName
        this.qrCode=data.qrCode
        this.price=data.itemPrice
        this.purPrice=data.purchasePrice
        this.discount=data.discount
        this.quantity=data.itemQuant
        this.discount=data.discount
        this.note=data.note
        this.images= JSON.parse(data.images)
        this.catName=data.catName
        this.storeName=data.storeName
        this.Role=data.Role
        this.row=data.row
        this.shelf=data.shelf
        this.view=data.show
        this.likes=data.likes
        this.catID=data.catID
        this.brandID=data.brandID
        this.brandName=data.brandName



        



    }
    CearteHTML(){
        let row=document.createElement("div");
        row.classList.add("row");
        let name=document.createElement("div");
        name.classList.add("name");
        let show=document.createElement("div");
        show.classList.add("show");
        let edit=document.createElement("div");
        show.classList.add("edit");
        let dele=document.createElement("div");
        dele.classList.add("delete");
        let  samp = document.createElement("samp")
            samp.innerText=this.name;
        let butShow=document.createElement("button")
    


        butShow.innerHTML=
        `  <i class="fa-light fa-pen-to-square"></i>
                                    <samp>show</samp>`;
        let butEdit=document.createElement("button");
    
        butEdit.innerHTML=`
          <i class="fa-light fa-pen-to-square"></i>
                         <samp>Edit</samp>
        `;
        let butDelete=document.createElement("button");
     
        butDelete.innerHTML=`
           <i class="fa-light fa-pen-to-square"></i>
                         <samp>Delete</samp>
        `;
      
        name.appendChild(samp);
        show.appendChild(butShow);
        edit.appendChild(butEdit);
        dele.appendChild(butDelete);
        row.appendChild(name);
        row.appendChild(show);
        row.appendChild(edit);
        row.appendChild(dele);
        body.appendChild(row)
        butShow.addEventListener("click",()=>this.Show())
        butEdit.addEventListener("click",()=>this.Edit())
        butDelete.addEventListener("click",()=>this.Delete())
        
    }
    Show(){
      let boxShow = document.createElement("div");
      boxShow.classList.add("box-Show");
      let left = document.createElement("div");
      left.classList.add("left");
      let right = document.createElement("div");
      right.classList.add("right");
      let boxMstr = document.createElement("div");
      boxMstr.classList.add("box-mstr");
      let listImg = document.createElement("div");
      listImg.classList.add("list");
      let img0 = document.createElement("img");
      img0.src ='../../products/'+ this.images[0];
      let boxTitle= document.createElement("div")
      boxTitle.classList.add("box-title");
      boxTitle.innerHTML=`<h2>${this.name}</h2>`;
        let boxList= document.createElement('div');
        boxList.classList.add("box-list");
        let list1 = document.createElement("ul");
        let list2 = document.createElement("ul");
let BoxButton =document.createElement('div')
BoxButton.classList.add("button");
let button1 = document.createElement("button");
button1.type='button';
button1.innerHTML=` <i class="fa-light fa-pen-to-square"></i> Close`
        this.images.forEach(img=>{
                if(img != null){
                    let newimg = document.createElement("img");
                    newimg.src = '../../products/'+ img;
                    listImg.appendChild(newimg);
                    newimg.addEventListener('click',e=>{
                        img0.src  = e.target.src;
                    })
                }
          
        })



        let li1= document.createElement('li')
        let li2= document.createElement('li')
        let li3= document.createElement('li')
        let li4= document.createElement('li')
        let li5= document.createElement('li')
        let li6= document.createElement('li')
        let li7= document.createElement('li')
        let li8= document.createElement('li')
        let li9= document.createElement('li')
        let li_1= document.createElement('li')
        let li_2= document.createElement('li')

        li1.innerHTML=`<samp></samp> <h4>PurchasePrice:  </h4>  ${this.purPrice}`
        li2.innerHTML=`<samp></samp> <h4>Price:  </h4> ${this.price}`
        li3.innerHTML=`<samp></samp> <h4>Discount:  </h4> ${this.discount}`
        li4.innerHTML=`<samp></samp> <h4> Quantity : </h4> ${this.quantity}`
        li5.innerHTML=`<samp></samp>  <h4>Category: </h4>  ${this.catName}`
        li6.innerHTML=`<samp></samp>  <h4> StoreName : </h4> ${this.storeName}`
        li7.innerHTML=`<samp></samp>  <h4> Role : </h4> ${this.Role}`
        li8.innerHTML=`<samp></samp> <h4> Row : </h4>  ${this.row}`
        li9.innerHTML=`<samp></samp>  <h4> Shelf : </h4> ${this.shelf}`
        li_1.innerHTML=`<samp></samp>  <h4> brandName : </h4> ${this.brandName}`
        li_2.innerHTML=`<samp></samp>  <h4> Likes : </h4> ${this.likes}`


        

        list1.appendChild(li1)
        list1.appendChild(li2)
        list1.appendChild(li3)
        list1.appendChild(li4)
        list1.appendChild(li5)
        list1.appendChild(li_1)
        list1.appendChild(li6)
        list1.appendChild(li7)
        list1.appendChild(li8)
        list2.appendChild(li9)
        // list2.appendChild(li_1)
        list2.appendChild(li_2)


        boxShow.appendChild(left)
        boxShow.appendChild(right)
        left.appendChild(boxMstr)
        boxMstr.appendChild(img0)
        left.appendChild(listImg)
        right.appendChild(boxTitle)
        right.appendChild(boxList)
        boxList.appendChild(list1)
        boxList.appendChild(list2)
        right.appendChild(BoxButton)
        BoxButton.appendChild(button1)
        table.appendChild(boxShow)
        button1.addEventListener('click',e=>boxShow.remove() )

    }
    Edit(){
        let box_Edit =document.createElement('div')
        box_Edit.className='box-edit'
        let row_1=document.createElement('div');
        row_1.className='row-edit'
        // star box Name
        let box_inupt_name=document.createElement('div');
        box_inupt_name.className='box-input'
        box_inupt_name.style='--width--input:50%;'
        let icon_name=document.createElement('div');
        icon_name.className='icon'
        icon_name.innerHTML='<i class="fa-regular fa-signature"></i>';
        let  input_box_name=document.createElement('div');
        input_box_name.className='input';
        let input_name=document.createElement('input');
        input_name.type='text'
        input_name.value=this.name
        input_name.placeholder='Enter Item Name'
        input_name.name='itemName'
        input_name.addEventListener("input",e=> this.name=e.target.value)
       //end
        //stsr box qrcode
        let box_inupt_qr=document.createElement('div');
        box_inupt_qr.className='box-input'
        box_inupt_qr.style='--width--input:50%;'
        let icon_qr=document.createElement('div');
        icon_qr.className='icon'
        icon_qr.innerHTML='<i class="fa-brands fa-qr-code"></i>';
        let  input_box_qr=document.createElement('div');
        input_box_qr.className='input';
        let input_qr=document.createElement('input');
        input_qr.type='text'
         input_qr.value=this.qrCode;
        input_qr.placeholder='Enter QR Code'
        input_qr.name='itemCode';
        input_qr.addEventListener("input",e=> this.qrCode=e.target.value)
        //end
        // end box row1
        //stsr box row2
        let row_2=document.createElement('div');
        row_2.className='row-edit'
        //stsr box purPrice
        let box_inupt_Purchase=document.createElement('div');
        box_inupt_Purchase.className='box-input'
        box_inupt_Purchase.style='--width--input:20%;'
        let icon_Purchase=document.createElement('div');
        icon_Purchase.className='icon'
        icon_Purchase.innerHTML='<i class="fa-solid fa-cart-shopping"></i>';
        let  input_box_Purchase=document.createElement('div');
        input_box_Purchase.className='input';
        let input_Purchase=document.createElement('input');
        input_Purchase.type='text'
        input_Purchase.name='itemPurchase';
        input_Purchase.value=this.purPrice
        input_Purchase.placeholder='Enter Purchase Price'
        input_Purchase.addEventListener("input",e=> this.purPrice=e.target.value)
        //end
        //stsr box price
        let box_inupt_price=document.createElement('div');
        box_inupt_price.className='box-input'
        box_inupt_price.style='--width--input:20%;'
        let icon_price=document.createElement('div');
        icon_price.className='icon'
        icon_price.innerHTML='<i class="fa-solid fa-cart-shopping"></i>';
        let  input_box_price=document.createElement('div');
        input_box_price.className='input';
        let input_price=document.createElement('input');
        input_price.type='text'
        input_price.name='itemprice';
        input_price.value=this.price
        input_price.placeholder='Enter  Price'
        input_price.addEventListener("input",e=> this.price=e.target.value)
        //end

        // star box Discount
        let box_inupt_discount=document.createElement('div');
        box_inupt_discount.className='box-input'
        box_inupt_discount.style='--width--input:20%;'
        let icon_discount=document.createElement('div');
        icon_discount.className='icon'
        icon_discount.innerHTML='<i class="fa-regular fa-percent"></i>'
        let input_discount=document.createElement("div");
        input_discount.className='input';
        let input_discount_input=document.createElement('input');
        input_discount_input.type='text'
        input_discount_input.name='Discount'
        input_discount_input.value=this.discount
        input_discount_input.placeholder='Enter Discount'
        //end box Discount
        // star box after
        let box_inupt_after=document.createElement('div');
        box_inupt_after.className='box-input'
        box_inupt_after.style='--width--input:20%;'
        let icon_after=document.createElement('div');
        icon_after.className='icon'
        icon_after.innerHTML='<i class="fa-solid fa-cart-shopping"></i>';
        let input_after=document.createElement("div");
        input_after.className='input';
        let input_after_input=document.createElement('input');
        input_after_input.type='text';
        input_after_input.name='after'
        // input_after_input.value=this.after
        input_after_input.placeholder='Enter After Discount'
        input_after_input.value= this.price - ( (this.discount  * this.price  ) / 100) 
        //end after

        //+++++++quantity
        let box_inupt_quantity=document.createElement('div');
        box_inupt_quantity.className='box-input'
        box_inupt_quantity.style='--width--input:20%;'
        let icon_quantity=document.createElement('div');
        icon_quantity.className='icon'
        icon_quantity.innerHTML='<i class="fa-solid fa-box"></i>';
        let input_quantity=document.createElement("div");
        input_quantity.className='input';
        let input_quantity_input=document.createElement('input');
        input_quantity_input.type='text';
        input_quantity_input.name='quantity'
        input_quantity_input.value=this.quantity;
        input_quantity_input.placeholder='Enter Quantity'
         input_quantity_input.addEventListener("input" , e=>{
            this.quantity = e.target.value
         })
        //++++++++++++++tolat
        let box_inupt_tolat=document.createElement('div');
        box_inupt_tolat.className='box-input'
        box_inupt_tolat.style='--width--input:20%;'
        let icon_tolat=document.createElement('div');
        icon_tolat.innerHTML='<i class="fa-thin fa-tags"></i>';
        let input_tolat=document.createElement("div");
        input_tolat.className='input';
        
        input_tolat.innerHTML= ( input_after_input.value * this.quantity  )
        // input_tolat.style='background-color: #f0f0f0;'
        input_quantity_input.addEventListener("input" , e=>{
            this.quantity = e.target.value
            input_tolat.innerHTML= ( input_after_input.value * this.quantity )
         })
        // -------------+++++++++---------- end row2
        // row 3
        let row3=document.createElement('div');

        row3.className='row-edit ';
        let box_inupt_Cat=document.createElement("div");
        box_inupt_Cat.className='box-input '
        box_inupt_Cat.style='--width--input:100%;'
        let icon_Cat=document.createElement('div');
        icon_Cat.className='icon'
        icon_Cat.innerHTML='<i class="fa-solid fa-list-check"></i>';
        let input_Cat=document.createElement("div");
        input_Cat.className='input select';
        let selectcat=document.createElement('select');
        selectcat.name='Category'
        //  selectcat.innerHTML=`<option selected value="${this.catID}">${this.catName}</option>`
         let MyPromiseSelect= new Promise((r,j)=>{
            let xhr=new XMLHttpRequest()
            xhr.open('POST','/App/Category',true)
            xhr.onload=()=>{
                if(xhr.status==200 && xhr.readyState == 4){
                   
                     r(JSON.parse(xhr.response))
                }else{
                    j('error')

                }
            }
            let data= new FormData();

            data.append('type','read');
           xhr.send(data)
        }) 
        MyPromiseSelect.then(data=>{
         
            data.forEach(element => {
                let option=document.createElement('option');
                if(this.catName === element.catName){
                    option.setAttribute('selected','')
                }else{
                    
                }
             
                option.value=element.catID
                option.text=element.catName
                selectcat.appendChild(option)
            })
        })

         selectcat.addEventListener("change" ,e=>{
            this.catID=e.target.value

        })


//---------------------*------------
        let row_text=document.createElement("div");
        row_text.className='row-text'
        let note= document.createElement("textarea")
        note.name='note'
        note.id='note'
        note.value=this.note
        note.placeholder='note'
        note.addEventListener("input",e=>{this.note=e.target.value})
//+++++++++++++++++++++++++++++---------------------------------
function EditIMG(images){
   
let img_div=document.createElement("div");
img_div.className='box-images';
let butt_imgClose=document.createElement('div')
let row=document.createElement("div");
row.className='row-img';
 butt_imgClose.className='button';
let buttClose=document.createElement('button');
buttClose.type='button';
buttClose.innerText='Close';
buttClose.addEventListener("click",_=>img_div.remove())
let index=0
images.forEach((imag , inde)=>{
      
        let box_input=document.createElement("div");
        box_input.className='box-input';
        box_input.style='--width--input:23.33%;'
        let icon_box=document.createElement('div')
        icon_box.className='icon'
        icon_box.innerHTML=`   <i class="fa-regular fa-image"></i>`
        let inputImg=document.createElement("div");
        inputImg.className='input';

        let label=document.createElement("label");
        label.id='img'+index
        let img=document.createElement('img')
        img.src='../../products/'+imag;
        let inputFill=document.createElement('input')
        inputFill.type='file'
        inputFill.name='image[]'
        inputFill.id='img'+index++
       
        box_input.appendChild(icon_box)
        box_input.appendChild(inputImg);
        inputImg.appendChild(label);
        label.appendChild(img)
        inputImg.appendChild(inputFill);

        row.appendChild(box_input)
     
        label.addEventListener("click",_=>{
            inputFill.click()
        })

        inputFill.addEventListener("change",_=>{
            img.src=URL.createObjectURL(inputFill.files[0])
     
           let     myPromiseEditImg= new Promise((r,j)=>{
              
                    let xhr=new XMLHttpRequest()
                    xhr.open('POST','/App/items',true)
                    xhr.onload=_=>{
                        if(xhr.status==200 && xhr.readyState == 4){
                            console.log(xhr.responseText)
                             r(JSON.parse(xhr.response))
                        }

                    }

                    let formData=new FormData()
                    formData.append("type",'img')
                    formData.append('image[]',inputFill.files[0])
                    xhr.send(formData)
                    
                })
                myPromiseEditImg.then(r=>{
                   
                    images.splice(inde, 1, r )
                  
                    })
            })
           

        })
        img_div.appendChild(row)
        butt_imgClose.appendChild(buttClose)
        img_div.appendChild(butt_imgClose)
       from.appendChild(img_div)
       return images;
  

}
let row4=document.createElement("div")
row4.classList.add("row-edit")
row4.style=`justify-content: start;`;
let box_Store_Name =document.createElement("div")
box_Store_Name.classList.add("box-input")
box_Store_Name.style=`--width--input:30%;`
let stro_icon=document.createElement('div');
stro_icon.classList.add('icon');
stro_icon.innerHTML='<i class="fa-solid fa-store"></i>';
let stro_input=document.createElement('div');
stro_input.classList.add("input");
stro_input.innerHTML=`<input type="text" name="store_name" placeholder="Store Name"  value="${this.storeName}">`;

box_Store_Name.appendChild(stro_icon);
box_Store_Name.appendChild(stro_input);


let Role=document.createElement("div")
Role.classList.add("box-input")
Role.style=`--width--input:23%;`
let role_icon=document.createElement('div');
role_icon.classList.add('icon');
role_icon.innerHTML='<i class="fa-solid fa-location-dot"></i>';
let role_input=document.createElement('div');
role_input.classList.add("input");
role_input.innerHTML=`<input type="text" name="role" placeholder="Role"  value="${this.Role}">`;
Role.appendChild(role_icon);
Role.appendChild(role_input);


let box_Row=document.createElement("div")
box_Row.classList.add("box-input")
Role.style=`--width--input:23%;`
let Row_icon=document.createElement("div")
Row_icon.classList.add("icon")
Row_icon.innerHTML='<i class="fa-solid fa-file"></i>'
let Row_input=document.createElement("div")
Row_input.classList.add("input")
Row_input.innerHTML=`<input type="text" name="row" placeholder="Row"  value="${this.row}">`;
box_Row.appendChild(Row_icon)
box_Row.appendChild(Row_input)


let Shelf=document.createElement("div")
Shelf.classList.add("box-input")
Shelf.style=`--width--input:23%;`
let Shelf_icon=document.createElement('div');
Shelf_icon.classList.add('icon');
Shelf_icon.innerHTML='<i class="fa-light fa-shelves-empty"></i>';
let Shelf_input=document.createElement('div');
Shelf_input.classList.add("input");
Shelf_input.innerHTML=`<input type="text" name="Shelf" placeholder="Shelf" value="${this.shelf}" >`










row4.appendChild(box_Store_Name);
row4.appendChild(Role);
row4.appendChild(box_Row);

 








  
        //star app box name 
        box_inupt_name.appendChild(icon_name)
        input_box_name.appendChild(input_name)
        box_inupt_name.appendChild(input_box_name)
        
        //end 
        //star app box qrcode
        box_inupt_qr.appendChild(icon_qr)
        input_box_qr.appendChild(input_qr)
        box_inupt_qr.appendChild(input_box_qr)
        
        //end
        //row1
        row_1.appendChild(box_inupt_name)
        row_1.appendChild(box_inupt_qr)
        // row1 end
        // row_2
        //star Purchase
        input_box_Purchase.appendChild(icon_Purchase)
        input_box_Purchase.appendChild(input_Purchase)
        box_inupt_Purchase.appendChild(input_box_Purchase)
        //++++++++++++price
        input_box_price.appendChild(icon_price)
        input_box_price.appendChild(input_price)
        box_inupt_price.appendChild(input_box_price)
        //end price

        //+++++++++Discount
        box_inupt_discount.appendChild(icon_discount)
        input_discount.appendChild(input_discount_input)
        box_inupt_discount.appendChild(input_discount)
       //+++++++++after
       box_inupt_after.appendChild(icon_after)
       input_after.appendChild(input_after_input)
       box_inupt_after.appendChild(input_after)
       //end after
        //---------quantity
        box_inupt_quantity.appendChild(icon_quantity)
        input_quantity.appendChild(input_quantity_input)
        box_inupt_quantity.appendChild(input_quantity)
        //end quantity
        //star tolal
        box_inupt_tolat.appendChild( icon_tolat)
        box_inupt_tolat .appendChild(input_tolat)

        
        //end app child row 2
        row_2.appendChild(box_inupt_Purchase)
        row_2.appendChild(box_inupt_price)
        row_2.appendChild(box_inupt_discount)
        row_2.appendChild(box_inupt_after)
        row_2.appendChild(box_inupt_quantity)
        row_2.appendChild(box_inupt_tolat)

        //app row 
        //row3
        //star app box 
        box_inupt_Cat.appendChild(icon_Cat)
        box_inupt_Cat.appendChild(input_Cat)
        input_Cat.appendChild(selectcat)
     
        
        row3.appendChild(box_inupt_Cat)
        //end row 3

        //+++ set row_text
        row_text.appendChild(note)
        let from=document.createElement('form')
        let BoxRowButton=document.createElement("div");
        BoxRowButton.className="button";
        let buttonSav=document.createElement("button")
        buttonSav.type="button"
        buttonSav.innerHTML=`<i class="fa-regular fa-floppy-disk"></i> Sav`
        let butEditIMG=document.createElement("button")
        butEditIMG.type="button"
        butEditIMG.innerHTML=`<i class="fa-regular fa-pen-to-square"></i>EditIMG`;
        let buttCloseBox=document.createElement("button")
        buttCloseBox.type="button"
        buttCloseBox.innerHTML=`<i class="fa-regular fa-xmark"></i> Close`
        butEditIMG.addEventListener("click",_=>{
             EditIMG(this.images)
          this.images= EditIMG(this.images)
            
        })
        buttCloseBox.addEventListener("click",_=>box_Edit.remove())


        BoxRowButton.appendChild(buttonSav)
        BoxRowButton.appendChild(butEditIMG)
        BoxRowButton.appendChild(buttCloseBox)

        from.appendChild(row_1)
        from.appendChild(row_2)
       
        from.appendChild(row4)
        from.appendChild(row3)

        from.appendChild(row_text)
 
        from.appendChild(BoxRowButton)

        box_Edit.appendChild(from)
       
        table.appendChild(box_Edit)
        buttonSav.addEventListener("click",e=>{
            // console.log(e)
             e.preventDefault()
        let MyPromise= new Promise((r,j)=>{
            let xhr=new XMLHttpRequest()
            xhr.open('POST','/App/items',true)
            // xhr.setRequestHeader('Content-Type', 'application/json');

            xhr.onload = _=> {
                if(xhr.status==200 && xhr.readyState == 4){
                    console.log(xhr.responseText)
                    r(xhr.responseText)
                }else{
                    j("ERROR")
                }
            }
            // let data={
            //     "id":this.id,
            //     "name":this.name,
            //     "price":this.price,
            //     "images":this.images

            //     }
                let dataFrom=new FormData(from);
                dataFrom.append("itemID",this.id)
                dataFrom.append("img",JSON.stringify(this.images))
                dataFrom.append("type",'update')
                xhr.send(dataFrom)
                

            
            // xhr.send()
        })

        MyPromise.then(data=>{
            if(data.status ){
                box_Edit.remove()
            }else{
              
            }
       
        })

        })
       

        

    }
    Delete(){
         let myDelete= new Promise((r,j)=>{
            let xhr=new XMLHttpRequest()
            xhr.open('POST','/App/items',true)
            xhr.onload = _=> {
                if(xhr.status==200 && xhr.readyState == 4){
                    
                    r(xhr.responseText)
                }else{

                }
            }
            let data= new FormData()
            data.append("itemID",this.id)
            data.append("type",'delete')
            xhr.send(data)
         })
        myDelete.then(data=>{
           console.log(data)
        })
    }
}


function GET_Items(){
    let myPromise=new Promise((r,j)=>{
        let xhr= new  XMLHttpRequest()
        xhr.open("POST",UrlIems,true);
        xhr.onload=()=>{
            if(xhr.status==200 && xhr.readyState == 4){
                
                r(JSON.parse(xhr.response))
            }
        }
        let data= new FormData()
            data.append("type",'read')
        xhr.send(data)

    })
    myPromise.then(data=>{
       
        body.innerHTML="";
       data.forEach(row => {
         console.log(row)

            let item=new items(row);
            item.CearteHTML();
       });
    })
}



searchinput.addEventListener('input',e=>{
    myPromise= new Promise((r,j)=>{
        let xhr= new XMLHttpRequest()
        xhr.open("POST",UrlIems,true);
        xhr.onload=()=>{
            if(xhr.status==200 && xhr.readyState == 4){
           
                if( JSON.parse(xhr.response)){
                    r(JSON.parse(xhr.response))
                }
                else{
                    GET_Items()
                }
                
            }
            else
            {
                j("error")
            }
        }
        let data = new FormData()
        data.append("type",'where')
        data.append("search",e.target.value)

        xhr.send(data)
        


    })
    myPromise.then(data=>{
        body.innerHTML="";
        
        data.forEach(row => {
            
            body.innerHTML="";
                let item=new items(row);
                item.CearteHTML();

           });
    })

})