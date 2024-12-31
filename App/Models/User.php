<?php

 namespace App\User;

use App\Database\Database;
use App\Models\Logger;
use App\trait\Role;
use App\trait\RoleUser;
use PDO;
// require_once __DIR__ . '/../../vendor/autoload.php';
// require_once __DIR__ . '/../../routes/wed.php';

session_start();

Class User 
{
    use Role;
    use RoleUser;
    private $db;
    private $Database;
    private $id;
    private $name;
    private $UserName;
    private $email;
    private $password;
    private $activeUser;
    public $tpye_M;
    private $userGender;
    public $UserID;
    public $UserType;
    public $UesrTypeID;
    public $PowerID;
    public $Views;
    public $Updates;
    public $Deletes;
    public $Power;
    public $search;
    





    public function __construct($conn)
    {
      
        $this->db=$conn->Conn();
        
        $this->name=filter_input(INPUT_POST,'name',FILTER_SANITIZE_SPECIAL_CHARS) ?? NULL;
        $this->UserName=filter_input(INPUT_POST,'UserName',FILTER_SANITIZE_SPECIAL_CHARS) ?? NULL;;
        $this->id=filter_input(INPUT_POST,'UserID',FILTER_SANITIZE_SPECIAL_CHARS) ?? NULL;
        $this->email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_SPECIAL_CHARS) ?? NULL;
        $this->password=filter_input(INPUT_POST,'password',FILTER_SANITIZE_SPECIAL_CHARS) ?? NULL;
        $this->password= password_hash( $this->password,PASSWORD_BCRYPT) ?? null;
        $this->userGender=filter_input(INPUT_POST,'gender',FILTER_SANITIZE_SPECIAL_CHARS) ?? null;
        $this->UserType=filter_input(INPUT_POST,'tpyeUser',FILTER_SANITIZE_NUMBER_INT) ?? null;
        $this->userGender == "Male" ? "M" : "F" ;
        $this->tpye_M=filter_input(INPUT_POST,'type',FILTER_SANITIZE_SPECIAL_CHARS) ?? null;
        $this->UesrID=$_SESSION['UserID'];
        $this->UesrTypeID=$_SESSION['TpyeID'];
        $this->Power=filter_input(INPUT_POST,'Power') ?? null;
        $this->Power=json_decode($this->Power);
        $this->search==filter_input(INPUT_POST,'search',FILTER_SANITIZE_SPECIAL_CHARS) ?? null;
        $this->PowerID=filter_input(INPUT_POST,'powerID',FILTER_SANITIZE_SPECIAL_CHARS) ?? null;
        $this->Views=filter_input(INPUT_POST,'views',FILTER_SANITIZE_SPECIAL_CHARS) ?? null;
        $this->Updates=filter_input(INPUT_POST,'updates',FILTER_SANITIZE_SPECIAL_CHARS) ?? null;
        $this->Deletes=filter_input(INPUT_POST,'deletes',FILTER_SANITIZE_SPECIAL_CHARS) ?? null;
        $this->activeUser=filter_input(INPUT_POST,'active',FILTER_SANITIZE_SPECIAL_CHARS) ?? null;
        $this->Role($this->db);
        $this->RoleUser($this->db);
    }

    public function insert()
    { 
   

          $User=$this->db->prepare("INSERT INTO T_User (UserID,nameAll,UserName,password,email,TpyeID,userBirthdate,userGender,created_at )  VALUES
           (:UserID,:name,:UserName,:password,:email,:TpyeID,GETDATE(),:userGender,:created_at)");
        $User->bindValue(':UserID', (int)$this->id);
        $User->bindValue(':name',$this->name);
        $User->bindValue(':UserName',$this->UserName);
        $User->bindValue(':email',$this->email);
        $User->bindValue(':password',$this->password);
        $User->bindValue(':TpyeID',$this->UserType);
        $User->bindValue(':userGender','M');
        $User->bindValue(':created_at', '');
        $addUser= $User->execute();
            if($addUser)
            {   
     
           
                foreach($this->Power as  $vlaue){
                    
                    $this->PowersInsert($vlaue);
                    
                }
              json_data(["status"=>true]);

            }else
            {
                json_data(["status"=>false]);
            }
     }
    public function PowersInsert($date)
    {
       $id= uniqid();

        $Power= $this->db->prepare("INSERT INTO  Power (PowerID,Views,Updates,Deletes,ScrID) VALUES (:PowerID,:Views,:Updates,:Deletes,:ScrID) ");
         $Power->bindValue(':PowerID', $id);
        $Power->bindValue(':Views',  $date->Views);
        $Power->bindValue(':Updates', $date->Updates);
        $Power->bindValue(':Deletes',  $date->Deletes);
        $Power->bindValue(':ScrID', (int) $date->ScrID);
        $Powers= $Power->execute();
            if( $Powers){
                 $this->RolesPowers($id);
            }else{
                
            }
    }    

    public function RolesPowers($id)
    {
        $RoleID= uniqid();
        $Roles= $this->db->prepare("INSERT INTO  Roles (RoleID,PowerID,UserID) VALUES (:RoleID,:PowerID,:UserID) ");
         $Roles->bindValue(':RoleID', $RoleID);
        $Roles->bindValue(':PowerID',$id);
        $Roles->bindValue(':UserID', $this->id);
        $Roless= $Roles->execute();
            if( $Roless){
                
            }else{
                
            }

    }
    public function ScreensUser()
    {
        $users=[];
        $user= $this->db->query("Select * from Power JOIN  Screens on Power.ScrID=Screens.ScrID   ");
        $user->execute();
         $read=$user->fetchAll(PDO::FETCH_ASSOC);
         foreach($read as  $vlaues)
         {
             
             array_push($users,$vlaues);
         }
        
            echo json_encode($users);
    }
    public function read()
    {
        $users=[];
       $user= $this->db->query("SELECT * FROM T_User join T_tpyeUser on T_User.TpyeID=T_tpyeUser.TpyeID  ORDER BY T_User.UserID ASC   ");
       $user->execute();
        $read=$user->fetchAll(PDO::FETCH_ASSOC);
        foreach($read as  $vlaues)
        {
            
            $vlaues['Powers']=$this->Power($vlaues['UserID']);
            array_push($users,$vlaues);
        }
       
           echo json_encode($users);
        //   json_data($users);
    }
    public function RolesDelete()
    {
       $dele=  $this->db->prepare("DELETE  FROM Roles WHERE UserID=$this->id");
    //    $dele->bindParam(':UserID',(int) $this->id);
       $Deletes=$dele->execute();
        if( $Deletes)
        {
            $this->UserDelete();
            $PowerID=json_decode($this->PowerID);
            foreach($PowerID as $id){
                $this->PowersDelete($id);
            }
         
        }
       
    }
    public function PowersDelete($id)
    {
        $dele=  $this->db->prepare("DELETE  FROM Power WHERE PowerID=:PowerID");
        $dele->bindParam(':PowerID',$id);
        $Deletes=$dele->execute();
         if( $Deletes)
         {
            
 
         }

    }
    public function UserDelete()
    {
        $dele= $this->db->prepare("DELETE  FROM T_User WHERE UserID=$this->id");

        $Deletes=$dele->execute();
         if( $Deletes)
         {
            json_data(["status"=>true]);
 
         }else{
            json_data(["status"=>false]);
         }

    }
    public function CreateScreen()
    {

        $this->getRole($this->UesrID,$this->UesrTypeID) ;
          
    }
   
    public function PowersUpdate()
    {
      
        $Power= $this->db->prepare("UPDATE   Power SET Views=:Views , Updates=:Updates ,Deletes=:Deletes WHERE PowerID =:PowerID");
        $Power->bindParam(':PowerID',  $this->PowerID);
        $Power->bindParam(':Views',  $this->Views);
        $Power->bindParam(':Updates', $this->Updates);
        $Power->bindParam(':Deletes',  $this->Deletes);
        $Powers= $Power->execute();
            if( $Powers){
                json_data(["status"=>true,'msg'=> "stor Inserted Successfully "]);
            }else{
                json_data(["status"=>false,'msg'=> "stor Inserted Successfully "]);
            }
    } 
    public function  Where()  {
      
        $users=[];
        $user= $this->db->query("SELECT * FROM T_User join T_tpyeUser on T_User.TpyeID=T_tpyeUser.TpyeID  where  UserName like '%$this->search%' ");
        $user->execute();
         $read=$user->fetchAll(PDO::FETCH_ASSOC);
         foreach($read as  $vlaues)
         {
            $vlaues['Powers']=$this->Power($vlaues['UserID']);
             array_push($users,$vlaues);
         }
        
            echo json_encode($users);
    }   
    public function active()
    {
       
        $sql=$this->db->prepare("UPDATE T_User SET active=:active where UserID=:UserID");
        $sql->bindValue(':active', $this->activeUser );
        $sql->bindValue(':UserID',  $this->UesrID );
        $results= $sql->execute();
        if($results)
        {
            json_data(["status"=>true]);
        }
        else
        {
            json_data(["status"=>false]);
        }

    }
    public function ScreenAll()
    {
        $users=[];
        $user= $this->db->query("SELECT  * FROM   Screens  ORDER BY  ScrID ASC   ");
        $user->execute();
         $read=$user->fetchAll(PDO::FETCH_ASSOC);
         foreach($read as  $vlaues)
         {
             
             array_push($users,$vlaues);
         }
        
            echo json_encode($users);        
    }

    public function Chik()
    {
        if($_SERVER['REQUEST_METHOD'] === "POST")
        {
            
        
            if($this->tpye_M == "insert")
            {
                 $this->insert();
                
            }
            elseif($this->tpye_M == "update")
            {

            }
            elseif($this->tpye_M == "read")
            {
                $this->read();
            }
            elseif($this->tpye_M == "delete")
            {
                $this->RolesDelete();
            }
            elseif($this->tpye_M == "Screen")
            {
                 $this->CreateScreen();
            }
            elseif($this->tpye_M =='Powers')
            {
                 $this->PowersUpdate();
            }
            elseif($this->tpye_M== 'ScreenUser')
            {
                $this->ScreensUser();
            }
            elseif($this->tpye_M == 'where'){
                $this->Where();
            }
            elseif($this->tpye_M == 'active'){
                $this->active();
            }
            elseif($this->tpye_M == 'FullScreens')
            {
                $this->ScreenAll();

            }
        }
    }
}


$user=new User( new Database());
$user->Chik();
//   $user->Roles(1,new Database());


