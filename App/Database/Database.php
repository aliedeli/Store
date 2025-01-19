<?php

namespace App\Database;

use App\Controllers\session;
use PDO;

// use function PHPSTORM_META\type;

class Database
{
    private $host;
    private $prot;
    private $user;
    private $pwd;
    private $dbName;
    public $db;
  
    public function __construct()
    {
        $this->host="127.0.0.1";
        $this->prot="1433";
        $this->user='sa';
        $this->pwd='123';
        $this->dbName="Store";
      
    }
public  function conn(){

    try{

        
        $conn = new PDO("sqlsrv:server=$this->host,$this->prot; TrustServerCertificate=true; Database= $this->dbName", $this->user, $this->pwd );
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
       
        return $conn;

        }catch(\PDOException $e){
            echo 'connection error ' . $e;

            }
       

    
}
public function query($sql)
{
    $this->db=self::conn()->prepare($sql);

}

public function bind($param,$vlaue,$type=null)
{
    switch(!empty($vlaue)){
        case is_int($vlaue) :
                $type=PDO::PARAM_INT;
            break;
        case is_bool($vlaue) :
                $type=PDO::PARAM_BOOL;
             break;
        case is_string($vlaue):
                $type=PDO::PARAM_STR;
                

            
    }

    return $this->db->bindParam($param ,$vlaue ,$type);
}

public function fetchAll()  
{
  return $this->db->fetchAll(PDO::FETCH_ASSOC);

}
public function execute() 
{
    return $this->db->execute();
}

}
//  $myconn=new Database();
//  $Conn = $myconn->conn();

