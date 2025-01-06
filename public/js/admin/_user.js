const AddUser=document.getElementById('ButAddUser')
const Boxbody=document.querySelector('#box-body')
const BoxnewUser=document.querySelector('.newUser')
const FormUser=document.getElementById('FormUser')
const bodyUser=document.querySelector('.tableUser > .bodyUser')
const cloes=document.querySelector('#cloes')
const search=document.getElementById('search')
const table=document.querySelector('.table')

let newScreenarr=[];


function getSceens()
{
    

      let myPromise=new Promise((r,j)=>{
        let xhr=new XMLHttpRequest()
            xhr.open("POST",'/App/User/',true)
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
                data.append('type','FullScreens')
                xhr.send(data);
    })
    myPromise.then(data=>{
    
        bodyUser.innerHTML='';
        newScreenarr=data;
      
        newScreenarr.forEach((e,index)=>{
           
            let newScreenarr= new UserScreens(e,index)
                newScreenarr.Screens()

        })


    })
   
    function  uintID(){
        let id= new Date().getTime()
           newid=id.toString().slice(7)
           
            
        return newid
      
    
    }
    FormUser.addEventListener("submit",e=>{
       
         e.preventDefault()
        
        myPromise=new Promise((r,j)=>{
            let xhr=new XMLHttpRequest();
                xhr.open('POST','App/User/',true)
                xhr.onload=()=>{
                    if(xhr.status==200 && xhr.readyState == 4)
                    {
                        console.log(xhr.responseText)
                        // r(JSON.parse(xhr.response))
                    }
                }
                let data = new FormData(FormUser);
                    data.append('Power',JSON.stringify(newScreenarr))
                    data.append("UserID",uintID())
                    data.append('type','insert')
    
                    xhr.send(data)
        })
        myPromise.then(data=>{
            console.log(data)
            // if(data.status)
            // {
    
            //     BoxnewUser.classList.remove('active');
            //     GetUser()
            // }else{
    
            // }
        })
     })
    
}
 getSceens()




AddUser.addEventListener("click",e=>{
    BoxnewUser.classList.add('active');
})
cloes.addEventListener('click',()=>{
    BoxnewUser.classList.remove('active');
})


GetUser()

