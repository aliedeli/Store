const bodyOrder=document.getElementById('body-order')
const CustName=document.getElementById('CustName')
const BoxList=document.querySelector('.box-list')
const Custlist=document.getElementById('Custlist')
const OrderID=document.getElementById('OrderID')
const AutoID=document.getElementById('AutoID')
const ItemName=document.getElementById('ItemName')
const BoxListitems=document.querySelector('.box-list-items')
const ItemsLIst=BoxListitems.querySelector('ul')
const price=document.getElementById('price')
const discount=document.getElementById('discount')
const Quantity=document.getElementById('Quantity')
const talo=document.getElementById('talo')
const  QuantityAvailable=document.getElementById('QuantityAvailable')
const Addorder=document.getElementById('Addorder')
const submit=document.getElementById('submit')
const ulrCustomers="/Add/Customers"
const ulrItems='/App/items'
const ulrOrder='/Add/Orders'
AutoID.checked=true;
OrderID.value=uintID();
let ArrItems=[]
 bodyOrder.innerHTML=''

let oders ={
    'OrderID':OrderID.value ,
    "CutID":null,
    "items":[]
    
}
localStorage.clear()
window.document.addEventListener('close',()=>localStorage.clear())


AutoID.addEventListener('change',e=>{
   
    if(e.target.checked)
    {
        OrderID.setAttribute('disabled',true)
        OrderID.value=uintID();
        oders.OrderID=OrderID.value;
    }else{

        OrderID.value='';
        OrderID.removeAttribute('disabled')
    }

})

OrderID.addEventListener('input',e=>{
    oders.OrderID=e.target.value;
})

function  uintID(){
    let id= new Date().getTime()
       newid=id.toString().slice(7)
       
        
    return newid
  

}


CustName.addEventListener('input',e=>{
    if(e.target.value != "")
    {
        let myPromise= new Promise((r,j)=>{
            let xhr=new XMLHttpRequest();
                xhr.open('POST',ulrCustomers,true)
                xhr.onload=()=>{
                    if(xhr.status==200 && xhr.readyState == 4)
                    {
                        
                        r(JSON.parse(xhr.response))
                    }
                    else
                    {
                        j("Error")
                    }
                }

                let data=new FormData()
                    data.append('name',e.target.value)
                    data.append('type','where')
                    xhr.send(data)
        })
        myPromise.then(data=>{
            if(data){
                BoxList.classList.add('active')
            }else{
                BoxList.classList.remove('active')
            }
         Custlist.innerHTML='';
           data.forEach(element => {
            let customers = new Customers(element)
            customers.Createlist()
            
           });
        })

    }else{
        BoxList.classList.remove('active')
        
    }
})
ItemName.addEventListener('input',e=>{
    if(e.target.value != "")
    {
        let myPromise= new Promise((r,j)=>{
            let xhr=new XMLHttpRequest();
                xhr.open('POST',ulrItems,true)
                xhr.onload=()=>{
                    if(xhr.status==200 && xhr.readyState == 4)
                    {
                      
                        r(JSON.parse(xhr.response))
                    }
                    else
                    {
                        j("Error")
                    }
                }

                let data=new FormData()
                    data.append('search',e.target.value)
                    data.append('type','where')
                    xhr.send(data)
        })
        myPromise.then(data=>{
            console.log(data)
            if(data){
                BoxListitems.classList.add('active')
            }else{
                BoxListitems.classList.remove('active')
            }
            ItemsLIst.innerHTML='';
           data.forEach(row => {
            let items= new Items(row)
            items.Createlist();
            
           });
        })

    }else{
        BoxListitems.classList.remove('active')
        
    }
})
ItemName.addEventListener('click',()=>getEveryItems())
CustName.addEventListener('click',()=>{getEveryname()})
function getEveryname()
{
    let myPromise= new Promise((r,j)=>{
        let xhr=new XMLHttpRequest();
            xhr.open('POST',ulrCustomers,true)
            xhr.onload=()=>{
                if(xhr.status==200 && xhr.readyState == 4)
                {
                    
                    r(JSON.parse(xhr.response))
                }
                else
                {
                    j("Error")
                }
            }

            let data=new FormData()
                data.append('type','read')
                xhr.send(data)
    })
    myPromise.then(data=>{
        if(data != null){
            BoxList.classList.add('active')
        }else{
            BoxList.classList.remove('active')
        }
     Custlist.innerHTML='';
       data.forEach(element => {
        let customers = new Customers(element)
        customers.Createlist()
        
       });
    })

}
function getEveryItems()
{
    let myPromise= new Promise((r,j)=>{
        let xhr=new XMLHttpRequest();
            xhr.open('POST',ulrItems,true)
            xhr.onload=()=>{
                if(xhr.status==200 && xhr.readyState == 4)
                {
                    
                    r(JSON.parse(xhr.response))
                }
                else
                {
                    j("Error")
                }
            }

            let data=new FormData()
                data.append('type','read')
                xhr.send(data)
    })
    myPromise.then(data=>{
        if(data != null){
            BoxListitems.classList.add('active')
        }else{
            BoxListitems.classList.remove('active')
        }
        ItemsLIst.innerHTML='';
       data.forEach(element => {
        let items = new Items(element)
        items.Createlist()
        
       });
    })

}

