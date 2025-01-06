<?php
use App\Models\Models;
use App\Database\Database;


    //  require_once __DIR__ . '/../../config/Database.php';

   

class Items implements Models
{

    public $Connt;
    public $itemID;
    public $itemName;
    public $itemCode;
    public $itemPurchase;
    public $price;
    public $Discount;
    public $quantity;
    public $Store_Name;
    public $Role;
    public $row;
    public $Shelf;
    public $Category;
    public $type;
    public $search;
    public $Brands;


   


    public $image;
    public $description;
    public $category;
    // public $subcategory;
    // public $created_at;

    // public $updated_at;
    // public $deleted_at;

     public $msg; 
     public $msg1;
     public $msgDele;
    // public $msgStor= json_encode(["status"=>true,'msg'=> "stor Inserted Successfully "]);
    // public $msg3= json_encode(["status"=>true,'msg'=> "Item Not Found "]);
    // public $msg4= json_encode(["status"=>true,'msg'=> "Item Already Exist "]);
    public $msg5;



    

        public function __construct($Conn)
        {
            $this->Connt=$Conn->conn();
            $this->itemID=filter_input(INPUT_POST,'itemID',FILTER_SANITIZE_SPECIAL_CHARS);
            $this->itemName=filter_input(INPUT_POST,'itemName',FILTER_SANITIZE_SPECIAL_CHARS);
            $this->itemCode=filter_input(INPUT_POST,'itemCode',FILTER_SANITIZE_SPECIAL_CHARS);
            $this->itemPurchase=filter_input(INPUT_POST,'itemPurchase',FILTER_SANITIZE_SPECIAL_CHARS);
            $this->price=filter_input(INPUT_POST,'price',FILTER_SANITIZE_SPECIAL_CHARS);
            $this->Discount=filter_input(INPUT_POST,'Discount',FILTER_SANITIZE_SPECIAL_CHARS);
            $this->quantity=filter_input(INPUT_POST,'quantity',FILTER_SANITIZE_SPECIAL_CHARS);
            $this->Store_Name=filter_input(INPUT_POST,'Store_Name',FILTER_SANITIZE_SPECIAL_CHARS);
            $this->Role=filter_input(INPUT_POST,'Role',FILTER_SANITIZE_SPECIAL_CHARS);
            $this->Shelf=filter_input(INPUT_POST,'Shelf',FILTER_SANITIZE_SPECIAL_CHARS);
            $this->row=filter_input(INPUT_POST,'Row',FILTER_SANITIZE_SPECIAL_CHARS);
            $this->Category=filter_input(INPUT_POST,'Category',FILTER_SANITIZE_SPECIAL_CHARS);
            $this->description=filter_input(INPUT_POST,'note',FILTER_SANITIZE_SPECIAL_CHARS);
            $this->type=filter_input(INPUT_POST,  'type',FILTER_SANITIZE_SPECIAL_CHARS);
            $this->search=filter_input(INPUT_POST,  'search',FILTER_SANITIZE_SPECIAL_CHARS);
            $this->Brands=filter_input(INPUT_POST,  'Brands',FILTER_SANITIZE_SPECIAL_CHARS);

            $this->msg=json_encode(["status"=>true,'msg'=> "Item Inserted Successfully "]);
            $this->msg1=json_encode(["status"=>true,'msg'=> "Item Updated Successfully "]);
            $this->msgDele= json_encode(["status"=>true,'msg'=> "Item Deleted Successfully "]);
            $this->msg5= json_encode(["status"=>false,'msg'=> "Item listed failed "]);
           
           
            
            

         }
         public function uploadImagms(){
           
            $names = $_FILES['image']['name'];
            $tmp_name = $_FILES['image']['tmp_name'];
            $size = $_FILES['image']['size'];
            $imgType = $_FILES['image']['type'];
            $error = $_FILES['image']['error'];
            $img_name_array=[];
            // $allowedExts = array("jpg", "jpeg", "png", "gif");

            function AddImages($img_name,$tmp_name,$error){
                if($error === 0){
                  
                    $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                    $img_ex_lc = strtolower($img_ex);
                    $img_arra = array("jpg", "jpeg" , "png","jfif","webp");
                    if (in_array($img_ex_lc, $img_arra)){
                        $img_tmp_new= uniqid('IMG',true) . "." .$img_ex_lc;
                        $img_upload=  base_path() . 'public/products/' .  $img_tmp_new;
                        move_uploaded_file($tmp_name,$img_upload);
                
                        return  $img_tmp_new ;
                
                        
                }
                
                 }
                }
                foreach(   $names as  $key => $name  ){
             
                    
                        array_push( $img_name_array , AddImages($name,$tmp_name[$key ], $error[$key]));
                    
                
               
               
            }
             return  json_encode($img_name_array );

         }
  function insert()
    {
      
        
        
            $app= $this->Connt->prepare("INSERT INTO  items
            ( itemID,itemName,qrCode,itemPrice,purchasePrice,discount,itemQuant,note,images,catID,branID)  VALUES (:itemID,:itemName,:qrCode,:itemPrice,:purchasePrice,:discount,:itemQuant,:note,:images,:catID,:branID)");
            $app->bindParam(":itemID",$this->itemID);
            $app->bindParam(":itemName",$this->itemName);
            $app->bindParam(":qrCode",$this->itemCode);
            $app->bindParam(":itemPrice",$this->price);
            $app->bindParam(":purchasePrice",$this->itemPurchase);
            $app->bindParam(":discount",$this->Discount);
            $app->bindParam(":itemQuant",$this->quantity);
            $app->bindParam(":note",$this->description);
            $app->bindParam(":images",  $this->uploadImagms());
            $app->bindParam(":catID",$this->Category);
            $app->bindParam(":branID",$this->Brands);

            $Chik=$app->execute();
            if($Chik)
            {
               $stor=$this->Connt->prepare("INSERT INTO storeItems (storeName,Role,row,shelf,itemID) VALUES (:storeName,:Role,:row,:shelf,:itemID)");
               $stor->bindParam(":storeName",$this->Store_Name);
               $stor->bindParam(":Role",$this->Role);
               $stor->bindParam(":row",$this->row);
               $stor->bindParam(":shelf",$this->Shelf);
               $stor->bindParam(":itemID",$this->itemID);
               $ChikStor=$stor->execute();
               if($ChikStor)
               {
                json_data(["status"=>true]);

               }
               else
               {
                json_data(["status"=>false]);

               }

            }
            else
            {
                 echo $this->msg5;
            }


    }

    public function read()
    {
        $array=[];
        // $app = $this->Connt->prepare('key', 'default')("SELECT * FROM ");
        $read = $this->Connt->query("SELECTiTEMSAll");
        $read->execute();
        $results=$read->fetchAll(PDO::FETCH_ASSOC);
        foreach($results as $result)
        {
            array_push($array , $result);
        }

        
      echo  json_encode( $array);

    }
    public function where()
    {
      
        $array=[];
        $where = $this->Connt->query("where_Items @search='%$this->search%'  ");
        $where->execute();
        $results=$where->fetchAll(PDO::FETCH_ASSOC);
        foreach($results as $result)
        {
            array_push($array , $result);
        }
            echo json_encode($array);
           
    }
    public function update()
    {
        
        $this->image= $_POST['img'] ;
       

        $update= $this->Connt->prepare("UPDATE items SET  itemName=:name,qrCode=:qrCode,itemPrice=:itemPrice
        ,purchasePrice=:purchasePrice,discount=:discount,itemQuant=:itemQuant,note=:note,images=:images,catID=:catID  where itemID=:itemID  ");
            $update->bindParam(":itemID",$this->itemID);
            $update->bindParam(":name",$this->itemName);
            $update->bindParam(":qrCode",$this->itemCode);
            $update->bindParam(":itemPrice",$this->price);
            $update->bindParam(":purchasePrice",$this->itemPurchase);
            $update->bindParam(":discount",$this->Discount);
            $update->bindParam(":itemQuant",$this->quantity);
            $update->bindParam(":note",$this->description);
            $update->bindParam(":images",$this->image);
            $update->bindParam(":catID",$this->Category);
            $Chik=$update->execute();
        if($Chik)
        {
            $stor=$this->Connt->prepare(" UPDATE  storeItems SET storeName=:storeName,Role=:Role,row=:row,shelf=:shelf  where itemID=:itemID");
               $stor->bindParam(":storeName",$this->Store_Name);
               $stor->bindParam(":Role",$this->Role);
               $stor->bindParam(":row",$this->row);
               $stor->bindParam(":shelf",$this->Shelf);
               $stor->bindParam(":itemID",$this->itemID);
               $ChikStor=$stor->execute();
               if($ChikStor)
               {
                    echo  $this->msg1;
               }
        }
        else{
        //     return false;
        }   

    }
    public function delete()
    {
        $delete= $this->Connt->prepare("DELETE FROM items WHERE itemID=:itemID");
        $delete->bindParam(":itemID",$this->itemID);
        $Chik=$delete->execute();
        if($Chik)
        {
            $this->StoreItems();
           echo  $this->msgDele;
        }
        else
        {
            return false;
        }

    }
    public function StoreItems()
    {
        $delete= $this->Connt->prepare("DELETE FROM storeItems WHERE itemID=:itemID");
        $delete->bindParam(":itemID",$this->itemID);
        $Chik=$delete->execute();
        if($Chik)
        {
           return true;
        }
        else
        {
            return false;
        }
    }

    public function searchDate()
    {
         $array=[];
        $where=$this->Connt->query("SELECT* FROM items WHERE  CONVERT( DATE ,CreateDate) >='$this->search'");
        $where->execute();
        $results=$where->fetchAll(\PDO::FETCH_ASSOC);;
        if($results)
        {
          foreach($results as $row)
          {
            array_push($array,$row);
          }
          json_data($array);
        }
        else
        {
          $this->read();
        }
    }
    public function searchCat()
    {
        $array=[];
        $where=$this->Connt->query("where_Items_categorys @catID=$this->category , @search='%$this->search%'");
        $where->execute();
        $results=$where->fetchAll(\PDO::FETCH_ASSOC);;
        if($results)
        {
          foreach($results as $row)
          {
            array_push($array,$row);
          }
          json_data($array);
        }
        else
        {
          $this->where();
        }
    }
public function Chik()
{
    if($_SERVER['REQUEST_METHOD'] === "POST" )
    {
        
        if($this->type == "insert")
        {
           
            $this->insert();

        }
        elseif($this->type == "update")
        {
          
             $this->update();
        }
        elseif($this->type == "delete")
        {
            $this->delete();
        }
        elseif($this->type == "read")
        {
            $this->read();
        }
        elseif($this->type == "where")
        {
            $this->where();
        }
        elseif($this->type == "img"){
           
            // Uploads an image and echoes the result.
            echo $this->uploadImagms();

        }
        elseif($this->type == "searchDate"){
            // print_r($_POST);
             $this->searchDate();

        }
        elseif($this->type == "searchCat"){
            // print_r($_POST);
             $this->searchCat();
        }

    }
  
}
}

$MyItems= new Items( new Database());
$MyItems->Chik();
