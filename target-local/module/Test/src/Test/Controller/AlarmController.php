<?php
namespace Test\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel ;
use Test\Model\Alarm;

class AlarmController extends AbstractRestfulController
{
    public function getList(){
        $response = $this->getResponse();
        $response->setStatusCode(200);
        $db = new Alarm();
        return new JsonModel($db->selectAll($this->params()->fromQuery()));        
    }  
    public function options(){
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Allow','GET');
        return $response;
    }    
}
?>