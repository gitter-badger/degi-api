<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel ;
use Application\Model\Member;

class MemberController extends AbstractRestfulController
{
    //resource
    //post
    public function create($data){
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	
    	if( empty($data['mm_email']) || empty($data['mm_password']) || empty($data['mm_repassword'])){
    	    return new JsonModel(array('success'=> false , 'msg'=>'遺漏欄位'));
    	}
    	if( $data['mm_password'] != $data['mm_repassword']){
    		return new JsonModel(array('success'=> false , 'msg'=>'兩次密碼輸入不同'));
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
        //Debug::dump($data);
        $admin = new Member();
        
        return new JsonModel($admin->update($data,$id));
    }
    public function options(){
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Allow','GET,POST,PUT,DELETE');
        return $response;
    }    
}
?>