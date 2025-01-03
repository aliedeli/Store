const btnAdd=document.querySelector('.btn-add');
const BoxCate=document.querySelector('.form-add-cat')
const form=document.getElementById('Category')
const BottClose=form.querySelector('.btn-Close')
const search=document.getElementById('search');
const BoxItems=document.querySelector(".table .body")
const searchDate=document.getElementById('date')
const UrlCategorys="/App/Category"
btnAdd.addEventListener('click',_=>{
    BoxCate.classList.add('active');
})
BottClose.addEventListener('click',_=>{
    BoxCate.classList.remove('active');
    })
 
class Categorys{
    constructor(data){
        this.ID=data.catID;
        this.Name=data.catName;
    }
    CearteHTML(){
        let row=document.createElement("div")
        let name=document.createElement('div');
        let edit=document.createElement('div');
        let dele=document.createElement('div');
        let buttEdit=document.createElement('button');
        let buttDele=document.createElement('button');
        row.classList.add('row')
        name.classList.add('name')
        edit.classList.add('edit')
        dele.classList.add('delete')
        buttEdit.innerHTML=`
        <i class="fas fa-edit"></i>
         <samp>Edit</samp>     
        `
        buttDele.innerHTML=`
        <i class="fas fa-trash-alt"></i>
        <samp>Delete</samp>
        `
        edit.appendChild(buttEdit)
        dele.appendChild(buttDele)
        name.innerHTML=this.Name;
        row.appendChild(name)
        row.appendChild(edit)
        row.appendChild(dele)
        BoxItems.appendChild(row)
        buttEdit.addEventListener('click',_=>this.EventEDit(this))
        buttDele.addEventListener('click',_=>this.EventDelete(this))

    }
    EventEDit(){
       let boxEdit= document.querySelector('.form-edit-cat');
       let from=boxEdit.querySelector('#Cate_edit')
       let inputName=from.querySelector('input');
       let butClose=from.querySelector(".btn-Close")
       boxEdit.classList.add('active');
       butClose.addEventListener("click",_=>boxEdit.classList.remove('active'))
       inputName.value=this.Name;

       
       from.addEventListener("submit",e=>{
        e.preventDefault()
        let myPromise= new Promise((r,j)=>{
            let xhr= new XMLHttpRequest()
            xhr.open("POST", UrlCategorys,true)
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
                    GetCategorys()
                }else{
                    GetCategorys()
                }
            })
    })
       
    }
    EventDelete(){
        let myPromise= new Promise((r,j)=>{
            let xhr= new XMLHttpRequest()
                xhr.open("POST", UrlCategorys,true)
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
                GetCategorys()
            }else{
                
            }
        })
    }
}

GetCategorys()
function GetCategorys(){
    let myPromise= new Promise((r,j)=>{
        let xhr= new XMLHttpRequest()
            xhr.open("POST", UrlCategorys,true)
            xhr.onload=()=>{
                if(xhr.status==200 && xhr.readyState == 4){
                    let data=JSON.parse(xhr.responseText)
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
            let myCat= new Categorys(row)
            myCat.CearteHTML()
            
        });
    })
}
form.addEventListener("submit",e=>{
    e.preventDefault()
    let myPromise= new Promise((r,j)=>{
        let xhr= new XMLHttpRequest()
        xhr.open("POST", UrlCategorys,true)
        xhr.onload=()=>{
            if(xhr.status==200 && xhr.readyState == 4){
                console.log(xhr.responseText)
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
                GetCategorys()
            }else{
                GetCategorys()
            }
        })
})
search.addEventListener("input",e=>{
    e.preventDefault()

    let myPromise= new Promise((r,j)=>{
        let xhr= new XMLHttpRequest()
        xhr.open("POST", UrlCategorys,true)
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

        let myCat= new Categorys(row)
        myCat.CearteHTML()
        
    });
})
})
searchDate.addEventListener("input",e=>{
    e.preventDefault()

    let myPromise= new Promise((r,j)=>{
        let xhr= new XMLHttpRequest()
        xhr.open("POST", UrlCategorys,true)
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