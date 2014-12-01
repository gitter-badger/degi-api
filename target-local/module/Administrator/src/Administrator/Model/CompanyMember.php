<?php
namespace Administrator\Model;

use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\DbSelect;
use Administrator\Model\Table\CompanyMemberTable;

class CompanyMember{
	public $db = null ;
	public function __construct(){
		$this->db = new CompanyMemberTable();
	}
    public function update($data , $id){
        try {
        	if(!empty($data['cm_account'])){
		      	$select = $this->db->getSql()->select();
	        	$select->where->EqualTo('cm_account', $data['cm_account'])
	        	              ->notEqualTo('cm_id',$id);
	        	if( !empty($this->db->selectWith($select)->toArray() )){
	        		return array('success'=>false, 'msg'=>'此帳號已被使用!');
	        	}
        	}
            if(!empty($data['cm_password'])){
                $data['cm_password'] = md5($data['cm_password']);
            }
            $this->db->update($data , array('cm_id'=>$id));
            return array('success'=>true , 'data'=> $data );
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
    
    public function delete($id){
        $this->db->update(array('cm_status'=>2),array('cm_id'=>$id));
        return array('success'=>true  );
    }
    
    public function get($id){
        return array('success'=>true , 'data'=> $this->db->select(array('cm_id'=>$id))->current());
    }
    
    public function selectAll($query){
    	try {
    		$select = $this->db->getSql()->select();
    		
    		if(!empty($query['q'])){
    			$select->where->like('cm_account','%'.$query['q'].'%');
    			$select->where->or->like('cm_title','%'.$query['q'].'%');
    		}
//     		if(isset($query['s'])){
//     			$select->where->equalTo('mm_status',$query['s']);
//     		}
    		
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
    
    public function insert($data){
        $data['cm_created'] = date('Y-m-d H:i:s');
        $data['cm_password'] = md5($data['cm_password']);
        
        try {
        	$select = $this->db->getSql()->select();
        	$select->where->EqualTo('cm_account', $data['cm_account']);
        	if( !empty($this->db->selectWith($select)->toArray() )){
        		return array('success'=>false, 'msg'=>'此帳號已被使用!');
        	}
            if( $this->db->insert($data) ) {
                $data['cm_id'] = $this->db->getLastInsertValue() ;
                return array('success'=>true , 'data'=> $data);
            }else{
                return array('success'=>false , 'msg'=> '新增過程發生錯誤');
            } 
            
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
}
    
?>