class User{
    constructor(data){
        this.id=data.UserID;
        this.UserName=data.UserName;
        this.Powers=data.Powers;
        this.email=data.email;
        this.typeName=data.typeName;
        this.created_at=data.created_at;
        this.active=data.active
        this.UserStatus=data.Status


    }
     createUser() {
        
        let DivUser=document.createElement('div');
        DivUser.className='row';
        let Boxname=document.createElement('div');
            Boxname.className='name';
            Boxname.innerHTML='<samp>'+ this.UserName +'</samp>'
            let active=document.createElement('div');
            active.className='name';
            active.innerHTML=this.active
         let Boxshow=document.createElement('div')
            Boxshow.className='show'
        let buttShow=document.createElement('button');
            buttShow.type='button';
            buttShow.className='btn-show';
            buttShow.innerHTML='<i class="fa-solid fa-eye"></i><samp>show</samp>';
        let Boxedit=document.createElement('div');
            Boxedit.className='edit';
        let buttStatus=document.createElement('button');
            buttStatus.type='button';
            buttStatus.className='btn-edit'
            if(this.UserStatus > 0)
            {
                buttStatus.innerHTML='<i class="fa-solid fa-eye-slash"></i><samp>Disble</samp>';
            }else{
                buttStatus.innerHTML='<i class="fa-solid fa-eye"></i><samp>Enble</samp>';
            }
           
        let BoxDele=document.createElement('div')
            BoxDele.className='delete' 
        let butdelete=document.createElement('button');
            butdelete.type='button';
            butdelete.innerHTML='<i class="fa-duotone fa-solid fa-trash"></i> <samp>Delete</samp>';
            butdelete.className='btn-edit'
           
            
            Boxshow.appendChild(buttShow)
            Boxedit.appendChild(buttStatus)
            BoxDele.appendChild(butdelete)


     

             
            DivUser.appendChild(Boxname)
            DivUser.appendChild(active)
            DivUser.appendChild(Boxshow)
            DivUser.appendChild(Boxedit)
            DivUser.appendChild(BoxDele)

            Boxbody.appendChild(DivUser)
            
            buttShow.addEventListener( 'click',e=>this.Show())
            butdelete.addEventListener('click',e=>this.Delete(this))
            buttStatus.addEventListener('click',e=>this.Status(this))

    }
    Show()
    {
        let BoxUesr=document.createElement('div');
            BoxUesr.className='box-user';
        let BoxTitle=document.createElement('div');
            BoxTitle.className='title-users';
            BoxTitle.innerHTML='<samp>'+ this.UserName+'</samp>';
        let tableUser=document.createElement('div')
            tableUser.className='table';
        let header=document.createElement('div');
        let BoxButt=document.createElement("div")
            BoxButt.className='button'
        let buttonClose=document.createElement('button')
            buttonClose.type='button'
            buttonClose.innerHTML='<i class="fa-solid fa-xmark"></i> <samp> Cloes</samp>'
            header.className='header';
            header.innerHTML=`
            <div class="name">
                            Name
                        </div>
                        <div class="show">
                            Show
                        </div>
                        <div class="edit">
                            Edit
                        </div>
                        <div class="delete">
                            Delete
                        </div>
            
            `
        let bodyUser=document.createElement('div');
            bodyUser.className='bodyUser';


            BoxButt.appendChild(buttonClose)
            tableUser.appendChild(header)
            tableUser.appendChild(bodyUser)
            tableUser.appendChild(BoxButt)

            BoxUesr.appendChild(BoxTitle)
            BoxUesr.appendChild(tableUser)

   
            this.Powers.forEach(e=>{
                 bodyUser.appendChild(this.Power(e))
                
             })
             table.appendChild(BoxUesr)
             buttonClose.addEventListener("click",()=>BoxUesr.remove())
    }
    Power(pow){
      
        let row=document.createElement('div')
            row.className='row';
        let name=document.createElement('div')
            name.className='name';
            name.innerText=pow.Name
        let show=document.createElement('div')
            show.className='show';
        let butshow=document.createElement('button')
            butshow.type='button'
            butshow.className='edit'
         
        let htmlshow=pow.Views > 0 ? 0 : 1 ;
            butshow.innerHTML=VinnerHTML(htmlshow);
        let edit=document.createElement('div');
            edit.className='edit'
        let buttStatus=document.createElement('button')
            buttStatus.type='button'
           
            buttStatus.innerHTML=VinnerHTML(pow.Updates);;
        let BOxdelete=document.createElement('div')
            BOxdelete.className='delete';
        let butdelete=document.createElement('button')     
            butdelete.type='button'
           
            butdelete.innerHTML=VinnerHTML(pow.Deletes);
            show.appendChild(butshow)
            edit.appendChild(buttStatus)
            BOxdelete.appendChild(butdelete)
            row.appendChild(name)
            row.appendChild(show)
            row.appendChild(edit)


            row.appendChild(BOxdelete)

            buttStatus.addEventListener('click' , (e)=>{

             
                pow.Updates > 0 ?  pow.Updates=0 : pow.Updates=1 ;
                buttStatus.innerHTML= VinnerHTML( pow.Updates);
                this.EitdPowers(pow)

        })

                
        butdelete.addEventListener('click' , (e)=>{

          
            pow.Deletes > 0 ?  pow.Deletes=0 : pow.Deletes=1 ;
            butdelete.innerHTML= VinnerHTML( pow.Deletes);
            this.EitdPowers(pow)
        
    })


            butshow.addEventListener('click' , e=>{
        
                   
                    pow.Views > 0 ?  pow.Views=0 : pow.Views=1 ;
                    pow.Views=this.EitdPowers(pow , pow.Views )
                    pow.Views > 0 ?  pow.Views=0 : pow.Views=1 ;
                    butshow.innerHTML= VinnerHTML(  pow.Views);
                    GetUser()
                  

                   
                  
                   
            })
            function VinnerHTML(vlaue){
                if(vlaue == 0)
                {
                    return '<i class="fa-solid fa-eye"></i><samp>Disble</samp>' ;
                }else{
                    return '<i class="fa-solid fa-check"></i><samp>Enble</samp>' ;
                }

            }
          
        return row;
    }
    Status()
    {
      let myPromise= new Promise((r,j)=>{
            let xhr=new XMLHttpRequest()
            xhr.open("POST",'/App/User/',true)
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
                data.append('type','Status')
                data.append('UserID',this.id)
                
                data.append('status',this.UserStatus > 0 ? 0 : 1 )
                xhr.send(data)
                
      })
      myPromise.then(data=>{
            if(data.status)
            {
                GetUser()
            
            }
   
      })


    }
    EitdPowers(Powers,type)
    {
     
        let myPromise=new Promise((r,j)=>{
            let xhr=new XMLHttpRequest()
                xhr.open("POST",'/App/User/',true)
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
                    data.append('type','Powers')
                    data.append('powerID',Powers.PowerID)
                    data.append('views',Powers.Views)
                    data.append('updates',Powers.Updates)
                    data.append('deletes',Powers.Deletes)

                    xhr.send(data);
        })
   myPromise.then(data=>{
           if(data.status)
           {
            type= true
           }else{
            type= false
           }
        })
        return type;
    }
    Delete()
    {
        let PowerID=[]
        this.Powers.forEach(e=>PowerID.push(e.PowerID))
        let myPromise=new Promise((r,j)=>{
            let myPromise=new Promise((r,j)=>{
                let xhr=new XMLHttpRequest()
                    xhr.open("POST",'/App/User/',true)
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
                        data.append('type','delete')
                        data.append('powerID',JSON.stringify(PowerID))
                        data.append('UserID',this.id)
                        xhr.send(data);
            })
        })
        myPromise.then(data=>{
          
        })

    }

}
search.addEventListener("input",e=>{
        
        if(e.target.value != ""){
            let myPromise=new Promise((r,j)=>{
                let xhr=new XMLHttpRequest()
                    xhr.open("POST",'/App/User/',true)
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
                        xhr.send(data);
            })
            myPromise.then(data=>{
                 Boxbody.innerHTML='';
             data.forEach(e=>{
              
                         let Users=new User(e)
                             Users.createUser();
                      })
                     
                          
                
            })
        }else
        {
            GetUser()
        }
    

})
function GetUser()
{
    let myPromise=new Promise((r,j)=>{
        let xhr=new XMLHttpRequest()
            xhr.open("POST",'/App/User/',true)
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
                xhr.send(data);
    })
    myPromise.then(data=>{
       
        Boxbody.innerHTML='';
        data.forEach(e=>{
          let Users=new User(e)
            Users.createUser();
        })
    })

}




