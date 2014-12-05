<?php
namespace Administrator\Model;

use Administrator\Model\Table\ItemFlavorTable;

class ItemFlavor {
	
	public $db = null ;
    public function __construct(){
    	$this->db = new ItemFlavorTable();
    }
    
    public function get($id){
        try {
            return array('success'=>true , 'data'=> $this->db->select(array('if_id'=>$id))->toArray() );
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
    
    public function update($data , $id){
        try {
        	
        	#檢查同商品同口味存在與否
        	if( !empty($data['if_name']) && !empty($data['im_id']) ){	
	            $select = $this->db->getSql()->select();
	            $select->where->notEqualTo('if_id',$id)
	            			  ->equalTo('if_name',$data['if_name'])
	                          ->equalTo('im_id',$data['im_id']);
	            if( !empty($this->db->selectWith($select)->toArray() )){
	            	return array('success'=>false, 'msg'=>'此商品已存在此口味!');
	            }
        	}
        	#檢查同商品同排序
        	if( !empty($data['im_id']) && !empty($data['if_seq']) ){
	            $select = $this->db->getSql()->select();
	            $select->where->notEqualTo('if_id',$id)
	           				  ->equalTo('im_id',$data['im_id'])
					          ->equalTo('if_seq',$data['if_seq']);
	            if( !empty($this->db->selectWith($select)->toArray() )){
	            	return array('success'=>false, 'msg'=>'此商品同排序已存在同口味,請選擇其他排序!');
	            }
        	}
        	
            $this->db->update($data , array('if_id'=>$id));
            return array('success'=>true , 'data'=> $data );
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
    
    public function insert($data){
        try {
        	if(!empty($data['if_id'])){
        		$id = $data['if_id'];
        		unset($data['if_id']);
        		$input['m_path']['if_cover']  ="images/item_flavor_cover";
        		$tool = new \Administrator\Model\Tool\Tool();
        		$result = $tool->upload($input);
        		if (! $result['success']) {
        			return array('success'=>false, 'msg'=>'上傳圖片失敗!');
        		}
        		if (! empty($result['files'])) {
        			//Debug::dump($result['files']);
        			$row = $this->db->select('if_id =' . (int) $id)->toArray();
        			foreach ($result['files'] as $index => $val) {
        				$path = PUBLIC_PATH .'/'.$input['m_path'][$index];
        				$tool->deleteimg($path,$row[0][$index]);
        				$data[$index] = $val;
        			}
        		}
        		
        		#檢查同商品同口味存在與否
        		if( !empty($data['if_name']) && !empty($data['im_id']) ){
        			$select = $this->db->getSql()->select();
        			$select->where->notEqualTo('if_id',$id)
        			->equalTo('if_name',$data['if_name'])
        			->equalTo('im_id',$data['im_id']);
        			if( !empty($this->db->selectWith($select)->toArray() )){
        				return array('success'=>false, 'msg'=>'此商品已存在此口味!');
        			}
        		}
        		#檢查同商品同排序
        		if( !empty($data['im_id']) && !empty($data['if_seq']) ){
	        		$select = $this->db->getSql()->select();
	        		$select->where->notEqualTo('if_id',$id)
	        			->equalTo('im_id',$data['im_id'])
	        			->equalTo('if_seq',$data['if_seq']);
	        		if( !empty($this->db->selectWith($select)->toArray() )){
	        			return array('success'=>false, 'msg'=>'此商品同排序已存在同口味,請選擇其他排序!');
	        		}
        		}
        		 
        		$this->db->update($data , array('if_id'=>$id));
        		return array('success'=>true , 'data'=> $data );
        		
        	}else{
        		
        		$tool = new \Administrator\Model\Tool\Tool();
        		$input['m_path']['if_cover']  ="images/item_flavor_cover";
        		$result = $tool->upload($input);
        		 
        		if (! $result['success']) {
        			return array('success'=>false, 'msg'=>'上傳圖片失敗!');
        		}
        		if (! empty($result['files'])) {
        			foreach ($result['files'] as $index => $val) {
        				$data[$index] = $val;
        			}
        		}
        		
        		#檢查同商品同口味存在與否
	            $select = $this->db->getSql()->select();
	            $select->where->equalTo('if_name',$data['if_name'])
	                          ->equalTo('im_id',$data['im_id']);
	            if( !empty($this->db->selectWith($select)->toArray() )){
	            	return array('success'=>false, 'msg'=>'此商品已存在此口味!');
	            }
	            
	            #檢查同商品同排序
	            $select = $this->db->getSql()->select();
	            $select->where->equalTo('im_id',$data['im_id'])
					          ->equalTo('if_seq',$data['if_seq']);
	            if( !empty($this->db->selectWith($select)->toArray() )){
	            	return array('success'=>false, 'msg'=>'此商品同排序已存在同口味,請選擇其他排序!');
	            }
	            
	            $data['if_created'] = date('Y-m-d H:i:s');
	            
	            $this->db->insert($data);           
	            $data['if_id'] = $this->db->getLastInsertValue(); 
	            return array('success'=>true , 'data'=>$data);
        	}   
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );          
        }
    }
    public function delete($id){
    	$this->db->update(array('if_status'=>2,'if_seq'=>0),array('if_id'=>$id));
    	return array('success'=>true);
    }
    public function selectAll($query){
    	try {
    		$select = $this->db->getSql()->select();
    		$select->join('item_main','item_main.im_id = item_flavor.im_id',array('im_name'));
    		$select->where->equalTo('item_flavor.im_id',$query['im_id']);
    		$select->where->equalTo('item_flavor.if_status','1');
    		$select->order('item_flavor.if_seq ASC');
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