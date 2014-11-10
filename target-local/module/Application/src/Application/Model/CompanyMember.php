<?php
namespace Application\Model;
use Application\Model\Tool\TokenHash;
use Application\Model\Table\CompanyMemberTable;

class CompanyMember{
	public $db = null ;
	public function __construct(){
		$this->db = new CompanyMemberTable();
	}
	public function login($account , $password){
		$rs = $this->db->select(array('cm_account'=>$account , 'cm_password'=>md5($password)))->current();		
		if($rs){
			unset($rs->cm_password);
			$AccessToken = TokenHash::GenerateToken($account);
			if( ( !empty($rs->cm_token) && !TokenHash::ExpiresIn($rs->cm_token, 3600) ) || empty( $rs->cm_token ) ){
				$this->db->update( array('cm_token'=>$AccessToken) , array('cm_id'=>$rs->cm_id));
				$rs->cm_token = $AccessToken;
			}
			return array('success'=>true , 'data'=> $rs ) ;
		}else {
			return array('success'=>false , 'msg'=> '帳號密碼錯誤');
		}
	}
	
	public function logout($AccessToken){
		$rs = $this->db->select(array('cm_token'=>$AccessToken))->current();
		if($rs){
			$this->db->update( array('cm_token'=>null) , array('cm_id'=>$rs->cm_id));
		}
		return array('success'=>true ) ;
	}  
	public function CheckLogin($AccessToken){
		$rs = $this->db->select(array('cm_token'=>$AccessToken))->current();
		
		if( $rs && !empty($rs->cm_token) && TokenHash::ExpiresIn($rs->cm_token, 3600) ){
			unset($rs->cm_password);
			return array('success'=>true, 'data'=> $rs );
		}else{
			return array('success'=>false, 'msg'=>'此access_token無法使用' ) ;
		}
	}
}
?>