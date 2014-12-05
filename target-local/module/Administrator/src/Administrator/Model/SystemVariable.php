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
    public function get_value_by_key($sv_key){
    	$sv = $this->db->select(array('sv_key'=>$sv_key))->toArray();
    	return $sv[0]['sv_value'];
    }
}
?>