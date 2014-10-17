<?php
namespace Administrator\Model;

use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;
use Administrator\Model\Table\NewsTable;

class News {
	
	public $db = null ;
    public function __construct(){
    	$this->db = new NewsTable();
    }
    public function get($id){
        try {
            return array('success'=>true , 'data'=> $this->db->select(array('nm_id'=>$id))->current() );
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
    
    public function update($data , $id){
        try {
            $this->db->update($data , array('nm_id'=>$id));
            return array('success'=>true , 'data'=> $data );
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
    
    public function insert($data){
        try {
        	
            $data['nm_created'] = date('Y-m-d H:i:s');
            
            $this->db->insert($data);           
            $data['nm_id'] = $this->db->getLastInsertValue(); 
            return array('success'=>true , 'data'=>$data);
            
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );          
        }
    }
    public function delete($id){
    	$this->db->delete('nm_id =' . (int) $id);
    	return array('success'=>true  );
    }
    public function selectAll($query){
        try {
            $select = $this->db->getSql()->select();
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