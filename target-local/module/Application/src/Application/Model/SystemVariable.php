<?php
namespace Application\Model;

use Application\Model\Table\SystemVariableTable;

class SystemVariable{
	
	public function __construct(){
		$this->db = new SystemVariableTable();
	}
    public function selectAll(){
        try{ 
        	$select = $this->db->getSql()->select();
            $result['success'] = true;
            $result['rows'] = $this->db->selectWith($select)->toArray();
            return $result;
        }catch (\Exception $e){
        	return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
    public function GetValueByKey($key){
    	$select = $this->db->getSql()->select();
        $select->where('sv_key=\''.$key.'\''); 
        $sv = $this->db->selectWith($select)->toArray();
        return $sv[0]['sv_value'];
    }  
}
?>