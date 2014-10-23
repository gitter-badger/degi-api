<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel ;
use Administrator\Model\Tool\InputCheck ;
use Application\Model\Member;

class MemberController extends AbstractRestfulController
{
    //resource
    //post
    public function create($data){
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	if( ! InputCheck::checkRequire(array('mm_email', 'mm_password', 'mm_repassword'),$data) ){
    		return new JsonModel(array('success'=>false ,'msg'=>'遺漏參數'));
    	}
   
    	$admin = new Member();
    	return new JsonModel($admin->insert($data));
    }   
    //entity
    //get 
    public function get($id){
        $response = $this->getResponse();
        $response->setStatusCode(200);
        
        $admin = new Member();

        return new JsonModel($admin->get($id));
    }  
    //put
    public function update($id , $data){
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    
    	$admin = new Member();
    
    	return new JsonModel(array('success'=>true , 'data'=> $admin->update($data,$id) ));
    }
    public function delete($email){
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    
    	$admin = new Member();
    	    
    	return new JsonModel($admin->forgetpassword($email));
    }
    public function options(){
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Allow','GET,POST,PUT,DELETE');
        return $response;
    }    
}
?>