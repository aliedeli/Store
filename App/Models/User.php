<?php

 namespace App\User;

use App\Database\Database;
use App\Models\Logger;
use App\trait\Role;
use App\trait\Screens;
use PDO;
// require_once __DIR__ . '/../../vendor/autoload.php';
// require_once __DIR__ . '/../../routes/wed.php';

session_start();

Class User 
{
    use Role;
    use Screens;
    private $db;
    private $Database;
    private $id;
    private $name;
    private $UserName;
    private $email;
    private $password;
    private $activeUser;
    public $type;
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
    public $Status;
    





    public function __construct($conn)
    {
      
        $this->db=$conn->Conn();
        
        $this->name=filter_input(INPUT_POST,'name',FILTER_SANITIZE_SPECIAL_CHARS) ?? NULL;
        $this->UserName=filter_input(INPUT_POST,'UserName',FILTER_SANITIZE_SPECIAL_CHARS) ?? NULL;;
        $this->id=(int) filter_input(INPUT_POST,'UserID',FILTER_SANITIZE_SPECIAL_CHARS) ?? NULL;
        $this->email=filter_input(INPUT_POST,'email',FILTER_SANITIZE_SPECIAL_CHARS) ?? NULL;
        $this->password=filter_input(INPUT_POST,'password',FILTER_SANITIZE_SPECIAL_CHARS) ?? NULL;
        $this->password= password_hash( $this->password,PASSWORD_BCRYPT) ?? null;
        $this->userGender=filter_input(INPUT_POST,'gender',FILTER_SANITIZE_SPECIAL_CHARS) ?? null;
        $this->UserType=filter_input(INPUT_POST,'tpyeUser',FILTER_SANITIZE_NUMBER_INT) ?? null;
        $this->userGender == "Male" ? "M" : "F" ;
        $this->type=filter_input(INPUT_POST,'type',FILTER_SANITIZE_SPECIAL_CHARS) ?? null;
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
        $this->Status=filter_input(INPUT_POST,'status',FILTER_SANITIZE_SPECIAL_CHARS) ?? null;

       
        $this->Role($this->db);
       
    }

    public function insert()
    { 
   

    

      
          $User=$this->db->prepare("INSERT INTO T_User (UserID,nameAll,UserName,password,email,TpyeID,userBirthdate,userGender,created_at )  VALUES
           (:UserID,:name,:UserName,:password,:email,:TpyeID,GETDATE(),:userGender,:created_at)");
        $User->bindValue(':UserID', $this->id);
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
                   
                    $this->PowersInsert($this->id,$vlaue);
                   if((int) $vlaue->filte  > 0){
                    
                    foreach($vlaue->childes as  $Child){

                        $this->PowersInsertChild($this->id,$Child);
                    
                }
            }
                    
                }
              json_data(["status"=>true]);

            }else
            {
                json_data(["status"=>false]);
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
            
            // $vlaues['Powers']=$this->Power($vlaues['UserID']);
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
    public function  UpdateStatus()  {
        
        $sql=$this->db->prepare("UPDATE T_User SET Status=:Status where UserID=:UserID");
        $sql->bindValue(':Status', $this->Status );
        $sql->bindValue(':UserID',  $this->id );
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
       json_data($this->getScreens())  ;
    }

    public function Chik()
    {
        if($_SERVER['REQUEST_METHOD'] === "POST")
        {
            
        
            if($this->type == "insert")
            {
             
                   $this->insert();
                
            }
            elseif($this->type == "update")
            {

            }
            elseif($this->type == "read")
            {
                $this->read();
            }
            elseif($this->type == "delete")
            {
                $this->RolesDelete();
            }
            elseif($this->type == "Screen")
            {
                 $this->CreateScreen();
            }
            elseif($this->type =='Powers')
            {
                 $this->PowersUpdate();
            }
            elseif($this->type== 'ScreenUser')
            {
                $this->ScreensUser();
            }
            elseif($this->type == 'where'){
                $this->Where();
            }
            elseif($this->type == 'active'){
                $this->active();
            }
            elseif($this->type == 'FullScreens')
            {
                $this->ScreenAll();

            }
            elseif($this->type == 'Status')
            {
              
                 $this->UpdateStatus();
            }
        }
    }
}


$user=new User( new Database());
$user->Chik();
//   $user->Roles(1,new Database());


