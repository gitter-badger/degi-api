<?php
namespace Administrator\Model;

use Administrator\Model\Table\SystemVariableTable;

class SystemVariable {
	
	public $db = null ;
    public function __construct(){
    	$this->db = new SystemVariableTable();
    }

    public function update($data , $id){
        try {
            $this->db->update($data , array('sv_id'=>$id));
            return array('success'=>true , 'data'=> $data );
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
    public function selectAll(){
        return array('success'=>true , 'data'=>$this->db->select()->toArray() );        
    }
}
?>