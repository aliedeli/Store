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
        $this->total=0;
        $stmt = $this->db->prepare("SELECT total FROM Orders");
        $stmt->execute();
        $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($brands as $brand){
              $this->total+=$brand['total'];
            }
          return $this->total;
            
    }
    public function expenses() {
        $this->total=0;
        $stmt = $this->db->prepare("SELECT Amount FROM MonthlyExpenses");
        $stmt->execute();
        $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($brands as $brand){
              $this->total+=$brand['Amount'];
            }
        return $this->total;
            
    }
    public function Accounts() {
        $this->total=0;
        $stmt = $this->db->prepare("SELECT balance FROM Accounts");
        $stmt->execute();
        $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($brands as $brand){
              $this->total+=$brand['balance'];
            }
           return  $this->total;

    }
    public function total()
    {
        $this->arr = [
            'orders' => (int) self::Orders(),
            'expenses' => self::expenses(),
            'accounts' => self::Accounts()
        ];
        echo json_encode($this->arr);
    }
    public function METHOD()
    {
        if($_SERVER['REQUEST_METHOD'] === "POST")
        {

            if($this->type == "total")
            {
                self::total();
            }
            elseif ($this->type == "orders")
            {
                self::Orders();
            }
            elseif ($this->type == "expenses")
            {
              
                self::expenses();
            } 
            elseif ($this->type == "accounts")
            {
                self::Accounts();
            }
        }
       
      }
    
}

new AotuTatol();