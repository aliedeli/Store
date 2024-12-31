<?php
   namespace App\Models;
    use App\Database\Database;
    use PDO;


   

class Category 
{

    public $Connt;

    public $name;
    public $if;
    public  $type;
    public $search;
    public $id;

        public function __construct($Conn)
        {
            $this->Connt=$Conn->conn();
            $this->type=filter_input(INPUT_POST,'type' , FILTER_SANITIZE_SPECIAL_CHARS);
            $this->id=filter_input(INPUT_POST,'id' , FILTER_SANITIZE_SPECIAL_CHARS);;
            $this->name=filter_input(INPUT_POST,'name' , FILTER_SANITIZE_SPECIAL_CHARS);
            $this->search=filter_input(INPUT_POST,'search' , FILTER_SANITIZE_SPECIAL_CHARS);


            

         }
   public function insert()
    {
     $app= $this->Connt->prepare("INSERT INTO  categorys (catName)  VALUES (:name) ");
    $app->bindParam(":name",$this->name);
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
        $array=[];
        // $app = $this->Connt->prepare('key', 'default')("SELECT * FROM categorys");
        $app = $this->Connt->query("SELECT * FROM categorys");
        $app->execute();
        $results=$app->fetchAll(PDO::FETCH_ASSOC);
        foreach($results as $result)
        {
            array_push($array , $result);
        }

        echo json_encode($array);

    }
    public function where()
    {
        $array=[];
        $app = $this->Connt->prepare("SELECT * FROM categorys WHERE catName LIKE  '%' + :name +'%' ");
        $app->bindParam(":name", $this->search );
        $app->execute();
        $results=$app->fetchAll(PDO::FETCH_ASSOC);
        foreach($results as $result)
        {
            array_push($array , $result);
        }
            echo json_encode($array);
        
    }
    public function update()
    {
    
        $app= $this->Connt->prepare("UPDATE categorys SET catName = :name where catID=:id ");
        $app->bindParam(":name",$this->name);
        $app->bindParam(":id",$this->id);
        $Chik=$app->execute();
        if($Chik)
        {
            echo json_encode(["status"=>true]);
        }
        else{
            echo json_encode(["status"=>false]);
        }   

    }
    public function delete()
    {
       
        $app= $this->Connt->prepare("DELETE  FROM categorys WHERE catID=:id");
        $app->bindParam(":id",$this->id,PDO::PARAM_INT);
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
    public function searchDate()
    {
         $array=[];
        $where=$this->Connt->query("SELECT* FROM Expenses WHERE  CONVERT( DATE ,CreateDate) >='$this->search'");
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
public function Chik()
{
    if($_SERVER['REQUEST_METHOD'] === "POST" )
    {
     
        if( $this->type == "insert")
        {
            $this->insert();
        }
        elseif( $this->type == "update")
        {
            $this->update();
        }
        elseif( $this->type == "delete")
        {
            $this->delete();
        }
        elseif( $this->type == "read")
        {
            $this->read();
        }
        elseif( $this->type == "where")
        {
            $this->where();
        }

    }
  
}
}

$myCategorg= new Category( new Database());
$myCategorg->Chik();

