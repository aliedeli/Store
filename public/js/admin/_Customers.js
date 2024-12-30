const ButAddCustomers=document.getElementById('ButAddCustomers')
const BoxCustomer=document.querySelector('.Box-Cut')
const form=BoxCustomer.querySelector('form');
const cloes=form.querySelector('#cloes')
const boxBody=document.getElementById('boxBody')
const search=document.getElementById('search')
const Ulr='/Add/Customers'



function  uintID(){
    let id= new Date().getTime()
       newid=id.toString().slice(7)
       
        
    return newid
}

search.addEventListener('keyup',()=>{
//     let value=search.value
//     let rows=document.querySelectorAll('.row')
//     rows.forEach(row=>{
//         if(row.innerText.toLowerCase().includes(value.toLowerCase())){
//             row.style.display='flex'
//         }else{
//             row.style.display='none'
//         }
//     })
 })
getData()

ButAddCustomers.addEventListener('click',()=>{
    BoxCustomer.classList.add('active')

})
cloes.addEventListener('click',()=>{

    BoxCustomer.classList.remove('active')

})
form.addEventListener('submit',e=>{
    e.preventDefault()
    myProims= new Promise((r,j)=>{
        let xhr=new XMLHttpRequest()
            xhr.open("POST",Ulr,true)
            xhr.onload=()=>{
                if(xhr.status==200 && xhr.readyState == 4)
                    {
                        console.log(xhr.responseText)
                        // r(JSON.parse(xhr.response))
                    }
                    else
                    {
                        j("Error")
                    }
            }
            let data = new FormData(form)
                data.append('type','insert')
                data.append('cutID',uintID())
            xhr.send(data);
    })
    myProims.then(data=>{
        getData()
    })
})

class Customers
{
    constructor(data)
    {

        this.CutID=data.CutID;
        this.FullName=data.FullName;
        this.Address=data.Address
        this.Phone=data.Phone;
        this.count=data.count;

    }
    CreateHTML()
    {
       

        let row=document.createElement('div');
            row.className='row';
        let div1=document.createElement('div')
            div1.className='name';
            div1.innerHTML=this.FullName;
        let div2=document.createElement('div');
            div2.className='name';
            div2.innerHTML= this.Address;
        let div3=document.createElement('div');
            div3.className='name'
            div3.innerHTML = `<samp> ${this.count}</samp> `
        let div4=document.createElement('div');
            div4.className='name';
        let butEdit=document.createElement('button')
            butEdit.type='button'
            butEdit.innerHTML=' <i class="fa-solid fa-eye"></i> / <i class="fa-solid fa-pen-to-square"></i>'
        let buttDele=document.createElement('button')
            buttDele.type='button'
            buttDele.innerHTML='<i class="fa-solid fa-trash"></i>'
      

        div4.appendChild(butEdit)
        div4.appendChild(buttDele)
        row.appendChild(div1)
        row.appendChild(div2)
        row.appendChild(div3)
        row.appendChild(div4)
        boxBody.appendChild(row)
        butEdit.addEventListener('click',()=>this.CreateElement())
        buttDele.addEventListener('click',()=>this.Delete())
    }
    CreateElement()
    {   
     
        let BoxCustomers=document.createElement('div')
            BoxCustomers.className='box-Cut'
        let row1=document.createElement('div')
            row1.className='row'
        let inputBox=document.createElement('div')
            inputBox.className='input'
        let icon=document.createElement('div')
            icon.className='icon'
            icon.innerHTML='<i class="fa-solid fa-user"></i>'
        let value=document.createElement('div')
            value.className='value'
        let input=document.createElement('input')
            input.type='text'
            input.name='name'
        input.value=this.FullName
        value.appendChild(input)
        inputBox.appendChild(icon)
        inputBox.appendChild(value)
        row1.appendChild(inputBox)
        let inputBox2=document.createElement('div')
        inputBox2.className='input'
        let icon2=document.createElement('div')
        icon2.className='icon'
        icon2.innerHTML='<i class="fa-solid fa-location-dot"></i>'
        let value2=document.createElement('div')
        value2.className='value'
        let input2=document.createElement('input')
        input2.type='text'
        input2.name='address'
        input2.value=this.Address
        value2.appendChild(input2)
        inputBox2.appendChild(icon2)
        inputBox2.appendChild(value2)
        row1.appendChild(inputBox2)
        let inputBox3=document.createElement('div')
        inputBox3.className='input'
        let icon3=document.createElement('div')
        icon3.className='icon'
        inputBox3.className='input'
        icon3.innerHTML='<i class="fa-solid fa-phone"></i>'
        let value3=document.createElement('div')
        value3.className='value'
        let input3=document.createElement('input')
        input3.type='text'
        input3.name='phone'
        input3.value=this.Phone
        value3.appendChild(input3)
        inputBox3.appendChild(icon3)
        inputBox3.appendChild(value3)
        row1.appendChild(inputBox3)
        let butSave=document.createElement('button')
        butSave.className='btn'
        butSave.innerHTML='Save'
        let butClose=document.createElement('button')
        butClose.className='btn'
        butClose.innerHTML='Close'
 

        butSave.addEventListener('click',()=>{
            let xhr=new XMLHttpRequest()
            xhr.open("POST",Ulr,true)
            xhr.onload=()=>{
                if(xhr.status==200 && xhr.readyState == 4)
                    {
                        if(JSON.parse(xhr.response).status){
                            BoxCustomers.remove()
                            getData()
                        }
                       
                    }
                    else
                    {
                        j("Error")
                    }
            }
            let data = new FormData(form)
                data.append('type','update')
                data.append('cutID',this.CutID)
                data.append('name',input.value)
                data.append('Address',input2.value)
                data.append('phone',input3.value)
            xhr.send(data);
        })
        butClose.addEventListener('click',()=>{
            BoxCustomers.remove()
        })
        let row2=document.createElement('div')
        row2.className='button'
        row2.appendChild(butSave)
        row2.appendChild(butClose)
        BoxCustomers.appendChild(row1)
        BoxCustomers.appendChild(row2)

       


        BoxCustomer.parentElement.insertBefore(BoxCustomers,BoxCustomer)
        // document.body.append(BoxCustomers)
     
    }
    Delete()
    {
      let myProims= new Promise((r,j)=>{
        let xhr=new XMLHttpRequest()
            xhr.open("POST",Ulr,true)
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
            let data = new FormData(form)
                data.append('type','delete')
                data.append('cutID',this.CutID)
            xhr.send(data);
    })
    myProims.then(data=>{
        if(data.status){
            BoxCustomer.remove()
            getData()
        }
        else{
           
        }
    })
    }
}























function getData()
{
    myProims= new Promise((r,j)=>{
        let xhr=new XMLHttpRequest()
            xhr.open("POST",Ulr,true)
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
            let data = new FormData(form)
                data.append('type','read')
               
            xhr.send(data);
    })
    myProims.then(data=>{
        boxBody.innerHTML=''
        data.forEach(row => {
              let customers = new Customers(row)
                    customers.CreateHTML();
        });
    })

}