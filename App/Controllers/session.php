<?php

session_start();
function session()
{
    if(!empty($_SESSION))
    {
        
    }
    else
    {
        header('Location:/login.php');
    }
}