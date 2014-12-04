<?php
namespace Administrator\Model;

use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;
use Administrator\Model\Table\BulkOrderMainTable;

class BPOrder{
	public $db = null ;
	public function __construct(){
		$this->db = new BulkOrderMainTable();
	}
	public function update($data , $id){
		try {
			$this->db->update($data , array('bpom_id'=>$id));
			return array('success'=>true , 'data'=> $data );
		}catch (\Exception $e){
			return array('success'=>false , 'msg'=> $e->getMessage() );
		}
	}

    public function get($id){
        return array('success'=>true , 'data'=> $this->db->select(array('bpom_id'=>$id))->current());
    }
    
    public function selectAll($query){
   	 	try {
    		$select = $this->db->getSql()->select();
    		$select->join('company_member_point','company_member_point.cmp_id = bulk_purchase_order_main.cmp_id',array('cmp_name','cmp_address'));
    	
    		
    		$paginator = new Paginator(new DbSelect($select, $this->db->adapter));
    
    		$paginator->setItemCountPerPage($query['limit'])->setCurrentPageNumber($query['page']);
    
    		$result['success'] = true ;
    		$result['total'] = $paginator->getTotalItemCount();
    		$result['rows'] = $paginator->getCurrentItems()->toArray();
    
    		return $result;
    	}catch (\Exception $e){
    		return array('success'=>false , 'msg'=> $e->getMessage() );
    	}
    }
}
    
?>