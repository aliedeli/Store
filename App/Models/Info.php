<?php
namespace App\Controllers;
use App\Database\Database;
use PDO;

class Info{
    public $db;
    public $name;
    public $type;
    public function __construct($conn)
    {

        $this->db=$conn->Conn();
       
       $this->name=filter_input(INPUT_POST,'name',FILTER_SANITIZE_SPECIAL_CHARS);
       $this->type=filter_input(INPUT_POST,'type',FILTER_SANITIZE_SPECIAL_CHARS);
    }
    public function getTables()
    {
        $counts=[];
        $ifno= $this->db->prepare("SELECT TABLE_NAME FROM INFORMATION_SCHEMA .TABLES
WHERE TABLE_TYPE='BASE TABLE'
AND TABLE_CATALOG='Store'  ");
        // $ifno->bindParam(':tables',$this->name,PDO::PARAM_STR);
        $ifno->execute();
        $smt= $ifno->fetchAll(PDO::FETCH_ASSOC);
        foreach($smt as $keys => $values)
        {
             if($values['TABLE_NAME'] =='sysdiagrams'  ){
               
            }
            else
            {
              
                array_push( $counts,[ 'name'=>$values['TABLE_NAME'],'conunt'=>$this->countTables($values['TABLE_NAME'])]) ;
            }
            
        }
        
        json_data($counts);
    }

    public  function countTables($name)
    {

        $ifno= $this->db->prepare("SELECT COUNT(*) as conunt FROM $name ");
        //  $ifno->bindParam(':tables',$name,PDO::PARAM_STR);
        $ifno->execute();
        $smt= $ifno->fetchAll(PDO::FETCH_ASSOC);
      
        if( $smt){
            if($smt[0]['conunt'] !=  null){
                return  $smt[0]['conunt'];
            }
        }
            
        

    }
    public function METHOD()
    {
        if($_SERVER['REQUEST_METHOD'] === "POST")
        {
            if($this->type == "tables")
            {
                $this->getTables();
            }elseif($this->type = "table")
            {
                
                json_data(["conunt"=> $this->countTables($this->name)])  ;
            }
          
        }

    }
}

$newifons =new Info(new Database);
$newifons->METHOD();
