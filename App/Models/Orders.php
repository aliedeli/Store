<?php
 
namespace Orders;
use App\trait\Accounts;
use App\Database\Database;

class Orders
{
    use Accounts;
    private $OrderID;
    private $CutID;
    private $items;
    public $FullName;
    public $db;
    public $type;
    public $search;
    public $Quantity;
    public $DalID;
    public $TypePush;
    public $total;
    public $Arr=[];
    public $amount;
    public function __construct($conn)
    {
        $this->db=$conn->conn();
        filter_input_array(INPUT_POST,FILTER_SANITIZE_SPECIAL_CHARS);
        $this->OrderID=$_POST['OrderID'] ?? null;
        $this->CutID=$_POST['CutID'] ?? null;;
        $this->type=$_POST['type'] ;
        $this->search=$_POST['search'] ?? null;;
        $this->items= $_POST['items'] ?? [];
        $this->Quantity=$_POST['Quantity'] ?? null;
        $this->DalID=$_POST['DalID'] ?? null;
        $this->FullName=$_POST['FullName'] ?? null;
        $this->TypePush=$_POST['TypePush'] ?? null;
        $this->total=$_POST['total'] ?? null;
        $this->amount=0;
        $this->Accounts($this->db);
       
    }
    public function insert()
    {
        $this->items=  json_decode( $this->items) ?? [] ;
        
        $OderAdd=$this->db->prepare("INSERT  INTO  Orders (OrdID,CutID,transaction_type,total) VALUES (:OrdID,:CutID,:type,:total) ");
        $OderAdd->bindValue(':OrdID',(int) $this->OrderID );
        $OderAdd->bindValue(':CutID',(int) $this->CutID );
        $OderAdd->bindValue(':type',(int) $this->TypePush );
        $OderAdd->bindValue(':total',(int) $this->amount);
        $Add=$OderAdd->execute();
        if($Add)
        {
             foreach($this->items as $item)
             {
                $this->Orderitem($item);
                $this->amount=$this->amount+=$item->talo;
             }
             json_data(["status"=>true]);
             $this->insertAccountTransactions($this->OrderID, 'Order', $this->amount);
        }



    }
    public function Orderitem($data)
    {
       
        $Orderitem=$this->db->prepare("INSERT INTO OederIems (DalID,name,OdrID,itemID,Price,Discount,Quantity,total)   VALUES (:DalID,:name,:OdrID,:itemID,:Price,:Discount,:Quantity,:total) ");
        $Orderitem->bindValue(':DalID',(int) $data->DalID);
        $Orderitem->bindValue(':name',  $data->name );
        $Orderitem->bindValue(':OdrID',(int) $this->OrderID );
        $Orderitem->bindValue(':itemID',(int) $data->itemID );
        $Orderitem->bindValue(':Price',(int) $data->price );
        $Orderitem->bindValue(':Discount',(int) $data->discount );
        $Orderitem->bindValue(':Quantity',(int) $data->Quantity );
        $Orderitem->bindValue(':total',(int) $data->talo );
        $Add=$Orderitem->execute();
        if($Add)
        {
            echo json_encode(["status"=>true]);
        }
    }
    public function UPOrderitem()
    {
       
        $up=$this->db->prepare('UPDATE OederIems SET Quantity=:Quantity  where DalID=:DalID');
        $up->bindValue(":Quantity",$this->Quantity);
        $up->bindValue(":DalID",$this->DalID);
        $update= $up->execute();
        if($update)
        {
            json_data(["status"=>true]);
        }
        else
        {
            json_data(["status"=>false]);
        }
    }
    public function read()
    {
        
        $read=$this->db->query('SELECT * FROM  Customers JOIN   Orders ON Customers.cutID=Orders.CutID   ORDER BY Orders.OrdID ASC ');
        $read->execute();
        $results=  $read->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($results as $row)
        {


            $row['Items']= $this->OrderIems($row['OrdID']);
            array_push($this->Arr , $row);
        }
       json_data($this->Arr);
    }
    public function OrderIems($id)
    {
     
        $Arr=[];
        $read=$this->db->query("SELECT * FROM OederIems where OdrID=$id  ");
        $read->execute();
        $results=  $read->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($results as $row)
        {
               
            array_push($Arr , $row);
        }
      return $Arr;
    }
    public function DeleteItemOrders()
    {
        $dete=$this->db->query("DELETE  FROM  OederIems WHERE OrdID=$this->OrderID ");
        $read=$dete->execute();
        if($read)
        {
            json_data(["status"=>true]);

        }
        else
        {
            json_data(["status"=>false]);
        }
    }
    public function where()
    {
        $read=$this->db->query("SELECT * FROM  Customers JOIN   Orders ON Customers.cutID=Orders.CutID   where FullName like '%$this->FullName%' ");
        $read->execute();
        $results=  $read->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($results as $row)
        {


            $row['Items']= $this->OrderIems($row['OrdID']);
            array_push($this->Arr , $row);
        }
       json_data($this->Arr);
    }
    public function Delete()
    {
        $dete=$this->db->query("DELETE  FROM  Orders WHERE OrdID=$this->OrderID ");
        $read=$dete->execute();
        if($read)
        {
            json_data(["status"=>true]);

        }
        else
        {
            json_data(["status"=>false]);
        }
    }
    public function DeleteOrderIems()
    {
        $dete=$this->db->query("DELETE  FROM  OederIems WHERE DalID=$this->DalID ");
        $read=$dete->execute();
        if($read)
        {
            json_data(["status"=>true]);

        }
        else
        {
            json_data(["status"=>false]);
        }
    }
    public function searchDate()
    {
         $array=[];
        $where=$this->db->query("SELECT * FROM  Customers JOIN   Orders ON Customers.cutID=Orders.CutID   where   CONVERT( DATE ,Cerate_Date) >='$this->search'");
        $where->execute();
        $results=$where->fetchAll(\PDO::FETCH_ASSOC);;
        if($results)
        {
          foreach($results as $row)
          {
            array_push($array,$row);
          }
          json_data($array);
        }
        else
        {
          $this->read();
        }
    }
    public function METHOD()
    {
       
        if($_SERVER['REQUEST_METHOD'])
        {
           
            if($this->type== 'insert'){
                $this->insert();
            }
            elseif($this->type == "read")
            {
                $this->read();
            }
            elseif($this->type == "delete")
            {
                $this->Delete();
            }
            elseif($this->type == "upItems")
            {
                $this->UPOrderitem();
            }
            elseif($this->type == "deleteItems")
            {
                $this->DeleteOrderIems();
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

$Order=new Orders(new Database());
$Order->METHOD();

