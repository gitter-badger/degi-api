<?php
namespace Application\Model;

use Application\Model\Table\BulkItemTable;

class BulkItem{
	public function __construct(){
		$this->db = new BulkItemTable();
	}
    public function get($id){
   		try {
   			
   			$select = $this->db->getSql()->select();
        	$select->where('cm_id='.$id);
   			$select->columns(array('bpi_id','ic_id','bpi_category','im_id','bpi_name','bpi_flavor','bpi_sprice'));
        	$result_row = $this->db->selectWith($select)->toArray();  
        	$result['success'] = true ;
   			$result['rows'] = $result_row;
   			
   			return $result;

        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
}
?>