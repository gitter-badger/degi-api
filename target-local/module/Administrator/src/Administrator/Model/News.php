<?php
namespace Administrator\Model;

use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;
use Administrator\Model\Table\NewsTable;

class News {
	
	public $db = null ;
    public function __construct(){
    	$this->db = new NewsTable();
    }
    public function get($id){
        try {
            return array('success'=>true , 'data'=> $this->db->select(array('nm_id'=>$id))->current() );
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
    
    public function update($data , $id){
        try {
            $this->db->update($data , array('nm_id'=>$id));
            return array('success'=>true , 'data'=> $data );
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
    
    public function insert($data){
        if($data['nm_id']=='0'){
        	try {
        		$tool = new \Administrator\Model\Tool\Tool();
        		$input['m_path']['nm_cover']  ="images/news_main_cover";
        		$result = $tool->upload($input);
        	
        		if (! $result['success']) {
        			return array('success'=>false, 'msg'=>'上傳圖片失敗!');
        		}
        		if (! empty($result['files'])) {
        			foreach ($result['files'] as $index => $val) {
        				$data[$index] = $val;
        			}
        		}
        		$data['nm_created'] = date('Y-m-d H:i:s');
        	
        		$this->db->insert($data);
        		$data['nm_id'] = $this->db->getLastInsertValue();
        		return array('success'=>true , 'data'=>$data);
        	
        	}catch (\Exception $e){
        		return array('success'=>false , 'msg'=> $e->getMessage() );
        	}
        }else{
        	try {
	        	$id = $data['nm_id'];
	        	unset($data['nm_id']);
	        	$tool = new \Administrator\Model\Tool\Tool();
	        	$input['m_path']['nm_cover']  ="images/news_main_cover";
	        	$result = $tool->upload($input);
	        	if (! $result['success']) {
	        		return array('success'=>false, 'msg'=>'上傳圖片失敗!');
	        	}
	        	if (! empty($result['files'])) {
	        		//Debug::dump($result['files']);
	        		$row = $this->db->select('nm_id =' . (int) $id)->toArray();
	        		foreach ($result['files'] as $index => $val) {
	        			$path = PUBLIC_PATH .'/'.$input['m_path'][$index];
	        			$tool->deleteimg($path,$row[0][$index]);
	        			$data[$index] = $val;
	        		}
	        	}
	        			 
	            $this->db->update($data , array('nm_id'=>$id));
	        	return array('success'=>true , 'data'=> $data );
        	}catch (\Exception $e){
        		return array('success'=>false , 'msg'=> $e->getMessage() );
        	}
        }
    }
    public function delete($id){
    	$this->db->delete('nm_id =' . (int) $id);
    	return array('success'=>true  );
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