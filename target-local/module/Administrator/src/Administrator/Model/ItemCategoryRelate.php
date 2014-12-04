<?php
namespace Administrator\Model;

use Administrator\Model\Table\ItemCateRelTable;

class ItemCategoryRelate {
	
	public $db = null ;
    public function __construct(){
    	$this->db = new ItemCateRelTable();
    }
    public function get($id){
        try {
            return array('success'=>true , 'data'=> $this->db->select(array('icr_id'=>$id))->current() );
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
    
    public function update($data , $id){
        try {
        	
        	#檢查商品存在與否
        	if( !empty($data['ic_id']) && !empty($data['im_id']) ){
	        	$select = $this->db->getSql()->select();
	            $select->where->notEqualTo('icr_id',$id)
	            			  ->equalTo('ic_id',$data['ic_id'])
	                          ->equalTo('im_id',$data['im_id']);
	            if( !empty($this->db->selectWith($select)->toArray() )){
	            	return array('success'=>false, 'msg'=>'此商品分類已存在此商品!');
	            }
        	}
        	#檢查同類型同排序
        	if( !empty($data['ic_id']) && !empty($data['icr_seq']) ){
	        	$select = $this->db->getSql()->select();
	            $select->where->notEqualTo('icr_id',$id)
	                          ->equalTo('ic_id',$data['ic_id'])
					          ->equalTo('icr_seq',$data['icr_seq']);
	            if( !empty($this->db->selectWith($select)->toArray() )){
	            	return array('success'=>false, 'msg'=>'此類型同排序已存在商品,請選擇其他排序!');
	            }
        	}
        	
            $this->db->update($data , array('icr_id'=>$id));
            return array('success'=>true , 'data'=> $data );
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
    
    public function insert($data){
        try {
        	
            #檢查商品存在與否
            $select = $this->db->getSql()->select();
            $select->where->equalTo('ic_id',$data['ic_id'])
                          ->equalTo('im_id',$data['im_id']);
            if( !empty($this->db->selectWith($select)->toArray() )){
            	return array('success'=>false, 'msg'=>'此商品分類已存在此商品!');
            }
            
            #檢查同類型同排序
            $select = $this->db->getSql()->select();
            $select->where->equalTo('ic_id',$data['ic_id'])
				          ->equalTo('icr_seq',$data['icr_seq']);
            if( !empty($this->db->selectWith($select)->toArray() )){
            	return array('success'=>false, 'msg'=>'此類型同排序已存在商品,請選擇其他排序!');
            }
            
            $data['icr_created'] = date('Y-m-d H:i:s');
            
            $this->db->insert($data);           
            $data['icr_id'] = $this->db->getLastInsertValue(); 
            return array('success'=>true , 'data'=>$data);
            
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );          
        }
    }
    public function delete($id){
    	$this->db->delete('icr_id =' . (int) $id);
    	return array('success'=>true  );
    }
    public function selectAll($query){
    	try {
    		$select = $this->db->getSql()->select();
    		$select->join('item_main','item_main.im_id = item_cate_rel.im_id',array('im_name'));
    		$select->where->equalTo('ic_id',$query['ic_id']);
    		$select->order('item_cate_rel.icr_seq ASC');
    		$cmp = $this->db->selectWith($select)->toArray();
            $result['success'] = true;
            $result['rows'] = Json_encode($cmp);
            return $result;
    
    	}catch (\Exception $e){
    		return array('success'=>false , 'msg'=> $e->getMessage() );
    	}
    }
}
?>