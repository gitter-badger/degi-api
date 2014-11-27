<?php
namespace Application\Model;
use Application\Model\Table\MemberTable;
use Application\Model\Tool\TokenHash;

class Member{
	public $db = null ;
	public function __construct(){
		$this->db = new MemberTable();
	}
	public function update($data , $id){ //data['access_token'], id:mm_id
		
		try {
			$member = new Member();
			if( !$member->InternalCheckLogin($data['access_token']) ){
				return array('success'=>false , 'msg'=> '未通過登入認證，請重新登入!' );
			}
			unset($data['access_token']);
			
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

	public function get($id,$query){//query{access_token}
		try {
			$member = new Member();
			if( !$member->InternalCheckLogin($query['access_token']) ){
				return array('success'=>false , 'msg'=> '未通過登入認證，請重新登入!' );
			}
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
	public function forgetpassword($email){
		//check db email exist
		$rs = $this->db->select(array('mm_email'=>$email))->current();
		
		if( !$rs ){
			return array('success'=>false , 'msg'=>'找不到該信箱!');
		}
		//update new pwd 
		$new_password = $this->generatorPassword();
		$this->db->update(array('mm_password'=>md5($new_password)),array('mm_email'=>$email));
		
		//send hash mail to member
		$messagePlugin = new MessagePlugin();
		
		$to = array(array('to'=>$email,'name'=>'得記麵包 會員'));
		$subject = 'reset password';
		$body =  '
得記麵包會員您好
		
我們收到您的重設密碼要求，您的密碼已更改成以下密碼，如果本信件持續發送，請聯絡我們！

＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
您的新密碼為: ' . $new_password .'
		
-請勿回覆本信件.';
		
		$messagePlugin->sendmail($to , $subject , $body);
		return array('success'=>true, 'mm_email'=>$rs->mm_email);
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
			return array('success'=>false, 'msg'=>'此access_token無法使用, 請重新登入!' ) ;
		}
	}
	public function InternalCheckLogin($AccessToken){
		$rs = $this->db->select(array('mm_token'=>$AccessToken))->current();
		if( $rs && !empty($rs->mm_token) && TokenHash::ExpiresIn($rs->mm_token, 3600) ){
			return $rs->mm_id;
		}else{
			return 0;
		}
	}
	function generatorPassword()
	{
		$password_len = 6;
		$password = '';
	
		// remove o,0,1,l
		$word = 'abcdXYZ0123456789';
		$len = strlen($word);
	
		for ($i = 0; $i < $password_len; $i++) {
			$password .= $word[rand() % $len];
		}
	
		return $password;
	}
}
?>