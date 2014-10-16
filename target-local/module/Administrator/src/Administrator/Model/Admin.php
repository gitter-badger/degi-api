<?php
namespace Administrator\Model;

use Administrator\Model\Table\AdminTable;
use Zend\Session\Container;

class Admin{
    
    public function update($data , $id){
        $adminTb = new AdminTable();
        try {
            if(!empty($data['a_password'])){
                $data['a_password'] = md5($data['a_password']);
            }
            $adminTb->update($data , array('a_id'=>$id));
            return array('success'=>true , 'data'=> $data );
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
    
    public function delete($id){
        $adminTb = new AdminTable();
        $adminTb->update(array('a_status'=>2),array('a_id'=>$id));
        return array('success'=>true  );
    }
    
    public function get($id){
        $adminTb = new AdminTable();
        return array('success'=>true , 'data'=> $adminTb->select(array('a_id'=>$id))->current());
    }
    
    public function selectAll(){
        $adminTb = new AdminTable();
        return array('success'=>true , 'rows'=>$adminTb->select()->toArray() );
    }
    
    public function insert($data){
        $adminTb = new AdminTable();
        $data['a_created'] = date('Y-m-d H:i:s');
        $data['a_password'] = md5($data['a_password']);
        try {
            
            if( $adminTb->insert($data) ) {
                $data['a_id'] = $adminTb->getLastInsertValue() ;
                return array('success'=>true , 'data'=> $data);
            }else{
                return array('success'=>false , 'msg'=> '新增過程發生錯誤');
            } 
            
        }catch (\Exception $e){
            return array('success'=>false , 'msg'=> $e->getMessage() );
        }
    }
    
    public function login($account , $password){
        $adminTb = new AdminTable();
        $rs = $adminTb->select(array('a_account'=>$account , 'a_password'=>md5($password)))->current();
        
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