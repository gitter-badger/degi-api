<?php
namespace Administrator\Model;

use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;
use Administrator\Model\Table\CompanyMemberTable;

class CompanyMember{
	public $db = null ;
	public function __construct(){
		$this->db = new CompanyMemberTable();
	}
	public function update($data , $id){
		try {
			$this->db->update($data , array('cm_id'=>$id));
			return array('success'=>true , 'data'=> $data );
		}catch (\Exception $e){
			return array('success'=>false , 'msg'=> $e->getMessage() );
		}
	}
    public function delete($id){
        $this->db->update(array('cm_status'=>2),array('cm_id'=>$id));
        return array('success'=>true  );
    }
    
    public function get($id){
        return array('success'=>true , 'data'=> $this->db->select(array('cm_id'=>$id))->current());
    }
    
    public function selectAll($query){
   	 	try {
    		$select = $this->db->getSql()->select();
    		
    		if(!empty($query['q'])){
    			$select->where->like('cm_account','%'.$query['q'].'%');
    			$select->where->or->like('cm_title','%'.$query['q'].'%');
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