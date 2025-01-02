<?php
namespace App\Models;
use App\Database\Database;
use App\trait\Accounts;
use PDO;
class Account
{
    use Accounts;
    private $conn;
    private $accountID;
    private $accountName;
    private $accountType;
    private $balance;
    private $amount;
    private $description;
    private $createdAt;
    private $updatedAt;
    private $type;
    private $arr = [];
    public function __construct()
    {
        $this->conn = (new Database())->conn();
        filter_input_array(INPUT_POST,  FILTER_SANITIZE_SPECIAL_CHARS);
        $this->accountName = filter_input(INPUT_POST, "account_name");
        $this->accountType = filter_input(INPUT_POST, "account_type");
        $this->balance = filter_input(INPUT_POST, "balance");
        $this->description = filter_input(INPUT_POST, "description");
        $this->amount = filter_input(INPUT_POST, "amount");
        $this->createdAt = date('Y-m-d H:i:s');
        $this->updatedAt = date('Y-m-d H:i:s');
        $this->type = filter_input(INPUT_POST, "type");
        $this->METHOD();

    }
    public function insertAccounts()
    {
        $sql = "INSERT INTO Accounts (account_name,account_type,balance) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
      
            if(  $stmt->execute([$this->accountName, $this->accountType, $this->balance]))
            {
                return true;
            }
            else
            {
                return false;

            }
        $this->accountID = $this->conn->lastInsertId();
    }
    public function insertAccountTransactions()
    {
        $sql = "INSERT INTO AccountTransactions (account_id, transaction_type, amount) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([ $this->accountID,  $this->accountType , $this->amount ]);
        $this->accountID = $this->conn->lastInsertId();
    }
    public function createAccount()
    {
        if($this->insertAccounts())
        {
            // $this->insertAccountTransactions($this->accountID, "debit", $this->balance);
            return true;
        }
        else
        {
            return false;
        }

    }
    public function updateAccount()
    {

    }
    public function read()
    {
        $sql = "SELECT * FROM Accounts";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($accounts as $account)
        {
            array_push($this->arr, $account);
        }
        json_data($this->arr);
    }
    public function METHOD()
    {
        if($_SERVER['REQUEST_METHOD'] === "POST")
        {
           
            if( $this->type == "create")
            {
                $this->insertAccounts();
            }elseif($this->type == "update")
            {
                $this->updateAccount($_POST);
            }elseif($this->type == "delete")
            {
                $this->deleteAccount($_POST);
            }
            elseif($this->type == "read")
            {
               
                $this->read();
            }
        }
    }
}
new Account();