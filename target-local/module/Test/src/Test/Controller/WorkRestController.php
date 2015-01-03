<?php
namespace Test\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel ;
use Test\Model\WorkRest;

class WorkRestController extends AbstractRestfulController
{
    //resource 
    //get
    public function getList(){
        $response = $this->getResponse();
        $response->setStatusCode(200);

        $member = new WorkRest();
        return new JsonModel($member->selectAll($this->params()->fromQuery()));        
    }  
    //entity
    //get 
    public function get($id){
        $response = $this->getResponse();
        $response->setStatusCode(200);
        
        $member = new WorkRest();

        return new JsonModel($member->get($id));
    }  
    //put
    public function update($id , $data){
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    
    	$member = new WorkRest();

        return new JsonModel($member->update($data,$id));
    }
    //delete
    public function delete($id){
        $response = $this->getResponse();
        $response->setStatusCode(200);
        
        $member = new WorkRest();

        return new JsonModel($member->delete($id));
    } 
    public function options(){
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Allow','GET,PUT,DELETE');
        return $response;
    }    
}
?>