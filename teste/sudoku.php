<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/* Em sudoku, o objetivo é preencher uma grade 9x9 subdivida em quadrantes 3x3 
com números de 1 a 9 de tal forma que não hajam números repetidos em uma mesma coluna, 
linha ou quadrante. Escreva um procedimento que gere uma matriz 9x9 válida como resultado 
de sudoku considerando uma grade vazia.*/ 

class SudokuController extends Controller
{
    public function sudoku()
    {       
      
        $matrix=  array();

       
        $sudoku = array();
       
        

        $n =3;
        $x =  rand(1, 9);
        for( $i = 0; $i < $n; $i++, $x++){
            for( $j = 0; $j < $n; $j++, $x+=$n){
                for( $k = 0; $k < $n*$n; $k++, $x++){
                    for( $k = 0; $k < $n*$n; $k++, $x++){
                        $sudoku[$n*$i+$j][$k] = ($x % ($n*$n)) + 1;
                    }
                }
            }
        }
   
       
        
     
        $out  = "";
        $out .= "<table>";

        foreach($sudoku as $key => $element){
            $out .= "<tr>";
            foreach($element as $subkey => $subelement){
                $out .= "<td>$subelement</td>";
            }
            $out .= "</tr>";
        }
        $out .= "</table>";

        echo $out;

        
        
        
    }

    
}