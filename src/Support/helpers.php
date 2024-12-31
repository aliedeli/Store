<?php

use Dotenv\Parser\Value;
use SecTheater\View\View;

if (!function_exists('env')) {
    function env($key, $default = null)
    {
        if (array_key_exists($key, $_ENV)) {
            return $_ENV[$key];
        }

        return $default;
    }
}
if(!function_exists('value')){
    function value($value){
        return ($value instanceof Closure) ? $value() : $value;
    }

}

 
function session()
{
    session_start();
    if($_SESSION['UserName'] != null)
    {
       if($_SESSION['UserID']){

       }
    }
    else
    {
          header('Location:/login');
    }
    if(isset($_GET['out'])){
        session_destroy();
        header('Location:/login');

    }
}


if(!function_exists('base_path')){
    function base_path(){
        return dirname(__DIR__)  . '/../';
    }
}
if(!function_exists('base_products')){
    function base_products(){
        return dirname(__DIR__)  . '../public/products/';
    }
}
if(!function_exists('view_path')){
    function view_path(){
        return  base_path() . 'views/';
    }
}

if(!function_exists('post_path')){
    function post_path(){
        return  base_path() . 'App/Models/';
    }
}
if(!function_exists('view')){
    function view($view,$params = [])  {
        View::make($view,$params);        
    }
}
if(!function_exists('viewpost')){
    function viewpost($view,$params = [])  {
    
        View::postMake($view,$params);        
    }
}
if(!function_exists("json_data")){
    function json_data($data)
    {
        echo json_encode($data);
    }
}