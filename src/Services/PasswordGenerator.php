<?php

namespace App\Services;

/**
 * Description of PasswordGenerator
 *
 * @author alicia
 */
class PasswordGenerator {
    
    public function generatePassword(){
        $N=10;
        $password=array($N);
        for($i=0; $i<$N; $i++){
            if($i<2){
                $password[$i]=rand(1,9);
            }else if($i>=2 && $i<4){
                $password[$i]=chr(rand(ord('A'),ord('Z')));
            }else{
                $password[$i]=chr(rand(ord('a'),ord('z')));
            }
        }
        shuffle($password);
        return implode("",$password);
    }
}
