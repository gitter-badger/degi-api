<?php
namespace Test\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel ;
use Test\Model\IndoorMonitor;

class IndoorMonitorController extends AbstractRestfulController
{
    //resource 
    //get
    public function getList(){
        $response = $this->getResponse();
        $response->setStatusCode(200);

        $db = new IndoorMonitor();
        return new JsonModel($db->selectAll($this->params()->fromQuery()));        
    }  
    //entity
    //get 
    public function get($id){
        $response = $this->getResponse();
        $response->setStatusCode(200);
        
        $db = new IndoorMonitor();

        return new JsonModel($db->get($id));
    }  
    //put
    public function update($id , $data){
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    
    	$db = new IndoorMonitor();

        return new JsonModel($db->update($data,$id));
    }
    //delete
    public function delete($id){
        $response = $this->getResponse();
        $response->setStatusCode(200);
        
        $db = new IndoorMonitor();

        return new JsonModel($db->delete($id));
    } 
    public function options(){
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Allow','GET,PUT,DELETE');
        return $response;
    }    
}
?>