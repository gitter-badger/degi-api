<?php
namespace Administrator\Model;

use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;
use Administrator\Model\Table\PopularTable;
use Administrator\model\Tool;

class PopularItem {
	
	public $db = null ;
    public function __construct(){
    	$this->db = new PopularTable();
    }
    
    public function get($id){
        try {
            return array('success'=>true , 'data'=> $this->db->select(array('pi_id'=>$id))->toArray() );
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
    
    public function update($data , $id){
        try {
        	
        	#檢查同類型同商品存在與否
        	if( !empty($data['pi_type']) && !empty($data['im_id']) ){	
	        	$select = $this->db->getSql()->select();
	            $select->where->notEqualTo('pi_id',$id)
	            			  ->equalTo('pi_type',$data['pi_type'])
	                          ->equalTo('im_id',$data['im_id']);
	            if( !empty($this->db->selectWith($select)->toArray() )){
	            	return array('success'=>false, 'msg'=>'此類型已存在此商品!');
	            }
        	}
        	#檢查同類型同排序
        	if( !empty($data['pi_type']) && !empty($data['pi_seq']) ){
	        	$select = $this->db->getSql()->select();
	            $select->where->notEqualTo('pi_id',$id)
	                          ->equalTo('pi_type',$data['pi_type'])
					          ->equalTo('pi_seq',$data['pi_seq']);
	            if( !empty($this->db->selectWith($select)->toArray() )){
	            	return array('success'=>false, 'msg'=>'此類型同排序已存在同商品,請選擇其他排序!');
	            }
        	}
        	
            $this->db->update($data , array('pi_id'=>$id));
            return array('success'=>true , 'data'=> $data );
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
    
    public function insert($data){
        try {
        	$tool = new Tool();
        	$input['m_path']['pi_image']  ="images/popular_item";
        	$result = $tool->upload($input);
        	
        	if (! $result['success']) {
        		return array('success'=>false, 'msg'=>'上傳圖片失敗!');
        	}
        	if (! empty($result['files'])) {
        		foreach ($result['files'] as $index => $val) {
        			$data[$index] = $val;
        		}
        	}
            #檢查同類型同商品存在與否
            $select = $this->db->getSql()->select();
            $select->where->equalTo('pi_type',$data['pi_type'])
                          ->equalTo('im_id',$data['im_id']);
            if( !empty($this->db->selectWith($select)->toArray() )){
            	return array('success'=>false, 'msg'=>'此類型已存在此商品!');
            }
            
            #檢查同類型同排序
            $select = $this->db->getSql()->select();
            $select->where->equalTo('pi_type',$data['pi_type'])
				          ->equalTo('pi_seq',$data['pi_seq']);
            if( !empty($this->db->selectWith($select)->toArray() )){
            	return array('success'=>false, 'msg'=>'此類型同排序已存在同商品,請選擇其他排序!');
            }
            
            $data['pi_created'] = date('Y-m-d H:i:s');
            
            $this->db->insert($data);           
            $data['pi_id'] = $this->db->getLastInsertValue(); 
            return array('success'=>true , 'data'=>$data);
            
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );          
        }
    }
    public function delete($id){
    	$this->db->delete('pi_id =' . (int) $id);
    	return array('success'=>true);
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