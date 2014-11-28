<?php
namespace Administrator\Model;

use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;
use Administrator\Model\Table\FoodCertificationTable;

class Food {
	
	public $db = null ;
    public function __construct(){
    	$this->db = new FoodCertificationTable();
    }
    
    public function get($id){
        try {
            return array('success'=>true , 'data'=> $this->db->select(array('fc_id'=>$id))->toArray() );
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
    
    public function update($data , $id){
        try {
        	//Debug::dump($data);
        	//Debug::dump($id);
        	if($data['fc_image'] == ''){
        		unset($data['fc_image']);
        	}else{
        		unset($data['fc_image']);
        		
	            $input['m_path']['fc_image']  ="images/food_certification_image";
	
	        	$tool = new \Administrator\Model\Tool\Tool();
        		$result = $tool->upload($input);
	        	if (! $result['success']) {
	        		return array('success'=>false, 'msg'=>'上傳圖片失敗!');
	        	}
	        	if (! empty($result['files'])) {
	        		//Debug::dump($result['files']);
	        		$row = $this->db->select('fc_id =' . (int) $id)->toArray();
	        		foreach ($result['files'] as $index => $val) {
	        			$path = PUBLIC_PATH .'/'.$input['m_path'][$index];
	        			$tool->deleteimg($path,$row[0][$index]);
	        			$data[$index] = $val;
	        		}
	        	}
        	}
        	//Debug::dump($data);
        	//Debug::dump($id);
        	
        	#檢查同類型同排序
        	if( !empty($data['fc_seq']) ){
	        	$select = $this->db->getSql()->select();
	            $select->where->notEqualTo('fc_id',$id)
					          ->equalTo('fc_seq',$data['fc_seq']);
	            if( !empty($this->db->selectWith($select)->toArray() )){
	            	return array('success'=>false, 'msg'=>'此排序已存在,請選擇其他排序!');
	            }
        	}
        	
            $this->db->update($data , array('fc_id'=>$id));
            return array('success'=>true , 'data'=> $data );
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
    
    public function insert($data){
        try {
        	if(!empty($data['fc_id'])){
        		$id = $data['fc_id'];
        		unset($data['fc_id']);
	            $input['m_path']['fc_image']  ="images/food_certification_image";
	        	$tool = new \Administrator\Model\Tool\Tool();
        		$result = $tool->upload($input);
	        	if (! $result['success']) {
	        		return array('success'=>false, 'msg'=>'上傳圖片失敗!');
	        	}
	        	if (! empty($result['files'])) {
	        		//Debug::dump($result['files']);
	        		$row = $this->db->select('fc_id =' . (int) $id)->toArray();
	        		foreach ($result['files'] as $index => $val) {
	        			$path = PUBLIC_PATH .'/'.$input['m_path'][$index];
	        			$tool->deleteimg($path,$row[0][$index]);
	        			$data[$index] = $val;
	        		}
	        	}
        	
	        	#檢查同類型同排序
	        	if( !empty($data['fc_seq']) ){
		        	$select = $this->db->getSql()->select();
		            $select->where->notEqualTo('fc_id',$id)
						          ->equalTo('fc_seq',$data['fc_seq']);
		            if( !empty($this->db->selectWith($select)->toArray() )){
		            	return array('success'=>false, 'msg'=>'此排序已存在,請選擇其他排序!');
		            }
	        	}
	        	
	            $this->db->update($data , array('fc_id'=>$id));
	            return array('success'=>true , 'data'=> $data );
	        		
        	}else{
        		
        		$tool = new \Administrator\Model\Tool\Tool();
		        $input['m_path']['fc_image']  ="images/food_certification_image";
        		$result = $tool->upload($input);
        		 
        		if (! $result['success']) {
        			return array('success'=>false, 'msg'=>'上傳圖片失敗!');
        		}
        		if (! empty($result['files'])) {
        			foreach ($result['files'] as $index => $val) {
        				$data[$index] = $val;
        			}
        		}
        		
        		#檢查同類型同排序
        		$select = $this->db->getSql()->select();
        		$select->where->equalTo('fc_seq',$data['fc_seq']);
        		if( !empty($this->db->selectWith($select)->toArray() )){
        			return array('success'=>false, 'msg'=>'此排序已存在,請選擇其他排序!');
        		}
        		
        		$data['fc_created'] = date('Y-m-d H:i:s');
        		
        		$this->db->insert($data);
        		$data['fc_id'] = $this->db->getLastInsertValue();
        		return array('success'=>true , 'data'=>$data);
        	}
            
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );          
        }
    }
    public function delete($id){
    	$this->db->delete('fc_id =' . (int) $id);
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