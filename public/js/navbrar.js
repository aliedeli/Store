const navlink=document.querySelector('.nav-link');
const Addlist=navlink.querySelector('.link')


function getLink()
{
    let myPromise=new Promise((r,j)=>{
        let xhr=new XMLHttpRequest();
            xhr.open("POST",'/App/User/',true);
            xhr.onload=()=>
                {
                if(xhr.status==200 && xhr.readyState == 4)
                {
                   
                    r(JSON.parse(xhr.response));
                }
                else
                {
                    j("Error");
                }
            }
           let data = new FormData();
               data.append('type','Screen');

               xhr.send(data);
             

    })
    myPromise.then(data=>{
        onsole.log(data);
        data.forEach(e=>{
            console.log(e);
        })
    })

}