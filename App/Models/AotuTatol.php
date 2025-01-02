<?php
namespace App\Models;
use App\Database\Database;
use PDO;


class AotuTatol  
{
    public $type;
    public $db;
    public $arr;
    public $total;
    public function __construct()
    {
        $this->db= (new Database())->conn();
        $this->total=0;
        $this->type=$_POST['type'];
        self::METHOD();

    }
    public function Orders()  {
        $stmt = $this->db->prepare("SELECT total FROM Orders");
        $stmt->execute();
        $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($brands as $brand){
              $this->total+=$brand['total'];
            }
            json_data(['total'=>$this->total]);
            
    }
    public function expenses() {
        $stmt = $this->db->prepare("SELECT Amount FROM MonthlyExpenses");
        $stmt->execute();
        $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($brands as $brand){
              $this->total+=$brand['Amount'];
            }
            json_data(['total'=>$this->total]);
            
    }

    public function METHOD()
    {
        if($_SERVER['REQUEST_METHOD'] === "POST")
        {

            if($this->type == "orders")
            {
                self::Orders();
            }
            elseif ($this->type == "expenses")
            {
              
                self::expenses();
            } 
        }
       
      }
    
}

new AotuTatol();