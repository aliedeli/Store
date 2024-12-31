<?php
    
    
namespace SecTheater\Http;

use SecTheater\View\View;

class Route
{
    public Request $request;
    public Response $response;
    public function __construct(Request $request, Response $response){
        $this->request = $request;
        $this->response = $response;
    }
    public static array $routes = [];


    public static function get($routes , $action)
    {
        self::$routes['get'][$routes]=$action;


    }
    public static function post($routes,$action)

    {
        
        self::$routes['post'][$routes]=$action;
      
    }
    
    public function resolve()
    {
        $path = $this->request->path();
        $method = $this->request->method();
        $action = self::$routes[$method] [$path] ?? false;

        if(!array_key_exists($path , self::$routes[$method])){
           
            View::makeError('404');
        }

        
        if(is_callable($action))
        {
            call_user_func_array($action,[]);
        }
        if(is_array($action))
        {
           
            call_user_func_array([new $action[0] ,$action[1] ],[]);
        }
    }
    
}

