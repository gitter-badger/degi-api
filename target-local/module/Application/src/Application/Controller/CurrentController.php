<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Application\Model\Current;


class CurrentController extends AbstractRestfulController
{
    //post
    public function create($data){
    	$db = new Current();
    	$response = $this->getResponse();
    	$response->setContent($db->insert($data));
    	$response->getHeaders()->addHeaders(array('Content-Type'=>'application/xml; charset=utf-8')); 
    	$response->setStatusCode(200);
       	return $response;
    }
   
    public function options(){
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Allow','POST');
        return $response;
    }    
}
?>