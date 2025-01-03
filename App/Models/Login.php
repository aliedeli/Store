<?php
use App\Database\Database;
use App\trait\Role;
use SecTheater\Support\Hash;

class Login  
{
    use Role;
    private $db;
    private $username;
    private $password;
    private $type;
    public $tpyeID;

    // private $rememberMe;
    // private $rememberMeToken;
    // private $rememberMeTokenExpiration;
    public function __construct($conn)
    {
       
        $this->db=$conn->conn();
        $this->username = filter_input(INPUT_POST,"UserName",FILTER_SANITIZE_SPECIAL_CHARS);
        $this->password = filter_input(INPUT_POST,"password",FILTER_SANITIZE_SPECIAL_CHARS);
        $this->type = filter_input(INPUT_POST,"type",FILTER_SANITIZE_SPECIAL_CHARS);
      
         
    }
    public function Loingin() 
    {
       $login= $this->db->prepare("SELECT * FROM T_User WHERE UserName=:UserName");
       $login->bindParam(':UserName',$this->username,PDO::PARAM_STR);
       $login->execute();
       $result = $login->fetchAll(PDO::FETCH_ASSOC);
       if($result)
       {
            if(password_verify($this->password,$result[0]['password']))
            {
                if($result[0]['Status'] > 0)
                {
                    session_start();
                    $_SESSION['UserName']=$result[0]['UserName'] ;
                    $_SESSION['nameAll']=$result[0]['nameAll'] ;
                    $_SESSION['UserID']=$result[0]['UserID'] ;
                    $_SESSION['TpyeID']=$result[0]['TpyeID'] ;
                    
                    echo json_encode(["status"=>true]);
                  
                }else{
                    echo json_encode(["status"=>false,"message"=>'Your account is not active' ]);
                }
          
            }else{
                echo json_encode(["status"=>false,"message"=>'Invalid username or password' ]);
            }
      
            
       
       }else{
        echo json_encode(["status"=>false,"message"=>'Invalid username or password' ]);
       }
       

    }
    public function chik()
     {
        if($_SERVER['REQUEST_METHOD']=== "POST")
        {
            if($this->type == "in")
            {
            
                $this->Loingin();
            }
        }
        
    }


}
$LoginNew= new Login(new Database() );
$LoginNew->chik();
