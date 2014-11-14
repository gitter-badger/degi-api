<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel ;
use Application\Model\Order;

class OrderController extends AbstractRestfulController
{
    //resource
    //post
    public function create($data){
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	$server_url = $this->getRequest()->getUri()->getScheme() . '://' . $this->getRequest()->getUri()->getHost();
    	$db = new Order();
    	return new JsonModel($db->insert($data,$server_url));
    }
    public function getList(){
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	$db = new Order();
    	return new JsonModel($db->selectAll($this->params()->fromQuery()));
    }   
    //entity
    //get 
    public function get($id){
        $response = $this->getResponse();
        $response->setStatusCode(200);
        
        $db = new Order();

        return new JsonModel($db->get($id,$this->params()->fromQuery()));
    }  
    //put
    public function update($id , $data){
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    
    	$db = new Order();
    
    	return new JsonModel($db->update($data,$id) );
    }
    
    public function options(){
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Allow','GET,POST,PUT,DELETE');
        return $response;
    }    
}
?>