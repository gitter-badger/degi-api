<?php
namespace Application\Model;
use Application\Model\Table\ItemCategoryTable;

class ItemCategory{
	
	public function __construct(){
		$this->db = new ItemCategoryTable();
	}
    public function selectAll($query){
        try{ 
        	$select = $this->db->getSql()->select();
        	$select->columns(array('ic_id','ic_name'));
        	$select->where('ic_type=1');
        	$outside_cate = $this->db->selectWith($select)->toArray();
        	$outside_cate_array = array();
        	       	
			array_push($outside_cate_array,array('ic_id'=>"-1",'ic_name'=>'所有商品'));
			
			foreach ($outside_cate as $value){	
        		array_push($outside_cate_array,$value);
        	}
        	$select = $this->db->getSql()->select();
        	$select->columns(array('ic_id','ic_name'));
        	$select->where('ic_type=2');
        	$storeside_cate = $this->db->selectWith($select)->toArray();
        	$storeside_cate_array = array();
        	
        	array_push($storeside_cate_array,array('ic_id'=>"-2",'ic_name'=>'所有商品'));
        	        	
        	foreach ($storeside_cate as $value){
        		array_push($storeside_cate_array,$value);
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
}
?>