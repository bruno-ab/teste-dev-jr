<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class EqController extends Controller
{
    public function equation($a,$b,$c)
    {       
           // x² – 10x + 24 = 0
          // ax² + bx + c = 0
         // a = 1 b = 10 c = 24
        // x = -b +- delta / 2 * a
       // delta = b² - 4 * a * c

       $delta = ($b * $b) - (4 * $a * $c);
    
       $eq  = (-$b + sqrt($delta)) / (2 * $a);
       $eq2 = (-$b - sqrt($delta)) / (2 * $a);
       
       if(is_nan($eq) || is_nan($eq2)){
            $result[] = "nao possui raizes reais";
       }else{
            $result[] = $eq;
            $result[] = $eq2;
 
       }    
       
       return $result;
    }

    
}