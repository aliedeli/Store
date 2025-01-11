<?php

namespace SecTheater\Http;

class Request
{
    public function method()
    {
        return strtolower( $_SERVER['REQUEST_METHOD']);
    }
    public function path()
    {
        $path= $_SERVER['REQUEST_URI'] ?? '/' ;

        return str_contains($path , "?")  ? explode('?', $path)[0] : $path ;

    }
    public function query()
    {
        return $_GET;
    }
    
    /**
     * Get all POST data
     * @return array
     */
    public function post()
    {
        return $_POST;
    }
    
    /**
     * Get request header value
     * @param string $key
     * @return string|null
     */
    public function header($key)
    {
        $header = 'HTTP_' . strtoupper(str_replace('-', '_', $key));
        
        return $_SERVER[$header] ?? null;
    }
}