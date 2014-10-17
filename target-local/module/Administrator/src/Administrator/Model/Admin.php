<?php
namespace Administrator\Model;

use Administrator\Model\Table\AdminTable;
use Zend\Session\Container;

class Admin{
	public $db = null ;
	public function __construct(){
		$this->db = new AdminTable();
	}
    public function update($data , $id){
        try {
        	if(!empty($data['a_account'])){
		      	$select = $this->db->getSql()->select();
	        	$select->where->EqualTo('a_account', $data['a_account'])
	        	              ->notEqualTo('a_id',$id);
	        	if( !empty($this->db->selectWith($select)->toArray() )){
	        		return array('success'=>false, 'msg'=>'此帳號已被使用!');
	        	}
        	}
            if(!empty($data['a_password'])){
                $data['a_password'] = md5($data['a_password']);
            }
            $this->db->update($data , array('a_id'=>$id));
            return array('success'=>true , 'data'=> $data );
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
    
    public function delete($id){
        $this->db->update(array('a_status'=>2),array('a_id'=>$id));
        return array('success'=>true  );
    }
    
    public function get($id){
        return array('success'=>true , 'data'=> $this->db->select(array('a_id'=>$id))->current());
    }
    
    public function selectAll(){
        return array('success'=>true , 'data'=>$this->db->select()->toArray() );
    }
    
    public function insert($data){
        $data['a_created'] = date('Y-m-d H:i:s');
        $data['a_password'] = md5($data['a_password']);
        
        try {
        	$select = $this->db->getSql()->select();
        	$select->where->EqualTo('a_account', $data['a_account']);
        	if( !empty($this->db->selectWith($select)->toArray() )){
        		return array('success'=>false, 'msg'=>'此帳號已被使用!');
        	}
            if( $this->db->insert($data) ) {
                $data['a_id'] = $this->db->getLastInsertValue() ;
                return array('success'=>true , 'data'=> $data);
            }else{
                return array('success'=>false , 'msg'=> '新增過程發生錯誤');
            } 
            
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
    
    public function login($account , $password){
        $rs = $this->db->select(array('a_account'=>$account , 'a_password'=>md5($password)))->current();
        
        if($rs){
            unset($rs->a_password);
            $auth = new Container('auth');
            $auth->data = $rs ;
            return array('success'=>true , 'data'=> $rs ) ;
        }else {
            return array('success'=>false , 'msg'=> '找不到帳號資料');
        }
    }
    
    public function logout(){
        $auth = new Container('auth');
        unset($auth->data);
        return array('success'=>true ) ;
    }
}
    
?>