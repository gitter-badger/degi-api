<?php
namespace Administrator\Controller;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel ;

use Administrator\Model\Admin;
use Zend\Session\Container;

class AuthController extends AbstractRestfulController
{
    //resource
    //post
    public function create($data){
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	
    	$account = $data['a_account'];
    	$password = $data['a_password'];
    	
    	if( empty($account) || empty($password) ){
    	    return new JsonModel(array('success'=>false , 'msg'=>'請輸入數值' ));
    	}
    	
    	$admin = new Admin();

    	return new JsonModel($admin->login($account, $password));
    }
    
    //get
    public function getList(){
        $response = $this->getResponse();
        $response->setStatusCode(200);
        
        $auth = new Container('auth');
        
        if( empty($auth->data)){
            return new JsonModel(array('success'=>false , 'msg'=>'請先登入'));
        }
        return new JsonModel(array('success'=>true , 'data'=> $auth->data ));
    }
    
    //delete
    public function deleteList(){    
        $response = $this->getResponse();
        $response->setStatusCode(200);
        $admin = new Admin();
        return new JsonModel($admin->logout());
    }   
}
?>