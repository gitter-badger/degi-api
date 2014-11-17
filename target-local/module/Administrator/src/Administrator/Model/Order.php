<?php
namespace Administrator\Model;

use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;
use Administrator\Model\Table\OrderMainTable;

class Order{
	public $db = null ;
	public function __construct(){
		$this->db = new OrderMainTable();
	}
	public function update($data , $id){
		try {
			$this->db->update($data , array('om_id'=>$id));
			return array('success'=>true , 'data'=> $data );
		}catch (\Exception $e){
			return array('success'=>false , 'msg'=> $e->getMessage() );
		}
	}

    public function get($id){
        return array('success'=>true , 'data'=> $this->db->select(array('om_id'=>$id))->current());
    }
    
    public function selectAll($query){
   	 	try {
    		$select = $this->db->getSql()->select();
    		
//     		if(!empty($query['q'])){
//     			$select->where->like('mm_email','%'.$query['q'].'%');
//     			$select->where->or->like('mm_purchaser_name','%'.$query['q'].'%');
//     		}
//     		if(isset($query['s'])){
//     			$select->where->equalTo('mm_status',$query['s']);
//     		}
    		
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