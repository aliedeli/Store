const totalOrders=document.getElementById("totalOrders");
const totalExpenses=document.getElementById("totalExpenses");
const totalAccounts=document.getElementById("totalAccounts");
getTotalOrders()
setInterval(getTotalOrders(), 30000);
function getTotalOrders(){  
    let xhr=new XMLHttpRequest();
    xhr.open("POST","/App/AotuTatol",true);
  
    xhr.onload=function(){
        if(xhr.status==200){
            let data=JSON.parse(xhr.response);
             totalOrders.innerHTML=data.orders;
             totalExpenses.innerHTML=data.expenses;
             totalAccounts.innerHTML=data.accounts;
            
            }
            else{
                alert("Error");
            }
        }
        let data=new FormData();
        data.append("type",'total');
        xhr.send(data);
 }
   
