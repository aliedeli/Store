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
        // ini_set('session.save_path', $this->sessionSavePath);
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
         header('Location:/login.php');
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
        return $_SESSION[$key];
    }
    
    public function unset($key)
    {
        unset($_SESSION[$key]);
       
    }


}


