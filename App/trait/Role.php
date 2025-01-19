<?php
namespace App\trait;

use App\Database\Database;
use PDO;
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../routes/wed.php';
// include_once "../Database/Database.php";
trait Role  
{

    public $Conn;
    public $Views;
    public $Updates;
    public $Deletes;
    public $ScrID;
    public $UesrID;
    public $UesrTypeID;
    public $UesrType;


    public function Role($conn)
    {
        $this->Conn=$conn;
  
       
       



    }
    public function getRole($UserID,$tpyeID)
    {
        $this->UesrID=$UserID;
        $this->UesrTypeID=$tpyeID;

        $stmt =$this->Conn->prepare("SELECT * FROM T_tpyeUser  WHERE TpyeID=:id");
        $stmt->bindParam(':id', $this->UesrTypeID);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // $this->RolesUser() ;
        foreach($results  as $result){
            
             $this->UesrType=$result['typeName'];
             $this->UesrType  == 'user' ?  $this->RolesUser() : $this->RolesUser()  ;
              
            
        }
        
            
            
        
    }
    public function RolesUser()
    {
        $Screens=[];
        
        $Role=$this->Conn->prepare("SELECT * FROM Power  join Screens on Screens.ScrID=Power.ScrID  Where  UserID=:UserID ");
        $Role->bindParam(':UserID', $this->UesrID);
        $Role->execute();
        $Roles=$Role->fetchAll(PDO::FETCH_ASSOC);
        foreach($Roles as $vlaues)
        {
            if($vlaues['Views'] > 0){
                if($vlaues['filte']  > 0){
            
                    $vlaues['childe']=$this->PowerChiles($vlaues['ScrID'],$vlaues['UserID']);
                 
             }
             array_push( $Screens,$vlaues) ;
            }



        }
       
        
         json_data($Screens)   ;
          
    }
    
    public function  PowerChiles($id,$UesrID){
        $ScreenAlls=[];
        $Screen=$this->Conn->query("SELECT  PowerChiles.PowerID, PowerChiles.Views,PowerChiles.Deletes,PowerChiles.Updates,childes.icon ,childes.Name,childes.ScrID
    ,childes.url
FROM PowerChiles INNER JOIN childes ON childes.childID=PowerChiles.childID  WHERE PowerChiles.UserID=$UesrID AND childes.ScrID=$id ");
        //  $Screen->bindParam(':id', $id);
        //  $Screen->bindParam(':UserID', $UesrID);

        $Screen->execute();
        $Screens= $Screen->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($Screens as $screen)
        {
   
            
                if($screen['Views'] > 0){
                    
                    array_push( $ScreenAlls,$screen);


                }
         
             
        }
        return  $ScreenAlls;
           
     }


}

