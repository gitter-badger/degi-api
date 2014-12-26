<?php
namespace Administrator\Model;

use Administrator\Model\Table\MemberTable;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;

class Member{
	public $db = null ;
	public function __construct(){
		$this->db = new MemberTable();
	}
	public function update($data , $id){
		try {
			$this->db->update($data , array('mm_id'=>$id));
			return array('success'=>true , 'data'=> $data );
		}catch (\Exception $e){
			return array('success'=>false , 'msg'=> $e->getMessage() );
		}
	}
    public function delete($id){
        $this->db->update(array('mm_status'=>2),array('mm_id'=>$id));
        return array('success'=>true  );
    }
    
    public function get($id){
        return array('success'=>true , 'data'=> $this->db->select(array('mm_id'=>$id))->current());
    }
    
    public function selectAll($query){
   	 	try {
    		$select = $this->db->getSql()->select();
    		
    		if(!empty($query['q'])){
    			$select->where->like('mm_email','%'.$query['q'].'%');
    			$select->where->or->like('mm_purchaser_name','%'.$query['q'].'%');
    		}
    		if(isset($query['s'])){
    			$select->where->equalTo('mm_status',$query['s']);
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