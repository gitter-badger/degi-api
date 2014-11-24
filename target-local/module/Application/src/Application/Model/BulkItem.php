<?php
namespace Application\Model;

use Application\Model\Table\BulkItemTable;
use Zend\Debug\Debug;

class BulkItem{
	public function __construct(){
		$this->db = new BulkItemTable();
	}
    public function get($id,$query){//query{access_token}
   		try {
   			$member = new CompanyMember();
   			if( !$member->InternalCheckLogin($query['access_token']) ){
   				return array('success'=>false , 'msg'=> '未通過登入認證，請重新登入!' );
   			}
   			$select = $this->db->getSql()->select();
        	$select->where('cm_id='.$id);
   			$select->columns(array('bpi_id','ic_id','bpi_category','im_id','bpi_name','bpi_flavor','bpi_sprice'));
        	$result_row = $this->db->selectWith($select)->toArray();  
        	//Debug::dump($result_row);
        	$result['success'] = true ;
   			$result['rows'] = $result_row;
   			
   			return $result;

        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
}
?>