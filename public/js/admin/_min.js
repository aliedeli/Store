const BoxInfos=document.getElementById('box_infos')
const NavList=document.querySelector('.link')
const DataInfo =document.querySelectorAll("[data-info]")
const Buttonav=document.querySelector('.nav-button')
const Nav=document.querySelector('.nav-link')
const BoxItems=document.querySelector('#body-item')


Buttonav.addEventListener('click',()=>{
    Nav.classList.toggle('active')
    if(Nav.classList.contains('active'))
    {
       
        Buttonav.innerHTML="<i class='fa-solid fa-arrow-right'></i>"    
    }else{
        Buttonav.innerHTML="<i class='fa-solid fa-arrow-left'></i>"
    }



})
let infoData=[]
window.onblur=()=>{
    let myPromise= new Promise((r,j)=>{
        let xhr= new XMLHttpRequest()
        xhr.open('POST','/App/User/',true)
        xhr.onload=()=>{
            if(xhr.status ===200 && xhr.readyState === 4)
            {
               
                 r(JSON.parse(xhr.response))
            }else
            {
                j("Error")
            }
        }
        let data= new FormData()
            data.append("type",'active')
            data.append('active','Off')
        xhr.send(data)
})
myPromise.then(data=>{
    
})
}
window.onfocus=()=>{
    let myPromise= new Promise((r,j)=>{
        let xhr= new XMLHttpRequest()
        xhr.open('POST','/App/User/',true)
        xhr.onload=()=>{
            if(xhr.status ===200 && xhr.readyState === 4)
            {
               
                 r(JSON.parse(xhr.response))
            }else
            {
                j("Error")
            }
        }
        let data= new FormData()
            data.append("type",'active')
            data.append('active','On')
        xhr.send(data)
})
myPromise.then(data=>{
    
})
}

let myPromiseNav= new Promise((r,j)=>{
        let xhr= new XMLHttpRequest()
        xhr.open('POST','/App/User/',true)
        xhr.onload=()=>{
            if(xhr.status ===200 && xhr.readyState === 4)
            {
               
                 r(JSON.parse(xhr.response))
            }else
            {
                j("Error")
            }
        }
        let data= new FormData()
            data.append("type",'Screen')
        xhr.send(data)
})
myPromiseNav.then((data)=>{

    NavList.innerHTML='';
    let ul = document.createElement("ul");
        ul.className="ul"
    data.forEach(e=>{
        e.forEach(ev=>{
          
          
            let li=document.createElement("li")
                li.className='nav-list';
            let a=document.createElement("a")
                    if(ev.url == "NULL")
                    {
                        a.href="#"
                        
                    }
                    else{
                        a.href=ev.url;
                    }
              
            let divicon=document.createElement("div")
                divicon.className="icon";
                divicon.innerHTML=ev.icon;
            let divText=document.createElement('div');
            divText.className='text';
                divText.innerText=ev.Name;
          
           

            //app ul
            ul.appendChild(li);
            li.appendChild(a);
            
            a.appendChild(divicon);
            a.appendChild(divText);

            NavList.appendChild(ul)

      
            if(ev.filte > 0)
            {
               
                  let icon=document.createElement('samp')
            icon.innerHTML='<i class="fas fa-arrow-alt-down"></i>'
            

            icon.style=`  position: absolute;
                         top: 20%;
                         right: 0;
                        color:var(--light-gray);
                        font-size: 20px;
                        font-family: Arial, Helvetica, sans-serif;
                        font-weight: bold;`

            let ulmian =document.createElement('ul')
                ulmian.className='lislMian'
              
            
                ev.childe.forEach(ch=>{
                    let index=0;
                    a.addEventListener('click',e=>{
               
                       
                        if(index == 0)
                        {
                            ulmian.classList.add('active');
                             icon.innerHTML='<i class="fas fa-arrow-alt-up"></i>'
                           
                            index=1;

                        }else{
                            ulmian.classList.remove('active');
                            icon.innerHTML='<i class="fas fa-arrow-alt-down"></i>'
                            
                            index=0;
                        }

                    
                      

                         e.preventDefault();
                        
                    })
                    // ulmian.addEventListener('mouseout',e=>{
                    //     ulmian.classList.remove('active');
                       
                    // })
                   
                    let liM=document.createElement("li")
                    liM.className='nav-list';
                let aM=document.createElement("a")
                    aM.href=ch.url;
                let diviconM=document.createElement("div")
                    diviconM.className="icon";
                    diviconM.innerHTML=ch.icon;
                let divTextM=document.createElement('div');
                divTextM.className='text';
                    divTextM.innerText=ch.Name;

                    
                    liM.appendChild(aM);
                    aM.appendChild(diviconM);
                    aM.appendChild(divTextM);
                    ulmian.appendChild(liM)
                    
                })
                a.appendChild(icon)
                li.appendChild(ulmian)
            
                
            }
        })
 
    })
            
})






