<?php


use SecTheater\Http\Route;
use SecTheater\Http\Request;
use SecTheater\Http\Response;



require_once __DIR__ .'../../src/Support/helpers.php';
require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../routes/wed.php';

$route= new Route(new Request,new Response );
$route->resolve();

    