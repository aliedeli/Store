<?php
namespace App\Controllers;

use SessionHandler;

// session_start();
// function session()
// {
//     if(!empty($_SESSION))
//     {
        
//     }
//     else
//     {
//         header('Location:/login.php');
//     }
// }

class session extends SessionHandler
{
    private $sessionNmae='MYSESSION';
    private $sessionMaxTime=0;
    private $sessionSSL=false;
    private $sessionTimeOut=0;
    private $sessionPath='/';
    private $sessionDomain= 'localhost';
    private $sessionSavePath='';
    private $sessionSecure=false;
    private $sessionHttpOnly=true;
    private $sessionCipher='AES-256-CBC';
    private $sessionCipherKey='my_secret_key';

    public function __construct()
    {
        $this->sessionDomain = $_SERVER['HTTP_HOST'];
        $this->sessionSavePath =base_path() .'App/Controllers/sessions';
        
         ini_set('session.use_cookies', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.use_trans_sid', 0);
        ini_set('session_save_handler', 'files');
        session_name($this->sessionNmae);
        session_save_path($this->sessionSavePath);
        session_set_cookie_params(
            $this->sessionMaxTime,
            $this->sessionPath,
            $this->sessionDomain,
            $this->sessionSSL,
            $this->sessionHttpOnly);
            session_set_save_handler(
            $this,
            true
        );
    }
    public function revomeSession(){

      
     
         unlink($this->sessionSavePath.'sess_po'.session_id());
         session_destroy();
         header('Location:/login');
    }
    public static function start()  {
        if('' === session_id())
        {
            return session_start();
        }
    }
    public function set($key,$vlaue)
    {
        $_SESSION[$key] = $vlaue;
     

    }

    public function has($key) 
    {
        return isset( $_SESSION[$key])  ? true : false ;
    }
    public function get($key)
    {
        return $_SESSION[$key] ? $_SESSION[$key] : null ;
    }
    
    public function unset($key)
    {
        unset($_SESSION[$key]);
       
    }
    
public function createToken($length = 32) {
    $token = bin2hex(random_bytes($length));
    $this->set('token', $token);
    $this->set('token_time', time());
    return $token;
}

public function validateToken($token) {
    if (!$this->has('token')) {
        return false;
    }
    
    $storedToken = $this->get('token');
    $tokenTime = $this->get('token_time');
    $tokenTimeout = 10; // 1 hour timeout
    
    if (time() - $tokenTime > $tokenTimeout) {
        $this->unset('token');
        $this->unset('token_time');
        return false;
    }
    
    return hash_equals($storedToken, $token);
}
}
$session=new session();

if( !$session->has('token'))
{
  
}else{
    $token = $session->get('token');
    if(!$session->validateToken($token))
    {
      
    }else{
        $session->revomeSession();
    }
}
