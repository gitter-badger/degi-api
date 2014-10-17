<?php
namespace Administrator\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel ;
use Administrator\Model\SystemVariable;

class SystemVariableController extends AbstractRestfulController
{
    //resource
    //get
    public function getList(){
        $response = $this->getResponse();
        $response->setStatusCode(200);
        
        $db = new SystemVariable();
        return new JsonModel($db->selectAll());
    }
     
    //entity    
    //put
    public function update($id , $data){
        $response = $this->getResponse();
        $response->setStatusCode(200);
        
        $db = new SystemVariable();
        return new JsonModel(array('success'=>true , 'data'=> $db->update($data,$id) ));
    }

    public function options(){
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Allow','GET,PUT');
        return $response;
    }   
}
?>