window.document.addEventListener("close",()=>{
    location.pathname='?out'
})


let Table={
    "user":"T_User",
    "product":"items",
    "order":"Orders",
    "category":"categorys",
    "Cut":"Customers",
    "exp":"MonthlyExpenses",
    "brands":"Brands",
}

if(DataInfo.length > 0){
  
    DataInfo.forEach(e=>{
      
        GetNameInfo(Table[e.dataset.info] ,e)
       
   })
    
}else{
     GetInfo()
}




class info{
    constructor(data){
        this.name=data.name
        this.cont=data.conunt
    }
    render(){
        let boxinfo=document.createElement('div')
        let box_l=document.createElement('div')
        let box_c=document.createElement('div')
        let box_r=document.createElement('div')
        let icon=document.createElement('div')
        let cont=document.createElement('div')
        // let progressBox=document.createElement('div')
        // let progress=document.createElement("progress")


        boxinfo.className='box-nifo'
        cont.className='cont'
        // progressBox.className="progress"
        box_l.className='box-l'
        box_l.innerText=this.name
        box_c.className='box-c'
        cont.innerText= (this.cont > 0 ? this.cont : 0 )
        box_r.className='box-r'
        icon.className='icon'
        // progress.value= this.cont / 100 
        // progress.max=100
        icon.innerHTML= this.cont > 6 ? "<i class='fa-duotone fa-solid fa-arrow-up'></i>" : "<i class='fa-regular fa-arrow-down'></i>"; 
        // progressBox.appendChild(progress)
        box_c.appendChild(cont)
        // box_c.appendChild(progressBox)
        boxinfo.appendChild(box_l)
        boxinfo.appendChild(box_c)
        box_r.appendChild(icon)
        boxinfo.appendChild(box_r)
        
        BoxInfos.appendChild(boxinfo)
    }
    
}



function GetInfo(){

    let myPromise= new Promise((r,j)=>{
        let xhr= new XMLHttpRequest()
            xhr.open("POST", "/info",true)
            xhr.onload=()=>{
                if(xhr.status==200 && xhr.readyState == 4){
                    let data=JSON.parse(xhr.response)
                    r(data)
                }else{
                    j("Error")
                }
            }
            let data=new FormData();
                 data.append('type','tables')
                
            xhr.send(data)
    })
    myPromise.then(data=>{
      
        BoxInfos.innerHTML=""

            

        data.forEach(coun=>{
        
          let newinfo= new info(coun)
          newinfo.render()
         
    })


})

}

function GetNameInfo(name,elem){

    let myPromise= new Promise((r,j)=>{
        let xhr= new XMLHttpRequest()
            xhr.open("POST", "/info",true)
            xhr.onload=()=>{
                if(xhr.status==200 && xhr.readyState == 4){
                   
                    let data=JSON.parse(xhr.response)
                    r(data)
                }else{
                    j("Error")
                }
            }
            let data=new FormData();
                 data.append('name',name)
                 data.append('type','table')
                
            xhr.send(data)
    })
    myPromise.then(data=>{
     
        elem.innerHTML=data.conunt

            

})

}