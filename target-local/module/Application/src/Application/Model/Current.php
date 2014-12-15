<?php
namespace Application\Model;
use Application\Model\Table\OrderMainTable;

class Current{
	public $db = null ;
	public function __construct(){
		$this->db = new OrderMainTable();
	}
	public function insert($data){	
		try {				
			/*<?xml version='1.0' encoding='UTF-8'?><CUBXML><CAVALUE></CAVALUE><ORDERINFO><STOREID></STOREID><ORDERNUMBER></ORDERNUMBER><AMOUNT></AMOUNT></ORDERINFO><AUTHINFO><AUTHSTATUS></AUTHSTATUS><AUTHCODE></AUTHCODE><AUTHTIME></AUTHTIME><AUTHMSG></AUTHMSG></AUTHINFO></CUBXML>*/
			// 			Debug::dump($data);
 			$storeID = '010260071';
 			$cubkey = '8de7af1d18d4f50f82e8d39d3f1820a1';
 			$link_root = '127.0.0.1:9000';
 			//http://127.0.0.1:9000/#/cart_step1
 			//(RETURL網域名稱(例如www.cathaybk.com.tw)+CUBKEY)
 			$cavalue = md5($link_root.$cubkey);	
			$strRsXML = $data['strRsXML'];
			$xml = simplexml_load_string($strRsXML);
			//Debug::dump($xml);
			
			$om_db = new OrderMainTable(); 
			$om_id = (string)$xml->ORDERINFO->ORDERNUMBER;
			$data_om = array();
			
			if( (string)$xml->AUTHINFO->AUTHSTATUS == '0000')
			{
				$data_om['om_payment_status'] = 1;// 修改訂單 om_payment_status = 1 
				$cash_token = sha1(md5((string)$xml->ORDERINFO->STOREID.(string)$xml->ORDERINFO->ORDERNUMBER));
				$returl = 'http://'.$link_root.'/#/cart_step4/'.$om_id.'/'.$cash_token;
			}else
			{
				$data_om['om_status'] = 4;// 修改訂單 om_status = 4 
				$returl = 'http://'.$link_root.'/#/cart_step1?payment_flow_error';
			}
			$this->db->update($data_om , array('om_id'=>$om_id));
			$result = '<?xml version=\'1.0\' encoding=\'UTF-8\'?><MERCHANTXML><CAVALUE>'.$cavalue.'</CAVALUE><RETURL>'.$returl.'</RETURL></MERCHANTXML>';
			return $result;
		}catch (\Exception $e){
			return array('success'=>false , 'msg'=> $e->getMessage() );
		}
	}
}
?>