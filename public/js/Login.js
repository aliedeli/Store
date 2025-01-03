let form=document.getElementById('Login');
let UserName=document.getElementById('userName');
let Password=document.getElementById('password');
let boxMessage=document.querySelector('.login-header')
let Userlen=0;
UserName.addEventListener('input',e=>{
    Userlen=e.target.value.length
 
    if(e.target.value.length < 3 ){
        UserName.style.border="2px solid red";
    }
    else
    {
        UserName.style.border="2px solid transparent";
    }

})

form.addEventListener('submit',e=>{
    e.preventDefault();
    let myPromise= new Promise((r,j)=>{
        let xhr=new XMLHttpRequest();
        xhr.open('POST','/App/Login',true);

        xhr.onload=()=>{
            
            if(xhr.status==200 && xhr.readyState == 4){
               console.log(xhr.responseText)
             r(JSON.parse(xhr.response));
            }
            else
            {
                j("error")
            }
        }
        let data= new FormData(form);
        data.append('type','in');
        xhr.send(data)

    })
    myPromise.then(data=>{
        if( data.status){
            location.pathname='/'
            active()
        }else{
            boxMessage.innerHTML=`<h2>${data.message}<h2 >`;
        }
       
    })

})
function  active(){
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