class UserScreens
{
    constructor(data,index)
    {
      

        this.ScrID=data.ScrID;
        this.name=data.Name;
        this.filte=data.filte;
        this.Views=data.Views;
        this.Updates=data.Updates;
        this.Deletes=data.Deletes;
        this.childes=data.childes;
        this.index=index;
    

    }
    Screens()
    {
     

     let row=document.createElement('div')
        row.className='row';
    let name=document.createElement('div')
        name.className='name';
        name.innerText=this.filte > 0 ? `list:${this.childes.length}  `  + this.name : this.name;
    let show=document.createElement('div')
        show.className='show';
    let butshow=document.createElement('button')
        butshow.type='button'
        butshow.className='edit'
        butshow.innerHTML="Show";
    let edit=document.createElement('div');
        edit.className='edit'
    let buttStatus=document.createElement('button')
        buttStatus.type='button'
        buttStatus.innerHTML="edit";
    let BOxdelete=document.createElement('div')
        BOxdelete.className='delete';
    let butdelete=document.createElement('button')     
        butdelete.type='button'
        butdelete.innerHTML='delete'

        show.appendChild(butshow)
            edit.appendChild(buttStatus)
            BOxdelete.appendChild(butdelete)
            row.appendChild(name)
            row.appendChild(show)
            row.appendChild(edit)


            row.appendChild(BOxdelete)
            console.log(row)
            bodyUser.appendChild(row)
            if(this.filte==1)
                {
                    this.childes.forEach((e,i)=>{
                        
                        bodyUser.appendChild(this.child(e,i)) 
                    })
                }

      butdelete.addEventListener("click",e=>{
            if(this.Deletes > 0){
                this.Deletes =0
                newScreenarr[this.index].Deletes=0
                

            }else{
                this.Deletes =1
                newScreenarr[this.index].Deletes=1

            }
 

        
        
      })
      buttStatus.addEventListener("click",e=>{

            if(this.Updates > 0){
                this.Updates=0
                newScreenarr[this.index].Updates=0
             
            }else
            {
                this.Updates=1
                newScreenarr[this.index].Updates=1
            }
       
      

        
      })

      butshow.addEventListener("click",e=>{
        if(this.Views > 0){
        this.Views =0
        newScreenarr[this.index].Views=0
        } else{
            this.Views =1
            newScreenarr[this.index].Views=1
        }
        
      })

      

    }
    child(data,i){
     
        let row=document.createElement('div')
        row.className='row';
    let name=document.createElement('div')
        name.className='name';
         name.innerText= i +' :'+ data.Name
    let show=document.createElement('div')
        show.className='show';
    let butshow=document.createElement('button')
        butshow.type='button'
        butshow.className='edit'
        butshow.innerHTML="Show";
    let edit=document.createElement('div');
        edit.className='edit'
    let buttStatus=document.createElement('button')
        buttStatus.type='button'
        buttStatus.innerHTML="edit";
    let BOxdelete=document.createElement('div')
        BOxdelete.className='delete';
    let butdelete=document.createElement('button')
        butdelete.type='button'
        butdelete.innerHTML='delete'
        show.appendChild(butshow)
        edit.appendChild(buttStatus)
        BOxdelete.appendChild(butdelete)
        row.appendChild(name)
        row.appendChild(show)
        row.appendChild(edit)
        row.appendChild(BOxdelete)

        butdelete.addEventListener("click",e=>{
            if(data.Deletes > 0){
                data.Deletes =0
                newScreenarr[this.index].childes[i].Deletes=0
                
            }
            else{
                data.Deletes =1
                newScreenarr[this.index].childes[i].Deletes=1
              
            }
                })

                buttStatus.addEventListener("click",e=>{
                    if(data.Updates > 0){
                        data.Updates=0
                        newScreenarr[this.index].childes[i].Updates=0
                    }
                    else
                    {
                        data.Updates=1
                        newScreenarr[this.index].childes[i].Updates=1
                        }
                })
            butshow.addEventListener("click",e=>{
                    if(data.Views > 0){
                        data.Views =0
                        newScreenarr[this.index].childes[i].Views=0
                    } else{
                        data.Views =1
                        newScreenarr[this.index].childes[i].Views=1
                    }
                    })

        



        return row;


        




    }

    
}


// bodyUser.innerHTML='';
// Screens.forEach((e,index)=>{
   
//     let newScreen= new UserScreens(e,index)
//        newScreen.Screens()
// })