class Customers
{
    constructor(data)
    {
        this.CutID=data.CutID
        this.name=data.FullName
    }
    Createlist(){
        let li=document.createElement('li')
            li.innerHTML=`
             <div class="icon">
                <i class="fa-solid fa-user"></i>
                         </div>
                    <div class="text">
                                ${this.name}
                </div>`
                li.addEventListener('click',()=>{
                    this.value(this)
                })    
                Custlist.appendChild(li)
    }
    value(){

        BoxList.classList.remove('active')
        CustName.value=this.name;
        oders.CutID=this.CutID;
        
    }

}
let Odersitems={
    'DalID':null,
    'itemID':null,
    'name':"",
    "price":null,
    "discount":null,
    "Quantity":null,
    "talo":null

}

class Items{
    constructor(data)
    {
        this.itemID=data.itemID
        this.ItemName=data.itemName;
        this.itemQuant=data.itemQuant;
        this.itemPrice=data.itemPrice;
        this.discount=data.discount;
        this.purchasePrice=data.purchasePrice;
        this.price= this.itemPrice - ((this.discount * this.itemPrice) / this.itemPrice ) ;
       
    }
    Createlist(){
     
        let li=document.createElement('li')
            li.innerHTML=`
             <div class="icon">
                <i class="fa-solid fa-user"></i>
                         </div>
                    <div class="text">
                                ${this.ItemName}
                </div>`
                li.addEventListener('click',()=>{
                    this.value(this)
                })    
                ItemsLIst.appendChild(li)
    }
    value(){

        BoxListitems.classList.remove('active')
        ItemName.value=this.ItemName;
        Odersitems.name=this.ItemName;
        price.value=this.price;
        discount.value=this.discount;
        Quantity.value=1
        QuantityAvailable.value=this.itemQuant
        talo.innerText=(this.price * Quantity.value).toFixed(2)

        


        Odersitems.itemID=this.itemID;
        Odersitems.price=price.value
        Odersitems.Quantity=Quantity.value;
        Odersitems.discount=discount.value;
        Odersitems.DalID=uintID();
        Odersitems.talo=( price.value * Quantity.value).toFixed(2);

        price.addEventListener('change',e=>{ 
            Odersitems.price= e.target.value 
            this.count()
        })
        discount.addEventListener('input',e=>{ 
            Odersitems.discount=e.target.value 
            this.Discount()

        })
        Quantity.addEventListener('input',e=>{
           Odersitems.Quantity=e.target.value 
             this.count()
            })

            this.Add()
    }
    count()
    {
       
        talo.innerText=( price.value * Quantity.value).toFixed(2)
        Odersitems.talo=( price.value * Quantity.value).toFixed(2)
    }
    Discount()
    {

        price.value = this.itemPrice - ((discount.value * this.itemPrice) / this.itemPrice)
        
       this.count()
    }
    Add(){
       
        let ind=1;

        Addorder.addEventListener('click',_=>{
             ArrItems=JSON.parse(localStorage.getItem('data'))  ? JSON.parse(localStorage.getItem('data')) : []; 
                if(ind > 0){
                    ArrItems.push(Odersitems)
                    localStorage.setItem('data',JSON.stringify(ArrItems))
                    ind=0
                }
                getOrders()
                

            
        })


    }

}

function getOrders(){
    ArrItems=JSON.parse(localStorage.getItem('data'))  ? JSON.parse(localStorage.getItem('data')) : []; 
    bodyOrder.innerHTML=''
    ArrItems.forEach(row=>{
            let Addorder=new Oders(row)
                Addorder.CreateOrder()

        })
}

function getOrdersA()
{
    ArrItems=JSON.parse(localStorage.getItem('data'))  ? JSON.parse(localStorage.getItem('data')) : [];

}
class Oders
{
    constructor(data)
    {
        this.DalID=data.DalID
        this.itemID=data.itemID;
        this.name=data.name
        this.price=data.price;
        this.discount=data.discount;
        this.Quantity=data.Quantity;
        this.talo=data.talo;
    }
    CreateOrder()
    {
       let row=document.createElement('div')
            row.className='row';
       let name=document.createElement('div');
            name.className='name'
       let qty=document.createElement('div')
            qty.className='name'
       let price=document.createElement('div')
            price.className='name'
       let Edit=document.createElement('div')
            Edit.className='name'
       let Delete=document.createElement('div')
            Delete.className='name'
        name.innerText=this.name
        qty.innerText=this.Quantity
        price.innerText=this.price


        row.appendChild(name)
        row.appendChild(qty)
        row.appendChild(price)
        row.appendChild(Edit)
        row.appendChild(Delete)

        bodyOrder.appendChild(row)
    }

}

submit.addEventListener('click',e=>{
    getOrdersA()
    oders.items=ArrItems;
    if(ArrItems !=null )
    {
        let xhr= new XMLHttpRequest()
            xhr.open('POST',ulrOrder,true)
            xhr.onload=()=>{
                if(xhr.status==200 && xhr.readyState == 4)
                {
                    console.log(xhr.responseText)
                }
            }
            let data= new FormData()
                data.append('type','insert')
                data.append('OrderID',oders.OrderID)
                data.append('CutID',oders.CutID)
                data.append('items',JSON.stringify(oders.items))

            xhr.send(data)
    }
})