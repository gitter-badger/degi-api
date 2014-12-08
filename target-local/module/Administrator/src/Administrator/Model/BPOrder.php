<?php
namespace Administrator\Model;

use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;
use Administrator\Model\Table\BulkOrderMainTable;
use Administrator\Model\Table\CompanyMemberTable;

class BPOrder{
	public $db = null ;
	public function __construct(){
		$this->db = new BulkOrderMainTable();
	}
	public function update($data , $id){
		try {
			$bpom_status = $this->db->select(array('bpom_id'=>$id))->current()->bpom_status;
			
			if( $bpom_status != 4 && $data['bpom_status'] == 4){ // 從 1,2,3 => 4 - 
		
				$cm_id = $this->db->select(array('bpom_id'=>$id))->current()->cm_id;
				$bpom_total = $this->db->select(array('bpom_id'=>$id))->current()->bpom_total;
				
				$cm_db = new CompanyMemberTable();
				$cm_consumption_amount = $cm_db->select(array('cm_id'=>$cm_id))->current()->cm_consumption_amount;
				
				$cm_func = new CompanyMember();
				$cmp_data = array();
				$cmp_data['cm_consumption_amount'] = (int)$cm_consumption_amount - $bpom_total;
				$cm_func->update($cmp_data, $cm_id);
				
			}else if( $bpom_status == 4 && $data['bpom_status'] != 4 ){ // 4 => 1,2,3 +
				$cm_id = $this->db->select(array('bpom_id'=>$id))->current()->cm_id;
				$bpom_total = $this->db->select(array('bpom_id'=>$id))->current()->bpom_total;
								
				$cm_db = new CompanyMemberTable();
				$cm_consumption_amount = $cm_db->select(array('cm_id'=>$cm_id))->current()->cm_consumption_amount;
				
				$cm_func = new CompanyMember();  
				$cmp_data = array();
				$cmp_data['cm_consumption_amount'] = (int)$cm_consumption_amount + $bpom_total;
				$cm_func->update($cmp_data, $cm_id);
				
			}
			
			$this->db->update($data , array('bpom_id'=>$id));
			return array('success'=>true , 'data'=> $data );
		}catch (\Exception $e){
			return array('success'=>false , 'msg'=> $e->getMessage() );
		}
	}

    public function get($id){
    	$select = $this->db->getSql()->select();
    	$select->where('bpom_id='.$id);
    	$select->join('company_member_point','company_member_point.cmp_id = bulk_purchase_order_main.cmp_id',array('cmp_name','cmp_address'));
    	
    	return array('success'=>true , 'data'=>  $this->db->selectWith($select)->toArray());
    }
    
    public function selectAll($query){
   	 	try {
    		$select = $this->db->getSql()->select();
    		$select->join('company_member_point','company_member_point.cmp_id = bulk_purchase_order_main.cmp_id',array('cmp_name','cmp_address'));
    		$select->order('bpom_created DESC');
    		if(isset($query['s'])){
    			$select->where->equalTo('bpom_status',$query['s']);
    		}
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