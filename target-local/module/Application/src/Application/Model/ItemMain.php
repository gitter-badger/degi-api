<?php
namespace Application\Model;

use Application\Model\Table\ItemMainTable;

class ItemMain{
	public function __construct(){
		$this->db = new ItemMainTable();
	}
    public function get($id){
        return array('success'=>true , 'data'=> $this->db->select(array('im_id'=>$id))->current());
    }
    public function selectAll(){
        try{ 
        	return array('success'=>true , 'rows'=>$this->db->select()->toArray() );
        }catch (\Exception $e){
        	return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
}
?>