<?php
namespace Administrator\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel ;

use Administrator\Model\Admin;

class AdminerController extends AbstractRestfulController
{
    //resource
    //post
    public function create($data){
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	
    	if( empty($data['a_account']) || empty($data['a_password']) || empty($data['a_email']) || empty($data['a_displayname']) ){
    	    return new JsonModel(array('success'=> false , 'msg'=>'遺漏欄位'));
    	}
    	
    	$source['a_account'] = $data['a_account'];
    	$source['a_password'] = $data['a_password'];
    	$source['a_email'] = $data['a_email'];
    	$source['a_displayname'] = $data['a_displayname'];
    	$source['a_status'] = $data['a_status'];

    	$admin = new Admin();
    	
    	return new JsonModel($admin->insert($source));
    }   
    //get
    public function getList(){
        $response = $this->getResponse();
        $response->setStatusCode(200);

        $admin = new Admin();
        return new JsonModel($admin->selectAll($this->params()->fromQuery()));
    }  
    //put
    public function replaceList($data){
        $response = $this->getResponse();
        $response->setStatusCode(404);
        return new JsonModel(array('success'=>false , 'method'=>'put' , 'data'=>$data));
    }
    //delete
    public function deleteList(){
        $response = $this->getResponse();
        $response->setStatusCode(404);
        return new JsonModel(array('success'=>false , 'method'=>'delete'));
    } 
    //entity
    //get 
    public function get($id){
        $response = $this->getResponse();
        $response->setStatusCode(200);
        
        $admin = new Admin();

        return new JsonModel($admin->get($id));
    }  
    //put
    public function update($id , $data){
        $response = $this->getResponse();
        $response->setStatusCode(200);
        
        $admin = new Admin();
        
        return new JsonModel($admin->update($data,$id));
    }
    //delete
    public function delete($id){
        $response = $this->getResponse();
        $response->setStatusCode(200);
        
        $admin = new Admin();

        return new JsonModel($admin->delete($id));
    } 
    public function options(){
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Allow','GET,POST,PUT,DELETE');
        return $response;
    }    
}
?>