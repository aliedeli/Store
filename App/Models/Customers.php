<?php
namespace App\Models;
use App\Database\Database;
class Customers
{
  private $cutID;
  private $fullName;
  private $Addrss;
  private $phone;
  private $type;
  private $Connt;
  public $Arr=[];
    public function __construct($Connt)
    {
        $this->Connt=$Connt->conn();

        filter_input_array(INPUT_POST,FILTER_SANITIZE_SPECIAL_CHARS);
        $this->cutID=$_POST['cutID'] ?? null;
        $this->fullName=$_POST['name'] ?? null;
        $this->Addrss=$_POST['Address'] ?? null;
        $this->phone=$_POST['phone'] ?? null;
        $this->type=$_POST['type'] ?? null;
    }

    public function insert()
    {
        $app= $this->Connt->prepare("INSERT INTO  Customers (cutID,fullName,Address,phone)  VALUES (:cutID,:fullName,:Addrss,:phone) ");
        $app->bindParam(":cutID",$this->cutID);
        $app->bindParam(":fullName",$this->fullName);
        $app->bindParam(":Addrss",$this->Addrss);
        $app->bindParam(":phone",$this->phone);
         $Chik=$app->execute();
         if($Chik)
         {
            echo json_encode(["status"=>true]);
         }
         else
         {
            echo json_encode(["status"=>false]);
         }
    }
    public function update()
    {
        $app= $this->Connt->prepare("UPDATE   Customers SET  fullName=:fullName ,Address=:Addrss , phone= :phone WHERE  cutID=:cutID  ");
        $app->bindParam(":cutID",$this->cutID);
        $app->bindParam(":fullName",$this->fullName);
        $app->bindParam(":Addrss",$this->Addrss);
        $app->bindParam(":phone",$this->phone);
         $Chik=$app->execute();
         if($Chik)
         {
            echo json_encode(["status"=>true]);
         }
         else
         {
            echo json_encode(["status"=>false]);
         }
        

    }
    public function read()
    {
        $Select=$this->Connt->query("SELECT *  FROM Customers    ORDER BY  CutID ASC  ");
        $Select->execute();
        $results=  $Select->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($results as $row)
        {
                    $row['count']=$this->CountOrder($row['CutID']);
            array_push($this->Arr , $row);
        }
        json_data($this->Arr);

    }
    public function CountOrder($id)
    {
        $Select=$this->Connt->query("SELECT count(*)  as conunt FROM Orders  where CutID=$id   ");
        $Select->execute();
         $results=  $Select->fetchAll(\PDO::FETCH_ASSOC);
        return  $results[0]['conunt'];

    }
    public function where()
    {
        $Select=$this->Connt->query("SELECT * FROM Customers where FullName LIKE '%$this->fullName%'  ");
        $Select->execute();
        $results=  $Select->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($results as $row)
        {
            array_push($this->Arr , $row);
        }
        json_data($this->Arr);

    }
    public function delete()
    {
        $delete= $this->Connt->prepare("DELETE FROM Customers WHERE CutID=:CutID");
        $delete->bindParam(":CutID",$this->cutID);
        $Chik=$delete->execute();
        if($Chik)
        {
            $this->deleteOrder() ;
           echo json_encode(["status"=>true]);
        }
        else
        {
            echo json_encode(["status"=>false]);
        }

    }
    public function deleteOrder()
    {
        $delete= $this->Connt->prepare("DELETE FROM Orders WHERE CutID=:CutID");
        $delete->bindParam(":CutID",$this->cutID);
        $Chik=$delete->execute();
        if($Chik)
        {
            echo json_encode(["status"=>true]);
        }
        else
        {
            echo json_encode(["status"=>false]);
        }
    }
    public function method()  {
        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            if($this->type == "insert")
            {
                $this->insert();

            }
            elseif($this->type == "update")
            {
                $this->update();
            }
            elseif($this->type == "read")
            {
                $this->read();
            }
            elseif($this->type == "delete")
            {
                $this->delete();
            }
            elseif($this->type == "where")
            {
                $this->where();
            }
        }
        
    }

}

$customers = new Customers(new Database);
$customers->method();