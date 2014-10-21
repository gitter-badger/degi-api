<?php
namespace Application\Model;
use Application\Model\Table\MemberTable;
use Application\Model\Tool\TokenHash;

class Member{
	public $db = null ;
	public function __construct(){
		$this->db = new MemberTable();
	}
	public function update($data , $id){
		//Debug::dump($data);
		try {
			if( !empty($data['mm_password']) ){
				if(empty($data['mm_repassword'])){
					return array('success'=> false , 'msg'=>'未輸入確認密碼');
				}
				if( $data['mm_password'] != $data['mm_repassword']){
					return array('success'=> false , 'msg'=>'密碼和確認密碼不符');
				}
				unset($data['mm_repassword']);
				$data['mm_password'] = md5($data['mm_password']);
			}
			if(!empty($data['mm_email'])){
				$select = $this->db->getSql()->select();
				$select->where->EqualTo('mm_email', $data['mm_email'])
				              ->notEqualTo('mm_id',$id);
				if( !empty($this->db->selectWith($select)->toArray() )){
					return array('success'=>false, 'msg'=>'此信箱已被使用');
				}
			}
			$this->db->update($data , array('mm_id'=>$id));
			return array('success'=>true , 'data'=> $data );
		}catch (\Exception $e){
			return array('success'=>false , 'msg'=> $e->getMessage() );
		}
	}

	public function get($id){
		try {
			return array('success'=>true , 'data'=> $this->db->select(array('mm_id'=>$id))->current() );
		}catch (\Exception $e){
			return array('success'=>false , 'msg'=> $e->getMessage() );
		}
	}
	
	public function insert($data){
		try {
			if( $data['mm_password'] != $data['mm_repassword']){
				return array('success'=> false , 'msg'=>'密碼和確認密碼不符');
			}
			$select = $this->db->getSql()->select();
			$select->where->EqualTo('mm_email', $data['mm_email']);
			if( !empty($this->db->selectWith($select)->toArray() )){
				return array('success'=>false, 'msg'=>'此信箱已被使用');
			}
			$data['mm_password'] = md5($data['mm_password']);
			$data['mm_created'] = date('Y-m-d H:i:s');
			$data['mm_status'] = 1;
			unset($data['mm_repassword']);				
			$this->db->insert($data);			
			$data['mm_id'] = $this->db->getLastInsertValue() ;
			return array('success'=>true , 'data'=> $data);
		}catch (\Exception $e){
			return array('success'=>false , 'msg'=> $e->getMessage() );
		}
	}
	
	public function login($account , $password){
		$rs = $this->db->select(array('mm_email'=>$account , 'mm_password'=>md5($password)))->current();		
		if($rs){
			unset($rs->mm_password);
			$AccessToken = TokenHash::GenerateToken($account);
			if( ( !empty($rs->mm_token) && !TokenHash::ExpiresIn($rs->mm_token, 3600) ) || empty( $rs->mm_token ) ){
				$this->db->update( array('mm_token'=>$AccessToken) , array('mm_id'=>$rs->mm_id));
				$rs->mm_token = $AccessToken;
			}
			return array('success'=>true , 'data'=> $rs ) ;
		}else {
			return array('success'=>false , 'msg'=> '帳號密碼錯誤');
		}
	}
	
	public function logout($AccessToken){
		$rs = $this->db->select(array('mm_token'=>$AccessToken))->current();
		if($rs){
			$this->db->update( array('mm_token'=>null) , array('mm_id'=>$rs->mm_id));
		}
		return array('success'=>true ) ;
	}  
	public function CheckLogin($AccessToken){
		$rs = $this->db->select(array('mm_token'=>$AccessToken))->current();
		
		if( $rs && !empty($rs->mm_token) && TokenHash::ExpiresIn($rs->mm_token, 3600) ){
			unset($rs->mm_password);
			return array('success'=>true, 'data'=> $rs ) ;
		}else{
			return array('success'=>false, 'msg'=>'此access_token無法使用' ) ;
		}
	}
}
?>