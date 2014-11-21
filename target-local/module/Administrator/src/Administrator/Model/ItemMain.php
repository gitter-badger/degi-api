<?php
namespace Administrator\Model;

use Administrator\Model\Table\ItemMainTable;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;

class ItemMain {
	
	public $db = null ;
    public function __construct(){
    	$this->db = new ItemMainTable();
    }
    
    public function get($id){
        try {
            return array('success'=>true , 'data'=> $this->db->select(array('im_id'=>$id))->current() );
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
    
    public function update($data , $id){
        try {
            $this->db->update($data , array('im_id'=>$id));
            return array('success'=>true , 'data'=> $data );
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
    
    public function insert($data){
        try {
            $data['im_created'] = date('Y-m-d H:i:s');
            $this->db->insert($data);           
            $data['im_id'] = $this->db->getLastInsertValue(); 
            return array('success'=>true , 'data'=>$data);          
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );          
        }
    }
    public function delete($id){
    	$this->db->update(array('im_status'=>2),array('im_id'=>$id));
    	return array('success'=>true);
    }
    public function selectAll($query){
    	try {
    		$select = $this->db->getSql()->select();
    		if(empty($query['limit'])){
    			return array('success'=>true , 'data'=>$this->db->select()->toArray() );
    		}else{
	    		$paginator = new Paginator(new DbSelect($select, $this->db->adapter));
	    
	    		$paginator->setItemCountPerPage($query['limit'])->setCurrentPageNumber($query['page']);
	    
	    		$result['success'] = true ;
	    		$result['total'] = $paginator->getTotalItemCount();
	    		$result['rows'] = $paginator->getCurrentItems()->toArray();
	    		return $result;
    		}
    		
    	}catch (\Exception $e){
    		return array('success'=>false , 'msg'=> $e->getMessage() );
    	}
    }
}
?>