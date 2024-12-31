<?php
 namespace App\Models;

 use App\Database\Database;
interface ILogger
{
    public function word($level,$data);

    public function info();

    public function waeing();

    public function Erroe();

}


class Logger  
{
    public $db;
    // public function __construct($conn)
    // {
           
    //     $this->db=$conn->conn();
       
        
    // }
    public function word($conn,$level,$data)

    {
        if(is_array($data))
        {
            $data=implode("/n", $data);

        }
    
        $data=$level.'=>' .$data;
      
       $word=$conn->prepare("INSERT INTO Loggers  (data) VALUES (:data)");
       $word->bindValue(":data", $data);
       $words= $word->execute();
       if( $words)
       {
       
       }
   


    }
    public function info($conn,$level,$date)
    {
        $this->word($conn,$level,$date);
    }
    public function waeing()
    {

    }
    public function Erroe()
    {

    }

}
// $logger=new Logger(new Database);
