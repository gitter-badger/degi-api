<?php
namespace Application\Model;
use Application\Model\Table\OrderMainTable;
use Zend\Debug\Debug;

class Current1{
	public $db = null ;
	public function __construct(){
		$this->db = new OrderMainTable();
	}
	public function insert($data){	
		try {				
			
// 			Debug::dump($data);
 			$storeID = '010260071';
 			$cubkey = '8de7af1d18d4f50f82e8d39d3f1820a1';
// 			$cavalue =  md5($storeID.$data['om_id'].$data['om_total'].$cubkey);
/*			$strRqXML = '<?xml version=\'1.0\' encoding=\'UTF-8\'?><MERCHANTXML><CAVALUE>'.$cavalue.'</CAVALUE><ORDERINFO><STOREID>'.$storeID.'</STOREID><ORDERNUMBER>'.$data['om_id'].'</ORDERNUMBER><AMOUNT>'.$data['om_total'].'</AMOUNT></ORDERINFO></MERCHANTXML>';			*/
// 			$data['strRqXML'] = $strRqXML;
			
			$strRsXML = $data['strRsXML'];
			$xml = simplexml_load_string($strRsXML);
			//(RETURL網域名稱(例如www.cathaybk.com.tw)+CUBKEY)
			$cavalue = md5('git.localhost'.$cubkey);
			$returl = 'http://git.localhost/degi-api/target-local/public/f/current';
			//http://dev.finpo.com.tw/target/#/cart_step4
			'<?xml version=\'1.0\' encoding=\'UTF-8\'?><MERCHANTXML><CAVALUE>'.$cavalue.'</CAVALUE><RETURL>'.$returl.'</RETURL></MERCHANTXML>';
			Debug::dump($xml);
			return array('success'=>true , 'data'=> $data);
		}catch (\Exception $e){
			return array('success'=>false , 'msg'=> $e->getMessage() );
		}
	}
}
?>