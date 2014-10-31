<?php
namespace Application\Model\Tool;

class InputCheck {   
   static function checkRequire( $check , $input ){
      foreach ($check as $c){
         if( empty( $input[$c] ) ){
            return false ;
         }
      }
      return true ;
   }
}
?>