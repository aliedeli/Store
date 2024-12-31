<?php
namespace App\trait;

use App\Database\Database;
use PDO;

trait Accounts 
{
    private $conn;
    private $accountID;
    private $accountName;
    private $accountType;
    private $balance;
    private $description;
    private $createdAt;
    private $updatedAt;
    
    public function Accounts($conn)
    {
        $this->conn = $conn;
    }

    public function insertAccounts($name, $type)
    {
        $sql = "INSERT INTO Accounts (account_name,account_type,balance) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$this->accountName, $this->accountType, $this->balance]);
        $this->accountID = $this->conn->lastInsertId();
    }

    public function insertAccountTransactions($id, $type, $amount)
    {
        $sql = "INSERT INTO AccountTransactions (order_id, transaction_type, amount) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id, $type, $amount]);
        $this->accountID = $this->conn->lastInsertId();
    }
 
    public function createAccount($data)
    {
     
    }

    public function updateAccount($id, $data)
    {

    }

    public function deleteAccount($id)
    {

    }

    public function updateBalance($id, $amount)
    {
 
    }
}
