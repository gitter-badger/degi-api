<?php
namespace Administrator\Model;

use Administrator\Model\Table\ItemCategoryTable;

class ItemCategory {
	
	public $db = null ;
    public function __construct(){
    	$this->db = new ItemCategoryTable();
    }
    public function get($id){
        try {
            return array('success'=>true , 'data'=> $this->db->select(array('ic_id'=>$id))->current() );
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
    
    public function update($data , $id){
        try {
        	
        	#檢查商品分類存在與否
        	if( !empty($data['ic_type']) && !empty($data['ic_name']) ){
	            $select = $this->db->getSql()->select();
	            $select->where->notEqualTo('ic_id',$id)
	                          ->equalTo('ic_type',$data['ic_type'])
	                          ->equalTo('ic_name',$data['ic_name']);
	            if( !empty($this->db->selectWith($select)->toArray() )){
	            	return array('success'=>false, 'msg'=>'此商品分類已存在!');
	            }
        	}
        	#檢查同類型同排序
        	if( !empty($data['ic_type']) && !empty($data['ic_seq']) ){
	            $select = $this->db->getSql()->select();
	            $select->where->notEqualTo('ic_id',$id)
	                          ->equalTo('ic_type',$data['ic_type'])
					          ->equalTo('ic_seq',$data['ic_seq']);
	            if( !empty($this->db->selectWith($select)->toArray() )){
	            	return array('success'=>false, 'msg'=>'此類型同排序已存在商品分類,請選擇其他排序!');
	            }
        	}
            $this->db->update($data , array('ic_id'=>$id));
            return array('success'=>true , 'data'=> $data );
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
    
    public function insert($data){
        try {
        	
            #檢查商品分類存在與否
            $select = $this->db->getSql()->select();
            $select->where->equalTo('ic_type',$data['ic_type'])
                          ->equalTo('ic_name',$data['ic_name']);
            if( !empty($this->db->selectWith($select)->toArray() )){
            	return array('success'=>false, 'msg'=>'此商品分類已存在!');
            }
            
            #檢查同類型同排序
            $select = $this->db->getSql()->select();
            $select->where->equalTo('ic_type',$data['ic_type'])
				          ->equalTo('ic_seq',$data['ic_seq']);
            if( !empty($this->db->selectWith($select)->toArray() )){
            	return array('success'=>false, 'msg'=>'此類型同排序已存在商品分類,請選擇其他排序!');
            }
            
            $data['ic_created'] = date('Y-m-d H:i:s');
          //  $data['ic_status'] = 1;
            
            $this->db->insert($data);           
            $data['ic_id'] = $this->db->getLastInsertValue(); 
            return array('success'=>true , 'data'=>$data);
            
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );          
        }
    }
    public function delete($id){
    	$this->db->update(array('ic_status'=>2),array('ic_id'=>$id));
    	return array('success'=>true  );
    }
    public function selectAll($query){
    	$select = $this->db->getSql()->select();
    	$select->order('ic_type ASC');
    	$select->order('ic_seq ASC');
    	
    	return array('success'=>true , 'data'=>$this->db->selectWith($select)->toArray() );        
    }
}
?>