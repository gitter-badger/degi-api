<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Application\Model\CompanyMember;

class CompanyMemberAuthController extends AbstractRestfulController
{
    //post -> login
    public function create($data){
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	
    	if( empty($data['cm_account']) || empty($data['cm_password'])){
    	    return new JsonModel(array('success'=>false , 'msg'=>'遺漏參數' ));
    	}

    	$account = $data['cm_account'];
    	$password = $data['cm_password'];

    	$member = new CompanyMember();
    	return new JsonModel($member->login($account, $password));
    }
    
    //get -> check-login & get information
    public function get($id){
        $response = $this->getResponse();
        $response->setStatusCode(200);
        
        $member = new CompanyMember();
        return new JsonModel($member->CheckLogin($id));
    }
    
    //delete -> logout
    public function delete($id){
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
		$member = new CompanyMember();
        return new JsonModel($member->logout($id));    
    }
    public function options(){
    	$response = $this->getResponse();
    	$response->getHeaders()->addHeaderLine('Allow','GET,POST,DELETE');
    	return $response;
    }
}
?>