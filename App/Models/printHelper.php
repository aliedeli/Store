<?php
namespace App\Models;
use App\Database\Database;

 include_once __DIR__ . "/../vendor/autoload.php";

class printHelper   {
    private  $mpdf;
    public function __construct( $mpdf)
    {
       $this->mpdf = $mpdf;
    }
    public function print()
    {
        $this->mpdf->WriteHTML('<h1>Hello world!</h1>');
        $this->mpdf->Output();
    }
}


$pri=new printHelper();
$pri->print();