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
        foreach($results  as $result){

            $this->UesrType=$result['typeName'];
            $this->UesrType  == 'user' ? $this->RolesUser() : $this->RolesUser()  ;
              
              
            
        }
        
            
            
        
    }
    public function RolesUser()
    {
        $Screens=[];
        
        $Role=$this->Conn->prepare("SELECT * FROM  Roles  join Power on Roles.PowerID=Power.PowerID Where  UserID=:UserID ");
        $Role->bindParam(':UserID', $this->UesrID);
        $Role->execute();
        $Roles=$Role->fetchAll(PDO::FETCH_ASSOC);
        foreach($Roles as $vlaues)
        {

            $this->Views=$vlaues['Views'];
            $this->Updates=$vlaues['Updates'];
            $this->Deletes=$vlaues['Deletes'];
            $this->ScrID= $vlaues['ScrID'];
     
            if($this->Views > 0){
                array_push( $Screens,$this->Screen()) ;
            }
       

        }
        json_data($Screens)   ;
          
    }
    
    public function Screen(){
        $ScreenAlls=[];
        $Screen=$this->Conn->query("SELECT * FROM Screens where ScrID=$this->ScrID ");
        // $Screen->bindParam(':ScrID', $this->ScrID);
        $Screen->execute();
        $Screens= $Screen->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($Screens as $screen)
        {
                if($screen['filte'] > 0){
                    
                      $screen['childe']= $this->Child();


                }
           array_push( $ScreenAlls,$screen);
             
        }
        return  $ScreenAlls;
           
    }
    public function Child(){
        $ScreenAll=[];
        $child=$this->Conn->prepare("SELECT * FROM childes where ScrID=:ScrID ");
        $child->bindParam(':ScrID', $this->ScrID);
        $child->execute();
        $childs=$child->fetchAll(PDO::FETCH_ASSOC);
        foreach( $childs as  $screen)
        {
            array_push($ScreenAll,$screen);


        }
        return $ScreenAll;

    }

}

