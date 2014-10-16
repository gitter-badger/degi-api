<?php
namespace Application\Model;
use Application\Model\Table\ItemCategoryTable;

class ItemCategory_f{
	
	public function __construct(){
		$this->db = new ItemCategoryTable();
	}
    public function selectAll($query){
        try{ 
        	$select = $this->db->getSql()->select();
        	$select->columns(array('ic_id'));
        	$select->where('ic_type=1');
        	$outside_cate = $this->db->selectWith($select)->toArray();
        	$outside_cate_array = array();
        	foreach ($outside_cate as $value){
        		array_push($outside_cate_array,(int)$value['ic_id']);
        	}
        	$select = $this->db->getSql()->select();
        	$select->columns(array('ic_id'));
        	$select->where('ic_type=2');
        	$storeside_cate = $this->db->selectWith($select)->toArray();
        	$storeside_cate_array = array();
        	foreach ($storeside_cate as $value){
        		array_push($storeside_cate_array,(int)$value['ic_id']);
        	}
            $result['success'] = true;
            $result['rows'] = array();
            $result['rows']['outside_cate'] = $outside_cate_array;
            $result['rows']['storeside_cate'] = $storeside_cate_array;
    
            return $result;
        }catch (\Exception $e){
        	return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
    public function selectItemByType($type){
    	if($type=='1'){
    		$select = $this->db->getSql()->select();
    		$select->columns(array('ic_id'));
    		$select->where('ic_type=1');
    		$outside_cate = $this->db->selectWith($select)->toArray();
    	}else{
    		$select = $this->db->getSql()->select();
    		$select->columns(array('ic_id'));
    		$select->where('ic_type=2');
    		$outside_cate = $this->db->selectWith($select)->toArray();
    	}
    	return $outside_cate;
    }
}
?>