const btnAdd=document.querySelector('.btn-add');
const BoxCate=document.querySelector('.form-add-cat')
const form=document.getElementById('Category')
const BottClose=form.querySelector('.btn-Close')
const search=document.getElementById('search');
const BoxItems=document.querySelector(".table .body")
const searchDate=document.getElementById('date')
const UrlAccounts="/App/Accounts"
btnAdd.addEventListener('click',_=>{
    BoxCate.classList.add('active');
})
BottClose.addEventListener('click',_=>{
    BoxCate.classList.remove('active');
    })
 
class Accounts{
    constructor(data){
        this.ID=data.account_id;
        this.Name=data.account_name;
        this.accountType=data.account_type;
        this.balance=data.balance;
        this.date=data.created_at;
        
    }
    CearteHTML(){
        let row=document.createElement("div")
        let Category=document.createElement('div');
        let Description=document.createElement('div');
        let Amount=document.createElement('div');
        let PaymentMethod=document.createElement('div');

        let edit=document.createElement('div');
        let dele=document.createElement('div');
        let buttEdit=document.createElement('button');
        let buttDele=document.createElement('button');
        row.classList.add('row')
        Category.classList.add('name')
        Description.classList.add('name')
        Amount.classList.add('name')
        PaymentMethod.classList.add('name')
        edit.classList.add('edit')
        dele.classList.add('delete')
        buttEdit.innerHTML=`
        <i class="fa-solid fa-eye"></i> / <i class="fa-solid fa-pen-to-square"></i>   
        `
        buttDele.innerHTML=` <i class="fa-solid fa-trash"></i> `
        edit.appendChild(buttEdit)
        dele.appendChild(buttDele)
        Category.innerHTML=this.Name;
        Description.innerHTML=this.accountType
        Amount.innerHTML=this.balance
        PaymentMethod.innerHTML=this.PaymentMethod
        row.appendChild(Category)
        row.appendChild(Description)
        row.appendChild(Amount)
        row.appendChild(PaymentMethod)

        row.appendChild(edit)
        row.appendChild(dele)
        BoxItems.appendChild(row)
        buttEdit.addEventListener('click',_=>this.EventEDit(this))
        buttDele.addEventListener('click',_=>this.EventDelete(this))
    }
    EventEDit(){
        let boxEdit= document.querySelector('.form-edit-cat');
       let from=boxEdit.querySelector('#Cate_edit')
       let Category=from.querySelector('.Category');
       let Description=from.querySelector('.Description');
       let Amount=from.querySelector('.Amount');
       let PaymentMethod=from.querySelector('.PaymentMethod');
       let butClose=from.querySelector(".btn-Close")
      
       boxEdit.classList.add('active');
       butClose.addEventListener("click",_=>boxEdit.classList.remove('active'))
       Category.value=this.Name;
       Description.value=this.accountType;
       Amount.value=this.balance;
       PaymentMethod.value=this.PaymentMethod;
       
  

       
       from.addEventListener("submit",e=>{
        e.preventDefault()
        let myPromise= new Promise((r,j)=>{
            let xhr= new XMLHttpRequest()
            xhr.open("POST", UrlExpenses,true)
            xhr.onload=()=>{
                if(xhr.status==200 && xhr.readyState == 4){
    
                 
                    r(JSON.parse(xhr.response))
                }else{
                    j("Error")
                }
            }
            let data = new  FormData(from)
                data.append('id',parseInt(this.ID))
                data.append("type",'update')
                

            xhr.send(data)
        })
    
        myPromise.then(
            data=>{
                if(data.status){
                    GetExpenses()
                }else{
                    GetExpenses()
                }
            })
    })
       
    }
    EventDelete(){
        let myPromise= new Promise((r,j)=>{
            let xhr= new XMLHttpRequest()
                xhr.open("POST", UrlAccounts,true)
                xhr.onload=()=>{
                    if(xhr.status==200 && xhr.readyState == 4){
                        console.log(xhr.responseText)
                        let data=JSON.parse(xhr.response)
                        r(data)
                    }else{
                        j("Error")
                    }
                }
                let data= new FormData(document.createElement("form"))
                data.append("id",parseInt(this.ID))
                data.append("type","delete")
                xhr.send(data)
        })
        myPromise.then(data=>{
            if(data.status){
                GetAccounts()
            }else{
                
            }
        })
    }
}

GetAccounts()
function GetAccounts(){
    let myPromise= new Promise((r,j)=>{
        let xhr= new XMLHttpRequest()
            xhr.open("POST", UrlAccounts,true)
            xhr.onload=()=>{
                if(xhr.status==200 && xhr.readyState == 4){
                    console.log(xhr.responseText)
                    let data=JSON.parse(xhr.response)
                    r(data)
                }else{
                    j("Error")
                }
            }
             let newData= new FormData();
             newData.append("type","read")

             xhr.send(newData)
    })
    myPromise.then(data=>{
        BoxItems.innerHTML=""
        data.forEach(row => {
            let myCat= new Accounts(row)
            myCat.CearteHTML()
            
        });
    })
}
form.addEventListener("submit",e=>{
    e.preventDefault()
    let myPromise= new Promise((r,j)=>{
        let xhr= new XMLHttpRequest()
        xhr.open("POST", UrlAccounts,true)
        xhr.onload=()=>{
            if(xhr.status==200 && xhr.readyState == 4){
               
                r(JSON.parse(xhr.response))
            }else{
                j("Error")
            }
        }
        let data= new FormData(form)
        data.append("type","insert")

        xhr.send(data)
    })

    myPromise.then(
        data=>{
            if(data.status){
                GetAccounts()
            }else{
                GetAccounts()
            }
        })
})
search.addEventListener("input",e=>{
    e.preventDefault()

    let myPromise= new Promise((r,j)=>{
        let xhr= new XMLHttpRequest()
        xhr.open("POST", UrlAccounts,true)
        xhr.onload=()=>{
            if(xhr.status==200 && xhr.readyState == 4){
                
                r(JSON.parse(xhr.response))
        }else{
            j("Error")
        }
       
    }
    let data= new FormData()
    data.append("search",e.target.value)
    data.append("type","where")

    xhr.send(data)
})

myPromise.then(data=>{
    BoxItems.innerHTML=""
    data.forEach(row => {

        let myCat= new Accounts(row)
        myCat.CearteHTML()
        
    });
})
})
searchDate.addEventListener("input",e=>{
    e.preventDefault()

    let myPromise= new Promise((r,j)=>{
        let xhr= new XMLHttpRequest()
        xhr.open("POST", UrlAccounts,true)
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
            BoxItems.innerHTML=""
            data.forEach(row => {
        
                let myCat= new Expenses(row)
                myCat.CearteHTML()
                
            });

        }else{
           
        }
   
})
})