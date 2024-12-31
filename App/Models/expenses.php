<?php
namespace App\Models\Expenses;
use App\Database\Database;
use App\Models\Logger;
session_start();
class Expenses extends Logger
{
    private $Conn;
    private $id;
    private $Category;
    private $Description;
    private $Amount;
    private $PaymentMethod;
    private $ExpenseDate;
    private $search;
    private $Arr;
    private $type;
    public function __construct($conn)
    {
        $this->Arr=[];
        $this->Conn=$conn->conn();
        filter_input_array(INPUT_POST,FILTER_SANITIZE_SPECIAL_CHARS);
        $this->id=$_POST['id'] ?? null;
        $this->Category=$_POST['Category'] ?? null;
        $this->Description= $_POST['Description'] ?? null;
        $this->Amount=$_POST['Amount'] ?? null;
        $this->PaymentMethod=$_POST['PaymentMethod'] ?? null;
        $this->ExpenseDate=$_POST['ExpenseDate'] ?? null;
        $this->search=$_POST['search'] ?? null;
        $this->type=$_POST['type'] ?? null;

        $this->Method();
    }
    public function insert()
    {

     $app= $this->Conn->prepare("INSERT INTO MonthlyExpenses (ExpenseDate,Category,Description,Amount,PaymentMethod,IsRecurring,UserCreateID) VALUES  (:ExpenseDate, :Category, :Description, :Amount, :PaymentMethod, :IsRecurring,:UserCreateID)");
     $app->bindValue(":ExpenseDate",$this->ExpenseDate);
     $app->bindValue(":Category",$this->Category);
     $app->bindValue(":Description",$this->Description);
     $app->bindValue(":Amount",$this->Amount);
     $app->bindValue(":PaymentMethod",$this->PaymentMethod);
     $app->bindValue(":IsRecurring",0);
     $app->bindValue(":UserCreateID",(int) $_SESSION['UserID']);
     $Chik=$app->execute();
     if($Chik)
     {
       self::info($this->Conn,'Expenses','Add new Expenses ' .$this->Category . ' ' .$this->Description . ' ' .$this->Amount . ' ' .$this->PaymentMethod);
        echo json_encode(["status"=>true]);
     }
     else
     {
        echo json_encode(["status"=>false]);
     } 


    }
    public function read()
    {
        $read = $this->Conn->query("SELECT * FROM MonthlyExpenses ");
        $read->execute();
        $results=$read->fetchAll(\PDO::FETCH_ASSOC);
        foreach($results as $result)
        {
            array_push($this->Arr , $result);
        }
    
        
      echo  json_encode( $this->Arr);

    }
    public function update()  {
        $up = $this->Conn->prepare("UPDATE MonthlyExpenses SET Category=:Category,Description=:Description,Amount=:Amount,PaymentMethod=:PaymentMethod,IsRecurring=:IsRecurring,LastModified=:LastModified,UserCreateID=:UserCreateID WHERE ExpenseID=:id");
        $up->bindValue(":id", $this->id);
        $up->bindValue(":Category",$this->Category);
        $up->bindValue(":Description",$this->Description);
        $up->bindValue(":Amount", $this->Amount);
        $up->bindValue(":PaymentMethod",$this->PaymentMethod);
         $up->bindValue(":IsRecurring",0);
         $up->bindValue(":LastModified",date("Y-m-d H:i:s"));
         $up->bindValue(":UserCreateID",(int) $_SESSION['UserID']);

        $Chik=$up->execute();
      $Chik=$up->execute();
      if($Chik)
      {
        self::info($this->Conn,'Expenses','Update new Expenses ' .$this->Category   .$this->Description   .$this->Amount   .$this->PaymentMethod);

         echo json_encode(["status"=>true]);
      }
      else
      {
         echo json_encode(["status"=>false]);
      }
 
 
        
    }
    public function Delete()  {
      $dete=$this->Conn->query("DELETE  FROM  MonthlyExpenses WHERE ExpenseID=$this->id ");
        $read=$dete->execute();
        if($read)
        {
          self::info($this->Conn,'Expenses',' delete Expenses ' .$this->id );
            json_data(["status"=>true]);

        }
        else
        {
            json_data(["status"=>false]);
        }
    }
    public function where()
    {
      $where=$this->Conn->query("SELECT * FROM MonthlyExpenses WHERE Category like '%$this->search%' or Description like '%$this->search%' or Amount like '%$this->search%' or PaymentMethod like '%$this->search%' ");
      $where->execute();
      $results=$where->fetchAll(\PDO::FETCH_ASSOC);;
      if($results)
      {
        foreach($results as $row)
        {
          array_push($this->Arr,$row);
        }
        json_data($this->Arr);
      }
      else
      {
        $this->read();
      }
    }  
    public function searchDate()
    {
      
      $where=$this->Conn->query("SELECT* FROM MonthlyExpenses WHERE  CONVERT( DATE ,ExpenseDate) BETWEEN '$this->search' AND '$this->search'");
      $where->execute();
      $results=$where->fetchAll(\PDO::FETCH_ASSOC);;
      if($results)
      {
        foreach($results as $row)
        {
          array_push($this->Arr,$row);
        }
        json_data($this->Arr);
      }
      else
      {
        $this->read();
      }
    }  
  public function Total_Accounts()
{
    $total=$this->Conn->query("SELECT SUM(Amount) as Total FROM MonthlyExpenses WHERE  CONVERT( DATE ,ExpenseDate) BETWEEN '$this->search' AND '$this->search'");
  $total->execute();
  $results=$total->fetchAll(\PDO::FETCH_ASSOC);
  if($results)
  {
    foreach($results as $row)
    {
      array_push($this->Arr,$row);
    }
    json_data($this->Arr);
  }
  else
  {
    $this->read();
  }

}
    public function Method()
    {
        if($_SERVER['REQUEST_METHOD'])
        {
         
          if($this->type == "read")
          {
            $this->read();
          }
         
          elseif($this->type == "insert")
          {
           $this->insert();

          }
          elseif($this->type == "update")
          {
          
             $this->update();
          }
          elseif($this->type == "delete")
          {
            $this->Delete();
          }
          elseif($this->type == "where")
          {
            $this->where();
          }
          elseif($this->type == "searchDate")
          {
           
             $this->searchDate();
          }
        }
    }
   
}

$expenses= new Expenses(new Database);

