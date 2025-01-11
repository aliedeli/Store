<?php
namespace App\trait;
use App\Database\Database;
use PDO;
trait Screens  
{
    public $Conn;
    public $Views;
    public $Updates;
    public $Deletes;
   
    // public $ScrID;
    // public $UesrID;
    public function __construct()
    {
        $this->Conn=(new Database())->conn();


    }
    public function getScreens()
    {
        $screens=[];
        $stmt =$this->Conn->prepare("SELECT * FROM Screens  ORDER BY  ScrID ASC");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($results  as $result){
            $result['Views']=1;
            $result['Updates']=1;
            $result['Deletes']=1;
            if($result['filte'] > 0){
              
                $result['childes']=$this->getchildes($result['ScrID']);
            }

            array_push($screens,$result);
        }
        return $screens;

    }
    public function getchildes($id)
    {
        $screens=[];
        $stmt =$this->Conn->prepare("SELECT * FROM childes  WHERE ScrID=:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($results  as $result){
            $result['Views']=1;
            $result['Updates']=1;
            $result['Deletes']=1;
          
                array_push($screens,$result);
            
        }
        return $screens;
    }

    public function PowersInsert($id,$date)
    {
      
        
        $id=(int)$this->id;
        $Power= $this->Conn->prepare("INSERT INTO  Power (Views,Updates,Deletes,UserID,ScrID) VALUES (:Views,:Updates,:Deletes,:UserID,:ScrID) ");
        $Power->bindValue(':UserID', $id);
        $Power->bindValue(':Views',  $date->Views);
        $Power->bindValue(':Updates', $date->Updates);
        $Power->bindValue(':Deletes',  $date->Deletes);
        $Power->bindValue(':ScrID', (int) $date->ScrID);
        $Powers= $Power->execute();
            if( $Powers){
                
            }else{
                
            }
        
    }
    public function PowersInsertChild($id,$date)
    {
        print_r($date);
        $stmt =$this->Conn->prepare("INSERT INTO PowerChiles (childID,Views,Updates,Deletes,UserID) VALUES (:childID,:Views,:Updates,:Deletes,:UserID)");
        $stmt->bindParam(':UserID', $id);
        $stmt->bindParam(':Views', $date->Views);
        $stmt->bindParam(':Updates', $date->Updates);
        $stmt->bindParam(':Deletes', $date->Deletes);
        $stmt->bindParam(':childID', $date->childID);

        $stmt->execute();
        return $stmt;
    }  
    public function getPower($id)
    {
        $Power=[];
        $stmt =$this->Conn->prepare("SELECT * FROM Power join Screens on Screens.ScrID=Power.ScrID  WHERE Power.UserID=:id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if($results)
        {
            foreach($results as $result)
            {
              
                if($result['filte'] > 0)
                {
                    $result['childes']=$this->getPowerChildesScreens($id,$result['ScrID']);
                   
                }     
                array_push($Power,$result);         

            }
          
        }
        return $Power;
        
}
public function getPowerChildesScreens($UserID, $id)
{
    $Power = [];

    $stmt = $this->Conn->prepare("SELECT  PowerChiles.PowerID, PowerChiles.Views,PowerChiles.Deletes,PowerChiles.Updates,childes.icon ,childes.Name,childes.ScrID
FROM PowerChiles INNER JOIN childes ON childes.childID=PowerChiles.childID  WHERE PowerChiles.UserID=:UserID AND childes.ScrID=:id");
    $stmt->bindParam(':UserID', $UserID);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($results) {
        foreach ($results as $result) {
   
           
                array_push($Power, $result);
            
        }
    }
    return $Power;
}



}

?>