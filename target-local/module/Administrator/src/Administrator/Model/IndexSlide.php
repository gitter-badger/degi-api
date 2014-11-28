<?php
namespace Administrator\Model;

use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;
use Administrator\Model\Table\IndexSlideTable;

class IndexSlide{
	
	public $db = null ;
    public function __construct(){
    	$this->db = new IndexSlideTable();
    }
    
    public function get($id){
        try {
            return array('success'=>true , 'data'=> $this->db->select(array('is_id'=>$id))->toArray() );
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
    
    public function update($data , $id){
        try {
        	//Debug::dump($data);
        	//Debug::dump($id);
        	if($data['is_pic'] == ''){
        		unset($data['is_pic']);
        	}else{
        		unset($data['is_pic']);
        		
	            $input['m_path']['is_pic']  ="images/index_slide_pic";
	
	        	$tool = new \Administrator\Model\Tool\Tool();
        		$result = $tool->upload($input);
	        	if (! $result['success']) {
	        		return array('success'=>false, 'msg'=>'上傳圖片失敗!');
	        	}
	        	if (! empty($result['files'])) {
	        		//Debug::dump($result['files']);
	        		$row = $this->db->select('is_id =' . (int) $id)->toArray();
	        		foreach ($result['files'] as $index => $val) {
	        			$path = PUBLIC_PATH .'/'.$input['m_path'][$index];
	        			$tool->deleteimg($path,$row[0][$index]);
	        			$data[$index] = $val;
	        		}
	        	}
        	}
        	
        	#檢查同類型同排序
        	if( !empty($data['is_seq']) ){
	        	$select = $this->db->getSql()->select();
	            $select->where->notEqualTo('is_id',$id)
					          ->equalTo('is_seq',$data['is_seq']);
	            if( !empty($this->db->selectWith($select)->toArray() )){
	            	return array('success'=>false, 'msg'=>'此排序已存在,請選擇其他排序!');
	            }
        	}
        	
            $this->db->update($data , array('is_id'=>$id));
            return array('success'=>true , 'data'=> $data );
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
    
    public function insert($data){
        try {
        	if(!empty($data['is_id'])){
        		$id = $data['is_id'];
        		unset($data['is_id']);
	            $input['m_path']['is_pic']  ="images/index_slide_pic";
	        	$tool = new \Administrator\Model\Tool\Tool();
        		$result = $tool->upload($input);
	        	if (! $result['success']) {
	        		return array('success'=>false, 'msg'=>'上傳圖片失敗!');
	        	}
	        	if (! empty($result['files'])) {
	        		//Debug::dump($result['files']);
	        		$row = $this->db->select('is_id =' . (int) $id)->toArray();
	        		foreach ($result['files'] as $index => $val) {
	        			$path = PUBLIC_PATH .'/'.$input['m_path'][$index];
	        			$tool->deleteimg($path,$row[0][$index]);
	        			$data[$index] = $val;
	        		}
	        	}
        	
	        	#檢查同類型同排序
	        	if( !empty($data['is_seq']) ){
		        	$select = $this->db->getSql()->select();
		            $select->where->notEqualTo('is_id',$id)
						          ->equalTo('is_seq',$data['is_seq']);
		            if( !empty($this->db->selectWith($select)->toArray() )){
		            	return array('success'=>false, 'msg'=>'此排序已存在,請選擇其他排序!');
		            }
	        	}
	        	
	            $this->db->update($data , array('is_id'=>$id));
	            return array('success'=>true , 'data'=> $data );
	        		
        	}else{
        		
        		$tool = new \Administrator\Model\Tool\Tool();
		        $input['m_path']['is_pic']  ="images/index_slide_pic";
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
        		$select->where->equalTo('is_seq',$data['is_seq']);
        		if( !empty($this->db->selectWith($select)->toArray() )){
        			return array('success'=>false, 'msg'=>'此排序已存在,請選擇其他排序!');
        		}
        		
        		$this->db->insert($data);
        		$data['is_id'] = $this->db->getLastInsertValue();
        		return array('success'=>true , 'data'=>$data);
        	}
            
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );          
        }
    }
    public function delete($id){
    	$this->db->delete('is_id =' . (int) $id);
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