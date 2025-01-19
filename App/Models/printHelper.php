<?php
namespace App\Models;
use App\Database\Database;
use Dompdf\Dompdf;



class printHelper   {
    private  $mpdf;
    public function __construct( )
    {
        $this->mpdf =new Dompdf();
    }
   public function Html()
   {
        $Html=`
            <div style="width: 100%; height: 45px; display: flex; justify-content: center; align-items: center;" class="title">
            <span>Main Menu</span>
        </div>
        
        
        `;
        
    
        return $Html;
    }


    public function print()
    {
       $this->mpdf->setPaper('A4', 'portrait');
        $this->mpdf->loadHtml($this->Html());
        $this->mpdf->render();
        $this->mpdf->stream("hello123.pdf", ["Attachment" => false]);
    }
}


$pri = new printHelper();
$pri->print(); 