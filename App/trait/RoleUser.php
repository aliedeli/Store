<?php
namespace App\trait;
use App\Database\Database;
use PDO;
trait RoleUser
{
    public $conn;
    public $UesrID;
    public function RoleUser($conn)
    {
        $this->conn=$conn;
        
    
    }
    public function Power($UserID) {
     
        $Power=[];
        $Powers=$this->conn->query("SELECT * FROM  Roles  join Power on Roles.PowerID=Power.PowerID join Screens on Power.ScrID=Screens.ScrID   Where  Roles.UserID=$UserID");
        $Powers->execute();
        $results=$Powers->fetchAll(PDO::FETCH_ASSOC);
        foreach($results as $vlaue)
        {
            //  $vlaue['screens']=$this->Screens($vlaue['ScrID']);
            array_push($Power,$vlaue);
        }
        return $Power;
    }
    public function Screens($ScrID)
    {
        $ScreenAlls=[];
        $Screen=$this->conn->query("SELECT * FROM Screens where ScrID=$ScrID ");
        $Screen->execute();
        $Screens= $Screen->fetchAll(PDO::FETCH_ASSOC);
        foreach($Screens as $vlaue)
        {   
            //   $vlaue['childe']=$this->childe($vlaue['ScrID']);
            
              array_push($ScreenAlls, $vlaue);
        }
        return $ScreenAlls;
    }

    public function childe($id)
    {
        $childes=[];
        $childe=$this->conn->query("SELECT * FROM Screens where ScrID=$id ");
        // $Screen->bindParam(':ScrID', $this->ScrID);
        $childe->execute();
        $childeall= $childe->fetchAll(PDO::FETCH_ASSOC);
        foreach($childeall as $vlaue)
        {
            array_push($childes, $vlaue);
        }
        return $childes;
    }
    

}