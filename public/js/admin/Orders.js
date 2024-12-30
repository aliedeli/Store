const boxBody=document.getElementById('box-body');
const search=document.getElementById('search');
const boxItems=document.querySelector('.box-items')
const box=document.querySelector('.box-Order')
const boxBodyOrder=document.querySelector('.boxBodyOrder')
const butCloes=document.querySelector('#Cloes')
const  buttAddItems=document.getElementById('add')
let fullItems=document.querySelector('.fullItems  ul')
let inputItems=document.getElementById('items')
let boxOrder=document.querySelector('.add-items-Order')
let butOrderCloes=boxOrder.querySelector('.button .Cloes')
let Peice=document.getElementById("Peice")
let Quantity=document.getElementById("Quantity")
let Discount=document.getElementById("Discount")
let total=document.getElementById('total')
const searchDate=document.getElementById('date')


const UrlOrder='/Add/Orders';
const UrlItems="/App/items"

butCloes.addEventListener('click',e=>box.classList.remove('active'))
butOrderCloes.addEventListener('click',()=> boxOrder.classList.remove('active'))
getOrders()

class Orders{
    constructor(data)
    {
       this.CutID=data.CutID
       this.FullName=data.FullName
       this.Address=data.Address
       this.Phone=data.Phone
       this.OrdID=data.OrdID
       this.Cerate_Date=data.Cerate_Date
       this.items=data.Items; 
    }
    CerateHTLM()
    {
        let row=document.createElement('div');
         row.className='row';
        let div1=document.createElement('div')
            div1.className='name'
        div1.innerText= this.FullName
        let div2=document.createElement('div')
            div2.className='name'
            div2.innerHTML=this.Address
        let div3=document.createElement('div')
            div3.className='name'
            div3.innerHTML=this.Phone
        let div4=document.createElement('div')
            div4.className='name'
            div4.innerHTML=this.Cerate_Date;
        let Control=document.createElement('div')
            Control.className='name'
        let button1=document.createElement('button');
            button1.type='button';
            button1.innerHTML=`
            <i class="fa-solid fa-eye"></i> / <i class="fa-solid fa-pen-to-square"></i>
            `
            let button2=document.createElement('button');
            button2.type='button';
            button2.innerHTML=`<i class="fa-solid fa-trash"></i>`





        Control.appendChild(button1)
        Control.appendChild(button2)
        row.appendChild(div1);
        row.appendChild(div2)
        row.appendChild(div3)
        row.appendChild(div4)
        row.appendChild(Control)


        boxBody.appendChild(row);
        buttAddItems.addEventListener("click",()=>this.addItems(this.OrdID))
        button1.addEventListener('click',e=>{
            box.classList.add('active')
            boxBodyOrder.innerHTML=``
            this.items.forEach(e=>{
                this.CerateHTLMItems(e)
            })
        })
        button2.addEventListener('click',e=> this.Delete(this))
        
    }
    addItems(OrderID)
    {
    
       
        boxOrder.classList.add('active')
       
      
        inputItems.addEventListener("input",e=>{
            if(e.target.value!="")
            {
                fullItems.parentElement.classList.add('active')
               this.getFullIte(e.target.value)
            }else
            {
                fullItems.parentElement.classList.remove('active')
            }
        })

       
        
    
       
    }

   

    CerateHTLMItems(e)
    {
       
       let row=document.createElement('div')
            row.className='row'
        let div=document.createElement('div')
            div.className='name';
            div.innerText=e.name
        let div1=document.createElement('div')
            div1.className='name';
          
        let div2=document.createElement('div')
            div2.className='name';
            div2.innerText=e.Price
            let div3=document.createElement('div')
            div3.className='name';
            div3.innerText=e.total   
        let  div4=document.createElement('div')
            div4.className='name';

        let buttEdit=document.createElement('button')
            buttEdit.type='button'
            buttEdit.innerHTML=`<i class="fa-solid fa-floppy-disk"></i>`
        let buttDele=document.createElement('button')
            buttDele.type='button'
            buttDele.innerHTML=`<i class="fa-solid fa-trash"></i>`
       
        let input=document.createElement('input')
            input.type='number'
            input.value=e.Quantity

       
        div4.appendChild(buttEdit)
        div4.appendChild(buttDele)
        div1.appendChild(input)
        row.appendChild(div)
        row.appendChild(div1)
        row.appendChild(div2)
        row.appendChild(div3)
        row.appendChild(div4)
        boxBodyOrder.appendChild(row)
        let Qty='';
        input.addEventListener('input',e=>{
             Qty=e.target.value
        })

        buttEdit.addEventListener('click',()=>{
            this.upItems(e.DalID,input.value)
        })
        buttDele.addEventListener('click',()=>{
            let myPromise=new Promise((r,j)=>{
                let xhr=new XMLHttpRequest()
                    xhr.open("POST",UrlOrder,true)
                    xhr.onload=()=>{
                        if(xhr.readyState == 4 && xhr.status ==200)
                        {
                            r(JSON.parse(xhr.response))
        
                        }
                        else
                        {
                            j("Error")
                        }
                    }
                    let data=new FormData()
                        data.append('type','deleteItems')
                        data.append("DalID",e.DalID)
                    xhr.send(data)
              })
              myPromise.then(data=>{
                if(data.status)
                {
                    row.remove()
                }else{
        
                }
              }
                
            )
        })
      
      
    }
    upItems(id,qty)
    {
        let myPromise=new Promise((r,j)=>{
            let xhr=new XMLHttpRequest()
                xhr.open("POST",UrlOrder,true)
                xhr.onload=()=>{
                    if(xhr.readyState == 4 && xhr.status ==200)
                    {
                        console.log(id)
                        
                        r(JSON.parse(xhr.response))
    
                    }
                    else
                    {
                        j("Error")
                    }
                }
                let data=new FormData()
                    data.append('type','upItems')
                    data.append("DalID",id)
                    data.append("Quantity",qty)
                xhr.send(data)
          })
          myPromise.then(data=>{
            
            if(data.status)
            {
                getOrders()
                
            }else{
    
            }
          }
            
        )
    }



    
    Delete()
    {
      let myPromise=new Promise((r,j)=>{
        let xhr=new XMLHttpRequest()
            xhr.open("POST",UrlOrder,true)
            xhr.onload=()=>{
                if(xhr.readyState == 4 && xhr.status ==200)
                {
                    r(JSON.parse(xhr.response))

                }
                else
                {
                    j("Error")
                }
            }
            let data=new FormData()
                data.append('type','delete')
                data.append("OrderID",this.OrdID)
            xhr.send(data)
      })
      myPromise.then(data=>{
        if(data.status)
        {
            getOrders()
        }else{

        }
      })
}

