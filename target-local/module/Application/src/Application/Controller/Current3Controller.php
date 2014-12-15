<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel ;
use Application\Model\Current;

class CurrentController extends AbstractRestfulController
{   
    //post
    public function create($data){
    	$response = $this->getResponse();
    	$response->setStatusCode(200);
    	$db = new Current();
    	return new JsonModel($db->insert($data));
    }
    
    public function options(){
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Allow','POST');
        return $response;
    }    
}
?>