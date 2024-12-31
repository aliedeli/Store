<?php
namespace App\Models;
use App\Database\Database;
use PDO;

class Brands
{
    public $db;
    public $arr;
    public $name;
    public $id;
    public $search;
    public $type;
    public function __construct()
    {
        $this->db = (new Database())->conn();
        $this->arr = [];
        $this->type = filter_input(INPUT_POST, "type", FILTER_SANITIZE_SPECIAL_CHARS);
        $this->name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
        $this->id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_SPECIAL_CHARS);
        $this->search = filter_input(INPUT_POST, "search", FILTER_SANITIZE_SPECIAL_CHARS);
        $this->METHOD();

    }
    public  function getBrands()
    {
        
        $stmt = $this->db->prepare("SELECT * FROM Brands");
        $stmt->execute();
        $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($brands as $brand){
              array_push($this->arr, $brand);
            }
        json_data($this->arr);
    }

    public  function insert()
    {
        $stmt = $this->db->prepare("INSERT INTO Brands (brandName) VALUES (?)");
        
        if($stmt->execute([$this->name]))
        {
            json_data( ['status'=>true, "Brand Added Successfully"]);
        }else{
            json_data( ['status'=>false, "Brand Not Added Successfully"]);
        }
        
    }

    public  function deleteBrand()
    {
        $stmt = $this->db->prepare("DELETE FROM Brands WHERE branID = ?");
        if($stmt->execute([$this->id]))
        {
            json_data(['status'=>true ,"Brand Deleted Successfully"]);
        }else{
            json_data(['status'=>false ,"Brand Not Deleted Successfully"]);
        }
      
    }
    public  function updateBrand()
    {
        $stmt = $this->db->prepare("UPDATE Brands SET brandName = ? WHERE branID = ?");
            if($stmt->execute([$this->name, $this->id]))
            {
                json_data("Brand Updated Successfully");    
            }
            else{
                json_data("Brand Not Updated Successfully");
            }
       
    }
    public function searchBrand()
    {
        $stmt = $this->db->prepare("SELECT * FROM Brands WHERE brandName LIKE ?");
        $stmt->execute(["%$this->search%"]);
        $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
        json_data($brands);
    }
    public function searchDateBrand()
    {
        $stmt = $this->db->prepare("SELECT * FROM Brands WHERE  CONVERT( DATE ,Create_date) >= ?");
        $stmt->execute([$this->search]);
        $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($brands as $brand){
            array_push($this->arr, $brand);
          }
        json_data($this->arr);
    }
    public function METHOD()
    {
        if($_SERVER['REQUEST_METHOD'] === "POST")
        {
            if($this->type === "read")
            {
                self::getBrands();
            }
            elseif($this->type === "insert")
            {
                self::insert();
            }
            elseif($this->type === "delete")
            {
                self::deleteBrand();
            }
            elseif($this->type === "update")
            {
                 self::updateBrand();
            }
            elseif($this->type === "where")
            {
                self::searchBrand();
            }
            elseif($this->type === "search"){
                self::searchDateBrand();
            }
        }
       
    }
}
new Brands();

 // $data = json_decode(file_get_contents("php://input"));