 getFullIte(value)
{
    let myPromise=new Promise((r,j)=>{
        let xhr=new XMLHttpRequest();
            xhr.open('POST',UrlItems,true);
            xhr.onload=()=>{
                if(xhr.readyState == 4 && xhr.status ==200 )
                {
                    r(JSON.parse(xhr.response))
                }
               
            }
            let data =new FormData()
                data.append('type','where')
                data.append('search',value)
            xhr.send(data)
    })
    myPromise.then(data=>{
            if(data){
                fullItems.innerHTML=''
                data.forEach(element => {
                      let orders = new AddNewOrder(element)
                      orders.CerateHTLMItems()
                });
            }else{
                fullItems.parentElement.classList.remove('active')
            }

    })
}

}


class AddNewOrder {
    constructor(data) {
        this.id=data.itemID
        this.itemName=data.itemName
        this.itemPrice=data.itemPrice
        this.purchasePrice=data.purchasePrice
        this.discount=data.discount
    }
    CerateHTLMItems()
    {
      
       let li=document.createElement('li')
            li.innerHTML=`<samp>${this.itemName}</samp>`
            fullItems.appendChild(li)
        li.addEventListener('click',()=>{
            this.appValue(this)
        })
    }
    appValue()
    {
        fullItems.parentElement.classList.remove('active')
        inputItems.value=this.itemName
        Peice.value=this.itemPrice -  ((this.itemPrice * this.discount) / 100 )
        Discount.value=this.discount
        Quantity.addEventListener('input',()=>this.Count())
        Discount.addEventListener("input",()=>this.Count())
    }
    Count()
    {
        Peice.value =  this.itemPrice -  ((this.itemPrice * Discount.value) / 100 )

        total.innerHTML=  Quantity.value * Peice.value 
    }
}


function getOrders()
{
    let myPromise=new Promise((r,j)=>{
        let xhr=new XMLHttpRequest();
            xhr.open('POST',UrlOrder,true);
            xhr.onload=()=>{
                if(xhr.readyState == 4 && xhr.status ==200 )
                {
                    r(JSON.parse(xhr.response))
                }
               
            }
            let data =new FormData()
                data.append('type','read')
            xhr.send(data)
    })
    myPromise.then(data=>{
       
        boxBody.innerHTML=''
      data.forEach(element => {
            let orders = new Orders(element)
            orders.CerateHTLM()
      });
    })
}

search.addEventListener("input",e=>{
 
        if(e.target.value != "")
        {
            console.log(e.target.value)
            getSearchOrders(e.target.value)
        }else{
            getOrders()
        }
    
})
function getSearchOrders(value)
{
    let myPromise=new Promise((r,j)=>{
        let xhr=new XMLHttpRequest();
            xhr.open('POST',UrlOrder,true);
            xhr.onload=()=>{
                if(xhr.readyState == 4 && xhr.status ==200 )
                {
                    r(JSON.parse(xhr.response))
                }
               
            }
            let data =new FormData()
                data.append('type','where')
                data.append('FullName',value)
            xhr.send(data)
    })
    myPromise.then(data=>{
      
        boxBody.innerHTML=''
      data.forEach(element => {
            let orders = new Orders(element)
            orders.CerateHTLM()
      });
    })
}
searchDate.addEventListener("input",e=>{
    e.preventDefault()

    let myPromise= new Promise((r,j)=>{
        let xhr= new XMLHttpRequest()
        xhr.open("POST", UrlOrder,true)
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
            boxBody.innerHTML=''
      data.forEach(element => {
            let orders = new Orders(element)
            orders.CerateHTLM()
      });

        }else{
           
        }
   
})
})