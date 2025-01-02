const totalOrders=document.getElementById("totalOrders");
const totalExpenses=document.getElementById("totalExpenses");
getTotalOrders()
getTotalexpenses()
function getTotalOrders(){  
    let xhr=new XMLHttpRequest();
    xhr.open("POST","/App/AotuTatol",true);
  
    xhr.onload=function(){
        if(xhr.status==200){
            totalOrders.innerHTML=JSON.parse(xhr.response).total;
            
            }
            else{
                alert("Error");
            }
        }
        let data=new FormData();
        data.append("type",'orders');
        xhr.send(data);
 }
   
 function getTotalexpenses(){  
    let xhr=new XMLHttpRequest();
    xhr.open("POST","/App/AotuTatol",true);
  
    xhr.onload=function(){
        if(xhr.status==200){
           
             totalExpenses.innerHTML=JSON.parse(xhr.response).total;
            
            }
            else{
                alert("Error");
            }
        }
        let data=new FormData();
        data.append("type",'expenses');
        xhr.send(data);
 }
