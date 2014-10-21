<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Application\Model\Member;

class AuthController extends AbstractRestfulController
{
    //post -> login
    public function create($data){
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	//Debug::dump($data);
    	
    	if( empty($data['mm_email']) || empty($data['mm_password']) ){
    	    return new JsonModel(array('success'=>false , 'msg'=>'請輸入完整資訊' ));
    	}
    	$account = $data['mm_email'];
    	$password = $data['mm_password'];
    	
    	$member = new Member();
    	return new JsonModel($member->login($account, $password));
    }
    
    //get -> check-login & get information
    public function get($id){
        $response = $this->getResponse();
        $response->setStatusCode(200);
        
        $member = new Member();
        return new JsonModel($member->CheckLogin($id));
    }
    
    //delete -> logout
    public function delete($id){
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
		$member = new Member();
        return new JsonModel($member->logout($id));    
    }
    public function options(){
    	$response = $this->getResponse();
    	$response->getHeaders()->addHeaderLine('Allow','GET,POST,DELETE');
    	return $response;
    }
}
?>