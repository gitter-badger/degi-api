<?php
namespace Application\Model\Tool;

class TokenHash {   
	static function strToHex($string){
	    $hex = '';
	    for ($i=0; $i<strlen($string); $i++){
	        $ord = ord($string[$i]);
	        $hexCode = dechex($ord);
	        $hex .= substr('0'.$hexCode, -2);
	    }
	    return strToUpper($hex);
	}
	static function hexToStr($hex){
	    $string='';
	    for ($i=0; $i < strlen($hex)-1; $i+=2){
	        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
	    }
	    return $string;
	}
	static function GenerateToken($account){
		$token_str = date('Y-m-d H:i:s').'/'.$account;
		return TokenHash::strToHex($token_str);
	}
	static function ExpiresIn($token_str_encode,$expire_in){	
		$token_str_decode = TokenHash::hexToStr($token_str_encode);
		$from_time = strtotime(explode('/', $token_str_decode)[0]);
		$now_time = strtotime(date('Y-m-d H:i:s'));
		$time_diff = round(abs($now_time - $from_time),2);
		return (int)$time_diff <= (int)$expire_in ? true:false;			
	}
}
?>